###
@requires js/mcc/core/behavior.js
          js/mcc/lib/number.js
          js/provabrasil/didactic/proficiency/view-filters-proficiency.coffee  
          js/provabrasil/didactic/fixed-main-block.coffee  
          js/provabrasil/didactic/fixed-buttons-filter.coffee  
          js/provabrasil/didactic/proficiency/proficiency-collection.coffee            
###
mcc.behavior 'provabrasil-didactic-proficiency-behavior', (config) ->
  fixedViewBlock = new FixedMainBlock
  fixedButtons = new FixedButtonsFilter
  if not config.isSchool
    view = new ViewFiltersProficiency
      'stateMenuConfigs': config.stateMenuConfigs