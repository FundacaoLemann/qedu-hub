DistortionBrazil = DistortionEntity.extend
  url: '/api/distortion/brasil'

  collectionEvolution: () ->
    new DistortionEvolutionBrazil [],
      entity: @

  getChildren: () ->
    if not @children
      @children = new DistortionStates()
      @children.setParentModel @
      @children.setFilter @getEvolution().getFilter()
    @children

  getURL: () ->
    '/brasil/'