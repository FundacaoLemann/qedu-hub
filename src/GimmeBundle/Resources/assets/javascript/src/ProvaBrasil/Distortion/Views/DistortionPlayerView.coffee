DistortionPlayerView = Backbone.View.extend
  events:
    'click': 'receiveEventFromUI'

  initialize: (@options) ->
    _.bindAll @, 'receiveEventFromUI', 'animate', 'isPlaying', 'getActualStep', 'play', 'pause'
    @filterField = @options['filterField']
    @regionalAggregation = @options['regionalAggregation']
    @icon = @$el.find('i')
    @items = @options['items'].reverse() #all the options of the filter
    @interval = @options['interval'] or 1500 #interval between steps
    @filter = @options['filter']
    @playing = false
    @curIndex = 0
    window.p = @

  receiveEventFromUI: () ->
    if @playing
      @pause()
    else
      @play()

  animate: () ->
    if not @playing or @curIndex == @items.length
      @pause()
      return
    animate = @animate
    interval = @interval
    # Wait until all the queue of the regionalAggregation was processed and put a interval to the next item
    @regionalAggregation.once 'queue-done', () ->
      setTimeout animate, interval
    actualItem = @items[@curIndex]
    ++@curIndex
    @filter.set @filterField, actualItem


  isPlaying: () ->
    @playing

  getActualStep: () ->
    @filter.get @filterField

  play: () ->
    if @playing
      return
    @playing = true
    @icon.removeClass 'icon-play'
    @icon.addClass 'icon-pause'
    @curIndex = 0
    @animate()
    @trigger 'play'

  pause: () ->
    if not @playing
      return
    @playing = false
    @icon.removeClass 'icon-pause'
    @icon.addClass 'icon-play'
    @trigger 'pause'