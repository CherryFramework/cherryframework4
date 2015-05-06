/**
 * Cherry framework script inits
 */
jQuery(document).ready(function($) {

	// Init magnific popup if magnificPopup plugin exist in namespace
	if ( $.isFunction( jQuery.fn.magnificPopup ) ) {

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

	// Init slick gallery if Slick plugin exists in namespace
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

	// Init slick gallery if Cherry Stick Up plugin exists in namespace
	if ( $.isFunction( jQuery.fn.CherryStickUp ) ) {
		$( sticky_data.selector ).CherryStickUp( sticky_data.args );

	}

});