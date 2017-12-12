DistortionEvolutionSchool = DistortionEvolution.extend
  url: () ->
    '/api/distortion/evolution/school/'+@entity.get("id")