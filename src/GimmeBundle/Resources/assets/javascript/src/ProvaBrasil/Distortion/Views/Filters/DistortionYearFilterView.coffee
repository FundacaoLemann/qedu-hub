DistortionYearFilterView = Backbone.View.extend
  events:
    'click .dropdown-menu > li > a': 'receiveEventFromUI'
  initialize: (@options) ->
    _.bindAll @, 'receiveEventFromUI', 'receiveEventFromModel', 'setValue', 'render'
    @active = null
    @label = @$el.find('#distortion-year-value')
    @regionalAggregation = @options['regionalAggregation']
    @filter = @options['filter']
    @filter.on 'change:year', @receiveEventFromModel


  receiveEventFromUI: (e) ->
    if $(e.currentTarget).parent().is '.disabled'
      return
    value = $(e.currentTarget).data 'value'
    @setValue value

  receiveEventFromModel: () ->
    value = @filter.get 'year'
    @setValue value

  setValue: (value) ->
    if @active == value
      return
    @active = value
    @$el.find('.dropdown-menu > li.active').removeClass 'active'
    elementSelected = @$el.find '.dropdown-menu > li > a[data-value="'+value+'"]'
    if not elementSelected.parent().is '.disabled'
      elementSelected.parent().addClass 'active'
    @label.html value
    @filter.set 'year', value

  render: () ->
    @active = @label.html()