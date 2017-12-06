###
@requires js/mcc/core/behavior.js

'subtract' => 'header.navbar', => selector of elements that should be subtracted from the container height
'element' => '#destiny', => the destiny element
'container' => 'body' => the container, can be blank, will be the window
###

mcc.behavior 'provabrasil-behavior-util-full-height', (config) ->
  if config.container is undefined
    config.container = window

  container = $(config.container)
  element = $(config.element).first()

  subtractHeight = 5

  # get the height of the elements
  $(document.body).children(config.subtract).each () ->
    if $(@) isnt element
      subtractHeight = subtractHeight + $(@).outerHeight()

  # substract the window size with the other elements size
  resizeFunction = (container, element, subtractHeight) ->
    containerHeight = container.outerHeight()

    console.log "containerHeight: "+containerHeight+" | subtractHeight: "+subtractHeight

    element.height(containerHeight - subtractHeight)

  delayedAdjustSize = _.debounce(_.bind(resizeFunction, @, container, element, subtractHeight), 500)

  $(window).on('resize', delayedAdjustSize)

  delayedAdjustSize(container, element, subtractHeight)