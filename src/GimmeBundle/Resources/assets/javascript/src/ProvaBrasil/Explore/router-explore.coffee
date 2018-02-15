class ProvaBrasilExploreRouter extends Backbone.Events

  constructor: (@state, @root) ->
    _.bindAll @, 'navigate', 'getHash', 'updateFilter', 'delegateEvents', 'undelegateEvents', 'enable', 'disable', 'hasData'

  hasPushState: () ->
    Modernizr.history

  navigate: () ->
    data = @state.getURLFields()
    queryString = mcc.URI.objectToQueryString data
    newQueryString = window.location.pathname + '?' + queryString
    if @hasPushState()
      window.history.replaceState data, document.title, newQueryString
      if not _.isEmpty(@getHash())
        window.location.hash = ""
    else
      newQueryString = "#" + queryString
      window.location.hash = newQueryString
      if not _.isEmpty(window.location.search)
        window.location.search = ""

  getHash: (w = window) ->
    result = w.location.href.match(/#(.*)$/)
    if result
      result[1]
    else
      ''

  updateFilter: () ->
    queryString = ""
    if _.isEmpty(window.location.search)
      queryString = @getHash()
    else
      queryString = window.location.search.substring(1)
    obj = mcc.URI.queryStringToObject queryString
    obj = _.pick obj, @state.urlFields
    @state.set obj, #window.location.search includes a ? before of the querystring
      unset: false
    @navigate()

  delegateEvents: () ->
    @state.on 'change', @navigate
    if @hasPushState()
      $(window).on 'popstate', @updateFilter
    else
      $(window).on 'hashchange', @updateFilter

  undelegateEvents: () ->
    @state.off 'change', @navigate
    if @hasPushState()
      $(window).off 'popstate', @updateFilter
    else
      $(window).off 'hashchange', @updateFilter

  enable: () ->
    @delegateEvents()

  disable: () ->
    @undelegateEvents()

  hasData: () ->
    urlParams = mcc.URI.queryStringToObject window.location.search.substring(1)
    dataState = _.pick urlParams, @state.urlFields
    return not _.isEmpty(dataState)