###
 * Manage a model to a block of content to compare Page
 Exemple of model data:
 {
  model: { "unique_id": "city-967", "name": "Palhoca" }
  proficiencyItems: [ item1, item2, item3, item4 ]
 }
 
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
CompareBlockModel = Backbone.Model.extend      
  defaults:       
      model: null 
      #informa se o bloco é o bloco principal da página, com o qual os outros são comparados
      isPrincipal: false
      #informa se é uma escola
      isSchool: false
      proficiecyItems: []        
      filter: {}

  getProficiency: ->      
    items = @get 'proficiencyItems'
    proficiencyItem = _.find items, @matchFilter.bind(this)                        
    return proficiencyItem    

  matchFilter: (item) ->    
    filter = @get('filter')
    disciplineOk = filter.discipline_id is item.aggregation.discipline
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
    return window.i18n('compare.competence.1') if filter.discipline_id is 1
    return window.i18n('compare.competence.2') if filter.discipline_id is 2      

  grade: ->
    filter = @get 'filter';
    return window.i18n('compare.grade.'+filter.grade_id)   
 
  dependence: ->
    filter = @get 'filter';   
    return window.i18n('compare.dependence.'+filter.dependence_id)

  edition: ->
    activeData = @getProficiency()      
    aggregation = activeData['aggregation'];
    return '2007' if aggregation.edition_id is 2
    return '2009' if aggregation.edition_id is 3
     
###
@property int model
###
CompareCollection = Backbone.Collection.extend
  model: CompareBlockModel

  initialize: (options) ->
    @on 'sync', @createItems.bind(this)

  url: ->
    return location.pathname+'/data'  

  createItems: ->
    @each (model) ->
      new CompareBlockView
        model: model,        
        el   : '#'+model.get('model').unique_id       


CompareBlockView = Backbone.View.extend
  initialize: ->
    @model.set 'isPrincipal', @$el.hasClass('compare-block-principal')
    @model.set 'isSchool', @$el.hasClass('compare-block-school')
    @model.on "change", @changeValues.bind(this)
    @changeValues();

  changeValues: (model) ->      
    activeData = @model.getProficiency()
    if not activeData
      return @emptyBlock()
      
    @$el.find(".percent-level").html mcc.number.format( activeData['optimal_index_perfect_hundred'], 0)
    
    newClass = 'qualitative-square optimal-decile-bg-'+activeData['optimal_decile_level_perfect_hundred'];
    @$el.find(".qualitative-square").attr 'class', newClass
    
    @$el.find(".optimal_count").html mcc.number.format( activeData['optimal_count'], 0)
    @$el.find(".present_count").html mcc.number.format( activeData['with_proficiency_weight'], 0)
    
    @$el.find('.competence').html @model.competence()
    @$el.find('.grade').html @model.grade()
    @$el.find('.dependence').html @model.dependence()
    @$el.find('.edition').html @model.edition()
    
    @$el.find('.percent-level-no-data').hide()
    @$el.find('.percent-level-with-data').show()
    @$el.find('p.no-data').hide()
    @$el.find('p.description').show()
    partial = @$el.find('small.partial')
    no_partial = @$el.find('small.no-partial')
    if activeData.is_partial
      no_partial.hide()
      partial.show()
    else
      partial.hide()
      no_partial.show()

  emptyBlock: ->
    @$el.find(".qualitative-square").attr 'class', 'qualitative-square optimal-decile-bg-no-data'

    @$el.find('.competence').html @model.competence()
    @$el.find('.grade').html @model.grade()
    @$el.find('.dependence').html @model.dependence()

    @$el.find('.percent-level-no-data').show()
    @$el.find('.percent-level-with-data').hide()
    @$el.find('p.no-data').show()
    @$el.find('p.description').hide()
    @$el.find('small').hide()
