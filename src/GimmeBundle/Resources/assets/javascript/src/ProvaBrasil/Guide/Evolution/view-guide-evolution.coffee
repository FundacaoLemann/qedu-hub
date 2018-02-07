###

###

ProvaBrasilGuideEvolutionView = ProvaBrasilGuideAbstractView.extend

  initialize: (config) ->
    @initSteps()
    ProvaBrasilGuideAbstractView::initialize.apply @, [config]

  initSteps: ->
    @appendStepView new ProvaBrasilGuideEvolutionStep1View
    @appendStepView new ProvaBrasilGuideEvolutionStep2View