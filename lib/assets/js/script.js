/**
 * Cherry framework script inits
 */
(function($){

	"use strict";

	CHERRY_API.utilites.namespace('tools.popup');
	CHERRY_API.utilites.namespace('tools.slider');
	CHERRY_API.utilites.namespace('tools.stickup');
	CHERRY_API.utilites.namespace('tools.navigation');

	// Init magnific popup
	CHERRY_API.tools.popup = {

		init: function( target ) {
			var self = this;
			if ( CHERRY_API.status.document_ready ) {
				self.render( target );
			} else {
				CHERRY_API.variable.$document.on('ready', self.render( target ) );
			}
		},

		render: function( target ) {

			if ( ! $.isFunction( jQuery.fn.magnificPopup ) ) {
				return;
			}

			// Init single image popup
			$('.popup-img').each(function( index, el ) {

				var _this     = $(this),
					zoom_init = _this.data( 'init' );

				if ( null == zoom_init || undefined == zoom_init ) {
					zoom_init = new Object();
					zoom_init.type = "image";
				}

				_this.magnificPopup( zoom_init );

			});

			// Init gallery images popup
			$('.popup-gallery').each(function(index, el) {

				var _this     = $(this),
					gall_init = _this.data( 'popup-init' );

				_this.magnificPopup( gall_init );

			});

			// init single lightboxes
			if ( 1 == cherry_data.use_lightbox && 0 <= $('.single-popup-image').length ) {
				$('.single-popup-image').magnificPopup({type:'image'});
			}

			if ( 1 == cherry_data.use_lightbox && 0 <= $('.single-popup-video').length ) {
				$('.single-popup-video').magnificPopup({type:'iframe'});
			}

		}

	}

	// Init slick gallery
	CHERRY_API.tools.slider = {

		init: function( target ) {
			var self = this;
			if ( CHERRY_API.status.document_ready ) {
				self.render( target );
			} else {
				CHERRY_API.variable.$document.on('ready', self.render( target ) );
			}
		},

		render: function( target ) {

			if ( $.isFunction( jQuery.fn.slick ) ) {

				$('.post-gallery').each(function(index, el) {

					var _this      = $(this),
						slick_init = _this.data( 'init' );

					slick_init.customPaging = function( slider, i ) {
						return slick_init.dotsFormat;
					}

					_this.slick(slick_init);

				});

			}

		}

	}

	// Init slick gallery
	CHERRY_API.tools.stickup = {

		init: function( target ) {
			var self = this;
			if ( CHERRY_API.status.document_ready ) {
				self.render( target );
			} else {
				CHERRY_API.variable.$document.on('ready', self.render( target ) );
			}
		},

		render: function( target ) {

			// Init slick gallery if Cherry Stick Up plugin exists in namespace
			if ( $.isFunction( jQuery.fn.CherryStickUp ) ) {
				$( sticky_data.selector ).CherryStickUp( sticky_data.args );
			}

		}

	}

	CHERRY_API.tools.navigation = {

		init: function( target ) {
			var self = this;
			if ( CHERRY_API.status.document_ready ) {
				self.render( target );
			} else {
				CHERRY_API.variable.$document.on('ready', self.render( target ) );
			}
		},

		render: function( target ) {

			var container, button, menu, links, subMenus;

			var self = this;

			container = document.getElementById( 'menu-primary' );

			if ( ! container ) {
				return;
			}

			button = container.getElementsByTagName( 'button' )[0];
			if ( 'undefined' === typeof button ) {
				return;
			}

			menu = container.getElementsByTagName( 'ul' )[0];

			// Hide menu toggle button if menu is empty and return early.
			if ( 'undefined' === typeof menu ) {
				button.style.display = 'none';
				return;
			}

			menu.setAttribute( 'aria-expanded', 'false' );
			if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
				menu.className += ' nav-menu';
			}

			button.onclick = function() {

				if ( -1 !== container.className.indexOf( 'toggled' ) ) {
					container.className = container.className.replace( ' toggled', '' );
					button.setAttribute( 'aria-expanded', 'false' );
					menu.setAttribute( 'aria-expanded', 'false' );
				} else {
					container.className += ' toggled';
					button.setAttribute( 'aria-expanded', 'true' );
					menu.setAttribute( 'aria-expanded', 'true' );
				}
			};

			// Get all the link elements within the menu.
			links    = menu.getElementsByTagName( 'a' );
			subMenus = menu.getElementsByTagName( 'ul' );

			// Set menu items with submenus to aria-haspopup="true".
			for ( var i = 0, len = subMenus.length; i < len; i++ ) {
				subMenus[i].parentNode.setAttribute( 'aria-haspopup', 'true' );
			}

			// Each time a menu link is focused or blurred, toggle focus.
			for ( i = 0, len = links.length; i < len; i++ ) {
				links[i].addEventListener( 'focus', self.toggle_focus, true );
				links[i].addEventListener( 'blur', self.toggle_focus, true );
			}

			self.double_tap_to_go( $( 'li', $(menu) ) );

			// Add duration before menu closing
			$( 'li', $(menu) ).hover(
				function() {
					self.show_sub( $(this) );
				},
				function() {
					self.hide_sub( $(this) );
				}
			);

		},

		show_sub: function( item ) {
			item.addClass('menu-hover');
		},

		hide_sub: function( item ) {
			var duration_timeout;
			clearTimeout( duration_timeout );
			duration_timeout = setTimeout(
				function() {
					item.removeClass('menu-hover');
				},
				400
			);
		},

		double_tap_to_go: function( item ) {

			if( !( 'ontouchstart' in window ) &&
				!navigator.msMaxTouchPoints &&
				!navigator.userAgent.toLowerCase().match( /windows phone os 7/i ) ) return false;

			item.each( function() {

				var curItem = false;

				$( this ).on( 'click', function( e ) {
					var item = $( this );
					if( item[ 0 ] != curItem[ 0 ] ) {
						e.preventDefault();
						curItem = item;
					}
				});

				$( document ).on( 'click touchstart MSPointerDown', function( e ) {

					var resetItem = true,
						parents	  = $( e.target ).parents();

					for( var i = 0; i < parents.length; i++ )
						if( parents[ i ] == curItem[ 0 ] )
							resetItem = false;

					if( resetItem )
						curItem = false;

				});

			});

		},

		toggle_focus: function() {

			var self = this;

			// Move up through the ancestors of the current link until we hit .nav-menu.
			while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

				// On li elements toggle the class .focus.
				if ( 'li' === self.tagName.toLowerCase() ) {
					if ( -1 !== self.className.indexOf( 'focus' ) ) {
						self.className = self.className.replace( ' focus', '' );
					} else {
						self.className += ' focus';
					}
				}

				self = self.parentElement;
			}
		}

	}

	$(function(){
		CHERRY_API.tools.popup.init();
		CHERRY_API.tools.slider.init();
		CHERRY_API.tools.stickup.init();
		CHERRY_API.tools.navigation.init();
	});

})(jQuery);