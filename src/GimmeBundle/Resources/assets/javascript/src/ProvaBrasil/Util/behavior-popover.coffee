###
@requires js/mcc/core/behavior.js
          js/bootstrap/bootstrap-popover.js
###

mcc.behavior 'provabrasil-behavior-util-popover', (config) ->
  defaultOptions = {
    html: true,
    container: 'body',
    delay: {
      show: 500,
      hide: 100
    }
    trigger: 'hover',
    placement: 'left'
  }

  $('[rel=popover]').popover(defaultOptions);
  $('[rel=popover-left]').popover(defaultOptions);
  $('[rel=popover-right]').popover( $.extend(defaultOptions, {placement: 'right'}) );
  $('[rel=popover-bottom]').popover( $.extend(defaultOptions, {placement: 'bottom'}) );
  $('[rel=popover-top]').popover( $.extend(defaultOptions, {placement: 'top'}) );