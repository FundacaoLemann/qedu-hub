
###
 * Permite que o bloco principal da página flutue
 * de sua posição inicial 
 * até ficar lado a lado com um determinado elemento final
###
FixedButtonsFilter = Backbone.View.extend

  el : 'div.container-db-filters'
  nextBlock : null
  stopper : null
  
  initialize: ->
    # Desativa se navegador for IE8 porque não está funcionando bem
  #  if $('body.internet-explorer-8').size() > 0
     # alert('IE8');
     # return

    @$el.waypoint @handler.bind(this)
    
    @nextBlock = @$el.parent().next()
    #get the row below the block with comparable blocks to server with stopper for buttons 
    @stopper = $('.didactic-block-last').last();
    @stopper.waypoint @handlerStopper.bind(this), {offset: @stopper.outerHeight(true)}
  
  handler: (event, direction) ->
    @fixer() if direction is 'down' 
    @normal() if direction is 'up' 
    
  fixer: ->
    @$el.children().first().css
      'position': 'fixed'
      'top': '0px'
      'z-index' : 2
    
    # Posiciona elemento imediamete abaixo para ocupar o espa;co deixado pelo elemento fixado.
    # 20 é a margem inferior do elemento de cima
    @nextBlock.css 
      'margin-top': @$el.outerHeight(true)+20
      
  normal: ->
    @$el.children().first().css
      'position': 'relative'
      'top': '0px'
    @nextBlock.css
      'margin-top': '0px'
  
  handlerStopper: (event, direction) ->
    if direction is 'down'
      @$el.children().first().css
        'position': 'absolute'  
        'top': (@stopper.offset().top-@$el.children().first().outerHeight(true))+'px'
        'z-index' : 2
    else
      @fixer()