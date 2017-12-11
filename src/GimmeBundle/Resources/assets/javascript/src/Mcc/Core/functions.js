/**
 * Core utility functions
 *
 * @requires js/mcc/core/boot.js
 */

/**
 * Empty function placeholder
 */
mcc.noop = function(){};

/**
 * Date.now is the fastest timestamp function, but isn't supported by every
 * browser. This gives the fastest version the environment can support.
 * The wrapper function makes the getTime call even slower, but benchmarking
 * shows it to be a marginal perf loss. Considering how small of a perf
 * difference this makes overall, it's not really a big deal. The primary
 * reason for this is to avoid hacky "just think of the byte savings" JS
 * like +new Date() that has an unclear outcome for the unexposed.
 *
 * @return Int A Unix timestamp of the current time on the local machine
 */
mcc.now = (Date.now || function() { return new Date().getTime(); });

/**
 * Throw an exception and attach the caller data in the exception.
 *
 * @param string Exception message.
 *
 * @note console.log, mcc.log and mcc.exception should only be used in __DEV__ mode
 */
mcc.exception = mcc.noop;

if(!!window.Raven){
    // If we have Raven..use it! :D
    mcc.exception = function(message){
        Raven.captureMessage(message, {"tags": {"type": "exception"}});
    }
}

if (__DEV__) {
	mcc.exception = function(message) {
		var e = new Error(message);
		var caller_fn = mcc.exception.caller;
		if (caller_fn) {
			e.caller_fn = caller_fn.caller;
		}
		throw e;
	};
}

mcc.log = mcc.noop;

// mcc.log does not need Raven as it is...Logs (Raven is most for exceptions :D)

// Checks if console && console.log is defined
if (!window.console || !window.console.log) {
	window.console = {
		log: mcc.noop
	};
}

if (__DEV__) {
	// Opera likes it different
	if (!window.console || !window.console.log) {
		if (window.opera && window.opera.postError) {
			window.console = {
				log:function (m) {
					window.opera.postError(m);
				}
			};
		}
	}

	mcc.log = function (message) {
		window.console.log(message);
	}

	/**
	 * This will prevent alert massacre
	 */
	window.alert = (function (native_alert) {
		var recent_alerts = [];
		var in_alert = false;
		return function (msg) {
			if (in_alert) {
				mcc.log('alert(...): discarded reentrant alert.');
				return;
			}
			in_alert = true;
			recent_alerts.push(mcc.now());

			if (recent_alerts.length > 3) {
				recent_alerts.splice(0, recent_alerts.length - 3);
			}

			if (recent_alerts.length >= 3 &&
					(recent_alerts[recent_alerts.length - 1] - recent_alerts[0]) < 5000) {
				if (confirm(msg + "\n\nLots of alert()s recently. Kill them?")) {
					window.alert = mcc.noop;
				}
			} else {
				//  Note that we can't .apply() the IE6 version of this "function".
				native_alert(msg);
			}
			in_alert = false;
		}
	})(window.alert);
}

/**
 * Checks if something is on the window (global) namespace, but can use, for exemple:
 *
 * `mcc.find_in_namespace('mcc.find_in_namespace')` will return this function
 *
 * mcc.find_in_namespace('something.not.really.defined') will return undefined
 *
 * @param Object
 */
mcc.find_in_namespace = function (ns_string) {
	var parts = ns_string.split('.'),
		parent = window,
		i;

	for (i = 0; i < parts.length; i += 1) {
		// create a property if it doesn't exist
		if (typeof parent[parts[i]] === 'undefined') {
			return undefined;
		}

		parent = parent[parts[i]];
	}

	return parent;
};