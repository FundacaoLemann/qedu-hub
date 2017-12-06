###
@requires js/mcc/core/behavior.js
###

mcc.behavior 'rotate-banner', (config, configStatic) ->
  num = Math.floor(Math.random()*3)
  $('.carousel').carousel('cycle').carousel( num );