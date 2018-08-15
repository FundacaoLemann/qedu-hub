###
@requires js/backbone.js
###

DistortionEntities = Backbone.Collection.extend
  initialize: (models, options) ->
    _.bindAll @, 'addEvolutionDataToEntity', 'addEvolutionDataToModel', 'getFilter', 'setFilter', 'parse',
      'setParentModel', 'processQueue', 'continueProcessingQueue', 'fetch'
    @setParentModel options.parentModel if options and options.parentModel
    @distortionFilter = new DistortionFilter 2017, 0, 0, 1

    @temporaryDistortionData = {}
    @on 'add', @addEvolutionDataToEntity

    ###
      Want to know what are the variables below? See in the DistortionEvolution.coffee file :)
    ###
    @filtersUsed = []
    @filtersQueue = []
    @actualOptions = null
    @actualFilter = null
    @on 'sync', @continueProcessingQueue

  url: () ->
    if __DEV__
      throw 'You need to overwrite the method url()'

  model: () ->
    if __DEV__
      throw "You need to overwrite the method/attribute model"

  addEvolutionDataToEntity: (model, collection, options) ->
    @addEvolutionDataToModel model, options['actualFilter']

  addEvolutionDataToModel: (model, filter=@actualFilter) ->
    if filter not instanceof DistortionFilter
      filter = @actualFilter
    if not filter
      throw "Actual Filter not found (in collection of entities)"
    idModel = model.get 'id'
    distortionData = @temporaryDistortionData[idModel]
    if not distortionData and __DEV__
      throw "Error in capture of the data of Distortion"
    distortionModel = new DistortionStatus()
    distortionModel.set distortionData
    distortionModel = model.getEvolution().addFilterAttributes distortionModel, filter
    model.getEvolution().add distortionModel,
      silent: true
    delete @temporaryDistortionData[idModel]

  getFilter: () ->
    if not @distortionFilter and __DEV__
      throw 'Specify a filter'
    @distortionFilter

  setFilter: (@distortionFilter) ->
    if @distortionFilter not instanceof DistortionFilter and __DEV__
      throw "Filter invalid"

  parse: (modelsData, options) ->
    allowed_keys = ['id','name','ibge_id']
    result = []
    for modelData in modelsData
      distortionData = _.omit modelData, allowed_keys
      modelData = _.pick modelData, allowed_keys
      idModel = modelData['id']
      @temporaryDistortionData[idModel] = distortionData
      if model = @get idModel
        @addEvolutionDataToModel model, options['actualFilter']
      else
        modelData['actualFilter'] = options['actualFilter']
        result.push modelData
    result

  setParentModel: (@parentModel) ->
    if @parentModel not instanceof DistortionEntity
      @parentModel = new DistortionEntity
        id: @parentModel

  getParentModel: () ->
    @parentModel

  processQueue: () ->
    if @actualOptions isnt null
      #We are waiting a request
      return
    else if _.isEmpty @filtersQueue
      # or we not have a queue to process!
      @trigger 'queue-done'
      return
    @trigger 'queue-started'
    @actualOptions = @filtersQueue.shift()
    if not @actualOptions
      return
    Backbone.Collection.prototype.fetch.call @, @actualOptions

  continueProcessingQueue: () ->
    ### There are a filter that is loaded. Here, we continue loading other items, if there exists ###
    @trigger 'queue-finalizated'
    @each (model) ->
      model.getEvolution().removeDuplicates() #Remove duplicates, if it exists
    @actualOptions = null # There are not requests actually happening
    @processQueue() # Continue to the next request

  fetch: (options = {}) ->
    @trigger 'start-sync'
    filter = @getFilter().clone()
    urlParams = filter.getURLParamsForEntities()
    options['actualFilter'] = filter
    options['data'] = urlParams
    options['remove'] = false
    oldSuccess = options['success'] or () ->
    if _.findWhere @filtersUsed, urlParams
      @trigger 'sync', @, null, options
      oldSuccess.call @, @, null, options
      return
    options['success'] = (collection, response, options) ->
      oldSuccess.call this, collection, response, options
    if _.findWhere @filtersQueue, options
      return
    @filtersUsed.push urlParams
    @filtersQueue.push options
    @processQueue()
