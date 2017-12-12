###
@requires js/backbone.js
###

DistortionStatus = Backbone.Model.extend
  defaults:
    percent: -1
    percentRounded: -1
    message: ""
    year: null
    stageId: null
    localization: null
    dependence: null
