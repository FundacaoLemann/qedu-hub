DistortionEvolutionView = Backbone.View.extend
  initialize: (@options) ->
    _.bindAll @, 'render'
    @evolution = @options['regionalAggregation'].getEvolution()
    @colorScale = @options['colorScale']

  render: () ->
    colorScale = @colorScale
    el = @$el.find '.chart'
    initial_year = @$el.find '.initial-year'
    final_year = @$el.find '.final-year'
    @evolution.on 'sync', (evolution) ->
      seriesData = evolution.getSelected().map (model) ->
        y: model.get 'percentRounded'
        id: model.get 'year'
        marker:
          radius: 7
          fillColor: colorScale.getColorByPercent model.get 'percent'
      seriesData = _.groupBy seriesData, 'id'
      seriesData = _.map seriesData, (serieData) ->
        serieData[0]
      seriesData = _.sortBy seriesData, 'id'
      years = _.pluck seriesData, 'id'
      initial_year.html _.first years
      final_year.html _.last years
      el.highcharts
        legend: false
        title: false
        tooltip:
          crosshairs: true
          valueDecimals: 0
          valuePrefix: ""
          pointFormat: "<b style=\"font-size: 16px;\">{point.y}%</b>"
          shared: true
          style:
            color: "#444"
            fontSize: "11px"
            padding: "8px"

        xAxis:
          categories: years

        yAxis:
          min: 0
          max: 100
          labels:
            format: "{value}%"

          title:
            text: false

        series: [
          name: 'Evolução'
          data: seriesData
          color: '#cccccc'
        ]
