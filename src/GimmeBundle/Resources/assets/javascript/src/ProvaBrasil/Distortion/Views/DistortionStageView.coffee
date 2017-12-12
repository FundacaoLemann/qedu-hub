DistortionStageView = Backbone.View.extend
  events:
    'click .stageIdItem': 'receiveEventFromUI'

  initialize: (@options) ->
    _.bindAll @, 'receiveEventFromUI', 'receiveEventFromModel', 'setValue', 'watchFilterAndUpdateStagesValues'
    @stageIdSelected = @$el.find('.stageIdFilters').parent().find('.active').data 'stageid'
    @regionalAggregation = @options['regionalAggregation']
    @colorScale = @options['colorScale']
    @filter = @options['filter']
    @filter.on 'change:stageId', @receiveEventFromModel
    @watchFilterAndUpdateStagesValues()
    # @$el.append($('<div class="alert data-notification" id="alertPrincipal">Estes dados ainda não foram divulgados. Enquanto isso, você pode ver as informações de outros anos utilizando o filtro acima.</div>'))

    # unless @regionalAggregation.children.length
    #   @$el.append($('<div class="alert data-notification" id="alertPrincipal">Estes dados ainda não foram divulgados. Enquanto isso, você pode ver as informações dos anos anteriores utilizando o filtro acima.</div>'))

  receiveEventFromUI: (e) ->
    element = $ e.currentTarget
    if element.data('disabled')
      return
    @setValue element.data 'value'

  receiveEventFromModel: () ->
    @setValue @filter.get 'stageId'

  setValue: (value) ->
    if value is @stageIdSelected
      return
    @filter.set 'stageId', value
    activeElement = @$el.find '.active'
    activeElement.removeClass 'active'
    activeElement.find('#title').addClass 'hide'
    activeElement.find('.value i').removeClass 'icon-white'
    activeElement.attr 'title', activeElement.data 'title-tooltip'
    activeElement.tooltip()

    element = $ ".stageIdItem[data-value='#{value}']"
    elementParent = element.parent()
    elementParent.addClass 'active'
    element.find('#title').removeClass 'hide'
    element.find('.value i').addClass 'icon-white'
    elementParent.tooltip 'destroy'
    elementParent.removeAttr 'title'

    @stageIdSelected = value

  watchFilterAndUpdateStagesValues: () ->
    evolution = @regionalAggregation.getEvolution()
    filter = @filter
    el = @$el
    colorScale = @colorScale
    @regionalAggregation.on 'sync', () ->
      dataValues = evolution.where filter.getURLParamsForGetEntity()
      stagesWithData = []
      for dataValue in dataValues
        percentRounded = dataValue.get 'percentRounded'
        percent = dataValue.get 'percent'
        stageId = dataValue.get 'stageId'
        stageIdContainer = el.find ".stageIdItem[data-value='#{stageId}']"
        stageIdContainer.data 'disabled', false
        stagesWithData.push stageIdContainer.data 'value'

        #Valor do titulo
        valueStageId = stageIdContainer.find '#percent'
        valueStageId.text percentRounded

        #Barra de progresso
        percentBar = stageIdContainer.find '.progress'
        barCssClass = percentBar.data 'cssclass'
        percentBar.removeClass barCssClass
        barCssClass = 'progress-'+colorScale.getCSSClassByPercent percent
        percentBar.addClass barCssClass
        percentBar.data 'cssclass', barCssClass

        #Tamanho da barra de progresso
        progressBar = percentBar.find '.bar'
        if percentRounded < 50
          progressBarWidth = percentRounded * 2
        else
          progressBarWidth = 100
        progressBar.css
          'width': progressBarWidth+'%'

        # Texto de titulo (ou impacto, sei lá)
        if percent == 0
          titleText = 'Nenhum aluno com atraso escolar de 2 anos ou mais'


        else if percent == 100
          titleText = 'Todos os alunos em atraso escolar de 2 anos ou mais'

        else
          titleText = 'De cada 100 alunos, aproximadamente '+percentRounded+' estavam com atraso escolar de 2 anos ou mais'

        titleElement = stageIdContainer.find '#title'
        titleElement.html titleText
        stageIdContainer.parent().data 'title-tooltip', titleText+'. Clique para ver mais'

      allStages = el.find('.stageIdItem')
      elementsThatNotHaveData = allStages.filter () ->
        stageIdElement = $ @
        not _.contains stagesWithData, stageIdElement.data 'value'
      elementsThatHaveData = allStages.filter () ->
        stageIdElement = $ @
        _.contains stagesWithData, stageIdElement.data 'value'
      if allStages.length == elementsThatNotHaveData.length
        allStages.data('disabled', true).fadeOut()
        el.find('.nav-header').fadeOut()
        el.find('#alertPrincipal').remove()
        # el.append($('<div class="alert data-notification" id="alertPrincipal">Estes dados ainda não foram divulgados. Enquanto isso, você pode ver as informações de outros anos utilizando o filtro acima.</div>'))
      else
        el.find('#alertPrincipal').remove()
        allStages.data('disabled', false).fadeIn()
        el.find('.nav-header').fadeIn()
        elementsThatHaveData.data('disabled', false).fadeIn()
        elementsThatHaveData.find('.alertItem').remove()
        elementsThatNotHaveData.each () ->
          $el = $ @
          $el.fadeOut()
          $el.data 'disabled', true
          $el.append $ '<div class="alert alertItem" id="alertPrincipal">Não existem dados de distorção idade série para esta localidade, com os filtros selecionados</div>'
