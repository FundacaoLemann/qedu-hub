###
@requires js/mcc/core/behavior.js
          js/bootstrap/bootstrap-dropdown.js
###

mcc.behavior 'provabrasil-behavior-util-dropdown', (config) ->
  if config.id
    $('#'+config.id).dropdown()