/**
 * Reload Behavior
 *
 * This a behavior to quickly reload the window by pressing R
 *
 * It reloads the page without cleaning the cache, so its really fast. Its like F5 on Windows.
 *
 * Use COMMAND/CTRL + R for a reload cleaning some caches and COMMAND/CTRL + SHIFT + R for a full reload
 *
 * @requires js/mcc/core/behavior.js
 *           js/jquery.js
 */

mcc.behavior('dev-reload', function(config){
	if (__DEV__) {
        $(document.body).on('keydown.dev-reload', function(event){
            if (event.which === 82 && event.target === document.body) {
                window.location = window.location
            }
        })
	}
});