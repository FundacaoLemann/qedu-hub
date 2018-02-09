###
@requires js/provabrasil/util/statemenu.coffee
###

###
 * Gerencia o comportamento do bloco principal da pághina de comparação.
 * Quando for uma página de escola, gerencia o bloco de escola
 * quando for de município, o bloco do município dono da página
 * e assim por diante...
 * 
 * Este bloco engloba também o filtro seletor.
###
ViewFiltersCompare = Backbone.View.extend

  el : 'div.db-filters'
  collection : null

  statemenu: null

  events:
    'click .nav-pills li a' : 'clickDimensionFilter'    
  
  initialize: (@options) ->
    @statemenu = new StateMenu @options.stateMenuConfigs

    @$el.mask(window.i18n('compare.loading'));
    @collection = new CompareCollection()
    @collection.on "sync", @dataLoaded.bind @
    @collection.fetch()

  dataLoaded: (param) ->
    @$el.unmask()

  set: (filter, value) ->
    @statemenu.set filter, value  #Just sync with the server

    el = $("a[data-filter='"+filter+"'][data-value="+value+"]")
    li = el.parent()
    ul = li.parent()

    ul.find('.active').removeClass 'active'
    li.addClass 'active'

    @updateFilterModels()

  updateFilterModels: ->
    @collection.each (model) =>
      model.set 'filter',
        discipline_id: parseInt @statemenu.get('discipline')
        grade_id: parseInt @statemenu.get('grade')
        dependence_id: parseInt @statemenu.get('dependence')

  clickDimensionFilter: (ev) ->
    ev.preventDefault()
    el = $ ev.currentTarget

    #get data to filter
    filter = el.attr 'data-filter'
    value = el.attr 'data-value'
    @set filter, value