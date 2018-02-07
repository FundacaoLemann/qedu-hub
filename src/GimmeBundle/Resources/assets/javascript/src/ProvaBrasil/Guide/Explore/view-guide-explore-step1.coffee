###
@requires js/backbone.js
###

ProvaBrasilGuideExploreStep1View = ProvaBrasilGuideStepAbstractView.extend

  el: '.explore-isotope-list'
  intro: 'Olá, mundo!'
  step: 1

  initialize: ->
    ProvaBrasilGuideStepAbstractView.prototype.initialize.apply @