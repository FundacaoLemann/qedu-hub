###
  @requires js/mcc/lib/number.js
 ###

EvolutionBlockModel = Backbone.Model.extend
  defaults:
    ###
    Ex:
    {
      "unique_id": "city-967",
      "name": "Palhoca"
    }
    ###
    model: null
    ###
    * Array de proficiência
    * Ex de evolução da proficiencia:
    {
      "aggregation": {
        "disicpline_id": "1",
        "grade_id": "5",
        "dependence_id": "0",
        "localization": "0"
      },
      "evolution": [
          Proficiency
         , Proficienc yGrowth
         ,  Proficiency
      ]
    },
    ###
    proficiecyItems: []

    # Filtros usados para selecionar os dados
    filter: {}

    #informa se o bloco é o bloco principal da página, com o qual os outros são comparados
    isPrincipal: false
    #informa se é uma escola
    isSchool: false

  getProficiency: () ->
    items = @get('proficiencyItems')
    filter = @get('filter')
    proficiencyItem = _.find items, @matchFilter.bind(this)
    return proficiencyItem

  matchFilter: (item) ->
    filter = @get('filter')
    disciplineOk = filter.discipline_id is item.aggregation.discipline_id
    gradeOk = filter.grade_id is item.aggregation.grade_id
    if @get('isPrincipal') and @get('isSchool')
      dependenceOk = true; #escolas só tem um dado de proficiencia, quando ela for a principal, não deve alterar independente de rede municipal ou estadual
    else if @get('isSchool') and (filter.dependence_id is 0)
      dependenceOk = true; #quando a depdendencia é zero, todas as escolas devem exibir dados
    else
      dependenceOk = filter.dependence_id is item.aggregation.dependence_id
    return ( disciplineOk and gradeOk and dependenceOk )

  competence: ->
    filter = @get 'filter'
    return window.i18n('evolution.competence.1') if filter.discipline_id is 1
    return window.i18n('evolution.competence.2') if filter.discipline_id is 2

  grade: ->
    filter = @get 'filter';
    return window.i18n('evolution.grade.'+filter.grade_id)

  dependence: ->
    filter = @get 'filter';
    return window.i18n('evolution.dependence.'+filter.dependence_id)

  edition: (data) ->
    aggregation = data.aggregation;
    return '2007' if aggregation.edition_id is 2
    return '2009' if aggregation.edition_id is 3
    return '2011' if aggregation.edition_id is 4
    return '2013' if aggregation.edition_id is 5
    return '2015' if aggregation.edition_id is 6

###
 * Manage a set of models from evolutionPage
###
EvolutionCollection = Backbone.Collection.extend
  model: EvolutionBlockModel

  initialize: (options) ->
    @on 'sync', @createItems.bind(this)

  url: ->
    return location.pathname+'/data'

  createItems: ->
    @each (model) ->
      new EvolutionBlockView
        model: model,
        el   : '#'+model.get('model').unique_id


EvolutionBlockView = Backbone.View.extend

  initialize: () ->
    @model.set 'isPrincipal', @$el.hasClass('compare-block-principal')
    @model.set 'isSchool', @$el.hasClass('compare-block-school')
    @model.on "change", this.changeValues.bind(this)
    @changeValues();

  changeValues: () ->
    proficiency = this.model.getProficiency();
    elEditions = this.$el.find('.didactic-evolution-edition');
    elGrowth = this.$el.find('.didactic-evolution-growth');

    if not proficiency
      elEditions.each (index, el) =>
        @changeEditionBlockEmpty el;
      elGrowth.each (index, el) =>
        @changeGrowthBlockEmpty el;
      return;

    evolution = proficiency['evolution'];

    # Dados 2013
    if evolution['edition-5']
      @changeEditionBlock elEditions[0], evolution['edition-5']
    else
      @changeEditionBlockEmpty elEditions[0]

    # Dados 2015
    if evolution['growth-6']
      @changeGrowthBlock elGrowth[0], evolution['growth-6']
    else
      @changeGrowthBlockEmpty elGrowth[0]

    if evolution['edition-6']
      @changeEditionBlock elEditions[1], evolution['edition-6']
    else
      @changeEditionBlockEmpty elEditions[1]

    # Dados 2017
    if evolution['growth-7']
      @changeGrowthBlock elGrowth[1], evolution['growth-7']
    else
      @changeGrowthBlockEmpty elGrowth[1]

    if evolution['edition-7']
      @changeEditionBlock elEditions[2], evolution['edition-7']
    else
      @changeEditionBlockEmpty elEditions[2]

  changeEditionBlock: (el, data) ->
    $el = $(el)
    $el.find(".percent-level").html mcc.number.format( data['optimal_index_perfect_hundred'], 0)
    $el.find(".qualitative-square").attr 'class', 'qualitative-square optimal-decile-bg-'+data['optimal_decile_level_perfect_hundred']
    $el.find('.percent-level-no-data').hide()
    $el.find('.percent-level-with-data').show()

  changeEditionBlockEmpty: (el) ->
    $el = $(el)
    $el.find(".qualitative-square").attr 'class', 'qualitative-square optimal-decile-bg-no-data'
    $el.find('.percent-level-no-data').show()
    $el.find('.percent-level-with-data').hide()

  changeGrowthBlock: (el, data) ->
    sinal = '+' if data['class'] is 'up'
    sinal = '-' if data['class'] is 'down'
    sinal = '' if data['class'] is 'equal'

    $(el).find(".num").html sinal+data['num']
    $(el).find(".num").parent().show()
    $(el).find(".text").html data['text']
    $(el).find("strong").attr 'class', data['class']

  changeGrowthBlockEmpty: (el) ->
    $(el).find(".num").parent().hide()
    $(el).find(".text").html ''
    $(el).find("strong").attr 'class', ''