###
@requires js/backbone.js
          js/backbone.validation/backbone.validation.js

This model holds and validates the state of all filters in the explore and the state of the Explore App
###

ProvaBrasilExploreState =  Backbone.Model.extend
  validation:

    ### BOTÕES de FILTRO ###

    grade:
      required: false
      oneOf: ['5', '9']

    discipline:
      required: false
      oneOf: ['1', '2']

    dependence:
      required: false
      oneOf: ['0', '2', '3']

    ### ZOOM ###

    zoom:
      required: false
      oneOf: ['1', '2', '3']

    ### ORDENAÇAO ###

    sort:
      required: false
      oneOf: ['name', 'optimal_index', 'optimal_index_perfect_hundred', 'enrolled_count', 'growth', 'nse']

    sortDirection:
      required: false
      oneOf: ['asc', 'desc']

    ### VISUALIZAÇÃO ###

    visualization:
      required: false
      oneOf: ['isotope', 'map']

    mode:
      required: false
      oneOf: ['basic', 'advanced']

    comparingSelected:
      required: false
      oneOf: ['no', 'yes']

    openSelected:
      required: false
      oneOf: ['no', 'yes']


  defaults:
    grade: '5'
    discipline: '1'
    dependence: '0'

    zoom: '2'

    sort: 'name'
    sortDirection: 'asc'

    visualization: 'isotope'

    mode: 'basic' # can be basic or advanced

    selected: '' # the ids that are selected (this could be in the collection/model instead)

    comparingSelected: 'no' # are we in comparing mode?

    openSelected: 'no'

    minSelectedToCompare: 2 # how many do we need to enable comparing?

    regionalLevel : 'city' # can be: country (showing states), state (showing cities) or city (showing schools)


  # what fields can be serialized in the url?
  urlFields: ['grade', 'discipline', 'dependence', 'nse', 'zoom', 'sort', 'sortDirection', 'visualization'] #, 'selected', 'comparingSelected'


  initialize: () ->
    _.extend(@, Backbone.Validation.mixin);

    @selectedModels = {}

    @.on('change:selected', @_selectedChange, @)
    @.on('change:sort', @_sortChange, @)


  getSelectedModels: () ->
    return @selectedModels


  isModelSelected: (model) ->
    key = "#{model.get('type')}:#{model.get('id')}"

    return if @selectedModels[key] is undefined then false else true


  addToSelected: (model) ->
    key = "#{model.get('type')}:#{model.get('id')}"

    if @selectedModels[key] is undefined
      @selectedModels[key] = model

      @setViaInterface(
        selected : _.keys(@selectedModels).join('|')
      )

  removeFromSelected: (model) ->
    key = "#{model.get('type')}:#{model.get('id')}"

    if @selectedModels[key] isnt undefined
      delete @selectedModels[key]

      @setViaInterface(
        selected : _.keys(@selectedModels).join('|')
      )


  emptySelected: () ->
    @selectedModels = {}

    @setViaInterface(
      selected : ''
    )


  _selectedChange: () ->
    selectedCount = _.size(@selectedModels)

    if selectedCount is 0 and @get('openSelected') is 'yes'
      @setViaInterface(
        openSelected : 'no'
      )

    if selectedCount < @get('minSelectedToCompare') and @get('comparingSelected') is 'yes'
      @setViaInterface(
        comparingSelected : 'no'
      )

  _sortChange: () ->
#    if @get('mode') is 'basic'
#      if @get('sort') is 'name' and @get('sortDirection') is 'desc'
#        @setViaInterface({ sortDirection: 'asc' })
#      else if @get('sort') is 'optimal_index' and @get('sortDirection') is 'asc'
#        @setViaInterface({ sortDirection: 'desc' })


  # updates the state model via interface
  setViaInterface: (data, options) ->
    finalData = {}
    _.each(data, (value, key) ->
      finalData[key] = value
    , @)

    return @set(finalData, options)


  # updates the state model via url (query)
  # only allows urlFields
  setViaUrl: (data, options) ->
    finalData = {}
    _.each(data, (value, key) ->
      if not @isUrlField(key)
        return

      finalData[key] = value
    , @)

    if _.size(finalData) is 0
      return false

    return @set(finalData, options)

  isUrlField: (key) ->
    return _.indexOf(@urlFields, key) isnt -1

  getURLFields: () ->
    return _.pick @toJSON(), @urlFields

  rotateZoom: () ->
    zoom = parseInt(@get('zoom'), 10) + 1

    if zoom > 3
      zoom = 1

    @set('zoom', zoom)
