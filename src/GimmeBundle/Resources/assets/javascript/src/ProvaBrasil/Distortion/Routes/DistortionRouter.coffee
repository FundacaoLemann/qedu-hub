###
  Devido a escolha da equipe em montar a URL usando uma querystring, e devido ao fato do Router do Backbone ter uma issue
  relacionada ao uso de rotas com querystrings, decidi montar essa classe com o mais básico para o uso de rotas com querystring
  na página de distorção idade/série.

  Não chega ser muito poderosa, na verdade, apenas implementa captura o reconhecimento da querystring, alterando no filtro conforme
  necessário.

  Além disso, implementa listeners no modelo de filtro para dar um pushState (se suportado), for selecionado.

  É isso. Opiniões?

  Ass: Fernando
###
class DistortionRouter

  constructor: (@filter) ->
    _.bindAll @, 'navigate', 'updateFilter', 'delegateEvents', 'undelegateEvents', 'enable', 'disable'


  hasPushState: () ->
    Modernizr.history

  navigate: () ->
    data = @filter.toJSON()
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
    fieldsInInt = ['dependence', 'year', 'localization']
    for field in fieldsInInt
      if _.has obj, field
        try
          obj[field] = parseInt obj[field]
        catch e
          delete obj[field] #Invalid field, the script can ignore
    @filter.set obj,
     unset: false
    @navigate()

  delegateEvents: () ->
    @filter.on 'change', @navigate
    if @hasPushState()
      $(window).on 'popstate', @updateFilter
    else
      $(window).on 'hashchange', @updateFilter

  undelegateEvents: () ->
    @filter.off 'change', @navigate
    if @hasPushState()
      $(window).off 'popstate', @updateFilter
    else
      $(window).off 'hashchange', @updateFilter

  enable: () ->
    @delegateEvents()
    @updateFilter()

  disable: () ->
    @undelegateEvents()