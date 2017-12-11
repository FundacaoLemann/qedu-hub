/**
 * @requires js/underscore.js
 *
 * Initialize the mcc namespace and core functions.
 *
 * This usually will be in the header of the document and all the rest goes to the footer.
 */

(function() {

	if (window.mcc) {
		return;
	}

	window.mcc = {};

	window['__DEV__'] = window['__DEV__'] || 0;
})();