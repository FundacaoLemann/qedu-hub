###
@requires js/backbone.js
###

DistortionEvolution = Backbone.Collection.extend
  comparator: 'year' #Sort the collection by year as it's used by evolution graph
  model: DistortionStatus

  initialize: (models, options) ->
    _.bindAll @, 'addFilterAttributes'
    @setEntity options.entity if options and options.entity
    @on 'add', @addFilterAttributes
    @distortionFilter = new DistortionFilter(2016, 0, 0, 1)

    ###
    Below exists two arrays that are true love <3

    The first is the filtersUsed: It's simply a 'lock' to don't allow the load of repeated filters that are really loaded
    The second is the filtersQueue: It's what the name speaks: A queue. When something calls the fetch method, the library
    puts the filter selected in the queue and load each filter one by one, avoiding duplicated (and simultaneous requests), too
    ###
    @filtersUsed = []
    @filtersQueue = []
    @actualOptions = null
    @actualFilter = null
    @on 'sync', @continueProcessingQueue

  url: () ->
    if __DEV__
      throw 'You need to overwrite the method url()'

  setEntity: (@entity) ->
    if @entity not instanceof DistortionEntity
      @entity = new DistortionEntity
        id: @entity

  removeDuplicates: () ->
    self = @
    @each (model) ->
      if self.where(model.toJSON()).length > 1
        self.remove model

  addFilterAttributes: (status, filter = null) ->
    if filter not instanceof DistortionFilter
      filter = @actualFilter
    if not filter
      throw "Actual Filter not found (in collection of evolution)"
    for filterName, filterValue of filter.toJSON()
      if not status.has(filterName) or not status.get filterName
        status.set filterName, filterValue
    return status

  getFilter: () ->
    if not @distortionFilter and __DEV__
      throw 'Specify a filter'
    @distortionFilter

  setFilter: (@distortionFilter) ->
    if @distortionFilter not instanceof DistortionFilter and __DEV__
      throw "Filter invalid"

  getSelected: () ->
    #Creates a clone of this collection, only with the registers that match the filter actually selected
    @removeDuplicates()
    result = @clone()
    result.reset @where _.omit @getFilter().toJSON(), 'year'
    result.removeDuplicates()
    result.setFilter @getFilter()
    result

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
    @actualFilter = @actualOptions['actualFilter']
    Backbone.Collection.prototype.fetch.call @, @actualOptions

  continueProcessingQueue: () ->
    ### There are a filter that is loaded. Here, we continue loading other items, if there exists ###
    @trigger 'queue-finalizated'
    @removeDuplicates() #Remove duplicates, if it exists
    @actualOptions = null # There are not requests actually happening
    @actualFilter = null
    @processQueue() # Continue to the next request

  getFiltersUsedAndFiltersQueue: () ->
    _.union @filtersUsed, _.pick @filtersQueue, 'data'

  fetch: (options = {}) ->
    @trigger 'start-sync'
    filter = @getFilter().clone()
    urlParams = filter.getURLParamsForEvolution()
    options['data'] = urlParams
    options['actualFilter'] = filter
    options['remove'] = false #It not can delete other documents in the collection, as this is a cache
    oldSuccess = options['success'] or () ->
    if _.findWhere @filtersUsed, urlParams #Compares all properties and return null if  undefined
      @trigger 'sync', @, null, options
      oldSuccess.call this, @, null, options
      return
    options['success'] = (collection, response, options) ->
      oldSuccess.call this, collection, response, options
    if _.findWhere @filtersQueue, options
      return
    @filtersUsed.push urlParams
    @filtersQueue.push options
    @processQueue()


