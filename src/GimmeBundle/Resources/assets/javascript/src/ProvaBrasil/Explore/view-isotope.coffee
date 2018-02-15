###
@requires js/backbone.js
          js/modernizr.js
          js/isotope/jquery.isotope.js
          js/jquery.loadmask.js
          js/jquery.smoothscroll.js
###

ProvaBrasilExploreIsotopeView = Backbone.View.extend
  el: '.explore-container .explore-isotope .explore-isotope-inner'

  active: false

  breathTime: 10

  initialize: (@state, @collection, @options) ->
    _.bindAll(@, 'render', '_initIsotope', '_renderItems', '_toggleEvents', '_modelToViewAggregation')

    @$isotope = @$('.explore-isotope-list')
    @itemsView = new ProvaBrasilExploreIsotopeItemsView(@state, @collection, @$isotope)

    # all posible filters that are applied (isotope filters using a css selector)
    @filterSelector = {
      dependence : ''
      comparing  : ''
      optimal_index : ''
      optimal_index_perfect_hundred : ''
    }

  ###
  this is shittie, but its what we have... =/
  A variável "breathTime" corresponde a algo como "tempoPraNascer".
  Ela é usada para renderizar o isotopo
  ###
  _adjustBreathTime: () ->
    size = _.size(@collection)

    if size < 100
      @breathTime = 1
    else if size < 500
      @breathTime = 10
    else if size < 1000
      @breathTime = 50
    else
      @breathTime = 100

  enable: () ->
    if @active
      return

    @active = true

    @$el.parent('.explore-isotope').show().css('visibility', 'hidden')

    $(document.body).addClass('body-explore-isotope')

    # This is shittie, better use other stuff to sync executuion
    if @_rendered is true
      @_toggleEvents(true)
      @$el.parent('.explore-isotope').css('visibility', '')
      @itemsView.enable()
    else
      _.delay(@render, @breathTime)


  disable: () ->
    if @active is false
      return

    @active = false

    $(document.body).removeClass('body-explore-isotope')
    @$el.parent('.explore-isotope').hide()

    # unlisten to events
    @_toggleEvents(false)

    @itemsView.disable()


  _toggleEvents: (enable) ->
    method = 'off'
    if enable
      method = 'on'

    @state[method]('change:zoom', @_modelToViewZoom, @)
    @state[method]('change:sort', @_modelToViewSort, @)
    @state[method]('change:sortDirection', @_modelToViewSort, @)
    @state[method]('change:dependence', @_modelToViewDependence, @)
    @state[method]('change:nse', @_modelToViewNSE, @)
    @state[method]('change:openSelected', @_modelToViewOpen, @)
    @state[method]('change:comparingSelected', @_modelToViewComparing, @)
    @itemsView[method]('change:selected', @_modelToViewOpen, @)

    @collection[method]('updatedProficiencies', @_modelToViewAggregation, @)

    @collection[method]('markedNSENumberInbound', @_modelToViewNSENumberInbound, @)
    @collection[method]('markedOptimalIndexInbound', @_modelToViewOptimalIndexInbound, @)
    @collection[method]('markedPresenceIndexInbound', @_modelToViewPresenceIndexInbound, @)
    @collection[method]('markedEnrolledCountInbound', @_modelToViewEnrolledCountInbound, @)

    if enable
      # we need to call all filters and sorters and all
      @_modelToViewAggregation()


  #############
  ### AÇÕES ###
  #############

  _modelToViewZoom: (apply = true) ->
    zoom = @state.get('zoom')
    @$isotope.removeClass('zoom-1 zoom-2 zoom-3').addClass("zoom-#{zoom}")

    if apply
      @$isotope.isotope('reLayout')

  _modelToViewSort: () ->
    sortBy = @state.get('sort')
    sortDirection = @state.get('sortDirection')

    sortAscending = true
    if sortDirection is 'desc'
      sortAscending = false

    #console.log "isotope: sorting"

    if __DEV__ and console.time
      console.time('explore-isotope-sort')

    @$isotope.isotope(
      sortBy : sortBy
      sortAscending : sortAscending
    )

    if __DEV__ and console.time
      console.timeEnd('explore-isotope-sort')

  _modelToViewDependence: (apply = true) ->
    regionalLevel = @state.get('regionalLevel')

    if regionalLevel isnt 'city'
      return

    # when we are in the city level, the dependence filter should hide the schools that do not match when filtering by dependence

    dependence = @state.get('dependence')

    filterSelector = ["[data-dependence=#{dependence}]", "[data-dependence=0]"]

    if dependence is '0'
      filterSelector = ''

    @filterSelector.dependence = filterSelector

    if apply
      @_applyFilters()

  _modelToViewOpen: (apply = true) ->
    $selected = @$isotopeItems.filter('.selected')

    if @state.get('openSelected') is 'yes'
      @_renderOpened()
      @$isotopeItems.removeClass('opened')
      $selected.addClass('opened')
      @$isotope.addClass('is-open')
    else
      @$isotopeItems.removeClass('opened')
      @$isotope.removeClass('is-open')

    if apply
      @$isotope.isotope('reLayout')

  _modelToViewComparing: (apply = true) ->
    filterSelector = ''

    if @state.get('comparingSelected') is 'yes'
      filterSelector = ".isotope-item.selected"
      @$isotope.addClass('is-comparing')
    else
      @$isotope.removeClass('is-comparing')

    @filterSelector.comparing = filterSelector

    if apply
      @_applyFilters()

  ######################################
  ### Métodos do tipo "MARK INBOUND" ###
  ######################################

  _modelToViewNSENumberInbound: (apply = true) ->
    if @state.get('mode') is 'basic'
      return

    filterSelector = ''

    if @state.get('nseNumberInboundApplied')
      _.each(@$isotopeItems, (el) ->
        $el = $(el)
        model = $el.data('model')

        if model.get('nse_number_inbound')
          $el.addClass('nse_number_inbound')
        else
          $el.removeClass('nse_number_inbound')
      , @)
      filterSelector = '.nse_number_inbound'

    @filterSelector.nse_number = filterSelector

    if apply
      @_applyFilters()

  _modelToViewOptimalIndexInbound: (apply = true) ->
    if @state.get('mode') is 'basic'
      return

    filterSelector = ''

    if @state.get('optimalIndexInboundApplied')
      _.each(@$isotopeItems, (el) ->
        $el = $(el)
        model = $el.data('model')

        if model.get('optimal_index_inbound')
          $el.addClass('optimal_index_inbound')
        else
          $el.removeClass('optimal_index_inbound')
      , @)

      filterSelector = '.optimal_index_inbound'

    @filterSelector.optimal_index = filterSelector

    if apply
      @_applyFilters()

  _modelToViewPresenceIndexInbound: (apply = true) ->
    if @state.get('mode') is 'basic'
      return

    filterSelector = ''

    if @state.get('presenceIndexInboundApplied')
      _.each(@$isotopeItems, (el) ->
        $el = $(el)
        model = $el.data('model')

        if model.get('presence_index_inbound')
          $el.addClass('presence_index_inbound')
        else
          $el.removeClass('presence_index_inbound')
      , @)

      filterSelector = '.presence_index_inbound'

    @filterSelector.presence_index = filterSelector

    if apply
      @_applyFilters()

  _modelToViewEnrolledCountInbound: (apply = true) ->
    if @state.get('mode') is 'basic'
      return

    filterSelector = ''

    if @state.get('enrolledCountInboundApplied')
      _.each(@$isotopeItems, (el) ->
        $el = $(el)
        model = $el.data('model')

        if model.get('enrolled_count_inbound')
          $el.addClass('enrolled_count_inbound')
        else
          $el.removeClass('enrolled_count_inbound')
      , @)

      filterSelector = '.enrolled_count_inbound'

    @filterSelector.enrolled_count = filterSelector

    if apply
      @_applyFilters()

  ###############################
  ### MÉTODOS DE RENDERIZAÇÃO ###
  ###############################

  render: () ->
    if @_rendered is true
      return @

    if __DEV__ and console.time
      console.time('explore-isotope-render-template')

    @_rendered = true

    # Found an otimization where we need to apply the zoom class for isotope to render faster
    @_modelToViewZoom(false)

    @templates =
      items:  _.template $('#tpl-explore-isotope-items').html().replace /^(\s+)/,"" #Remove the space at init
      itemOpened:  _.template $('#tpl-explore-isotope-item-opened').html().replace /^(\s+)/,""  #Remove the space at init

    collectionData = @collection.map((model) =>
      return _.extend(model.toJSON(),
        _cid: model.cid
      )
    )

    if __DEV__ and console.time
      console.time('explore-isotope-render-template-html')

    @$isotope.html(@templates.items({collection : collectionData}))

    if __DEV__ and console.time
      console.timeEnd('explore-isotope-render-template-html')

    @$isotopeItems = @$isotope.children()

    # Bind the model with the element and vice versa for fast access both ways
    _.each(@$isotopeItems, (el) ->
      $el = $(el)
      model = @collection.get
        "cid": $el.attr 'data-cid'
      model.set('_explore$el', $el)
      $el.data('model', model)
    , @)

    if __DEV__ and console.time
      console.timeEnd('explore-isotope-render-template')

    # call init isotope with some time for CPU to breath
    _.delay(@_initIsotope, @breathTime)

  _initIsotope: (deferredRender) ->
    if @_createdIsotope is true
      return

    @_createdIsotope = true

    if __DEV__ and console.time
      console.time('explore-isotope-render-isotope-init')

    animationEngine = 'best-available'
    transformsEnabled = !window.opera # disable transforms in Opera

    if Modernizr.csstransitions is false
      animationEngine = 'none'
      transformsEnabled: false

    @$isotope.isotope(
      layoutMode  : 'fitRows'
      getSortData : @_getIsotopeSorter()
      animationEngine: animationEngine
      transformsEnabled: transformsEnabled
    )

    if __DEV__ and console.time
      console.timeEnd('explore-isotope-render-isotope-init')

    _.delay(() =>
      @_toggleEvents(true)
      @$el.parent('.explore-isotope').css('visibility', '')
      @itemsView.enable()
    , @breathTime)

  _renderOpened: () ->
    modelsOpened = []

    _.each(@state.getSelectedModels(), (model) ->
      $el = model.get('_explore$el')

      modelsOpened.push(model)

      if $el.children('.isotope-item-opened').length is 0
        $opened = $(@templates.itemOpened({
        model : model.toJSON()
        }))
        $el.append($opened)
    , @)

    @_renderItems(modelsOpened)

  _renderItems: (modelsOpened = null) ->
    if __DEV__ and console.time
      console.time('explore-isotope-render-itens')

    context = {}

    context.discipline = @state.get('discipline')
    context.grade = @state.get('grade')
    context.dependence = @state.get('dependence')

    context.disciplineText = 'português'
    if context.discipline is '2'
      context.disciplineText = 'matemática'

    context.gradeText = '5'
    if context.grade is '9'
      context.gradeText = '9'

    context.isAdvanced = false
    if @state.get('mode') is 'advanced'
      context.isAdvanced = true

    @collection.each((model) ->
      if modelsOpened isnt null
        if _.contains(modelsOpened, model) is false
          return

      @_renderItem(model, context)
    , @)

    if __DEV__ and console.time
      console.timeEnd('explore-isotope-render-itens')

  _renderItem: (model, context) ->
    finalProficiency = model.getCurrentProficiency()
    hasProficiency = _.size(finalProficiency)

    $el = model.get('_explore$el')

    #
    # render the item
    #
    $box = $el.find('.isotope-item-optimal-box').removeClass().addClass('isotope-item-optimal-box')

    $opened = $el.children('.isotope-item-opened')

    if hasProficiency
      # box color
      $el.removeClass('no-data')
      $box.addClass("optimal-decile-bg-#{finalProficiency.optimal_decile_level}")

      # box number
      $box.children('.isotope-item-optimal-box-number').text(finalProficiency.optimal_index_perfect_hundred+'%')
      $el.attr('title', '')

      # description
      if $opened.length
        evolutionText = ''
        if context.isAdvanced and finalProficiency.growth
          evolutionTextPoints = 'ponto percentual'
          if finalProficiency.growth.num > 1
            evolutionTextPoints = 'pontos percentuais'

          if finalProficiency.growth['class'] is 'down'
            evolutionText = "(<span title='Queda em relação a 2009: menos #{finalProficiency.growth.num} #{evolutionTextPoints}' class='growth-down'>-#{finalProficiency.growth.num}</span>)"
          else if finalProficiency.growth['class'] is 'equal'
            evolutionText = "(<span title='Sem crescimento em relação a 2009' class='growth-equal'>+#{finalProficiency.growth.num}</span>)"
          else
            evolutionText = "(<span title='Crescimento em relação a 2009: mais #{finalProficiency.growth.num} #{evolutionTextPoints}' class='growth-up'>+#{finalProficiency.growth.num}</span>)"


        descriptionTextLearned = 'aprendeu'
        if finalProficiency.optimal_index_perfect_hundred > 1
          descriptionTextLearned = 'aprenderam'

        descriptionText = "#{finalProficiency.optimal_index_perfect_hundred}% #{evolutionText} #{descriptionTextLearned} o adequado em #{context.disciplineText} no #{context.gradeText}º ano"

        $opened.find('.isotope-item-description').html(descriptionText)

        if context.isAdvanced
          $opened.find('.isotope-item-qualitative-list, .isotope-item-enrolled, .isotope-item-presence').show()

          $qualitativeList = $opened.find('.isotope-item-qualitative-list li');

          $qualitativeList.eq(0).text("#{finalProficiency.qualitative_distribution[3]}% avançado")
          $qualitativeList.eq(1).text("#{finalProficiency.qualitative_distribution[2]}% proficiente")
          $qualitativeList.eq(2).text("#{finalProficiency.qualitative_distribution[1]}% básico")
          $qualitativeList.eq(3).text("#{finalProficiency.qualitative_distribution[0]}% insuficiente")

          if finalProficiency.is_partial
            $opened.addClass("isotope-item-partial")
            $opened.find('.isotope-item-enrolled').text("Sem taxa de participação")
            $opened.find('.isotope-item-presence').html("<a href='http://academia.qedu.org.br/prova-brasil-2013-taxa-de-rendimento-nao-disponivel/' target='_blank'>Saiba mais</a>")
          else
            presenceTotal = parseInt(finalProficiency.presence_index, 10)
            enrolledText = "#{mcc.number.format(finalProficiency.enrolled_count, 0)} matriculado"
            if finalProficiency.enrolled_count > 1
              enrolledText = enrolledText+'s'

            $opened.find('.isotope-item-presence').text("#{presenceTotal}% taxa participação")
            $opened.find('.isotope-item-enrolled').text(enrolledText)

          if model.get("nse")
            nseText =  "NSE "+model.get("nse").text+" ("+mcc.number.format(model.get("nse").number, 1)+")"
            $opened.find('.isotope-item-nse').text(nseText)
          else
            $opened.find('.isotope-item-nse').text("NSE não calculado")
    else
      # box color
      $el.addClass('no-data')
      $box.addClass('optimal-decile-bg-no-data')

      noDataText = "Sem dados em #{context.disciplineText} no #{context.gradeText}º ano"

      # box number
      $box.children('.isotope-item-optimal-box-number').html('&mdash;')
      $el.attr('title', noDataText)

      # description
      if $opened.length
        $opened.find('.isotope-item-description').text(noDataText)

        if context.isAdvanced
          $opened.find('.isotope-item-qualitative-list, .isotope-item-enrolled, .isotope-item-presence').hide()

      $opened.find('.isotope-item-nse').text("")

    #
    # update the item data for isotope filters (they filter using a css selector)
    #
    dependence = 0
    if model.get('dependence') isnt undefined
      dependence = model.get('dependence').id
    $el.attr('data-dependence', dependence)
    nse = model.get('nse')
    if nse
      $el.attr('data-nse', nse.group)

  ### OUTROS ###

  # Isotope sort stuff using its own method, here we tell where it should look for data to sort
  _getIsotopeSorter: () ->
    sorter = {
    name : ($el) ->
      return $el.data('model').get('nameToOrder').replace(/-/g, ' ')
    optimal_index: ($el) ->
      value = $el.data('model').getCurrentProficiency().optimal_index
      if value is undefined
        value = -1
      return value
    optimal_index_perfect_hundred: ($el) ->
      value = $el.data('model').getCurrentProficiency().optimal_index_perfect_hundred
      if value is undefined
        value = -1
      return value
    enrolled_count: ($el) ->
      value = $el.data('model').getCurrentProficiency().enrolled_count
      if value is undefined
        value = -1
      return value
    growth: ($el) ->
      value = $el.data('model').getCurrentProficiency()
      if value is undefined or value.growth is undefined
        value = -1000
      else
        value = value.growth
        if value.class is 'down'
          value = value.num * -1
        else
          value = value.num

      return value
    nse: ($el) =>
      nse = $el.data('model').get('nse');
      if nse
        return nse.number
      else
        return -1
    }

    return sorter

  # This method updates the agregaton info on the items (view)
  _modelToViewAggregation: () ->
    if __DEV__
      console.log "_modelToViewAggregation called!"

    # update the elements
    @_renderItems()

    if __DEV__ and console.time
      console.time('explore-isotope-update-and-filter')

    # update isotope sorter
    if @_createdIsotope is true
      # tell isotope to update its sort data
      if __DEV__ and console.time
        console.time('explore-isotope-update-sort-data')

      @$isotope.isotope('updateSortData', @$isotopeItems)

      if __DEV__ and console.time
        console.timeEnd('explore-isotope-update-sort-data')

      @_modelToViewOpen(false)
      @_modelToViewComparing(false)
      @_modelToViewDependence(false)
      @_modelToViewOptimalIndexInbound(false)
      @_modelToViewPresenceIndexInbound(false)
      @_modelToViewEnrolledCountInbound(false)
      @_modelToViewNSENumberInbound(false)
      @_applyFilters()
      @_modelToViewSort()

    if __DEV__ and console.time
      console.timeEnd('explore-isotope-update-and-filter')

  _applyFilters: () ->
    if __DEV__
      console.log "_applyFilters called!"

    andFilters = []
    orFilters = []

    # filters are cumulative, so if a filter is a string, we need to concatenate it with other rules, other wise we will have a OR CSS Selector
    _.each(@filterSelector, (filterSelector) ->
      if _.isString(filterSelector) and filterSelector.length > 0
        andFilters.push(filterSelector)
    )

    andFilters = andFilters.join('')

    _.each(@filterSelector, (filtersSelectors) ->
      if _.isArray(filtersSelectors) and filtersSelectors.length > 0
        _.each(filtersSelectors, (filterSelector) ->
          orFilters.push(andFilters+filterSelector)
        )
    )

    finalFilters = andFilters

    if orFilters.length > 0
      finalFilters = orFilters.join(',')

    if __DEV__ and console.time
      console.time('explore-isotope-filter')

    @$isotope.isotope(
      filter : finalFilters
    )

    if __DEV__ and console.time
      console.timeEnd('explore-isotope-filter')


