###
@requires js/backbone.js
###

ProvaBrasilGuideStepAbstractView = Backbone.View.extend

    el: null

    ###*
     * Introduction text to be used on the step
    ###
    intro: null

    ###*
     * The step number
    ###
    step: null

    ###*
     * The position of the introduction text
    ###
    position: null

    ###*
     * The guide view instance
    ###
    guideView: null

    ###*
     * The elements that will receive the always-positive class and will not be hightlighted by the introjs layer
    ###
    alwaysPositive: null

    initialize: (@options) ->
        if not @intro
            @intro = @options.intro

        if not @step
            @step = @options.step

        if not @position
            @position = @options.position

        if not @alwaysPositive
            @alwaysPositive = @options.alwaysPositive

        @guideView = @options.guideView

        @_appendDataIntro()
        @_appendDataStep()
        @_appendDataPosition()

        @listenTo @guideView, 'stepchange', -> @_observeMutations()

    ###*
     * Appends the always-positive classes to all elements that have selectors inside the
     * @alwaysPositive array. This will also add the class to the children elements recursively.
    ###
    appendAlwaysPositiveClasses: ->
        $(@alwaysPositive).each (i, selector) =>
            if selector is 'self'
                selected = $(@el)
            else
                selected = $(@el).find(selector)

            selected.addClass 'always-positive'
            selected.find("*").each (x, el) ->
                $(el).addClass 'always-positive'

    negative: ->
        if not $(@el).hasClass 'always-positive'
            $(@el).addClass 'negative'

        $(@el).find("*").each (i, el) ->
            if not $(el).hasClass 'always-positive'
                $(el).addClass 'negative'

    positive: ->
        $(@el).removeClass 'negative'

        $(@el).find('*').each (i, el) ->
            $(el).removeClass 'negative'

    ###*
     * Appends the data-intro attribute to the html element
    ###
    _appendDataIntro: ->
        $(@el).attr 'data-intro', @intro

    ###*
     * Appends the data-step attribute to the html element
    ###
    _appendDataStep: ->
        $(@el).attr 'data-step', @step

        ###*
     * Appends the data-position attribute to the html element
    ###
    _appendDataPosition: ->
        $(@el).attr 'data-position', @position

    ###*
     * Observes for mutations on the element of this view. This will
     * basically track any changes on the DOM of the element, such
     * as size changes, color changes and so on.
    ###
    _observeMutations: ->
        MutationObserver = window.MutationObserver or window.WebKitMutationObserver

        # Prevents the trigger of the event to happen a bunch of times
        observer = new MutationObserver _.throttle (mutations, observer) =>
            @trigger 'elementmutate'
        , 250

        observer.observe $(@el).get(0),
            subtree: true
            attributes: true

    onBeforeChange: ->
        if __DEV__
            console.log "NotImplementedException: the current step doesn't implement onBeforeChange() method"

    onChange: ->
        if __DEV__
            console.log "NotImplementedException: the current step doesn't implement onChange() method"

    onExit: ->
        if __DEV__
            console.log "NotImplementedException: the current step doesn't implement onExit() method"

    onBeforeExit: ->
        if __DEV__
            console.log "NotImplementedException: the current step doesn't implement onBeforeExit() method"

