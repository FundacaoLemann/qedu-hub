###
  Esta classe abstrai os dados necessários para impressão de um determinado elemento de uma página.
###
PrintData = Backbone.Model.extend
  defaults:
    elementToPrint: $('body').get(0)
    format: 'pdf' # 'pdf' or 'png'
    documentTitle: 'QEdu: aprendizado em foco'

  initialize: () ->

  getFormat: () ->
    return @get('format')

  isPDF: () ->
    return @get('format') is 'pdf'

  isBodyToPrint: () ->
    return @get('elementToPrint') is $('body').get(0);

  isPNG: () ->
    return @get('format') is 'png'

  isPrint: () ->
    return @get('format') is 'print'

  getEl: () ->
    return @get('elementToPrint')

  getTitle: () ->
    return @get('documentTitle')