ProvaBrasilExploreIsotopeItemsView = Backbone.View.extend
  events:
    'dblclick .isotope-item'    : '_viewToModelElementDoubleClick'
    'click .isotope-item'       : '_viewToModelElementClick'
  ###
    Aqui usamos um construtor para evitar a transferência de argumentos desnecessários para a View. Neste caso em específico,
    era necessário evitar passar determinados atributos do Model que conflitavam com a abordagem do Backbone, de detectar,
    no objeto, determinadas palavras chaves e atualizar a view conforme o que acontecia.
    Ao usar initialize, esse problema acontecia, graças ao fato de que o initalize só é chamado após o Backbone realizar
    determinados processamentos nos argumentos e na view. Ao usar constructor, porém, o Backbone chama diretamente o
    construtor, antes de qualquer processamento, e aí nós podemos facilmente inicializar o objeto chamando diretamente o
    construtor Backbone.View, e passando o objeto criado através do método apply, com todos os argumentos vazios para
    evitar conflitos, como ocorria neste caso em especial.
  ###
  constructor: (@state,  @collection, @$el) ->
    Backbone.View.apply @, [
      "el":@$el
    ]
  initialize: () ->
    _.bindAll(@, 'enable', 'disable')
  setState: (state) ->
    @state = state;

  enable: () ->
    @_toggleEvents(true)


  disable: () ->
    @_toggleEvents(false)


  _toggleEvents: (enable) ->
    method = 'off'
    if enable
      method = 'on'

    @state[method]('change:selected', @_modelToViewElementSelect, @)

    if enable
      @_modelToViewElementSelect()


  _viewToModelElementDoubleClick: (e) ->
    if @$el.hasClass('is-comparing')
      return

    e.preventDefault()
    e.stopPropagation()

    if @state.get('openSelected') is 'no'
      @state.setViaInterface({'openSelected' : 'yes'})

    @_viewToModelElementClick(e, true)


  _viewToModelElementClick: (e) ->
    $el = $(e.currentTarget)

    # if it is a link, just ignore it
    if $el.is('a') or $(e.target).is('a')
      return

    model = $el.data('model')

    if @$el.hasClass('is-comparing')
      return

    if @state.isModelSelected(model)
      @state.removeFromSelected(model)
    else
      @state.addToSelected(model)


  _modelToViewElementSelect: () ->
    @$el.children('.selected').removeClass('selected')

    _.each(@state.getSelectedModels(), (model) ->
      $el = model.get('_explore$el')

      if $el
        $el.addClass('selected')
    )

    @trigger('change:selected')