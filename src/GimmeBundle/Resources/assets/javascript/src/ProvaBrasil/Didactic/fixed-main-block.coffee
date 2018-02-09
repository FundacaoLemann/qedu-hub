
###
 * Permite que o bloco principal da página flutue
 * de sua posição inicial 
 * até ficar lado a lado com um determinado elemento final
###
FixedMainBlock = Backbone.View.extend

  el : 'div.container-didactic-main-block'
  stopper : null
  
  extraTop: 0
  heightDifference: 0
  
  initialize: ->
    # Desativa se navegador for IE8 porque não está funcionando bem
 #   if $('body.internet-explorer-8').size() > 0
      #return

    #get height from another element fixed up above
    #more a margin of 20px equivalent to static layout
    dbFilter = $('div.db-filters');
    @extraTop = dbFilter.outerHeight(true) + 20
    
    # launch waypoint to fixed the main block
    @$el.waypoint @handler.bind(this), offset: @extraTop       
        
    #get element to stop the mainblock
    @stopper = $('.didactic-block-last')        
    @heightDifference = (@$el.outerHeight(true) - @stopper.outerHeight(true))
    #launch waypoint to stop the main block
    @stopper.waypoint @handlerStopper.bind(this), {offset: @heightDifference+@extraTop}
  
  handler: (event, direction) ->
    @fixer() if direction is 'down' 
    @normal() if direction is 'up'
    
  fixer: ->
    @$el.children().first().css
      'position': 'fixed'
      'top': @extraTop+'px'
      'z-index' : 1
      
  normal: ->
    @$el.children().first().css
      'position': 'relative'
      'top': '0px'    
  
  handlerStopper: (event, direction) ->
    if direction is 'down'
      @$el.children().first().css
        'position': 'absolute'
        'top': (@stopper.offset().top-@heightDifference)+'px'
        'z-index' : 1
    else
      @fixer()
