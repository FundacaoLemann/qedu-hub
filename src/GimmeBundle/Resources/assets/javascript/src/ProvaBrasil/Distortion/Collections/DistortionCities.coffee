DistortionCities = DistortionEntities.extend
  url: () ->
    if not @parentModel and __DEV__
      throw 'You need to set a parent model to load the cities'
    '/api/distortion/state/'+@parentModel.get('id')+'/cities'
  model: DistortionCity