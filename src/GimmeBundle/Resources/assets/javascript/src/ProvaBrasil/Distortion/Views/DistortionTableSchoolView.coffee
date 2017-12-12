DistortionTableSchoolView = Backbone.View.extend
  initialize: (@options) ->
    _.bindAll @, 'render'
    @filter = @options['filter']
    @regionalAggregation = @options['regionalAggregation']

  render: () ->
    children = @regionalAggregation.getChildren()
    filter = @filter
    el = @$el
    templateEl = el.find('#school-row-template')
    rowTemplate = _.template templateEl.html()
    templateEl.remove()

    headerEl = el.find('#school-header-template')
    headerTemplate = headerEl.html()
    headerEl.remove()

    #groups SVG child nodes to avoid DOM manipulation (or similar) and allow faster access

    children.on 'start-sync', () ->
      $('body').css 'cursor', 'wait'
      el.eq(0).mask(); # add a loading mask
      el.eq(1).mask 'Carregando...' # add a loading mask

    children.on 'sync', () ->
      ###
        Nos meus testes, é surpreendentemente mais rápido trabalhar com strings HTML grandes do que com
        objetos do DOM, por isso, essa foi a escolha tomada para trabalhar com a tabela de escolas em um município.
        Assim, cidades como São Paulo, por exemplo, tornam-se pelo menos usáveis do ponto de vista da velocidade e
        da estabilidade do navegador :D
        Ass: Fernando (@fjorgemota)
      ###

      el.find('#year').html filter.get 'year'

      filterData = filter.toJSON()
      html = [headerTemplate]
      console.time 'tableDOM' if __DEV__

      children.each (model) ->
        evolution = model.getEvolution()

        #Filter evolution by filter selected
        dataValue = evolution.findWhere filterData

        if dataValue
          #Get data
          percent = dataValue.get 'percentRounded'
          percent = "#{percent}%"
          #Add to querystring only parameters that have changed in a determinated moment in the page
          urlParams = mcc.URI.objectToQueryString filter.changedAttributes() or {}
          if _.isEmpty urlParams
            #Why add params if urlParams is empty?
            url = model.getURL()+'/distorcao-idade-serie'
          else
            url = model.getURL()+'/distorcao-idade-serie?'+urlParams
          html.push rowTemplate
            name: model.get 'name'
            percent: percent
            legend: title
            url: url

      html = html.join ''
      if html == headerTemplate
        html += '<tr colspan="2">Não há escolas para esta etapa</div>'
      el.find('#schools-container').html "<table class='table table-striped table-bordered table-hover'>#{html}</table>"
      console.timeEnd 'tableDOM' if __DEV__
      $('body').css 'cursor', ''
      el.unmask() # remove the loading mask
