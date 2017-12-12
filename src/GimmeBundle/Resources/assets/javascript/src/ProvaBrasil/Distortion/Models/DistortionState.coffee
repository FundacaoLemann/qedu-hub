DistortionState = DistortionEntity.extend
  url: () ->
    '/api/distortion/state/'+@get('id')
  collectionEvolution: () ->
    new DistortionEvolutionState [],
      entity: @
  getChildren: () ->
    if not @children
      @children = new DistortionCities()
      @children.setParentModel @
      @children.setFilter @getEvolution().getFilter()
    @children

  getURL: () ->
    '/estado/'+@get 'id'