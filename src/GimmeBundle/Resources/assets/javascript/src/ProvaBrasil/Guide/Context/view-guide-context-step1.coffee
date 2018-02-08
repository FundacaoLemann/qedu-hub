###
@requires js/backbone.js
###

ProvaBrasilGuideContextStep1View = ProvaBrasilGuideStepAbstractView.extend

  el: '.didactic-block-title'
  intro: 'stunny! money!'
  step: 1
  position: 'bottom'

  initialize: ->
    ProvaBrasilGuideStepAbstractView::initialize.apply @