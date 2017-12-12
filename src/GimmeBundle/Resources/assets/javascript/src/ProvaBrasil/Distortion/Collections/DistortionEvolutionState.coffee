DistortionEvolutionState = DistortionEvolution.extend
  url: () ->
    '/api/distortion/evolution/state/'+@entity.get("id")