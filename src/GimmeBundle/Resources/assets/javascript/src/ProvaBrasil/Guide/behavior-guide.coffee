###
@requires js/mcc/core/behavior.js
@requires js/intro.js/intro.js
@requires js/local-storage-js/storage.js
###

mcc.behavior 'provabrasil-behavior-guide', (config) ->

    # TODO this is a temporary solution
    $('.btn-tour').click ->
        new ProvaBrasilGuideAbstractView config

#    switch config.guide
#        when 'evolution' then new ProvaBrasilGuideEvolutionView config
#        when 'explore' then new ProvaBrasilGuideExploreView config
#        when 'context' then new ProvaBrasilGuideContextView config
#        else
#        # ?