###
@requires js/mcc/core/behavior.js
          js/provabrasil/util/fixedLayout.coffee
###

mcc.behavior 'provabrasil-behavior-util-fixed-layout', (config) ->
 if config.selector
   FixedLayout.fix(config.selector)