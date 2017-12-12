DistortionEntity = Backbone.Model.extend

  constructor: () ->
    @evolution = @collectionEvolution()
    Backbone.Model.apply @, arguments

  initialize: () ->
    _.bindAll @, 'getEvolution', 'parse', 'processQueue', 'continueProcessingQueue', 'fetch'
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
      throw "You need to overwrite the method url()"

  defaults: () ->
      name: ""
      id: ""
      ibge_id: ""

  collectionEvolution: () ->
    throw "You need to overwrite the method collectionEvolution"

  getEvolution: () ->
    @evolution

  parse: (response, options) ->
    filter = @actualFilter
    data = if response then response['data'] else []
    if options['actualFilter']
      @actualFilter = filter = options['actualFilter']
    if not filter
      throw "Actual Filter not found (in model)"
    response = _.omit response, 'data'
    evolution = @getEvolution()
    for stage, status of data
      statusModel = new DistortionStatus()
      statusModel.set status
      statusModel = evolution.addFilterAttributes statusModel, filter
      statusModel.set 'stageId', stage
      evolution.add statusModel,
        silent: true
    evolution.removeDuplicates()
    response


  processQueue: () ->
    if @actualOptions isnt null
      #We are waiting a request
      return
    else if _.isEmpty @filtersQueue
      # or we not have a queue to process!
      @trigger 'queue-done'
      return
    @trigger 'queue-started'
    @actualOptions = @filtersQueue.shift() # Get a item from the queue and remove it
    if not @actualOptions
      return
    @actualFilter = @actualOptions['actualFilter']
    Backbone.Model.prototype.fetch.call @, @actualOptions

  continueProcessingQueue: () ->
    ### There are a filter that is loaded. Here, we continue loading other items, if there exists ###
    @trigger 'queue-finalizated'
    @getEvolution().removeDuplicates() #Remove duplicates, if it exists
    @actualOptions = null # There are not requests actually happening
    @actualFilter = null
    @processQueue() # Continue to the next request

  fetch: (options = {}) ->
    @trigger 'start-sync'
    # Clone the model to correct use of the filters (and the queue in this model)
    filter = @getEvolution().getFilter().clone()
    urlParams = filter.getURLParamsForGetEntity()
    options['data'] = urlParams
    options['actualFilter'] = filter
    if _.findWhere @filtersUsed, urlParams
      @trigger 'sync', @, null, options
      return
    if _.findWhere @filtersQueue, options
      return
    @filtersUsed.push urlParams
    @filtersQueue.push options
    @processQueue()

  getChildren: () ->
    throw 'Overwrite the method getChildren() to use it'

  hasMap: () ->
    true

  getURL: () ->
    throw 'Overwrite the method getURL() to use it'