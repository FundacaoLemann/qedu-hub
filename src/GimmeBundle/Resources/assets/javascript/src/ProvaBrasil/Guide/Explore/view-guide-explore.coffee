###

###

ProvaBrasilGuideExploreView = ProvaBrasilGuideAbstractView.extend

  initialize: (config) ->
    ProvaBrasilGuideAbstractView::initialize.apply @, [config]

  initSteps: ->
    @appendStepView new ProvaBrasilGuideExploreStep1View
    @appendStepView new ProvaBrasilGuideExploreStep2View