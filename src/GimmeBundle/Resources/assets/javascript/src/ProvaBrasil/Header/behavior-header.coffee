###
@requires js/mcc/core/behavior.js
          js/bootstrap/bootstrap-dropdown.js
###

mcc.behavior 'provabrasil-header', (config) ->

  $('header .dropdown-toggle').dropdown()