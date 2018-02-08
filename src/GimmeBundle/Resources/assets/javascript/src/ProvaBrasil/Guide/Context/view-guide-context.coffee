###

###

ProvaBrasilGuideContextView = ProvaBrasilGuideAbstractView.extend

    initialize: (config) ->
        ProvaBrasilGuideAbstractView::initialize.apply @, [config]

    _initSteps: ->
        @_appendStepView new ProvaBrasilGuideContextStep1View {guideView: @}
        @_appendStepView new ProvaBrasilGuideContextStep2View {guideView: @}
        @_appendStepView new ProvaBrasilGuideContextStep3View {guideView: @}
        @_appendStepView new ProvaBrasilGuideContextStep4View {guideView: @}