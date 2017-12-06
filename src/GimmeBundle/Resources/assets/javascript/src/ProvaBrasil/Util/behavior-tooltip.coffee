###
@requires js/mcc/core/behavior.js
          js/bootstrap/bootstrap-tooltip.js
###

mcc.behavior 'provabrasil-behavior-util-tooltip', (config) ->
  if config.all
    defaultOptions =
      html: true
      container: 'body'
      delay: delay: { show: 300, hide: 100 }
      placement: 'left'

    $('[rel=tooltip]').tooltip(defaultOptions);
    $('[rel=tooltip-left]').tooltip(defaultOptions);
    $('[rel=tooltip-right]').tooltip( $.extend(defaultOptions, {placement: 'right'}) );
    $('[rel=tooltip-bottom]').tooltip($.extend(defaultOptions, {placement: 'bottom'}) );
    $('[rel=tooltip-top]').tooltip( $.extend(defaultOptions, {placement: 'top'}) );