###
@requires js/mcc/core/behavior.js
          js/svg.js/svg.min.js
###
mcc.behavior 'behavior-distortion', (config) ->

  # We need of working pane..Okay? :)
  DistortionPaneToggleView.applyToAll()

  filter = new DistortionFilter()
  router = new DistortionRouter filter


  switch config.regionalAggregationType
    when 'country'
      regionalAggregation = new DistortionBrazil()
    when 'state'
      regionalAggregation = new DistortionState()
    when 'city'
      regionalAggregation = new DistortionCity()
    when 'school'
      regionalAggregation = new DistortionSchool()
    else
      throw 'Regional Aggregation '+config.regionalAggregationType+' invalid'
      return

  if config.regionalAggregationType != 'country'
    if not config.regionalAggregationId
      throw 'Regional Aggregation ID not received'
    regionalAggregation.set 'id', config.regionalAggregationId

  regionalAggregation.getEvolution().setFilter filter
  colorScale = new ColorScale config.colorScale

  filter.on 'change', () ->
    regionalAggregation.fetch()
    if regionalAggregation.hasMap() or regionalAggregation instanceof DistortionCity
      regionalAggregation.getChildren().fetch()
    evolution = regionalAggregation.getEvolution()
    evolution.fetch()

  view = new DistortionView
    filter: filter
    colorScale: colorScale
    regionalAggregation: regionalAggregation
    rawSVGMap: config.rawSVGMap or null
    el: $('#distortion-container').get 0

  router.enable()
  if not filter.changedAttributes() #Only load data if it's not changed at startup
    evolution = regionalAggregation.getEvolution()
    evolution.fetch()
    #Update map
    if regionalAggregation.hasMap()
      regionalAggregation.getChildren().fetch()
  if regionalAggregation instanceof DistortionCity
    # If it's a city we need to load all the children firstly
    regionalAggregation.getChildren().fetch()
  view.render()