ProvaBrasilExploreSubnavView = Backbone.View.extend

  el: '.explore-filters-section'

  events:
    'click #sort-container a'                     : 'sort'
    'click #explore-btn-zoom button'              : 'zoom'

    'click .explore-topbar-compare .explore-topbar-compare button'                : 'highlight'
    'click .explore-topbar-compare .explore-topbar-compare-clean a' : 'clearSelected'

    'click .explore-topbar-search input[type=search]'   : 'searchFocus'
    'click .explore-topbar-search .search-reset'        : 'resetSearch'
    'click .explore-topbar-search button'               : 'searchFocus'


  initialize: (@options) ->
    @initTypeahead()

    @$btnView = @$el.find('.explore-topbar-mode button')
    
    @handleGlobalEvents()
  
  
  highlight: (e) ->
    $this = $(e.currentTarget)
    params = if $this.hasClass 'active' then true else false
    
    _events.trigger 'isotope:highlight', params, $this
    
  
  initTypeahead: ->
    @$searchInput = @$el.find('.explore-topbar-search input[type=search]')
    @$searchReset = @$el.find('.explore-topbar-search .search-reset')

    name = _.pluck(@options.entities, 'name');

    @$searchInput.typeahead
      source: name
    .on 'keyup', (e) =>
      @search e
  
  
  selectItem: (e) ->
    e.stopPropagation()
    e.preventDefault()

    @$searchInput.val('')
      type: 'keyup'
      keyCode: 13
    
  searchFocus: (e) ->
    e.preventDefault()

    if not @$searchInput.val()
      @$searchInput.focus()
  
  search: (e) ->
    text = @$searchInput.val()

    if text.length
      @$searchReset.fadeIn('fast')
    else
      @$searchReset.fadeOut('fast')
    
    _events.trigger 'isotope:overlay', text.toLowerCase(), e.keyCode

  resetSearch: (e) ->
    @$searchInput.val('').trigger 'keyup'

  clearSelected: (e) ->
    e.preventDefault()
    
    $li = $('#isotope_container').find('li.advanced').removeClass 'advanced'
    _events.trigger 'router:update', [{ key: '#list', value: '' }]

    @$searchInput.trigger 'keyup'
  
  
  zoom: (e) ->
    $this = $(e.currentTarget)
    value = $this.data('value')
    
    if value
      currentZoom = parseInt $('#z').val(), 10
      if value is 'plus' then currentZoom++ else currentZoom--
      
      return false if currentZoom is 0 or currentZoom is 4
      _events.trigger 'router:update', [{ key: '#z', value: currentZoom }]
  
      
  submit: (e) ->
    e.preventDefault()
    $(e.currentTarget).trigger 'keyup'
  
  
  sort: (e) ->
    e.preventDefault()
    $this = $(e.currentTarget)
    
    _events.trigger 'router:update', [ { key: '#asc', value: $this.data().asc }, {key: '#sort', value: $this.data().sortby }], =>
      
      _events.trigger 'isotope:updateEmptyValues', $this.data().asc, $this.data().sortby
      
      window.setTimeout =>
         _events.trigger 'isotope:sort'
      , 100
      
          
  initStates: (queryParams) ->
    queryParams = queryParams || {}

    @changeMapBtnState queryParams
    @changeSortBtnState queryParams
    @changeTotalState queryParams  
    
    _events.trigger 'stateChanged:zoom', queryParams
  
  
  changeMapBtnState: (queryParams) ->
   
    if @$btnView.size() > 0
      
      if queryParams.vs is '2'
        @$btnView.addClass('show-map').data().value = '1' 
      else
        @$btnView.removeClass('show-map').data().value = '2'
        
      
  changeSortBtnState: (queryParams) ->
    asc = if queryParams.asc is 'true' then true else false
    isBasic = if queryParams.adv is '0' then true else false
    
    $target = if isBasic then @$el.find(".simple #sort-#{ queryParams.sort }") else @$el.find(".advanced #sort-#{ queryParams.sort }")
    
    if $target.size() > 0
      @$el.find('#sort-container ul li.selected').removeClass 'selected' if not isBasic
      value = if $target.data().asc is true then false else true
       
      $target.parent().addClass('selected').end().attr('id', "sort-#{ queryParams.sort }").data('asc', value)
       
      params = if value then { toRemove: 'icon-arrow-up', toAdd: 'icon-arrow-down' } else { toAdd: 'icon-arrow-up', toRemove: 'icon-arrow-down' } 
      $target.find('.icon').removeClass(params.toRemove).addClass(params.toAdd)
    
      if not @firstTime
        @firstTime = true
        
        window.setTimeout =>
          _events.trigger 'isotope:sort'
        , 100
   
         
  changeTotalState: (queryParams) ->
    #window.setTimeout =>
    total = $('#isotope_container').find('li.advanced').size()
    selectionText = ''

    if total is 0
      selectionText = 'Selecione 2 ou mais quadrados para comparar.'
    else if total is 1
      selectionText = 'Selecione 1 ou mais quadrados para comparar. '
    else
      selectionText = total + ' selecionados'

    @$('.explore-topbar-compare .explore-topbar-compare-selection').html selectionText

    method = if total > 1 then 'removeClass' else 'addClass'
    @$('.explore-topbar-compare .explore-topbar-compare-clean, .explore-topbar-compare .explore-topbar-compare-action')[method] 'hide'
    #, 50
    
  
  handleGlobalEvents: ->
    _events.on 'view:initState', @initStates, @
    _events.on 'counter:update', @updateCounter, @