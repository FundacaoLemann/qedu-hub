###
@requires js/backbone.js
          css/provabrasil/proficiency/colors.less
          css/provabrasil/explore/explore.less
          js/provabrasil/explore/view-isotope.coffee
          js/provabrasil/explore/view-map.coffee
          js/provabrasil/explore/router-explore.coffee
          js/provabrasil/explore/model-explore.coffee
          js/provabrasil/explore/model-explore-state.coffee

This is the main Explore View. Its responsible for creating all necessary stuff and gluing it all togheter
###

ProvaBrasilExploreView = Backbone.View.extend
  
  el: '.explore-container'
  isotopeView: null
  mapView: null
  
#  events:
#    'click #change-explore-lasers' : 'clickChangeExploreLasers'
  
  initialize: (@options) ->
    _.bindAll(@, '_onVisualizationChange')
    # this hold the state of the App (filters applyed and other stuff)
    @state = new ProvaBrasilExploreState()

    # set the inicial state of configs and filters
    if @options.exploreState
      @state.set(@options.exploreState)

    # the second option can go out after refactor
    @collection = new ProvaBrasilExploreProficiencyCollection @state
    @collection.url = @options.collectionUrl

    @statemenu = new StateMenu @options.stateMenuConfigs
    @statemenu.setExplore()
    @statemenu.on "updated", (data) ->
      for key, value of data
        # Converts all values directly to String as necessary to state
        data[key] = value.toString()
      # Set it in a unique shot!
      @state.set data,
        unset: false
    , @

    # the main controller view that deals with filters and controls
    @filtersView = new ProvaBrasilExploreFiltersView @state, @collection, @statemenu,  @options

    # init the router to handle URL changes
    @router = new ProvaBrasilExploreRouter @state
    @collection.on('sync', @_onCollectionLoad, @)




    # load the models
    if __DEV__ and console.time
      console.time('explore-load-and-parse-json')

    @collection.fetch
      reset: true

  _onCollectionLoad: () ->
    if __DEV__ and console.time
      console.timeEnd('explore-load-and-parse-json')

    @filtersView.on('changeMode', @_changeMode, @)

    if @router.hasData()
      #If the router has data...use it!
      @router.updateFilter()
    else
      #If the router hasn't data..load the state from the server!
      @statemenu.update(false)

    @router.enable() #Listen the event of change in URL

    @router.navigate()

    @state.on('change:visualization', @_onVisualizationChange, @)

    @_onVisualizationChange()






  _onVisualizationChange: () ->
    visualization = @state.get('visualization')
    if not @mapView
      @mapView = new ProvaBrasilExploreMapView(@state, @collection, @options)
    if not @isotopeView
      @isotopeView = new ProvaBrasilExploreIsotopeView(@state, @collection, @options)


    if visualization is 'map'
      @isotopeView.disable()
      @mapView.enable()
    else
      @mapView.disable()

      @isotopeView.enable()

    @filtersView.unblock()


  _changeMode: () ->
    if @options.userLogged
      $.ajax(
        url: @options.modeChangeUrl
        type: 'POST'
      ).always( ->
        uri = new mcc.URI(window.location);
        window.location = uri.toString();
      )