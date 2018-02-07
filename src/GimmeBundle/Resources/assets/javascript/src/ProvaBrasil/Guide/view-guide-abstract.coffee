###
@requires js/backbone.js
###

ProvaBrasilGuideAbstractView = Backbone.View.extend

    ###*
     * {ProvaBrasilGuideStepViewAbstract[]} A list of steps
    ###
    steps: [null]

    ###*
     * {number} The active step
    ###
    activeStep: 1

    ###*
     * {IntroJs} The IntroJs instance
    ###
    introJs: null

    lastNext: null

    initialize: (config) ->
        if config.json
            @_initStepsFromJson(config.json)
        else
            @_initSteps()

        @introJs = introJs().setOptions(
            nextLabel: 'Avançar'
            prevLabel: 'Voltar'
            skipLabel: '<img src="http://d2jaknbl34vcit.cloudfront.net/img/provabrasil/guide/close.gif" />'
            doneLabel: '<img src="http://d2jaknbl34vcit.cloudfront.net/img/provabrasil/guide/close.gif" />'
            lastNext: @lastNext
            buttonCls: 'btn'
            showStepNumbers: false
            endLabel: 'Concluir'
        )

        @activeStep = @_getActiveStepFromLocalStorage()

        @_start()

    ###*
     * {abstract}
     *
     * Initializes the steps of the super class.
    ###
    _initSteps: ->
        console.log 'called abstract method ProvaBrasilGuideAbstractView::_initSteps. Are you sure this is what you want?'

    ###*
     * Initializes the steps of the guide using a definition json object.
    ###
    _initStepsFromJson: (json) ->
        guide = JSON.parse json

        if guide.lastNext
            # TODO this is a big workaround and we should remove it asap
            replace = window.location.href.substring window.location.href.lastIndexOf('/') + 1
            @lastNext = (window.location.href.replace replace, guide.lastNext) + '?guide=active'

        $.each guide.steps, (i, step) =>
            if step.view is undefined
                @_appendStepView new ProvaBrasilGuideStepAbstractView(
                    el: step.el
                    step: parseInt step.step
                    intro: (if _.isArray(step.intro) then step.intro.join(" ") else step.intro)
                    position: step.position
                    guideView: @
                    alwaysPositive: step.alwaysPositive
                )
            else
                if window[step.view] is undefined
                    if __DEV__
                        throw step.view + ' is undefined. ' + guide
                    return

                @_appendStepView new window[step.view](
                    guideView: @
                )

    _enableNext: ->
        localStorage.setItem 'nextEnabled', true
        @introJs.enableNext()

    _disableNext: ->
        localStorage.setItem 'nextEnabled', false
        @introJs.disableNext()

    ###*
     * Adds a step view to the list of steps of this class.
     *
     * @param {ProvaBrasilGuideStepViewAbstract} The step view
    ###
    _appendStepView: (stepView) ->
        if stepView instanceof ProvaBrasilGuideStepAbstractView
            @steps.splice parseInt(stepView.step), 0, stepView

    ###*
     * Calls the introJs main function, chaining some config
     * callback functions, such as onchange() and onexit().
    ###
    _start: ->
        @introJs.onbeforechange(() =>
            @steps[@activeStep].positive()
            # TODO this is important, so we need to use _intro.js while the PR doesn't get merged
#            return @steps[@activeStep].onBeforeChange()
        ).onchange((el) =>
            @_storeActiveStep $(el).attr 'data-step'
            @trigger 'stepchange'
            @steps[@activeStep].appendAlwaysPositiveClasses()
            @steps[@activeStep].negative()
            @listenTo @steps[@activeStep], 'elementmutate', -> @_refresh()
            # TODO should this be removed?
            @introJs.setOption 'buttonCls', 'btn'
#        ).onbeforeexit(() =>
#            if not @_stepIsLast @activeStep
#                return confirm 'u sure?'
        ).onexit(() =>
            @_storeActiveStep 0
        ).goToStep(@activeStep).start()

    ###*
     * Refreshes the guide.
    ###
    _refresh: ->
        @introJs.refresh()

    ###*
     * Stores an active step into the localStorage variable
     * and the activeStep member of this class.
     *
     * @param {number} The step to store as active
    ###
    _storeActiveStep: (@activeStep) ->
        localStorage.setItem 'activeStep', @activeStep

    ###*
     * Loads the activeStep from the localStorage. If the value
     * returned by localStoarage is not a number or is 0, than this
     * method will return the default value for the activeStep property.
     *
     * @return {number}
    ###
    _getActiveStepFromLocalStorage: ->
        activeStepLocalStorage = parseInt(localStorage.getItem 'activeStep')

        if _.isNumber(activeStepLocalStorage) and activeStepLocalStorage isnt 0
            return activeStepLocalStorage

        return @activeStep

    ###*
     * Checks it the given step is the last step of the guide.
     *
     * @return {boolean}
    ###
    _stepIsLast: (step) ->
        return (parseInt(step) + 1) is @steps.length