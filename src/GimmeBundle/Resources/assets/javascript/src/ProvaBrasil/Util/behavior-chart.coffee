###
@requires js/mcc/core/behavior.js
###

mcc.behavior 'provabrasil-behavior-util-chart', (config) ->
  $(".income-range-graph #container").highcharts $.parseJSON config.graph