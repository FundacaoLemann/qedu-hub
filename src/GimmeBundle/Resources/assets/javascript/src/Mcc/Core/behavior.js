/**
 * This installs behavior base class.
 *
 * @requires js/mcc/core/install.js
 */


/**
 * Define a behavior, which holds glue code in a structured way.
 *
 * To define a behavior, provide a name and a function:
 *
 *   mcc.behavior('win-a-hog', function(config, configStatic) {
 *     alert("YOU WON A HOG NAMED " + config.hogName + "!");
 *   });
 *
 * @param string    Behavior name.
 * @param function  Behavior callback/definition.
 * @return void
 */
mcc.behavior = function (name, control_function) {
	if (__DEV__) {
		if (mcc.behavior._behaviors.hasOwnProperty(name)) {
			mcc.exception('mcc.behavior("' + name + '", ...): '+'behavior is already registered.');
		}
		if (!control_function) {
			mcc.exception('mcc.behavior("' + name + '", <nothing>): '+'initialization function is required.');
		}
		if (typeof control_function != 'function') {
			mcc.exception('mcc.behavior("' + name + '", <garbage>): '+'initialization function is not a function.');
		}
	}
    if(!!window.Raven){
        // If RavenJS is loaded, we wrap the function to allow the capture of exceptions
      control_function = Raven.wrap({"tags":{"behavior_name":name}}, control_function);
    }
	mcc.behavior._behaviors[name] = control_function;
	mcc.behavior._statics[name] = {};
};


/**
 * Execute previously defined behaviors, running the glue code they
 * contain to glue stuff together.
 *
 * Normally, you do not call this function yourself; instead, your server-side
 * library builds it for you.
 *
 * @param map  Map of behaviors to invoke: keys are behavior names, and values
 *              are lists of configuration dictionaries. The behavior will be
 *              invoked once for each configuration dictionary.
 * @return void
 */
mcc.init_behaviors = function (map) {
	var missing_behaviors = [];
	for (var name in map) {
		if (!(name in mcc.behavior._behaviors)) {
			missing_behaviors.push(name);
			continue;
		}
		var configs = map[name];
		if (!configs.length) {
			if (mcc.behavior._initialized.hasOwnProperty(name)) {
				continue;
			}
			configs = [null];
		}
		for (var ii = 0; ii < configs.length; ii++) {
			mcc.behavior._behaviors[name](configs[ii], mcc.behavior._statics[name]);
		}
		mcc.behavior._initialized[name] = true;
	}
	if (missing_behaviors.length) {
		mcc.exception('mcc.initBehavior(map): behavior(s) not registered: ' + missing_behaviors.join(', '));
	}
};

mcc.behavior._behaviors = {};
mcc.behavior._statics = {};
mcc.behavior._initialized = {};