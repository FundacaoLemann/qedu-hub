###
@requires js/BlobBuilder.js
          js/FileSaver.js
          js/jspdf.plugin.addimage.js
          js/html2canvas.js
          js/canvg.js
          js/jquery.js
          js/canvas-toBlob.js
###

PrintView = Backbone.View.extend

  initialize: (config) ->
    _.bindAll @, 'buttonPrintPressed', 'printVersionButton'

    # This variable is util becouse the HTML canvas scroll the screen to top
    # we will back to actual position after html2Canvas use.
    @actualPosition = 0

    @modalTooBig = $('#'+config.modals.too_big);
    @modalNotSupported = $('#'+config.modals.not_supported);
    @csrfToken = config.token;
    @userAction = config.actionId;

    $("body").on "click", ".btn-subnav-print", this.buttonPrintPressed
    $("body").on "click", ".btn-subnav-print-version", this.printVersionButton
    $("body").on "click", ".block-print-button", this.trackPrintButton
    $("body").on "click", ".signup-print-btn", this.trackSignUp

  buttonPrintPressed: (ev) ->
    ev.preventDefault()
    if __DEV__
      console.log $(ev.target), 'Botão Pressionado no elemento'

    @actualPosition = window.scrollY

    el = $(ev.target);
    if not el.get(0).hasAttribute('data-toprint')
      el = el.parent();

    elementToPrint = $( el.data "toprint" ).get( el.data("toprint-index") or 0 )
    if not elementToPrint
      console.log 'Elemento "'+(el.data "toprint")+'" não encontrado.' if __DEV__
      alert('Desculpe-nos, ocorreu um erro ao gerar a imagem deste bloco. Tente novamente e se o problema persistir, por favor, envie-nos uma mensagem na área de ajuda.')

    format = el.data("toprint-format") or "pdf"
    title = el.data("toprint-title") or document.title
    printData = new PrintData({
      elementToPrint: elementToPrint,
      format: format,
      documentTitle: title
    })

    this.download( printData )

  printVersionButton: (ev) ->
    ev.preventDefault();

    if $('body').hasClass('print-version')
      this.removePrintVersion()
    else
      this.showPrintVersion()

  showPrintVersion: ->
    $body =  $('body')
    $body.addClass 'print-version'

  removePrintVersion: ->
    $body =  $('body')
    $body.removeClass 'print-version'

    window.scrollTo 0, @actualPosition

  download: ( printData ) ->
    console.log 'Executando operação de download' if __DEV__

    if printData.isPrint()
      this.showPrintVersion()
      this.trackRequest(printData)
      print();
      this.removePrintVersion()

      url = location.href+"#print/navigator/"+printData.getTitle()
      message =  "Impressão da página/bloco "+printData.getTitle()+" pelo navegador."
      clicky.log(url, message) if typeof clicky is 'object'

      return

    if printData.isPDF() or printData.isPNG()

      if not @isBrowserSupported()
        if @modalNotSupported
          @modalNotSupported.modal()
        else
          alert('Seu navegador não suporta esse recurso. Por gentileza use um navegador mais atualizado.')

        url = location.href+"#print/browser_unsupported/"+printData.getTitle()
        message =  "Impressão da página/bloco "+printData.getTitle()+" falhou - browser nao ser suportado."
        clicky.log(url, message) if typeof clicky is 'object'

        return

      heightElement = $(printData.getEl()).outerHeight()
      if heightElement > 19500
        #Se o conteúdo é muito grande, exibimos uma modal que pergunta se o usuário topa imprimir o PDF cortado.
        #esta modal está na view provabrasil/footer/print e é adicionada à view footer
        if true or @modalTooBig
          @modalTooBig.modal()
          button = @modalTooBig.find('.btn[data-action=continue]')
          button.on('click', this.execDownloadPDForPNG.bind(this, printData))
        else
          alert('Essa página é muito grande! O conteúdo será cortado.')
          @execDownloadPDForPNG(printData)

        url = location.href+"#print/monster_page/"+printData.getTitle()
        message =  "Impressão da página/bloco "+printData.getTitle()+" cortada para 19500 pixels. Tamanho original " + heightElement
        clicky.log(url, message) if typeof clicky is 'object'

        return
      else
        this.execDownloadPDForPNG(printData)

  execDownloadPDForPNG: (printData) ->
    #Gsarante que a modal suma antes de gerar o PDF
    #P.S. Essa modal só abre se o arquivo tem Mais de 15 páginas
    if @modalTooBig
      @modalTooBig.modal('hide');
      $('.modal-backdrop').hide();

    this.showPrintVersion()
    printCanvas = new PrintCanvas( { printData: printData })
    printCanvas.on('printFinish', => this.removePrintVersion())
    printCanvas.on('printFinish', => this.trackRequest(printData))
    printCanvas.download()

    url = location.href+"#print/"+printData.getFormat()+"/"+printData.getTitle()
    message =  "Impressão da página/bloco "+printData.getTitle()+" em formato " + printData.getFormat()
    clicky.log(url, message) if typeof clicky is 'object'

  isBrowserSupported: ->
    browserVersion = parseInt($.browser().version, 10)
    console.log  $.browser(),'Imprimindo PDF no navegador: ' if __DEV__
    $browser = $.browser()

    #API HTML5 necessária para o funcionamento do recurso.
    if not window['Uint8Array']
      console.log  'API do HTML5 Uint8Array não encontrada ' if __DEV__
      return false

    if $browser.webkit
      return true

    if $browser.msie && browserVersion >= 10
      return true

    if $browser.mozilla && browserVersion >= 3  and window['Uint8Array']
      return true

    return false

  trackRequest: (printData) ->
    console.log "Tracking action" if __DEV__

    eventAction = 'download ' + printData.getFormat()
    eventLabel = window.location.href

    dataLayer.push({
      'event': 'printTrigger',
      'printActionVariable': eventAction,
      'printLabelVariable': eventLabel
    });

    if window._cio
      _cio.track 'printPage',
        'format': printData.getFormat(),
        'title': printData.getTitle(),
        'url': window.location.href

    $.ajax
      url: '/tracking/user'
      dataType: 'json',
      type: 'POST',
      data:
        token: @csrfToken
        referrer: location.href
        type: @userAction

  trackPrintButton: ->
    dataLayer.push({
      'event': 'printTrigger',
      'printActionVariable': 'click print button',
      'printLabelVariable': window.location.href
    });

    return

  trackSignUp: ->
    dataLayer.push({
      'event': 'printTrigger',
      'printActionVariable': 'click sign up',
      'printLabelVariable': window.location.href
    });

    return
