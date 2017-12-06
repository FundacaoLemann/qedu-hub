###
@requires js/mcc/core/behavior.js
          js/underscore.js
          js/jquery.js
          js/jquery.smoothscroll.js

  This behaviors auto add smoothscroll to links with data-smoothscroll

  data-smoothscroll : selector to be the target. Can also be 'top' to go to the top of the screen
  data-offset : the offset in pixels, can also be 'middle'. The default is -40px
###

mcc.behavior 'provabrasil-behavior-util-smoothscroll', (config) ->
  $('body').on('click.smoothscroll.data-api', '[data-smoothscroll]', (event) ->
    $el = $(this)

    # Special case to go to the top of the screen
    if $el.data('smoothscroll') is 'top'
      $el.data('smoothscroll', 'body').data('offset', 0)

    $target = $($el.data('smoothscroll'))

    if $target.length > 0
      scrollOptions = {
        scrollTarget : $target
      }

      if $el.data('offset')?
        scrollOptions['offset'] = $el.data('offset')

      $.smoothScroll(scrollOptions)

    event.preventDefault()
  )
