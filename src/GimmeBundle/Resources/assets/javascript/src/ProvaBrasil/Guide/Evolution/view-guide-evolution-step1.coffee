###
@requires js/backbone.js
###

ProvaBrasilGuideEvolutionStep1View = ProvaBrasilGuideStepAbstractView.extend

  el: '.didactic-block-title'
  intro: 'De acordo com o número de pontos obtidos na <b>Prova Brasil</b>, os alunos são distribuídos em 4 níveis em uma escala de proficiência: <i>Insuficiente</i>, <i>Básico</i>, <i>Proficiente</i> e <i>Avançado</i>. <br /><br />Neste Portal, consideramos que alunos com aprendizado adequado são aqueles que estão nos níveis proficiente e avançado. Para saber mais sobre este conceito e outros, acesse a <a href="/ajuda/baseconhecimento" target="_blank">Base de Conhecimento.</a>'
  step: 1
  position: 'bottom'

  initialize: ->
    ProvaBrasilGuideStepAbstractView.prototype.initialize.apply @