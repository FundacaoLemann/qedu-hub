DistortionFilterView = Backbone.View.extend

  initialize: (@options) ->
    @filter = @options['filter']
    @regionalAggregation = @options['regionalAggregation']
    @yearView = new DistortionYearFilterView
      el: @$el.find('#distortion-filter-year-block').get(0)
      filter: @filter
      regionalAggregation: @regionalAggregation

    if @regionalAggregation not instanceof DistortionSchool
      @dependenceView = new DistortionDependenceFilterView
        el: @$el.find('#distortion-filter-dependence-block').get(0)
        filter: @filter

      @localizationView = new DistortionLocalizationFilterView
        el: @$el.find('#distortion-filter-localization-block').get(0)
        filter: @filter

  render: () ->
    @yearView.render()
    if @regionalAggregation not instanceof DistortionSchool
      @dependenceView.render()
      @localizationView.render()
