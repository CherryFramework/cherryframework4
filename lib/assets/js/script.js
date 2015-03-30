/**
 * Cherry framework script inits
 */
jQuery(document).ready(function($) {

	// Init magnific popup if magnificPopup plugin exist in namespace
	if ( $.isFunction( jQuery.fn.magnificPopup ) ) {
	
		$('.popup-img').each(function( index, el ) {

			var _this     = $(this),
				zoom_init = _this.data('init');

			if ( null == zoom_init || undefined == zoom_init ) {
				zoom_init = new Object();
				zoom_init.type = "image";
			}

			_this.magnificPopup(zoom_init);

		});

	}

	// Init slick gallery if Slick plugin exists in namespace
	if ( $.isFunction( jQuery.fn.slick ) ) {

		$('.post-gallery').each(function(index, el) {
			
			var _this      = $(this),
				slick_init = _this.data('init');

			_this.slick(slick_init);

		});

	}

});