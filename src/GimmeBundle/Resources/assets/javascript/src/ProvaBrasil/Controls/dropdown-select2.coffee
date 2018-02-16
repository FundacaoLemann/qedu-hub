###
@requires js/mcc/core/behavior.js
          js/jquery.js
          js/underscore.js
          js/select2-base.js
          js/select2.js
###
$(window).on('resize select2-open', _.throttle(() ->
  # console.log 'Redimensionando' if __DEV__
  height = $(this).height()/2
  dropdowns = $('.dropdown-auto-height')
  dropdowns.each () ->
    dropdown = $(this)
    if not dropdown.is ':visible'
      return
    dropdown_y = dropdown.offset().top
    recommended_height = height-dropdown_y+100
    dropdown.find('.select2-results').animate
      'max-height': recommended_height+'px'
, 500)).resize()
behaviorDropdownSelect2 = (config) ->
  convert = (data, function_keys = [
    'placeholderOption',
    'id',
    'matcher',
    'sortResults',
    'formatSelection',
    'formatResult',
    'formatResultCssClass',
    'formatNoMatches',
    'formatSearching',
    'formatInputTooShort',
    'formatSelectionTooBig',
    'createSearchChoice',
    'initSelection',
    'tokenizer',
    'query',
    name: 'ajax'
    methods: [
      'transport',
      'url',
      'jsonpCallback',
      'data',
      'results',
      'params'
    ]
    'tags',
    'containerCss',
    'containerCssClass',
    'dropdownCss',
    'dropdownCssClass',
    'adaptContainerCssClass',
    'adaptDropdownCssClass',
    'escapeMarkup',
    'nextSearchTerm'
  ]) ->
    ###
      This function accesses the configuration passed by the behavior and, if possible, replaces a function name
      by it's direct reference in global namespace using mcc.find_in_namespace, but only if it is not a function
      and if a function is found in global namespace.

      Why? Why a string is not a function to Select 2..(and to me too)

      (but for PHP is!)
    ###
    for function_key in function_keys
      if _.isObject(function_key) and data[function_key['name']]
        # The case of Ajax
        data[function_key['name']] = convert data[function_key['name']], function_key['methods']
      else if data[function_key] and not _.isFunction data[function_key]
        fn = mcc.find_in_namespace data[function_key]
        if not fn
          continue
        data[function_key] = fn
    return data
  config = convert config
  if config['fetch_from']
    # Defines a query function that fetches from the URL specified a unique time and queries the data consistently
    # in the browser
    exclude_filters = []
    if not config['exclude_case']
      config['exclude_case'] = []
    for exclude_case in config['exclude_case']
      exclude_filters.push new RegExp exclude_case
    is_valid = (item) ->
      if item['hide_from_search']
        return false
      for exclude_filter in exclude_filters
        if not exclude_filter.test item['text']
          return false
      return true
    items_per_page = 25 # 10 itens per page

    search = (items, options) ->
      if options.term.length == 0
        # If we have nothing to search, return the original items array
        return items
      result = []
      for item in items
        #Find the result....Note that it is case insensitive
        matcher = config['matcher'] or $.fn.select2.defaults['matcher']
        if matcher(options.term, item.text) and is_valid item
          #If match, we push to found array
          result.push item
        if item['children']
          # If we have children, find it recursively and concat it to the result
          result = result.concat process item['children'], options

      return result
    process = (results, options) ->
      if config['auto_hide'] and result.length is 0
        options.element.hide()
        return
      found = search results, options
      if found.length > 30
        # We need of infinite scroll as Select 2 is too slow to renderize the itens
        # With a dataset of exactly 295 itens, the function options.callback have a time
        # of ~430ms, afecting firefox performance at all.
        # With infinite scroll and 10 itens ~per page~, the options.callback process in
        # ~25ms. So great, no? =)
        found = found.slice items_per_page*(options.page-1), items_per_page*options.page
        more = found.length == items_per_page # Detect if the scroll can terminate
      else
        more = false
      options.callback
        results: found
        more: more
        context: null
    config['query'] = (options) ->
      # Just query logic
      e = options.element
      key = 'cache-'+config['fetch_from']
      if e.data key
        # Get the element of the cache
        _.defer process, e.data(key), options
      else
        # Fetch result from server using jQuery and Ajax
        $.ajax
          'url': config['fetch_from']
          'dataType': 'json'
          'success': (result) ->

            e.data key, result #Caches in the element
            _.defer process, result, options #Show results to the user
  #If the server fails, as the script does not encounter a cache, requests will be made continuously as users
  #clicks or type o/

  objToAttr = (obj) ->
    s = ""
    for key, value of obj
      s += "#{key}='#{value}' "
    return s
  addImage = (item) ->
    html = ''
    if item.image
      html += "<img src='#{item.image}' #{objToAttr item.image_attributes} /> #{item.text}"
    else
      # It's don't have a image!
      html += item.text
    return html
  config['escapeMarkup'] = (content) -> content
  if not config['formatResult']
    config['formatResult'] = addImage
  if not config['formatSelection']
    config['formatSelection'] = addImage
  if not config['containerCssClass']
    config['containerCssClass'] = ''
  if config['initial_selection']
    if _.isArray config['initial_election']
      config['query'] = (options) ->
        options.callback config['initial_selection']
    else if _.isObject config['initial_selection']
      config['query'] = (options) ->
        options.callback config['initial_selection']['results']
      if config['initial_selection']['first'] is null
        config['containerCssClass'] += 'dropdown-empty-initial-value'
      config['initSelection'] = (element, callback) ->
        callback
          id: -1
          text: config['initial_selection']['first']
    else
      config['initSelection'] = (element, callback) ->
        callback
          id: -1
          text: config['initial_selection']
  else
    config['containerCssClass'] += 'dropdown-empty-initial-value'
  if config['formatSearchingText']
    config['formatSearching'] = () -> config['formatSearchingText']
  if not config['dropdownCssClass']
    config['dropdownCssClass'] = ''
  config['dropdownCssClass'] += ' '
  if _.indexOf([0,1,2], config['height']) != -1
    if config['height'] == 0
      config['dropdownCssClass'] += 'dropdown-auto-height'
    else if config['height'] == 1
      config['dropdownCssClass'] += 'dropdown-limited-height'
    else
      config['dropdownCssClass'] += 'dropdown-unlimited-height'
  if config['pull_right']
    config['dropdownCssClass'] += ' pull-right-select2'
  if config['small_dropdown']
    config['dropdownCssClass'] += ' small-select2'
  if config['extra_dropdown_classes']
    config['dropdownCssClass'] += ' '+config['extra_dropdown_classes']
  config['dropdownAutoWidth'] = true
  if config['formatNoMatches'] and not _.isFunction config['formatNoMatches']
    messageNoMatch = config['formatNoMatches']
    config['formatNoMatches'] = (term) ->
      messageNoMatch.replace('%s', term)
  el = $("##{config.idElement}")
  el.select2 config
  body = $('body')
  getScrollbarWidth = ()->
    div = document.createElement 'div'
    $(div).css
      'width': '200px'
      'visibility': 'hidden'
      'overflow': 'scroll'
      'position': 'absolute'
      'top': 0
      'left': 0
    .appendTo('body')
    p = document.createElement 'p'
    $(p).css
      'width':'100%'
      'height': '100px'
    .appendTo div
    width = $(div).width()-$(p).width()
    $(div).remove()
    return width
  scrollbarWidth = getScrollbarWidth()
  el.on 'select2-open', (e) ->
    $(window).trigger 'select2-open'
    dataLayer.push({
                'event': 'breadcrumbTrigger',
                'breadcrumbAction': 'Breadcrumb clicked',
                'breadcrumbLabel': 'Search appeared'
            });
    results = $('.select2-results')
    theInput = el.select2 'search'
    checkClose = setInterval () ->
      if not el.select2 'opened'
        # When the dropdown is closed, we trigger blur in all we can to trigger in the element \o/
        el.select2('container').find('*').trigger 'blur'
        clearInterval checkClose # And clear interval, too
    , 250
    results.on 'click', '.select2-clean', () ->
      theInput.val('') #Cleans the visible select2
      theInput.trigger 'keyup-change' # A little hack that force Select 2 to update the results in the screen
    results.parent().on 'click', '.select2-redirect', () ->
      link = $(this)
      if not link.data 'url'
        return
      window.location.href = link.data 'url'
    results.parent().on 'click', '.select2-set-config', () ->
      if $(this).data 'lock'
        return
      $(this).data 'lock', true
      newConfig = $(this).data()
      if newConfig['last'] and config['lastConfig']
        if __DEV__
          console.log 'Restaurando configuração antiga'
        console.log config['lastConfig']
        newConfig = config['lastConfig']

      if config['lastConfig']
        if __DEV__
          console.log 'Apagando configuração antiga para evitar recursão'
        delete config['lastConfig']
      if __DEV__
        console.log 'Salvando configuração anterior'
      newConfig['lastConfig'] = _.clone config
      result = _.extend config, newConfig
      if __DEV__
        console.log "O objeto final ficou assim:"
        console.log result
      el.select2 'close'
      el.select2 'destroy'
      el.off()
      behaviorDropdownSelect2 result
      el.select2('container').css 'display', ''
      el.select2 'open'
      $(this).data 'lock', false
    results.on 'mouseover', () ->
      body.css('padding-right',scrollbarWidth+'px').addClass 'select2-no-scroll'
    results.on 'mouseout', () ->
      body.css('padding-right','0px').removeClass 'select2-no-scroll'
    if config['placeholder_input']
      $('.select2-input').attr 'placeholder', _.result config, 'placeholder_input'
    if config['message_bottom']
      drop = $('.select2-drop:visible')
      if drop.find('.select2-bottom').length == 0
        messageBottom = document.createElement 'div'
        $(messageBottom).html(config['message_bottom']).addClass('select2-bottom').appendTo drop
  el.on 'select2-selecting', (e) ->
    if e.object.url

      label = 'Search result clicked '.concat(e.object.text)
      dataLayer.push({
                'event': 'breadcrumbTrigger',
                'breadcrumbAction': 'Breadcrumb search clicked',
                'breadcrumbLabel': label
        });
      window.location.href = e.object.url
    else if e.object.hide_from_search
      e.preventDefault()

mcc.behavior 'behavior-dropdown-select2', behaviorDropdownSelect2
