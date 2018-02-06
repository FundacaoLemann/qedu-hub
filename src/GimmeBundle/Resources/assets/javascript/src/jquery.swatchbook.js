/**
 * jquery.swatchbook.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2012, Codrops
 * http://www.codrops.com
 */

( function( window, $, undefined ) {
	
	'use strict';

	var Modernizr			= window.Modernizr;

	jQuery.fn.reverse		= [].reverse;
	
	$.SwatchBook			= function( options, element ) {
		
		this.$el	= $( element );
		this._init( options );
		
	};

	$.SwatchBook.defaults	= {
		// index of initial centered item
		center		: 6,
		// number of degrees that is between each item
		angleInc	: 8,
		speed		: 700,
		easing		: 'ease',
		// amount in degrees for the opened item's next sibling
		proximity	: 45,
		// amount in degrees between the opened item's next siblings
		neighbor	: 4,
		// animate on load
		onLoadAnim	: true,
		// if it should be closed by default
		initclosed	: false,
		// index of the element that when clicked, triggers the open/close function
		// by default there is no such element
		closeIdx	: -1
	};

	$.SwatchBook.prototype	= {

		_init			: function( options ) {
			
			this.options	= $.extend( true, {}, $.SwatchBook.defaults, options );

			this.$items		= this.$el.children( 'div' );
			this.itemsCount	= this.$items.length;
			this.current	= -1;
			this.support	= Modernizr.csstransitions;
			this.cache		= [];
			
			if( this.options.onLoadAnim ) {

				this._setTransition();

			}

			if( !this.options.initclosed ) {

				this._center( this.options.center, this.options.onLoadAnim );

			}
			else {

				this.isClosed	= true;
				if( !this.options.onLoadAnim ) {

					this._setTransition();

				}

			}
			
			this._initEvents();
			
		},

    close			: function( ) {
      this.current	= -1;
      this.isClosed	= true;

      this.$items.removeClass('ff-active').each( function( i ) {

        var transformStr	= 'rotate(0deg)';

        $( this ).css( {
          '-webkit-transform'	: transformStr,
          '-moz-transform'	: transformStr,
          '-o-transform'		: transformStr,
          '-ms-transform'		: transformStr,
          'transform'			: transformStr
        } );

      } );
    },

		_setTransition	: function() {

			if( !this.support ) {

				return false;

			}

			this.$items.css( {
				'-webkit-transition': '-webkit-transform ' + this.options.speed + 'ms ' + this.options.easing,
				'-moz-transition'	: '-moz-transform ' + this.options.speed + 'ms ' + this.options.easing,
				'-o-transition'		: '-o-transform ' + this.options.speed + 'ms ' + this.options.easing,
				'-ms-transition'	: '-ms-transform ' + this.options.speed + 'ms ' + this.options.easing,
				'transition'		: 'transform ' + this.options.speed + 'ms ' + this.options.easing
			} );

		},
		_openclose		: function() {

			var _self = this;

			if( this.isClosed ) {

				this._center( this.options.center, true );

			}
			else {

				this.$items.each( function( i ) {

					var transformStr	= 'rotate(0deg)';

					$( this ).css( {
						'-webkit-transform'	: transformStr,
						'-moz-transform'	: transformStr,
						'-o-transform'		: transformStr,
						'-ms-transform'		: transformStr,
						'transform'			: transformStr
					} );

				} );

			}

			this.isClosed = !this.isClosed;

		},
		_center			: function( idx, anim ) {

			var _self = this;

			this.$items.each( function( i ) {

				var transformStr	= 'rotate(' + ( _self.options.angleInc * ( i - idx ) ) + 'deg)';

				$( this ).css( {
					'-webkit-transform'	: transformStr,
					'-moz-transform'	: transformStr,
					'-o-transform'		: transformStr,
					'-ms-transform'		: transformStr,
					'transform'			: transformStr
				} );

			} );

		},
		_initEvents		: function() {

			var _self = this;

			this.$items.on( 'click.swatchbook', function( event ) {

				var $item	= $( this ),
					itmIdx	= $item.index();

				if( itmIdx !== _self.current ) {

					if( _self.options.closeIdx !== -1 && itmIdx === _self.options.closeIdx ) {

						_self._openclose();
						_self._setCurrent();

					}
					else {

						_self._setCurrent( $item );

						var transformStr	= 'rotate(0deg)';

						$item.css( {
							'-webkit-transform'	: transformStr,
							'-moz-transform'	: transformStr,
							'-o-transform'		: transformStr,
							'-ms-transform'		: transformStr,
							'transform'			: transformStr
						} );

						_self._rotateSiblings( $item );

					}

				}

			} );

		},
		_rotateSiblings	: function( $item ) {

			var _self		= this,
				idx			= $item.index(),
				$cached		= this.cache[ idx ],
				$siblings;

			if( $cached ) {

				$siblings = $cached;

			}
			else {

				$siblings = $item.siblings();
				this.cache[ idx ] = $siblings;

			}

			$siblings.each( function( i ) {

				var rotateVal	= ( i < idx ) ?
									_self.options.angleInc * ( i - idx ) :
									( i - idx === 1 ) ? _self.options.proximity : _self.options.proximity + ( i - idx - 1 ) * _self.options.neighbor;

				var transformStr	= 'rotate(' + rotateVal + 'deg)';

				$( this ).css( {
					'-webkit-transform'	: transformStr,
					'-moz-transform'	: transformStr,
					'-o-transform'		: transformStr,
					'-ms-transform'		: transformStr,
					'transform'			: transformStr
				} );

			} );

		},
		_setCurrent		: function( $el ) {

			this.current = $el ? $el.index() : -1;
			this.$items.removeClass( 'ff-active' );
			if( $el ) {

				$el.addClass( 'ff-active' );

			}

		}

	};
	
	var logError			= function( message ) {

		if ( window.console ) {

			window.console.error( message );
		
		}

	};
	
	$.fn.swatchbook			= function( options ) {
		
		if ( typeof options === 'string' ) {
			
			var args = Array.prototype.slice.call( arguments, 1 );
			
			this.each(function() {
			
				var instance = $.data( this, 'swatchbook' );
				
				if ( !instance ) {

					logError( "cannot call methods on swatchbook prior to initialization; " +
					"attempted to call method '" + options + "'" );
					return;
				
				}
				
				if ( !$.isFunction( instance[options] ) || options.charAt(0) === "_" ) {

					logError( "no such method '" + options + "' for swatchbook instance" );
					return;
				
				}
				
				instance[ options ].apply( instance, args );
			
			});
		
		} 
		else {
		
			this.each(function() {
			
				var instance = $.data( this, 'swatchbook' );
				if ( !instance ) {

					$.data( this, 'swatchbook', new $.SwatchBook( options, this ) );
				
				}

			});
		
		}
		
		return this;
		
	};
	
} )( window, jQuery );