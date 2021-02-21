DistortionMapView = Backbone.View.extend
  initialize: (@options) ->
    _.bindAll @, 'initializePlayer', 'loadSVG', 'adjustWidthAndHeight', 'render', '_tooltipMouseMove',
      '_tooltipMouseLeave'
    if @isSupported()
      @svg = SVG @$el.find('#distortion-map-svg')[0]
      @loadSVG(@options['rawSVGMap'])
    @regionalAggregation = @options['regionalAggregation']
    @filter = @options['filter']
    @colorScale = @options['colorScale']
    if @regionalAggregation not instanceof DistortionSchool
      @initializePlayer()

  isSupported: () ->
    Modernizr.svg and SVG.supported

  initializePlayer: () ->
    items = ['2020', '2018', '2017', '2016', '2015','2014', '2013', '2012', '2011', '2010', '2009', '2008', '2007', '2006']

    @player = new DistortionPlayerView
      el: @$el.find('.distortion-play').get 0
      items: items
      filter: @filter
      filterField: 'year'
      regionalAggregation: @regionalAggregation.getChildren()
    yearLabel = @$el.find('#year')
    @player.on 'play', () ->
      yearLabel.css
        'background': '#000'
        'color': '#fff'
        'padding': '5px'
    @player.on 'pause', () ->
      yearLabel.css
        'background-color': ''
        'color': ''
        'padding': ''

  loadSVG: (content) ->
    @svg.svg(content)
    @adjustWidthAndHeight()

  adjustWidthAndHeight: () ->
    children = @svg.children()
    viewbox = children[0].viewbox()
    viewbox.y = 0
    viewbox.x = 0
    @svg.viewbox viewbox
    @svg.size viewbox.width, viewbox.height

    @$el.find('#distortion-map-svg').css('margin-left', (($('#distortion-map-svg').width()-viewbox.width)/2)+'px')

  render: () ->
    if not @isSupported()
      @$el.find('.distortion-map-unsupported').removeClass('hide')
      return
    self = @
    @$tooltip = $('<div class="distortion-map-tooltip"></div>').appendTo @$el
    children = @regionalAggregation.getChildren()
    filter = @filter
    el = @$el
    player = @player
    colorScale = @colorScale
    svg = @svg.children()
    svg = svg[0]
    yearLabel = el.find('#year')

    #groups SVG child nodes to avoid DOM manipulation (or similar) and allow faster access

    svgChildNodes = {}
    svg.each (i, svgElements) ->
      for svgElement in svgElements
        if not svgElement.node
          continue
        key = svgElement.node.id.toString()
        if not key.match /^\d+$/
          continue
        svgChildNodes[key] = svgElement
    , true

    children.on 'sync', () ->
      yearLabel.html filter.get 'year'
      usedIDs = []
      filterData = filter.toJSON()

      children.each (model) ->

        id = model.get 'id'
        id = id.toString()
        ibge_id = model.get 'ibge_id'
        ibge_id = ibge_id.toString()
        name = model.get 'name'

        usedIDs.push id
        usedIDs.push ibge_id

        evolution = model.getEvolution()

        #Filter evolution by filter selected
        dataValue = evolution.findWhere filterData

        if dataValue
          #Get data
          percent = dataValue.get 'percent'
          percentRounded = dataValue.get 'percentRounded'
          title = name+' ('+percent+'%)'

          color = colorScale.getColorByPercent percent
        else
          title = name+' - Sem dados de distorção idade/série para o filtro selecionado'
          color = '#ffffff'

        #Get element cached
        element = svgChildNodes[id] or svgChildNodes[ibge_id]

        if not element
          #We do not have a element, how we can paint it? R: We can't
          return

        #Define title
        element.data 'title', title

        #Add to querystring only parameters that have changed in a determinated moment in the page
        urlParams = mcc.URI.objectToQueryString filter.changedAttributes() or {}
        if _.isEmpty urlParams
          #Why add params if urlParams is empty?
          element.data 'url', model.getURL()+'/distorcao-idade-serie'
        else
          element.data 'url', model.getURL()+'/distorcao-idade-serie?'+urlParams
        element.style 'cursor', 'pointer'

        element.click () ->
          window.location.href = this.data 'url'
        element.mousemove self._tooltipMouseMove, element
        element.mouseleave self._tooltipMouseLeave, element
        #Animate and fill color
        element.animate().fill color

      notUsedElements = _.omit svgChildNodes, usedIDs
      for id, elementNotUsed of notUsedElements
        elementNotUsed.animate().fill '#ffffff'
        elementNotUsed.data 'title', 'Sem dados de distorção idade/série para o filtro selecionado'

  _tooltipMouseMove: (e) ->
    $el = new SVG.Element e.currentTarget
    if @$tooltip.html() isnt $el.data 'title'
      @$tooltip
      .html($el.data('title')+"<br />Clique para abrir ")
      .show()
    @$tooltip
    .css('left', e.pageX + 10)
    .css('top', e.pageY + 10)

    $el.style 'stroke-width', 4

  _tooltipMouseLeave: (e) ->
    $el = new SVG.Element e.currentTarget

    @$tooltip.html('').hide()
    $el.style 'stroke-width', ''

