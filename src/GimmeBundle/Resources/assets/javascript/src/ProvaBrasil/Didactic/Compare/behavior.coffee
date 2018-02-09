###
@requires js/mcc/core/behavior.js
          js/mcc/lib/number.js
          js/provabrasil/didactic/compare/view-filters-compare.coffee  
          js/provabrasil/didactic/fixed-main-block.coffee  
          js/provabrasil/didactic/fixed-buttons-filter.coffee  
          js/provabrasil/didactic/compare/compare-collection.coffee            
###

mcc.behavior 'provabrasil-didactic-compare-behavior', (config) ->
  fixedViewBlock = new FixedMainBlock
  fixedButtons = new FixedButtonsFilter
  view = new ViewFiltersCompare
    'stateMenuConfigs': config.stateMenuConfigs