###
@requires js/mcc/core/behavior.js
          js/underscore.js
          js/jquery.js
          js/jquery-color.js
          js/jquery.smoothscroll.js
###

mcc.behavior 'provabrasil-behavior-footer', (config) ->
  if not config.background
    config.background = '#02F181'

  # Scroll to the features
  $('.main-footer a.main-footer-links-find-school').click (event) ->
    event.preventDefault()

    offset = if config.home then 20 else 0;
    scrollTarget = if config.home then $('.home-callout') else null;

    $.smoothScroll
      scrollTarget : scrollTarget
      offset       : offset
      afterScroll  : ->
        $('.global-search-container input')
        .focus()
        .animate('background-color': config.background, 500)
        .animate('background-color': '#fff', 2500)