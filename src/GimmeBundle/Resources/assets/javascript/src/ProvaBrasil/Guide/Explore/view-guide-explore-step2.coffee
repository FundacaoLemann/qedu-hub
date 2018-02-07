###
@requires js/backbone.js
###

ProvaBrasilGuideExploreStep2View = ProvaBrasilGuideStepAbstractView.extend

  el: '.explore-sidebar'
  intro: 'Olá, 2º mundo!'
  step: 2

  initialize: ->
    ProvaBrasilGuideStepAbstractView.prototype.initialize.apply @