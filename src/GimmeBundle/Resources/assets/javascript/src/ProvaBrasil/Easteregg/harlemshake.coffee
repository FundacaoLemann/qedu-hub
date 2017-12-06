mcc.behavior 'provabrasil-easteregg-harlemshake', (config) ->
  harlemshake = () ->
    if $("body").data("runningHarlemShake")
      return true
    $("body").data("runningHarlemShake", true)
    addStyle = ->
      style = document.createElement("link")
      style.setAttribute "type", "text/css"
      style.setAttribute "rel", "stylesheet"
      style.setAttribute "href", css_link
      style.setAttribute "class", css_class
      $("body").append style
    remove = ->
      styles = $("."+css_class)

      for style in styles
        $(style).remove()
    addContainer = ->
      container = document.createElement("div")
      container.setAttribute "class", container_class
      $("body").append container
      setTimeout ->
                   $(container).remove()
                 , 100
    getSize = (element) ->
      height: element.offsetHeight
      width: element.offsetWidth
    isAdequate = (element) ->
      size = getSize(element)
      min_height < size.height < max_height and min_width < size.width < max_width
    getOffsetTop = (element) ->
      parent = element
      offset_top = 0
      until not parent
        offset_top += t.offsetTop
        parent = t.offsetParent
      offset_top
    getHeight = ->
      e = document.documentElement
      unless not window.innerWidth
        return window.innerHeight
      else return e.clientHeight  if e and not isNaN(e.clientHeight)
      0
    getYOffset = ->
      return window.pageYOffset  if window.pageYOffset
      Math.max document.documentElement.scrollTop, document.body.scrollTop
    isInTop = (e) ->
      offsettop = getOffsetTop(e)
      offsettop >= offsety and offsettop <= bodyHeight + offsety
    putAudio = ->
      window.element_audio = new Audio
      element_audio.className = css_class

      element_mp3 = document.createElement "source"
      element_mp3.src = mp3_link
      $(element_audio).append element_mp3

      element_ogg = document.createElement "source"
      element_ogg.src = ogg_link
      $(element_audio).append element_ogg

      element_audio.loop = false
      element_audio.addEventListener "canplay", ->
        setTimeout ->
          addClassToElement first
        , 500
        setTimeout ->
          findAndRemoveElementsByClass()
          addContainer()
          for element in valid_elements
            addRandomClassToElement element
        , 15500
      , true
      element_audio.addEventListener "ended", ->
        findAndRemoveElementsByClass()
        remove()
        $("body").data("runningHarlemShake", false)
      , true
      $("body").append element_audio
      element_audio.play()
    addClassToElement = (element) ->
      $(element).addClass harlem_class
      $(element).addClass first_class
    addRandomClassToElement = (element) ->
      $(element).addClass harlem_class
      $(element).addClass css_classes[Math.floor(Math.random() * css_classes.length)]
    findAndRemoveElementsByClass = ->
      elements = $("."+harlem_class)

      for element in elements
        if not element or not element.className
          continue
        $(element).removeClass(harlem_class)
    min_height = 30
    min_width = 30
    max_height = 350
    max_width = 350
    mp3_link = "/music/harlem-shake.mp3"
    ogg_link = "/music/harlem-shake.ogg"
    harlem_class = "mw-harlem_shake_me"
    first_class = "im_first"
    css_classes = ["im_drunk", "im_baked", "im_trippin", "im_blown"]
    container_class = "mw-strobe_light"
    css_link = "/css/easteregg/harlem-shake-style.css"
    css_class = "mw_added_css"
    bodyHeight = getHeight()
    offsety = getYOffset()
    elements = $("*")

    valid_elements = []
    for element in elements
      valid_elements.push element  if isAdequate(element)
    first = valid_elements[0] or null
    if not first
      console.warn "Could not find a node of the right size. Please try a different page."
    addStyle()
    putAudio()
    false
  checkInputForHarlemShake = () ->
    val = $(this).val()
    if not val
      return true
    val = val.toLowerCase().split(" ").slice(0, 2).join(" ")
    if val isnt "harlem shake"
      return true
    harlemshake()
  checkSpeechForHarlemShake = () ->
    val = $(this).val()
    if not val
      return true
    if val is "balança tudo"
      harlemshake()
      $(this).val("")
    return true
  $(config.searchField).keyup checkInputForHarlemShake
  $(config.searchField).bind "webkitspeechchange", checkSpeechForHarlemShake