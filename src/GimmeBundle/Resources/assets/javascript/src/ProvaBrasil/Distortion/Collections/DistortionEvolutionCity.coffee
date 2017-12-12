DistortionEvolutionCity = DistortionEvolution.extend
  url: () ->
    '/api/distortion/evolution/city/'+@entity.get("id")