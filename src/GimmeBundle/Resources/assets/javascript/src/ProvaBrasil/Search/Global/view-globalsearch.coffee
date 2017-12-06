window.ProvaBrasilViewGlobalSearch = Backbone.View.extend
  
  el: '.global-search-container'
  
  events: 
    'keyup input[type="text"]'   : 'keyUp'
    'keydown input[type="text"]'   : 'keyDown'
    'focus input[type="text"]'   : 'inputFocus'
    'blur input[type="text"]'    : 'inputBlur'
    'click button.btn'           : 'clickButton'
    'mouseenter a.result'        : 'hover'
    'mouseleave a.result'        : 'hover'
    'submit'                     : 'submit'
    'webkitspeechchange input[type="text"]': 'speechResult'
  
  textToSearch: null
  autosend: false
  initialize: ->      
    @$imgLoading = $('.ajax-loading')
    @model = new ProvaBrasilModelGlobalSearch()
    
    @templateResults = _.template $('#search-tmpl').html()
    @templateNothingTyped = _.template $('#search-tmpl-nothing-typed').html()
    @templateNothingFounded = _.template $('#search-tmpl-nothing-founded').html()
    
    @model.on 'change', (data) => @onFetch data 
    
    @debouncedFind = _.debounce(_.bind(@find, this), 300)

  keyDown: (e) ->
    switch e.keyCode
     when 27 then @close() #ESC
     when 13 then @goResultSelected() #ENTER
     when 38 then @moveCursorUp()
     when 40 then @moveCursorDown()
     else         
        return
      
  keyUp: (e) ->
    if @textToSearch is e.currentTarget.value
      return

    @textToSearch = e.currentTarget.value
    @debouncedFind()   

  speechResult: (e) ->
    @$el.find("input[type='text']").prev().hide();
    regOpts = /^ir para (aprendizado|compare|comparar|evolução|proficiência|explorer?|contexto|pessoas|censo|censo escolar)( d[aoe])? /
    regWithoutOpts = /^ir para /
    v = @$el.find("input[type='text']").val()
    m = v.match regOpts #Procura pela sequencia
    if not m
      m = v.match regWithoutOpts #Procura pela sequencia
    if m
      if m.length > 1
        #Replaces the regex:
        @$el.find("input[type='text']").val v.replace regOpts, ""
        #Some replaces to the match
        modes =
          "evolução": "evolucao"
          "proficiência": "proficiencia"
          "comparar": "compare"
          "explore": "explorar"
          "explorer": "explorar"
          "censo escolar": "censo-escolar"
          "censo": "censo-escolar"
        if modes[m[1]]
          @autosend = modes[m[1]]
        else
          @autosend = m[1]
      else
        @$el.find("input[type='text']").val v.replace regWithoutOpts, ""
        @autosend = true

  ### Controle do Teclado ###
  
  close: () ->
    @$el.find('input').val('') if $('.global_search-results').size() is 0
    @removeAll()
    
  goResultSelected: () ->
    $el = @$el.find 'a.result.hover'
    if $el.size() > 0
      url = $el.get(0).href
      if not _.isBoolean(@autosend)
        if _.last(url) != "/"
          url += "/"
        url +=  @autosend
      window.location = url
      return true
    return false
    
  
  moveCursorUp: () ->        
    #Pega todos os resultados
    allResults = @$el.find('ul li a.result');    
    #Encontra o índice do resultado selecionado
    indexSelected = null
    allResults.each (index, item) ->
      if $(item).hasClass 'hover'
        indexSelected = index;
    
    #Encontra o índice do próximo item a ser selecionado   
    lastIndex = allResults.length-1;
    indexToSelect = indexSelected-1
    if indexToSelect < 0 
      indexToSelect = lastIndex;

    #muda seleção
    $(allResults[indexSelected]).removeClass('hover')
    $(allResults[indexToSelect]).addClass('hover')          
  
  moveCursorDown: () ->    
    #Pega todos os resultados
    allResults = @$el.find('ul li a.result');    
    #Encontra o índice do resultado selecionado
    indexSelected = null
    allResults.each (index, item) ->
      if $(item).hasClass 'hover'
        indexSelected = index;
    
    #Encontra o índice do próximo item a ser selecionado   
    lastIndex = allResults.length-1;
    indexToSelect = indexSelected+1
    if indexToSelect > lastIndex 
      indexToSelect = 0
      
    #muda seleção
    $(allResults[indexSelected]).removeClass('hover')
    $(allResults[indexToSelect]).addClass('hover') 
      
  selectFirstResult: () ->
    @$el.find('a.result').first().addClass 'hover'
    
  ### Métodos de Busca ###
      
  find: () ->
    if not @textToSearch
      ##cancela timeout anterior
      clearTimeout @timeOut if @timeOut
      #exibe que nada foi encontrada
      return @showNothingTyped()
    else      
      # We use a timeout to prevent to call to much an ajax request
      @findText()
  
  findText: () ->
    #se não limparmos o modelo, e o resultado da busca retornar a mesma coisa
    #que a busca anterior, o evento 'change' não é lancado.
    @model.removeAll()
    @model.url = "/api/search/?text=#{ @textToSearch }"      
    @model.fetch
      beforeSend: =>
        @$imgLoading.fadeIn()
      complete: =>
        @$imgLoading.fadeOut()
  
  onFetch: (model) ->
    if model.get('states').length is 0 and model.get('cities').length is 0 and model.get('schools').length is 0      
      return @showNothingFounded()
      
    @removeAll()    
    @$el.append @templateResults model.toJSON()
    @selectFirstResult()
    if @autosend != false
      @goResultSelected()
  showNothingFounded: () ->
    @removeAll()
    @$el.append @templateNothingFounded {}
    
  showNothingTyped: () ->
    @removeAll()
    @$el.append @templateNothingTyped {}
   
  removeAll: () ->   
    @$el.find('.global_search-results').remove();    
    
  submit: (e) ->
    e.preventDefault()   
  
  #Quando o foco do campo sair, 
  #deve remover os resultados da busca para nao atrapalhar a navegação na página.
  #O setTimeOut é necessário porque, se o usuário clicasse em um resultado da busca, 
  #o close seria executado antes do click ser executado.
  inputBlur: (e) ->
    _.delay @removeAll.bind(this), 200
    
  #Quando ocorre um input no campo de texto,
  #solta o find para exibir os resultados.  
  inputFocus: (e) ->    
    @textToSearch = e.currentTarget.value
    @find()
    
  clickButton: (e) ->
    if $('.global_search-results').length > 0
      return false

    e.preventDefault()
    e.stopPropagation()
        
    if not @goResultSelected()
      $input = $(e.currentTarget).siblings 'input'
      @textToSearch = $input.val()
      @focus()          
  
  focus: () ->
    @$el.find('input[type="text"]').focus();
  
  hover: (e) ->
    @$el.find('ul li a.result.hover').removeClass 'hover';  
    $this = $(e.currentTarget)
    if e.type is 'mouseenter' then $this.addClass 'hover' else $this.removeClass 'hover'   
    
  
    
  
      
      
  
   
  
    
