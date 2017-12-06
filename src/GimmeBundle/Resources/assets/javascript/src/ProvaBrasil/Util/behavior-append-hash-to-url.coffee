###
@requires js/mcc/core/behavior.js
          js/underscore.js
          js/jquery.js

This is a behavior to auto append the current hash fragment and query string (for html5 history) to the clicked link.

If we pass a selector to the config it will auto delegate all a tags with magic, if not it will append to all a tags with .append-query or .append-hash class

append_query config will also include any hash fragment.
target_selector can be passed too

@todo will have to do it watching when location.href change (see backbone route) and update the links, cause when open in new window we can not
stop the event.
###

mcc.behavior 'provabrasil-behavior-util-append-hash-to-url', (config) ->
  # When the link gets clicked we change its href
  href_changer = (event) ->
    el = $(event.currentTarget)

    if el.data 'href-changed'
      return

    current_url = mcc.$U window.location.href
    new_url = mcc.$U window.location.href
    el_url = mcc.$U el.attr 'href'

    new_url.path = el_url.path

    if not event.data.append_query
      new_url.query_params = undefined

    el.attr 'href', new_url.toString()
    el.data 'href-changed', true


  # Bind the events to a click
  selector = null
  target_selector = 'a'

  if config.target_selector
    target_selector = config.target_selector

  if config.selector
    selector = $(config.selector)
  else
    selector = $('html')

  if config.append_query
    selector.off('click.append-query').on 'click.append-query', target_selector+(if config.selector then '' else '.append-query'), {append_query : true}, href_changer
  else
    selector.off('click.append-hash').on 'click.append-hash', target_selector+(if config.selector then '' else '.append-hash'), {append_query : false}, href_changer