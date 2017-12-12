DistortionView = Backbone.View.extend

  initialize: (@options) ->

    @filter = @options['filter']
    @regionalAggregation = @options['regionalAggregation']
    @colorScale = @options['colorScale']

    @filterView = new DistortionFilterView
      regionalAggregation: @regionalAggregation
      filter: @filter
      regionalAggregation: @regionalAggregation
      el: @$el.find('#distortion-filter-block').get 0

    @gradeView = new DistortionStageView
      filter: @filter
      el: @$el.find('#distortion-stage-block').get 0
      regionalAggregation: @regionalAggregation
      colorScale: @options['colorScale']

    @evolutionView = new DistortionEvolutionView
      regionalAggregation: @regionalAggregation
      filter: @filter
      colorScale: @colorScale
      el: @$el.find('#distortion-evolution-block').get 0

    if @regionalAggregation.hasMap() and @options['rawSVGMap']
      @mapView = new DistortionMapView
        regionalAggregation: @regionalAggregation
        el: @$el.find('#distortion-map-block').get 0
        rawSVGMap: @options['rawSVGMap']
        colorScale: @colorScale
        filter: @filter
    else if @regionalAggregation instanceof DistortionCity
      @tableSchoolsView = new DistortionTableSchoolView
        regionalAggregation: @regionalAggregation
        el: @$el.find('#distortion-schools-block').get 0
        filter: @filter
        
  render: () ->
    @filterView.render()
    @gradeView.render()
    @evolutionView.render()
    if @regionalAggregation.hasMap()
      @mapView.render()
    else if @regionalAggregation instanceof DistortionCity
      @tableSchoolsView.render()
