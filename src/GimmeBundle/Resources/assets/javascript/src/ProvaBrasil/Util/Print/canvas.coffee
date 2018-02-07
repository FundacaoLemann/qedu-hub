PrintCanvas = Backbone.View.extend

  # @var PrintData
  printData : null,
  canvas: null
  # Contexto 2D do Canvas
  ctx: null

  initialize: (@options) ->
    _.bindAll this, 'download', 'onRenderedCanvas', 'drawSVGs', 'drawSVG', 'downloadPDF', 'downloadPNG'
    this.printData = this.options.printData

  download: () ->
    console.log @printData.getEl(), 'Iniciando Download do elemento' if __DEV__
    optionsToHTML2Canvas =
      onrendered: @onRenderedCanvas

    if $(this.printData.getEl()).outerHeight() > 19500
      optionsToHTML2Canvas.height = 19500

    html2canvas this.printData.getEl(), optionsToHTML2Canvas

  onRenderedCanvas: (canvas) ->
    console.log 'Canvas Renderizado, avançando no processamento,' if __DEV__
    this.canvas = canvas
    this.ctx = canvas.getContext "2d"
    this.drawSVGs()

    if @printData.isPDF()
      @downloadPDF()

    else if @printData.isPNG()
      @downloadPNG()

  drawSVGs: () ->
    console.log 'Desenha SVG`s para dentro do canvas' if __DEV__
    #Faz o loop por TODOS os SVG's do elemento capturado

    for el in jQuery("svg", @printData.getEl())
      $el = $ el
      # jQuery does not detect currently when a parent is hidden, and because of this we need to query using
      # parents(':hidden')
      if $el.find('svg').length > 0 or $el.parents(':hidden').length > 0
        # Does not rerenderize svgs that have a children element or are hidden
        continue
      parent = $el.parent()
      @drawSVG parent[0]

    for el in jQuery("object[type*='image/svg']", this.printData.getEl() )
      $el = $ el
      if $el.is(':hidden') or $el.parents(':hidden').length > 0
        # Does not rerenderize svgs that are hidden
        continue
      @drawSVG el



  drawSVG: (el) ->
    console.log 'Desenhando um SVG para dentro do canvas' if __DEV__
    #Pega o elemento object atual
    obj = jQuery(el)

    #Pega as coordenadas do elemento
    x = Math.floor(obj.offset().left)
    y = Math.floor(obj.offset().top)
    console.log "A posicao X do SVG e " + x + " e a posicao Y e " + y if __DEV__

    #Pega o tamanho do elemento na pagina
    width = obj.outerWidth()
    height = obj.outerHeight()
    console.log "A largura do Espaço na tela é " + width + " e a altura e " + height if __DEV__

    #Depois nós analisamos melhor o conteúdo do Object, pegamos a tag SVG e..
    svgElement = jQuery("svg", el.contentDocument or obj).clone();
    widthSVG = parseInt(svgElement.attr('width'))
    heightSVG = parseInt(svgElement.attr('height'))
    console.log "A largura do SVG e " + widthSVG + " e a altura e " + heightSVG if __DEV__

    # colocamos ela em um container para podermos pegar o conteudo do SVG por si só
    svgContent = $("<div></div>").append(svgElement).html()

    #Trata o conteudo do SVG para ser processado pelo CanVG
    svgContent = svgContent.replace /\sversion=\"0[^\"]*"/, ""
    svgContent = svgContent.replace /(>\s+)/g, ">"
    svgContent = svgContent.replace /(\s+\<)/g, "<"
    svgContent = svgContent.replace /<canvas.+/g, ""
    svgContent = svgContent.replace /(\s{2,})/g, " "

    if __DEV__
      console.log "Salvando conteudo do SVG de forma global para acesso facil.."
      window.svgC = svgContent

    #Cria um canvas branco para poder sobrepor a imagem corretamente depois
    tempCanvas = document.createElement "canvas"
    tempCanvas.width = widthSVG
    tempCanvas.height = heightSVG

    #Pega o contexto do canvas temporario..
    tempContext = tempCanvas.getContext "2d"

    #Define a cor como sendo branca
    tempContext.fillStyle = "white"

    #Pinta!
    tempContext.fillRect 0, 0, widthSVG, heightSVG

    #Agora pintamos o SVG..
    tempContext.drawSvg svgContent

    # fundo branco
    this.ctx.fillStyle = "white"
    this.ctx.fillRect x, y, width, height

    if heightSVG > widthSVG
      widthSVGProporcionalToHeight = height * widthSVG / heightSVG;
      console.log 'Largura Proporcional SVG - '+widthSVGProporcionalToHeight if __DEV__
      offsetLeftExtra = + (width - widthSVGProporcionalToHeight) / 2;
      # E ..agora podemos desenhar a imagem normalmente sob o screenshot
      this.ctx.drawImage tempCanvas, 0, 0, widthSVG, heightSVG, x + offsetLeftExtra , y, widthSVGProporcionalToHeight, height
    else
      heightSVGProporcionalToWidth = width * heightSVG / widthSVG;
      console.log 'Altura Proporcional SVG - '+heightSVGProporcionalToWidth if __DEV__
      offsetTopExtra = + (height - heightSVGProporcionalToWidth) / 2;
      # E ..agora podemos desenhar a imagem normalmente sob o screenshot
      this.ctx.drawImage tempCanvas, 0, 0, widthSVG, heightSVG, x  , y + offsetTopExtra, width, heightSVGProporcionalToWidth


  downloadPDF: () ->
    console.log 'Gerando PDF' if __DEV__

    width_pdf = 190; # milímetros
    maxHeight = 1300
    #Número máximo de pixels para PDF A4 considerando 960 de largura

    # Largura do site (940) + 10 pixels de cada lado
    maxWidth = 960
    #ou 1200 caso esteja no modo responsivo.
    if(this.printData.isBodyToPrint() and $('body').hasClass('responsive-after-1200'))
      maxWidth = 1200

    doc = new jsPDF
    heightToEnd = this.canvas.height

    # Configura largura da página
    width = maxWidth
    if this.canvas.width < width
      width = this.canvas.width
      width_pdf = width * width_pdf / maxWidth

    #Gera o PDF com as diversas páginas conforme a altura da imagem do site.
    while heightToEnd > 0

      # Configura altura da página
      height = heightToEnd
      if heightToEnd > maxHeight
        height = maxHeight

      #Cria canvas e preenche ele com a imagem recortada no tamanho certo
      # Neste canvas colamos apenas a parte da imagem que queremos, sem as grandes bordas.
      cropedCanvas = document.createElement "canvas"
      cropedCanvas.width = width
      cropedCanvas.height = height

      ##Cria e preenche o contexto do canvas com a imagem recortada
      ctxCropedCanvas = cropedCanvas.getContext "2d"
      ctxCropedCanvas.fillStyle = "orange"
      ctxCropedCanvas.fillRect 0, 0, width, height

      #Desenhamos do canvas principal para o o canvas com a imagem recortada
      ctxCropedCanvas.drawImage this.canvas, (this.canvas.width - width) / 2, this.canvas.height - heightToEnd, width, height, 0, 0, width, height

      # converte pixels para milímetros
      height_pdf = height * width_pdf / width

      # Adicionamos ao doucmento PDF a imagem gerada
      doc.addImage cropedCanvas.toDataURL("image/jpeg", 1.0), "JPEG", 10, 10, width_pdf, height_pdf
      heightToEnd = heightToEnd - height

      #Adiciona uma nova pagina somente se ainda ha conteudo para processar
      if heightToEnd > 0
        doc.addPage()

    #Fix a bug in the HTML2CANVAS that repositionate some elements wrong..
    $(".pull-right").css "float", "none"

    setTimeout ->
      jQuery(".pull-right").css "float", "right"
    , 10

    #Salva o PDF com o titulo da pagina
    doc.save this.printData.getTitle() + '.pdf'
    this.trigger('printFinish')

  downloadPNG: () ->
    console.log 'Canvas to PNG' if __DEV__

    width = this.canvas.width
    height = this.canvas.height

    #Cria canvas e preenche ele com a imagem recortada no tamanho certo
    # Neste canvas colamos apenas a parte da imagem que queremos, sem as grandes bordas.
    cropedCanvas = document.createElement "canvas"
    cropedCanvas.width = (width + 20)
    cropedCanvas.height = (height + 20)

    ##Cria e preenche o contexto do canvas com a imagem recortada
    ctxCropedCanvas = cropedCanvas.getContext "2d"
    ctxCropedCanvas.fillStyle = "white"
    ctxCropedCanvas.fillRect 0, 0, (width + 20), (height + 20)

    #Desenhamos do canvas principal para o o canvas com a imagem recortada
    ctxCropedCanvas.drawImage this.canvas,  0, 0, width, height, 10, 10, width, height

    cropedCanvas.toBlob (blob) =>
      saveAs blob, this.printData.getTitle()+".png"

    this.trigger('printFinish')