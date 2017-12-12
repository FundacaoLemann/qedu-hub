DistortionSchool = DistortionEntity.extend
  url: () ->
    '/api/distortion/school/'+@get('id')

  collectionEvolution: () ->
    new DistortionEvolutionSchool [],
      entity: @

  hasMap: () ->
    false
  getChildren: () ->
    throw "There's no children"

  getURL: () ->
    '/escola/'+@get 'id'