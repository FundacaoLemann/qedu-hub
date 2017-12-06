###
@requires js/backbone.js
          js/jquery.js

This is the main Explore View. Its responsible for creating all necessary stuff and gluing it all togheter
###
window.StateMenu = Backbone.Model.extend
  initialize: (stateMenuConfigs) ->
    @explore = false
    @token = stateMenuConfigs.token
    @set
      discipline: stateMenuConfigs.discipline
      grade: stateMenuConfigs.grade
      dependence: stateMenuConfigs.dependence

    @on "change", @synchronize

  setExplore: () ->
    @explore = true

  update: (async = true) ->
    data =
      "token": @token
      "selected": "-"

    if @explore
      data["explore"] = 1

    $.ajax
      "url": "/ajax/permanent/select/default"
      "type": "POST"
      "data": data
      "dataType": "json"
      "cache": false
      "async": async
      "context": @
      "success": (data) ->
        @set(data)
        @trigger("updated", data)

  synchronize: () ->

    for filter, value of @changedAttributes()

# In Explore, the value of dependence ALL is different
      if filter is 'dependence' and value is '*'
        value = 0

      $.ajax
        "url": "/ajax/permanent/select/"+filter
        "type": "POST"
        "data":
          "selected": value,
          "token": @token
        "dataType": "json"
        "cache": false

      clicky.log(location.href+"#click/"+filter+"/"+value,'Clicou no Filtro '+filter+' ('+value+') na página '+document.title) if typeof clicky is 'object'