###
@requires js/mcc/core/behavior.js
          js/jquery.labels_behind_form_fields.js
###

mcc.behavior 'provabrasil-behavior-util-label_behind', (config) ->
    return false
    $(document.body).lbff();