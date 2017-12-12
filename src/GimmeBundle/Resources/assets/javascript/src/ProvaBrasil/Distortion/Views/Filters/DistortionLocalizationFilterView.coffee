DistortionLocalizationFilterView = Backbone.View.extend
  events:
    'click .dropdown-menu > li > a': 'receiveEventFromUI'

  initialize: (@options) ->
    _.bindAll @, 'receiveEventFromUI', 'receiveEventFromModel', 'setValue', 'render'
    @active = null
    @label = @$el.find('#distortion-localization-value')
    @filter = @options['filter']
    @filter.on 'change:localization', @receiveEventFromModel

  receiveEventFromUI: (e) ->
    if $(e.currentTarget).parent().is('.disabled')
      return
    value = $(e.currentTarget).data 'value'
    @setValue value

  receiveEventFromModel: () ->
    value = @filter.get 'localization'
    @setValue value

  setValue: (value) ->
    if @active == value
      return
    @active = value
    @$el.find('.dropdown-menu > li.active').removeClass 'active'
    elementSelected = @$el.find '.dropdown-menu > li > a[data-value="'+value+'"]'
    if not elementSelected.parent().is '.disabled'
      elementSelected.parent().addClass 'active'
    @label.html elementSelected.html()
    @filter.set 'localization', value

  render: () ->
    @active = @$el.find('.dropdown-menu > li.active').data 'value'