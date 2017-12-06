###
@requires js/mcc/core/behavior.js
          js/jquery.js
          js/backbone.js
          js/provabrasil/search/global/view-globalsearch.coffee
          js/provabrasil/search/global/model-globalsearch.coffee
###

mcc.behavior 'provabrasil-behavior-globalsearch', (config) ->
  search = new ProvaBrasilViewGlobalSearch()

  if config.focus
    search.focus()