###
@requires js/backbone.js
###

###
Esta classe corresponde ao modelo dos dados de cada um dos quadrados.
Cada quadrado, além de dados gerais como NSE, nome, etc,
possui diversos items de proficiência, 1 para 5o ano, portugues, outro para 9o ano matemática, etc.
###
ProvaBrasilExploreModel =  Backbone.Model.extend
  defaults:
    id: null

  initialize: () ->
    @currentProficiency = {}

  # return an object of proficiency or an empty model
  getCurrentProficiency: () ->
    return @currentProficiency

  ###
  Esta função seleciona qual das diversas proficiência de um quadrado,
  é a que deve ser exibida em um determinado momento.
  ###
  updateCurrentProficiency: (aggregationFilter) ->
    proficiencies = @get('proficiency')
    modelType = @get('type')

    @currentProficiency = _.find(proficiencies, (proficiency) ->
      proficiencyDependence = proficiency.aggregation.dependence_id

      # if this is a school and we wanna all dependences, we should overwrite the dependence to be zero
      if modelType is 'school' and aggregationFilter.dependence is 0
        proficiencyDependence = 0

      # special case: federal schools should show only when dependence is 0 (all)
      if modelType is 'school' and proficiencyDependence is 1
        proficiencyDependence = aggregationFilter.dependence

      if proficiency.aggregation.grade_id is aggregationFilter.grade and proficiency.aggregation.discipline is aggregationFilter.discipline and proficiencyDependence is aggregationFilter.dependence
        return true
      else
        return false
    , @)

    if @currentProficiency is undefined
      @currentProficiency = {}


###
  Contém uma coleção de quadrados (ProvaBrasilExploreModel)
  e se encarrega de alterá-los sempre que ocorre uma mudança nos filtros.
