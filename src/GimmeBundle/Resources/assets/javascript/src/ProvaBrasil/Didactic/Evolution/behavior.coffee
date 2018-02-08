###
@requires js/mcc/core/behavior.js
          js/mcc/lib/number.js
          js/provabrasil/didactic/evolution/view-filters-evolution.coffee  
          js/provabrasil/didactic/fixed-main-block.coffee  
          js/provabrasil/didactic/fixed-buttons-filter.coffee  
          js/provabrasil/didactic/evolution/evolution-collection.coffee            
###
mcc.behavior 'provabrasil-didactic-evolution-behavior', (config) ->      
  fixedViewBlock = new FixedMainBlock
  fixedButtons = new FixedButtonsFilter
  view = new ViewFiltersEvolution
    'stateMenuConfigs': config.stateMenuConfigs