DistortionDependenceFilterView = Backbone.View.extend
  events:
    'click ul.dropdown-menu > li > a': 'receiveEventFromUI'

  initialize: (@options) ->
    _.bindAll @, 'receiveEventFromUI', 'receiveEventFromModel', 'setValue', 'render'
    @active = null
    @label = @$el.find('#distortion-dependence-value')
    @filter = @options['filter']
    @filter.on 'change:dependence', @receiveEventFromModel

  receiveEventFromUI: (e) ->
    if $(e.currentTarget).parent().is('.disabled')
        return
    value = $(e.currentTarget).data 'value'
    @setValue value

  receiveEventFromModel: () ->
    value = @filter.get 'dependence'
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
    @filter.set 'dependence', value

  render: () ->
    @active = @$el.find('.dropdown-menu > li.active').data 'value'
