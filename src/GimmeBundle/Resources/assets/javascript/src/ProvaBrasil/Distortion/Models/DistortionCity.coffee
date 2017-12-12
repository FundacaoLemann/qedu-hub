DistortionCity = DistortionEntity.extend
  url: () ->
    '/api/distortion/city/'+@get('id')
  collectionEvolution: () ->
    new DistortionEvolutionCity  [],
      entity: @
  hasMap: () ->
    false
  getChildren: () ->
    if not @children
      @children = new DistortionSchools()
      @children.setParentModel @
      @children.setFilter @getEvolution().getFilter()
    @children

  getURL: () ->
    '/cidade/'+@get 'id'