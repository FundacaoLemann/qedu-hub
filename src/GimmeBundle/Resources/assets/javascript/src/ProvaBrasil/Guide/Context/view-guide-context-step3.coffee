###
@requires js/backbone.js
###

ProvaBrasilGuideContextStep3View = ProvaBrasilGuideStepAbstractView.extend

  el: '#ujeid_3'
  intro: 'zas!'
  step: 3

  initialize: ->
    ProvaBrasilGuideStepAbstractView::initialize.apply @