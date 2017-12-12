class ColorScale
  constructor: (@scale) ->

  # @param percent int
  # @return string
  getColorByPercent: (percent) ->
    numberRange = @getNumberRangeByPercent percent
    @scale[numberRange]['color']

  # @param percent int
  # @return string
  getCSSClassByPercent: (percent) ->
    numberRange = @getNumberRangeByPercent percent
    return 'distortion-color-scale-'+numberRange

  # @return array
  getScale: () ->
    @scale

  # @param percent int
  # @return string
  getNumberRangeByPercent: (percent) ->
    if isNaN parseInt percent
      throw 'Percent passed is not a valid percentage'

    if percent < 0 or percent > 100
      throw 'Percent passed is not a valid percentage'

    for index, color of @scale
      if color['min'] <= percent and color['max'] >= percent
        return index