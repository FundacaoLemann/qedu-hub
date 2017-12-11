/**
 * Uservoice widget
 *
 * @todo This Should became a Real Class that can be accessed in a standard way and will not really load clicky javascript
 * until the page is complete. But it will be possible for early pieces to have access to the clicky methods that will get
 * pushed to for latter use when clicky actually loads.
 *
 * @requires js/mcc/core/behavior.js
 */

mcc.behavior('uservoice-widget', function(config){
  if (__DEV__) {
    if (!config.id) {
      mcc.exception('behavior-uservoice: ID is not defined. Please provide one.');
    }
  }

  var url = '//widget.uservoice.com/'+config.id+'.js';

  if (config.user_logged === false) {
    if (config.subdomain === undefined) {
      config.subdomain = 'feedback';
    }

    mcc.BigPipe.load_resources('http://'+config.subdomain+'.uservoice.com/logout.js');
  }

  // Include the UserVoice JavaScript SDK (only needed once on a page)
  UserVoice = window.UserVoice || [];
  (function () {
    var uv = document.createElement('script');
    uv.type = 'text/javascript';
    uv.async = true;
    uv.src = url;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(uv, s)
  })();

  // Set configuration
  _.each(config['push'], function(v, k) {
    UserVoice.push([k, v]);
  });

  // Autoprompt for Satisfaction and SmartVote (only displayed under certain conditions)
  UserVoice.push(['autoprompt', {}]);
});



