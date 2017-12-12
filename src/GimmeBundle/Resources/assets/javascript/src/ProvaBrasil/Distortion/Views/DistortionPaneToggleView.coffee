DistortionPaneToggleView = Backbone.View.extend
  events:
    'click': 'toggle'
  render: () ->
    if __DEV__ and not @$el.is '.distortion-pane-button'
      throw 'Invalid button'
    @paneId = @$el.data 'pane-id'
    @$pane = jQuery '#'+@paneId
    @max = parseInt @$pane.find('.distortion-pane').last().data 'pane-index'
    @activeElement = @$pane.find('.distortion-pane-active')
    @active = parseInt @activeElement.data 'pane-index'

  getNext: (active = @active) ->
    next = active + 1
    if next > @max
      next = 0
    return next

  toggle: () ->
    @activeElement.removeClass 'distortion-pane-active'
    next = @getNext()
    @activeElement = @$pane.find '#'+@paneId+'-'+next
    @activeElement.addClass 'distortion-pane-active'
    @$el.html @$pane.find('#'+@paneId+'-'+@getNext(next)).data 'pane-title'
    @active = next

DistortionPaneToggleView.applyToAll = () ->
  $('.distortion-pane-button').each () ->
    instance = new DistortionPaneToggleView
      el: @
    instance.render()
    $(@).data 'instance', instance