/**
 * This will provide functions to install stuff on the mcc namespace.
 *
 * This as borrowed from JavelinJS with the diference that we do not create classes structures, it is up to the user to
 * do it.
 *
 * This is compatible with backbone.js in a way that if the object has a initialize property it will be called upon
 * object creation.
 *
 * If we define `window.` on the extends it will look for the class in the window namespace, so we can extends stuff outside mcc
 *
 * @todo try to take out underscore dependency
 *
 * @requires js/mcc/core/boot.js
 * @requires js/mcc/core/functions.js
 */

mcc.install = function(new_name, new_junk, internal) {

	// If it is an internal call is that we are waiting for an external class to load, so we will not push it to queue again
	internal = internal || false;

	// If we've already installed this, something is up.
	if (new_name in mcc && ! internal) {
		if (__DEV__) {
			mcc.exception(
				'mcc.install("' + new_name + '", ...): ' +
				'trying to reinstall something that has already been installed.');
		}

		return;
	}

	// We can not extend from two sources
	if (new_junk.__extend && new_junk.__extend_external) {
		if (__DEV__) {
			mcc.exception(
				'mcc.install("' + new_name + '", ...): ' +
				'trying to extend from two classes, the external extend will be ignored!');
		}

		// priority is the internal extension
		delete new_junk['__extend_external'];
	}

	// Since we may end up loading things out of order (e.g., Dog extends Animal
	// but we load Dog first) we need to keep a list of things that we've been
	// asked to install but haven't yet been able to install around.
	if ( ! internal) {
		(mcc.install._queue || (mcc.install._queue = [])).push([new_name, new_junk]);
	}

	var name;
	do {
		var junk;
		var initialize;
		name = null;
		for (var ii = 0; ii < mcc.install._queue.length; ++ii) {
			// If it is an internal call we are only interested in one class
			if (internal && new_name !== mcc.install._queue[ii][0])
				continue;

			junk = mcc.install._queue[ii][1];

			// If we need to extend something that we haven't been able to install yet, so just keep this in queue.
			if (junk.__extend && !mcc[junk.__extend]) {
				continue;
			} else if (junk.__extend_external && ! mcc.find_in_namespace(junk.__extend_external)) {
				/**
				 * It would be really nice to extend external classes (from window namespace) but for now we are not allowing it
				 * cause we would have to poll to wait for the class to load and this would cause BigPipe execution to get
				 * busted cause we would say a resource is loaded but actually the class was not installed.
				 *
				 * This is mainly used for extending backbone models and views, so for now lets just include backbone in the header.
				 *
				 * @todo In the future we might implement it in a clever way but I think we would have to have something like require.js:
				 *
				 *   mcc.require('Class_That_Extends_External_Class', function(Class_That_Extends_External_Class){
				 *       var my_object = new Class_That_Extends_External_Class();
				 *   });
				 *
				 * Bigpipe would have to use events to know when stuff is loaded.
				 */
				mcc.exception('You are extending an external class named "'+junk.__extend_external+'" from the window'+
						      'namespace and it was not found. You must load it in the header of the document. In the future we might support it.');

				delete junk.__extend_external;
			}

			// Install time! First, get this out of the queue.
			name = mcc.install._queue.splice(ii, 1)[0][0];
			--ii;

			// If it extends something then it is on the mcc or the window namespace
			if (junk.__extend) {
				junk.__extend = mcc[junk.__extend];
			} else if (junk.__extend_external) {
				// Finds the extension on the global namespace
				junk.__extend_external = mcc.find_in_namespace(junk.__extend_external);
			}

			/**
			 * If it is already a functions we are just no responsible for it and can not guarantee asynchronously load.
			 * Otherwise we need to create a basic function encapsulating the junk object.
			 */
			if (_.isFunction(junk)) {
				mcc[name] = junk;
			} else {
				mcc[name] = mcc.create_class(name, junk);
			}
		}

		// In effect, this exits the loop as soon as we didn't make any progress
		// installing things, which means we've installed everything we have the
		// dependencies for.
	} while (name);
};

/**
 * Creates the class wrapper.
 *
 * You can define a unique name for the class. The name should use underscore for directory separator and camelcase.
 *
 * You can define:
 *
 * __construct
 * __static
 * __extend or __extend_external
 * method_a
 * method_b
 * property_ccc
 * property_bbb
 * _private_property
 *
 * Public properties will get their get_ and set_ method that can be overloaded.
 */
mcc.create_class = function(name, junk) {
	// If __construct is defined in junk then we call it as a constructor.
	var Class = (function(name, junk) {
		var result = function() {
			return (junk.__construct || junk.__extend || junk.__extend_external || mcc.noop).apply(this, arguments);
		};

		return result;
	})(name, junk);

	// Copy in all the static methods and properties.
	if (junk.__static) {
		_.extend(Class, junk.__static);
	}

	var proto = {};
	if (junk.__extend) {
		var Inheritance = function() {};
		Inheritance.prototype = junk.__extend.prototype;
		proto = Class.prototype = new Inheritance();
	} else {
		proto = Class.prototype = {};
	}

  if (junk.toString !== undefined) {
    Class.prototype.toString = junk.toString;
    delete junk.toString;
  }

	// Default setter function
	var setter = function(prop) {
		return function(v) {
			this[prop] = v;
			return this;
		};
	};

	// Default getter function
	var getter = function(prop) {
		return function(v) {
			return this[prop];
		};
	};

	// Extends it with the junk
	for (k in junk) {
		if (k.substr(0, 2) !== '__') {
			proto[k] = junk[k];

			// Set the Getter and Setter of public properties
			if (k.substr(0, 1) !== '_' && ! _.isFunction(junk[k])) {
				proto['get_'+k] = getter(k);
				proto['set_'+k] = setter(k);
			}

			if (__DEV__) {
				/**
				  * Check for aliasing in default values of members. If we don't do this, you can run into a problem like this:
                  *
	              *    JX.install('List', { members : { stuff : [] }});
                  *
	              *    var i_love = new JX.List();
	              *    var i_hate = new JX.List();
				  *
	              *    i_love.stuff.push('Psyduck');  // I love psyduck!
	              *    JX.log(i_hate.stuff);          // Show stuff I hate.
				  *
	              * This logs ["Psyduck"] because the push operation modifies
	              * JX.List.prototype.stuff, which is what both i_love.stuff and
	              * i_hate.stuff resolve to. To avoid this, set the default value to
	              * null (or any other scalar) and do "this.stuff = [];" in the
	              * constructor.
				  *
	              *  In the future we might implement deep copy but i think it is better to just initialize stuff in
	              *  the constructor.
				  */
				if (typeof junk[k] == 'object' && junk[k] !== null) {
					mcc.exception('mcc.install/create_class("' + name + '", ...): ' +
				          'installed member "' + k + '" is not a scalar or ' +
				          'function. Prototypal inheritance in Javascript aliases object ' +
				          'references across instances so all instances are initialized ' +
				          'to point at the exact same object. This is almost certainly ' +
				          'not what you intended. Make this member static to share it ' +
				          'across instances, or initialize it in the constructor to ' +
				          'prevent reference aliasing and give each instance its own ' +
				          'copy of the value.');
				}
			}
		}
	}

	return Class;
};