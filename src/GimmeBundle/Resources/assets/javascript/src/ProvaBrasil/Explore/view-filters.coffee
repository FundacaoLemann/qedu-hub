###
@requires js/backbone.js
          js/provabrasil/util/fixedLayout.coffee
          js/jquery.loadmask.js
          js/jquery.nouislider/jquery.nouislider.js
          js/provabrasil/util/statemenu.coffee

This view is responsible for updating the filters model based on user input and updating the user interface bases on the filters model change

We can have some kinds of filters:

data-filter-type
  one-of-kind    : selects at most one of a kind (like: big or small or medium)
  many-of-kind  : selects any number of a kind (like: surgar and lemmon)
  slider         : slider filter with min and max value

And a model/view binder could be really helpful here!

###
ProvaBrasilExploreFiltersView = Backbone.View.extend
  el : '.explore-filters-section'

  events:
    'click a[data-filter]'                              : '_viewToModelFilters'
    'click .explore-topbar .explore-topbar-mode button' : '_viewToModelVisualization'
    'click .explore-topbar .explore-topbar-zoom button' : '_viewToModelZoom'

    'click .explore-topbar .explore-topbar-compare .explore-topbar-compare-action-open button' : '_viewToModelOpen'
    'click .explore-topbar .explore-topbar-compare .explore-topbar-compare-action-compare button' : '_viewToModelComparing'
    'click .explore-topbar .explore-topbar-compare .explore-topbar-compare-clean a'       : '_viewToModelSelectedEmpty'

    'click .explore-sidebar-mode-callout button' : '_viewToModelMode'

  
  initialize: (@state, @collection, @statemenu, @options) ->

    # Set the filters section as fixed, based on the height of the topbar
    # FixedLayout.fix('.explore-filters-section:eq(0)', $('.explore-filters-section:eq(0) .explore-topbar'))
    # FixedLayout.fix('.explore-filters-section:eq(1)', 0,  $('.explore-filters-section:eq(0) .explore-topbar'))

    $('.explore-filters-section:eq(1)').css('z-index', 0);

    @block()

    @state.on('change', @_modelToViewFilters, @)
    @state.on('change:zoom', @_modelToViewZoom, @)
    @state.on('change:visualization', @_modelToViewVisualization, @)
    @state.on('change:selected', @_modelToViewSelected, @)
    @state.on('change:openSelected', @_modelToViewOpen, @)
    @state.on('change:comparingSelected', @_modelToViewComparing, @)

    @collection.on('reset:sliders', @_modelToViewSliders, @)

    @initSlider()

    @_modelToViewFilters()
    @_modelToViewZoom()
    @_modelToViewVisualization()
    @_modelToViewSelected()
    @_modelToViewComparing()
    @_modelToViewOpen()

    @_initWindowResize()


  # @todo pass this methods to view-explore
  unblock: () ->
    $(document.body).css('cursor', '')
    @$el.unmask(); # remove the loading mask

  block: () ->
    $(document.body).css('cursor', 'wait')
    @$el.eq(0).mask(); # add a loading mask
    @$el.eq(1).mask('Carregando...'); # add a loading mask


  initSlider: () ->
    if @state.get('mode') is 'basic'
      return
    self = @
    @$el.find('[data-slider]').each((index, el) =>
      slider = $(el)

      min = parseInt(slider.attr('data-value-min'))
      max = parseInt(slider.attr('data-value-max'))
      step = Math.floor((max-min)/20)
      slider.noUiSlider
        handles: parseInt(slider.data('handles'))
        connect: true
        range: [min, max]
        start: [min, max]
        step: step
        margin: step
        set: () ->
          self._viewToModelSlider(slider)
        slide: () ->
          values = slider.val()
          format = slider.data('format')

          values[0] = parseInt values[0]
          values[1] = parseInt values[1]
          values[0] = self._sliderDataConversor format, values[0]
          values[1] = self._sliderDataConversor format, values[1]
          slider.find('.noUi-handle-lower .infoBox').text(values[0]);
          slider.find('.noUi-handle-upper .infoBox').text(values[1]);

      ##Fill the Slider Labels
      slider.find('.noUi-handle').each((index, el) =>
        $el = $(el)
        $el.css
          'white-space': 'nowrap'

        values = slider.val()
        format = slider.data('format')
        values[0] = parseInt values[0]
        values[1] = parseInt values[1]
        values[0] = @_sliderDataConversor format, values[0]
        values[1] = @_sliderDataConversor format, values[1]

        $el.append('<span class="infoBox">'+values[index]+'</span>')
      )
    )

    @_modelToViewSliders(@collection.getSliderData())

  _sliderDataConversor: (format, value) ->
    if format is 'percent'
      return (value += '%')
    else if format is 'nse_class'
      switch value
        when 1 then return 'Mais baixo'
        when 2 then return 'Baixo'
        when 3 then return 'Médio-baixo'
        when 4 then return 'Médio'
        when 5 then return 'Médio-alto'
        when 6 then return 'Alto'
        when 7 then return 'Mais alto'
    else
      return mcc.number.format(value, 0)

  _viewToModelSlider: (slider) ->
    if @state.get('mode') is 'basic'
      return

    values = slider.val()
    min = values[0]
    max = values[1]

    finalData = {}
    finalData[slider.data('slider')] = values

    @state.setViaInterface(finalData)

  roundStep: (min, max) ->
    total = max-min
    steps = Math.pow 10, total.toString().length-1
    return steps/20

  _modelToViewSliders: (slidersMaxMin) ->
    if @state.get('mode') is 'basic'
      return

    if slidersMaxMin.enrolled_count
      min = parseInt(slidersMaxMin.enrolled_count.min)
      max = parseInt(slidersMaxMin.enrolled_count.max)

      if min == max
          @$el.find('.enrollment-slider').hide()
          return

      slider = @$el.find('[data-slider=enrolled_count]')

      step = @roundStep min, max

      slider.noUiSlider
        range: [min, max]
        save: true
        # We need to add a good margin to the max value because of a bug in noUiSlider
        start: [min, max+step]
        step: step
        margin: step
      , true
      slider.find('.noUi-handle').each((index, el) =>
        $el = $(el)
        $el.css
          'white-space': 'nowrap'

        values = slider.val()
        format = slider.data('format')
        values[0] = @_sliderDataConversor format, values[0]
        values[1] = @_sliderDataConversor format, values[1]

        $el.append('<span class="infoBox">'+values[index]+'</span>')
      )



  # When the filters model is updated, we should update our interface
  _modelToViewFilters: () ->
    # lets update the interface
    _.each(@state.toJSON(), (value, key) ->
      #console.log "Atualizando interface com os valores do filtro: #{key} para #{value}"

      # first lets update the one-of-kind filters
      $filters = @$("a[data-filter=#{key}][data-type=one-of-kind]")

      _.each($filters, (filter) ->
        $filter = $ filter
        filterName = $filter.data("filter")
        if $filter.data('filter') is 'sort'
          @_modelToViewSortAndDirection $filter
        val = $filter.data 'value'
        if val.toString() is value.toString()
          $filter.parent('li').addClass 'active'
          if filterName in ["dependence", "grade", "discipline"] and @state.hasChanged filterName # If it' really not fake
            @statemenu.set filterName, val.toString()
        else
          $filter.parent('li').removeClass 'active'
      , @)
    , @)
  # adjust the icon of the sorting direction
  _modelToViewSortAndDirection: ($filter) ->
    sort = @state.get('sort')
    sortDirection = @state.get('sortDirection')

    $filter.attr('title', '').children('i').remove()

    if $filter.data('value') is sort
      classToAdd = if sortDirection is 'asc' then 'down' else 'up'
      $filter.attr('title', 'Clique novamente para inverter a ordenação').append(" ").append($("<i class='icon-chevron-#{classToAdd} icon-white'></i>"))

  _autoToggleSortDirection: ($filter) ->
    # if its a click in a alread selected sort, lets invert the direction
    if $filter.data('value') is @state.get('sort')
      direction = 'asc'
      if @state.get('sortDirection') is 'asc'
        direction = 'desc'

      @state.setViaInterface({sortDirection: direction})

  # When a filter is selected in the interface, we should update the filters model
  _viewToModelFilters: (e) ->
    e.preventDefault()

    $filter = $(e.currentTarget)

    filterData = $filter.data()

    # sort has a diferent behavior on advanced mode
    if filterData.filter is 'sort'
      @_autoToggleSortDirection($filter)
      if window._cio
        _cio.track 'sortedExplore',
          'order': @state.get('sortDirection'),
          'name': filterData.value,
          'url': window.location.href

    finalData = {}
    finalData[filterData.filter] = filterData.value.toString()

    @state.setViaInterface(finalData)

  _viewToModelZoom: (e) ->
    e.preventDefault()

    # dont relay on target cause
    #$btn = @$('.explore-topbar .explore-topbar-mode button')
    #$btn = $(e.currentTarget)

    @state.rotateZoom()

  _modelToViewZoom: () ->
    $btn = $('.explore-topbar .explore-topbar-zoom button')

    $btn.html('<i class="icon-th"></i> '+@state.get('zoom')+'x')

  _viewToModelVisualization: (e) ->
    e.preventDefault()

    # dont relay on target cause
    #$btn = @$('.explore-topbar .explore-topbar-mode button')
    $btn = $(e.currentTarget)

    @state.set({ visualization: $btn.data('value') })

  _modelToViewVisualization: () ->
    $btn = $('.explore-topbar .explore-topbar-mode button')

    if @state.get('visualization') is 'isotope'
      $btn.data('value', 'map').html('<i class="icon-map-marker icon-white"></i> Mapa')

      # show stuff
      @$('[data-hide-on-map=true]').show()
    else
      $btn.data('value', 'isotope').html('<i class="icon-th icon-white"></i> Quadrados')

      @$('[data-hide-on-map=true]').hide()

  _modelToViewOpen: () ->
    if @state.get('visualization') is 'map'
      $('.explore-topbar .explore-topbar-mode button').click()

    $btn = @$('.explore-topbar-compare .explore-topbar-compare-action-open button')

    if @state.get('openSelected') is 'yes'
      $btn.data('value', 'no').html('Aberto').addClass('active')
    else
      $btn.data('value', 'yes').html('Abrir').removeClass('active')

  _viewToModelOpen: (e) ->
    e.preventDefault()

    $btn = $(e.currentTarget)

    @state.set({ openSelected: $btn.data('value') })

  _viewToModelComparing: (e) ->
    e.preventDefault()

    $btn = $(e.currentTarget)

    @state.set({ comparingSelected: $btn.data('value') })

  _modelToViewComparing: () ->
    if @state.get('visualization') is 'map'
      $('.explore-topbar .explore-topbar-mode button').click().click().click()

    #console.log "_modelToViewComparing: #{@state.get('comparingSelected')}"
    $btn = @$('.explore-topbar-compare .explore-topbar-compare-action-compare button')

    if @state.get('comparingSelected') is 'yes'
      $btn.data('value', 'no').html('Comparando').addClass('active')
    else
      $btn.data('value', 'yes').html('Comparar').removeClass('active')

  _viewToModelSelectedEmpty: (e) ->
    e.preventDefault()

    @state.emptySelected()

  _modelToViewSelected: () ->
    selectedModels = @state.getSelectedModels()
    selectedTotal = _.size(selectedModels)

    $selection = $('.explore-topbar-compare .explore-topbar-compare-selection')
    $btnOpen = $('.explore-topbar-compare .explore-topbar-compare-action-open')
    $btnsCompare = $('.explore-topbar-compare .explore-topbar-compare-action-compare, .explore-topbar-compare .explore-topbar-compare-clean')

    if selectedTotal is 0
      $btnOpen.addClass('hide')
      $btnsCompare.addClass('hide')
      $selection.html("<strong>0</strong> selecionados, clique em um ou mais para selecionar")
    else if selectedTotal is 1
      $btnOpen.removeClass('hide')
      $btnsCompare.addClass('hide')
      $selection.html("<strong>1</strong> selecionado")
    else
      $btnOpen.removeClass('hide')
      $btnsCompare.removeClass('hide')
      $selection.html("<strong>#{selectedTotal}</strong> selecionados")

  _viewToModelMode: (e) ->
    e.preventDefault()
    @trigger('changeMode')

  _initWindowResize: () ->
    $el = @$('.explore-sidebar').css('overflow', 'auto').addClass('scrollbar')
    @_delayedAdjustSidebarHeight = _.throttle(_.bind(@_adjustSidebarHeight, @, $el, @$el, $(window)), 250)
    $(window).on('resize', @_delayedAdjustSidebarHeight)
    @_delayedAdjustSidebarHeight()


  _adjustSidebarHeight: ($el, $parent, $window) ->
    elementBorderPaddingHeight =  $el.outerHeight(true) - $el.height()

    height = parseInt($window.height(), 10) - parseInt($parent.css('top'), 10) - elementBorderPaddingHeight
    $el.height(height)