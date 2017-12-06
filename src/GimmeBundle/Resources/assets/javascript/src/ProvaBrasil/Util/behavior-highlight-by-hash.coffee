###
@requires js/mcc/core/behavior.js
          js/underscore.js
          js/jquery.js
          js/jquery.smoothscroll.js

This behavior should be used when we want to scroll to and highlight and id passed via URL.

For exemple: /ajuda/#portal

The behavior would look for an tag with id attribute of #portal and scroll the screen to it and then highlight it.

There is an magic in the hashes for choosing what element to select:

  #blockname  (will hightlight the element#blockname)
  #blockname+ (will hightlight the element#blockname plus the next element)
  #blockname- (will hightlight parent of the element#blockname)

@todo In the future we should bind to hashchange event (http://benalman.com/projects/jquery-hashchange-plugin/)

###

mcc.behavior 'provabrasil-behavior-util-highlight-by-hash', (config, configStatic) ->
  # Singleton Behavior
  if configStatic.already_runned
    return

  configStatic.already_runned = true

  if not config.background
    config.background = '#02F181'

  last_fragment = null
  last_element = null

  find_and_highlight = (event) ->
    fragment = window.location.hash

    if fragment and fragment isnt last_fragment
      last_fragment = fragment

      what_to_highlight = fragment.substr(fragment.length - 1, 1);

      if what_to_highlight is '+' or what_to_highlight is '-'
        fragment = fragment.substr(0, fragment.length - 1)

      el = $(fragment)

      return false if not el.length

      if last_element? and last_element.length
        $(last_element).stop(true, true)

      if what_to_highlight is '+'
        el = el.add(el.next())
      else if what_to_highlight is '-'
        el = el.parent()

      last_element = el

      old_background_color = el.css('background-color')
      original_background  = ''#if old_background_color is 'rgba(0, 0, 0, 0)' then '' else old_background_color

      $.smoothScroll
        scrollTarget : el
        offset       : 'middle'
        afterScroll  : ->
          el
          .animate('background-color': config.background, 500)
          .animate('background-color': old_background_color, 8000, ->
            el.css('background-color', original_background)
          )

  # comentei porque não estava funcionando e gerava erros no console.
  # setInterval(find_and_highlight, 50)