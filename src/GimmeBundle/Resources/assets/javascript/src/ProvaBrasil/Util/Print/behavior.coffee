###
@requires js/mcc/core/behavior.js
###

mcc.behavior 'util-print', (config, configStatic) ->
  # Singleton Behavior
  if configStatic.already_runned
    return

  configStatic.already_runned = true

  new PrintView(config)