window.ProvaBrasilModelGlobalSearch = Backbone.Model.extend
  
  defaults:
    states: []
    cities: []
    schools: []
    last_update: null
  
  removeAll: () ->
    @set(
      'schools': []
      'cities': []
      'citygroups': []
      'states': []
      'last_update' : new Date() ##isso garante que a cada fetch o evento change seja lançado
    ,
      'silent':true
      )
    
  

