###
@requires js/underscore.js
          js/jquery.js
          js/backbone.js

This is a handy class to set some content (as a global navbar) to fixed and adjust the padding of the body so the rest of the content goes down. The height is calculated correcly and you do not have to know the size of the bar.

The elements gotta be direct childs (body > element) or it wont work.

This class is a singleton and should not be used new to create. Use directly:

FixedLayout.fix('.main-header')

@todo maybe we can trasnform this in a jquery plugin

###

((Backbone, _, $) ->
  fixedLayoutSingleton = Backbone.View.extend(
    initialize: () ->
      #_.bindAll(@, '_onResponseSuccess', '_onResponseError', '_handleValidInput', '_handleInvalidInput')

      # list of fixed elements with its heights
      @totalHeight = 0

      @$spacer = $('<div></div>').height(0).css('display', 'block').prependTo(@$el)


    ## If you pass the second argument, it will be used to calculate the height
    fix: (selector, heightSelector, substractSelector) ->
      return @_fix(selector, true, heightSelector, substractSelector)

    unfix: (selector) ->
      return @_fix(selector, false)

    _fix: (selector, fix = true, heightSelector, substractSelector) ->
      element = @$el.children(selector).first()

      if element.length is 0
        return @

      if element.data('fixed') is undefined
        element.data('fixed', !fix)

      if element.data('fixed') is !fix
        element.data('fixed', fix)

        heightElement = element

        if heightSelector
          heightElement = heightSelector

          if _.isString(heightSelector)
            heightElement = @$el.find(heightSelector).first()

        height = heightElement.outerHeight(true)

        if heightSelector is 0
          height = 0

        if fix
          @_addHeight(height)

          top = @totalHeight - parseInt(height, 10)

          if substractSelector
            top = top - parseInt($(substractSelector).outerHeight(true), 10)

#          element.css(
#            position : 'fixed'
#            top      : top + 'px'
#          ).addClass('fixed')
        else
          @_substractHeight(height)

#          element.css(
#            position : ''
#            top      : ''
#          ).removeClass('fixed')

        # apply the padding to the body
#        @$spacer.height(@totalHeight+'px')

      return @


    _addHeight: (height) ->
      @totalHeight += parseInt(height, 10)
      return @

    _substractHeight: (height) ->
      @totalHeight -= parseInt(height, 10)

      if @totalHeight < 0
        @totalHeight  = 0

      return @
  )

  # @todo when we migrate this to mcc, put in the correct namespace
  window.FixedLayout = new fixedLayoutSingleton (
    el: 'body'
  )

)(Backbone, _, jQuery)