DistortionFilter = Backbone.Model.extend
  defaults:
    dependence: 0
    localization: 0
    stageId: 'initial_years'
    year: 2016

  getURLParamsForGetEntity: () ->
    result = @toJSON()
    _.omit result, 'stageId'

  getURLParamsForEvolution: () ->
      schoolStage: @get 'stageId'
      dependence: @get 'dependence'
      localization: @get 'localization'

  getURLParamsForEntities: () ->
      schoolStage: @get 'stageId'
      dependence: @get 'dependence'
      localization: @get 'localization'
      year: @get 'year'
