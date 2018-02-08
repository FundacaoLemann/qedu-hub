###
  @requires js/mcc/lib/number.js 
 ###

ProficiencyBlockModel = Backbone.Model.extend
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
    Exemple of item proficiency:
   {
    "aggregation": {
        "dependence_id": 0,
        "localization_id": 0,
        "edition_id": 3,
        "grade_id": 5,
        "discipline": 1,
        "city_id": "967"
      },
    "enrolled_count": 2785,
    "present_count": 2295,
    "with_proficiency_weight": 2296,
    "presence_index": 82.4057450628,
    "optimal_count": 754,
    "optimal_index": 32.8540305011,
    "optimal_decile_level": 3,
    "optimal_centile_level": 32,
    "qualitative_distribution": [
        22.96,
        44.18,
        27.02,
        5.84
      ],
    "qualitative_distribution_count": [
        527,
        1014,
        620,
        134
      ]
    }
  ###
    proficiecyItems: []

    # Filtros default usados para selecionar os dados - From Server
    filter: {}

  getProficiency: (grade_id, discipline_id) ->
    items = @get('proficiencyItems')    
    filter = @get('filter');
    filter.grade_id = grade_id
    filter.discipline_id = discipline_id
    proficiencyItem = _.find items, @matchFilter.bind(this) 
    return proficiencyItem

  matchFilter: (item) ->    
    filter = @get('filter')
    disciplineOk = filter.discipline_id is item.aggregation.discipline
    gradeOk = filter.grade_id is item.aggregation.grade_id
    dependenceOk = filter.dependence_id is item.aggregation.dependence_id
    return ( disciplineOk and gradeOk and dependenceOk )
 
  dependence: ->
    filter = @get 'filter';
    return window.i18n('proficiency.dependence.'+filter.dependence_id)

###
 * Manage a set of models from evolutionPage
###
ProficiencyCollection = Backbone.Collection.extend
  model: ProficiencyBlockModel
  
  initialize: (@options) ->
    @on 'sync', @createItems.bind(this)

  url: ->
    return location.pathname+'/data'  

  createItems: ->
    @each (model) ->
      new ProficiencyBlockView 
        model: model,        
        el   : '#'+model.get('model').unique_id


ProficiencyBlockView = Backbone.View.extend

  initialize: () ->
    @model.on "change", this.changeValues.bind(this)
    @changeValues();

  changeValues: () ->
    proficiency51 = this.model.getProficiency(5, 1) # 5o ano, portugues 
    proficiency91 = this.model.getProficiency(9, 1) # 9o ano, portugues 
    proficiency52 = this.model.getProficiency(5, 2) # 5o ano, matemática 
    proficiency92 = this.model.getProficiency(9, 2) # 9o ano, matemática

    if proficiency51
      @changeBlock( @$el.find('.proficiency-5-1'), proficiency51)
    else
      @emptyBlock( @$el.find('.proficiency-5-1') )
    
    if proficiency52
      @changeBlock( @$el.find('.proficiency-5-2'), proficiency52)
    else
      @emptyBlock( @$el.find('.proficiency-5-2') )
      
    if proficiency91
      @changeBlock( @$el.find('.proficiency-9-1'), proficiency91)
    else
      @emptyBlock( @$el.find('.proficiency-9-1') )
      
    if proficiency92
      @changeBlock( @$el.find('.proficiency-9-2'), proficiency92)
    else
      @emptyBlock( @$el.find('.proficiency-9-2') )
  
  changeBlock: (el, data) ->
    el.find(".percent-level").html mcc.number.format( data['optimal_index_perfect_hundred'], 0)
    
    newClass = 'qualitative-square optimal-decile-bg-'+data['optimal_decile_level_perfect_hundred'];
    el.find(".qualitative-square").attr 'class', newClass
    
    el.find(".optimal_count").html mcc.number.format( data['optimal_count'], 0)
    el.find(".present_count").html mcc.number.format( data['with_proficiency_weight'], 0)
    
    el.find('.dependence').html @model.dependence()    
    
    el.find('.percent-level-no-data').hide()
    el.find('.percent-level-with-data').show()
    el.find('p.no-data').hide()
    el.find('p.description').show()
    partial = el.find('small.partial')
    no_partial = el.find('small.no-partial')
    if data.is_partial
      no_partial.hide()
      partial.show()
    else
      partial.hide()
      no_partial.show()
  
  emptyBlock: (el) ->
    el.find(".qualitative-square").attr 'class', 'qualitative-square optimal-decile-bg-no-data'  
    el.find('.dependence').html @model.dependence()  
    
    el.find('.percent-level-no-data').show()
    el.find('.percent-level-with-data').hide()
    el.find('p.no-data').show()
    el.find('p.description').hide()
    el.find('small').hide()