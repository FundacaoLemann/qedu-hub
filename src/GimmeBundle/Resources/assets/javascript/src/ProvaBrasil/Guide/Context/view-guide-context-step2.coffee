###
@requires js/backbone.js
###

window.ProvaBrasilGuideContextStep2View = ProvaBrasilGuideStepAbstractView.extend

    el: '.didactic-block-filters'
    intro: 'as hemorroida izemv'
    step: 2

    initialize: ->
        ProvaBrasilGuideStepAbstractView::initialize.apply @

        $(@el).find('ul.nav-pills').on 'click', 'li a', =>
            @trigger 'nextenable'