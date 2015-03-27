/**
 * Cherry framework script inits
 */
jQuery(document).ready(function($) {

	// Init magnific popup if magnificPopup plugin exist
	if ( $.isFunction( jQuery.fn.magnificPopup ) ) {
		$('.popup-img').magnificPopup(
			{
				type:'image'
			}
		);
	}

});