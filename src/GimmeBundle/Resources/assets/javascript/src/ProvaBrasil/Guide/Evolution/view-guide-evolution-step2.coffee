###
@requires js/backbone.js
###

ProvaBrasilGuideEvolutionStep2View = ProvaBrasilGuideStepAbstractView.extend

  el: '.container-db-filters'
  intro: 'Você pode filtrar os resultados para alcançar uma análise mais detalhada e aprofundada sobre os fatos.<br /><br />É possível filtrar por ano, disciplina e rede escolar.'
  step: 2

  initialize: ->
    ProvaBrasilGuideStepAbstractView.prototype.initialize.apply @