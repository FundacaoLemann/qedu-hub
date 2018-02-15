###
@requires js/backbone.js
          js/modernizr.js
          js/jquery.loadmask.js
###

ProvaBrasilExploreMapView = Backbone.View.extend
  el: '.explore-container .explore-map .explore-map-inner'

  active: false

  views: []

  initialize: (@state, @collection, @options) ->
    _.bindAll(@, '_mapLoaded', '_viewToModelElementClick', '_viewToModelElementMouseMove', '_viewToModelElementMouseLeave')

    @$map = null
    @mapPaths = {}
    

  enable: () ->
    if @active
      return

    @active = true

    $(document.body).addClass('body-explore-map')

    @$el.parent('.explore-map').show()

    @render()

    # listen to events
    @_toggleEvents(true)


  disable: () ->
    if @active is false
      return

    @active = false

    $(document.body).removeClass('body-explore-map')

    @$el.parent('.explore-map').hide()

    # unlisten to events
    @_toggleEvents(false)


  _toggleEvents: (enable) ->
    method = 'off'
    if enable
      method = 'on'

    @state[method]('change:selected', @_redrawElements, @)
    @state[method]('change:comparingSelected', @_redrawElements, @)

    @collection[method]('updatedProficiencies', @_redrawElements, @)

    @collection[method]('markedOptimalIndexInbound', @_redrawElements, @)
    @collection[method]('markedPresenceIndexInbound', @_redrawElements, @)
    @collection[method]('markedEnrolledCountInbound', @_redrawElements, @)

    if enable
      @_initWindowResize()
      @_redrawElements()
    else
      @_deInitWindowResize()


  _redrawElements: () ->
    if @mapPaths is undefined
      return @
    @collection.each((model) ->
      finalProficiency = model.getCurrentProficiency()
      hasProficiency = _.size(finalProficiency) > 0

      el = @mapPaths[model.get('ibge_code')] or @mapPaths[model.get('id')]

      if el
        # default style
        fillColor = @fillColors['no-data']
        strokeColor = '#666'
        strokeWidth = '1'

        # sliders filters
        if @state.get('optimalIndexInboundApplied') and model.get('optimal_index_inbound') is false
          hasProficiency = false

        if @state.get('presenceIndexInboundApplied') and model.get('presence_index_inbound') is false
          hasProficiency = false

        if @state.get('enrolledCountInboundApplied') and model.get('enrolled_count_inbound') is false
          hasProficiency = false

        if hasProficiency
          fillColor = @fillColors[finalProficiency.optimal_decile_level]

        if @state.isModelSelected(model) is true
          strokeColor = '#000'
          strokeWidth = '4'

        el.css('cursor', 'pointer')

        @_SVGPaint(el, fillColor, strokeColor, strokeWidth)
    , @)


  _updateInfoBox: (model, el) ->



  _SVGPaint: (el, fill = 'eee', stroke = '', strokeWidth = '1') ->
    el.css('fill', fill)

    el.css('stroke', stroke)
    #el.attr('stroke', stroke)

    el.css('stroke-width', strokeWidth)
    #el.attr('stroke-width', strokeWidth)


  render: () ->
    # There is a bug in SVG, so we gotta recreate it all the times...
    #if @_rendered is true
    #  return @

    if @mapLoaded
      return

    if @$map
      @$map.remove();

    @_rendered = true
    @mapLoaded = true

    if @options.mapUrl
      @_generateColors()

      if Modernizr.svg
        @$map = $('<object width="100%" height="100%"></object>').appendTo(@$el)

        @$map[0].addEventListener('load', @_mapLoaded)
        @$map.attr('type', 'image/svg+xml').attr('data', @options.mapUrl)

        @_initWindowResize()

        @$tooltip = $('<div class="explore-map-tooltip"></div>').appendTo(@$el)
      else
        @$('.explore-map-unsupported').show()
    else
      @$('.explore-map-to-state').show()


  _generateColors: () ->
    @fillColors =
      'no-data': '#eee'
      0 : '#FF0000'
      1 : '#FF6600'
      2 : '#FC9700'
      3 : '#fcc115'
      4 : '#fde51f'
      5 : '#f6fd2c'
      6 : '#c9de26'
      7 : '#87CC1D'
      8 : '#63B916'
      9 : '#3EA50F'
      10 : '#3EA50F'

  _mapLoaded: () ->
    #console.log "mapa carregou!"
    svgDocument = @$map[0].contentDocument

    if (svgDocument is undefined)
      svgDocument = @$map[0].getSVGDocument()

    @mapSVG = $(svgDocument).find('svg')

    @mapSVG.find('path').each((num, el) =>
      $el = $(el)

      @mapPaths[el.id] = $el
    )

    @collection.each((model) ->
      el = @mapPaths[model.get('ibge_code')] or @mapPaths[model.get('id')]

      if el
        el.data('model', model)

        el.attr('title', model.get('name'))
          .attr('class', 'isotope-item')
          .attr('style', '')
          .click(@_viewToModelElementClick)
          .mousemove(@_viewToModelElementMouseMove)
          .mouseleave(@_viewToModelElementMouseLeave)
    , @)


    @_redrawElements()


  # the SVG gotta have:
  #   width="100%"
  #   height="100%"
  #   preserveAspectRatio="x200Y200 meet"
  _initWindowResize: () ->
    if @_delayedAdjustSize is undefined
      @_delayedAdjustSize = _.throttle(_.bind(@_adjustSize, @, @$map, @$el, $(window)), 250)

    $(window).on('resize', @_delayedAdjustSize)

    @_adjustSize.call @, @$map, @$el, $(window)


  _deInitWindowResize: () ->
    if @_delayedAdjustSize isnt undefined
      $(window).off('resize', @_delayedAdjustSize)


  _adjustSize: ($el, $parent, $window, tries) ->
    if @$map
      height = parseInt($window.height(), 10) - parseInt($parent.position().top, 10)

      if height < 100
        tries = tries || 0
        if tries > 30
            height = 100
        else
            return setTimeout _.bind(@_adjustSize, @, @$map, @$el, $(window), tries+1), 50

      @$map.attr('height', height)


  _viewToModelElementClick: (e) ->
    $el = $(e.currentTarget)

    model = $el.data('model')

    if @state.isModelSelected(model)
      @state.removeFromSelected(model)
    else
      @state.addToSelected(model)

  _viewToModelElementMouseMove: (e) ->
    $el = $(e.currentTarget)

    model = $el.data('model')

    if @$tooltip.data('id') isnt model.get('id')
      finalProficiency = model.getCurrentProficiency()
      hasProficiency = if _.size(finalProficiency) > 0 then true else false

      finalOptimalIndex = '—'

      if hasProficiency
        finalOptimalIndex = finalProficiency.optimal_index_perfect_hundred+'%'

      @$tooltip
        .data('id', model.get('id'))
        .html(model.get('name')+' ('+finalOptimalIndex+')')
        .show()

    @$tooltip
      .css('left', e.clientX + 10)
      .css('top', e.clientY + 10)

    $el.css('stroke-width', 4)

  _viewToModelElementMouseLeave: (e) ->
    $el = $(e.currentTarget)

    model = $el.data('model')

    @$tooltip.data('id', null).hide()

    if @state.isModelSelected(model) is false
      $el.css('stroke-width', 1)