###
ProvaBrasilExploreProficiencyCollection = Backbone.Collection.extend

  model: ProvaBrasilExploreModel

  initialize: (@state) ->
    # Estes eventos correspondem aos botões
    # Sempre que um botão é pressionado, a proficiência é atualizada.
    @state.on('change:grade', @updateCurrentProficiency, @)
    @state.on('change:discipline', @updateCurrentProficiency, @)
    @state.on('change:dependence', @updateCurrentProficiency, @)
    # Evento padrão de uma collection, quando ela for reiniciada, atualiza a proficiência também.
    @.on('reset', @updateCurrentProficiency, @)

    # Estes eventos correspondem aos Sliders.
    # Sempre que um Slider muda, a collection se encarrega de processar quais itens
    # que deverão ser exibidos. Isso é feito nas funções do tipo "MarkInbound"
    @state.on('change:optimal_index', @markOptimalIndexInbound, @)
    @state.on('change:presence_index', @markPresenceIndexInbound, @)
    @state.on('change:enrolled_count', @markEnrolledCountInbound, @)
    @state.on('change:nse_number', @markNSENumberInbound, @)

    @sliderData = {
      optimal_index:
        min: 0
        max: 100
      presence_index:
        min: 0
        max: 100
      enrolled_count:
        min: 0
        max: 100
    }

  parse: (data) ->
    @sliderData = data.slide
    @trigger('reset:sliders', @sliderData)

    return data.entities

  getSliderData: ->
    return @sliderData

  ###
   UPDATE PROFICIENCY
   filters the models proficiecy and selects the right one based on filter
   return false if the aggregation did not change
  ###

  updateCurrentProficiency: () ->
    aggregationFilter = {
      grade      : parseInt(@state.get('grade'), 10)
      discipline : parseInt(@state.get('discipline'), 10)
      dependence : @state.get('dependence')
    }

    if aggregationFilter.dependence is '0'
      aggregationFilter.dependence = 0
    else
      aggregationFilter.dependence = parseInt(aggregationFilter.dependence, 10)

    # return if the filter has not changed and this was called
    aggregationFilterJSON = JSON.stringify(aggregationFilter)
    #console.log "Collection.updateCurrentProficiency: #{aggregationFilterJSON}"
    if @_lastAgregationFilter isnt undefined and aggregationFilter is @_lastAgregationFilter
      #console.log "filtro já aplicado."
      return false

    @_lastAgregationFilter = aggregationFilterJSON

    if __DEV__ and console.time
      console.time('explore-collection-updateCurrentProficiency')

    # we are not filtering by localization and edition for now (the backend must send only using the default localization and last edition)
    #localization = @state.get('localization')
    #edition = @state.get('edition')

    # we iterate over the collection capturing the right agregation and updating the info on the model and set the correct aggregation
    @.each((model) ->
        model.updateCurrentProficiency(aggregationFilter)
    , @)

    if @state.get('optimalIndexInboundApplied')
      @markOptimalIndexInbound()

    if @state.get('presenceIndexInboundApplied')
      @markPresenceIndexInbound()

    if @state.get('enrolledCountInboundApplied')
      @markEnrolledCountInbound()

    if @state.get('nseNumberInboundApplied')
      @markNSENumberInbound()

    if __DEV__ and console.time
      console.timeEnd('explore-collection-updateCurrentProficiency')

    @trigger('updatedProficiencies')

    return true

  ###
  MARK INBOUND FUNCTIONS

  Estas funções são responsáveis por marcar, com uma classe,
  todos os quadrados que estão dentro de um determinado limite
  para um dos sliders do explore. Assim, sempre que o slider é modificado,
  esta função entra em ação, marca ois quadrados que devem ser exibidos, de modo
  que o isotopo consegue saber quais blocos deve filtrar.

  Cada função se refere a um Slider.
  E cada uma tem como responsabilidade:
  * Colocar um valor nos quadrados que se encaixam no limite;
  * Marcar no model state uma variável informando se o filtro foi ou não aplicado
  * Lança evento que informa para a interface que um dos valores foi alterado.
  ###

  markOptimalIndexInbound: () ->
    if @state.get('mode') is 'basic'
      return

    optimal_index = @state.get('optimal_index')

    min = parseInt(optimal_index[0])
    max = parseInt(optimal_index[1])

    #console.log "Filtrando pelo min: #{min} e máximo #{max}"

    if min is 0 and max is 100
      @state.set('optimalIndexInboundApplied', false)

      @.each((model) ->
        model.set('optimal_index_inbound', true)
      , @)
    else
      @state.set('optimalIndexInboundApplied', true)

      @.each((model) ->
        value = model.getCurrentProficiency().optimal_index
        if value is undefined
          value = -1

        model.set('optimal_index_inbound', value >= min and value <= max)
      , @)

    @trigger('markedOptimalIndexInbound')

  markPresenceIndexInbound: () ->
    if @state.get('mode') is 'basic'
      return

    presence_index = @state.get('presence_index')

    min = parseInt(presence_index[0])
    max = parseInt(presence_index[1])

    #console.log "Filtrando pelo min: #{min} e máximo #{max}"

    if min is 0 and max is 100
      @state.set('presenceIndexInboundApplied', false)

      @.each((model) ->
        model.set('presence_index_inbound', true)
      , @)
    else
      @state.set('presenceIndexInboundApplied', true)

      @.each((model) ->
        proficiency = model.getCurrentProficiency()
        value = proficiency.presence_index
        if value is undefined or proficiency.is_partial
          value = -1

        model.set('presence_index_inbound', value >= min and value <= max)
      , @)

    @trigger('markedPresenceIndexInbound')

  markNSENumberInbound: () ->
    if @state.get('mode') is 'basic'
      return

    #The number used is a class from 1 to 7, equivalent to "Mais baixo" até "Mais alto"
    nse_number = @state.get('nse_number')

    min = parseInt(nse_number[0])
    max = parseInt(nse_number[1])

    if min is 1 and max is 7
      @state.set('nseNumberInboundApplied', false)

      @.each((model) ->
        model.set('nse_number_inbound', true)
      , @)
    else
      @state.set('nseNumberInboundApplied', true)

      @.each((model) ->
        if model.get('nse')
          value = model.get('nse').class
        else
          value = 999 if @state.get('sortDirection') is 'asc'
          value = -1 if @state.get('sortDirection') is 'desc'

        model.set('nse_number_inbound', value >= min and value <= max)
      , @)

    @trigger('markedNSENumberInbound')

  markEnrolledCountInbound: () ->
    if @state.get('mode') is 'basic'
      return

    enrolled_count = @state.get('enrolled_count')

    min = parseInt(enrolled_count[0])
    max = parseInt(enrolled_count[1])

    #console.log "Filtrando pelo min: #{min} e máximo #{max}"

    if min is @sliderData.enrolled_count.min and max is @sliderData.enrolled_count.max
      @state.set('enrolledCountInboundApplied', false)

      @.each((model) ->
        model.set('enrolled_count_inbound', true)
      , @)
    else
      @state.set('enrolledCountInboundApplied', true)

      @.each((model) ->
        value = model.getCurrentProficiency().enrolled_count
        if value is undefined
          value = -1

        model.set('enrolled_count_inbound', value >= min and value <= max)
      , @)

    @trigger('markedEnrolledCountInbound')