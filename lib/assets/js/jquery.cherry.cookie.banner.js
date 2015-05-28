(function($){
	$(document).ready(function(){

		$('#cherry-dismiss-cookie').on( 'click', function (event){
			event.preventDefault();

			// Set cookie.
			setCookie( cookie_banner_args.name, cookie_banner_args.value, cookie_banner_args.options );

			// Hide cookie banner.
			$( '#cherry-cookie-banner' ).remove();
		} );

		function setCookie(name, value, options) {
			options = options || {};

			var expires = options.expires;

			if ( typeof expires == "number" && expires ) {
				var d = new Date();
				d.setTime(d.getTime() + expires * 1000);
				expires = options.expires = d;
			}

			if ( expires && expires.toUTCString ) {
				options.expires = expires.toUTCString();
			}

			value = encodeURIComponent( value );

			var updatedCookie = name + "=" + value;

			for ( var propName in options ) {
				var propValue = options[propName];

				if ( propValue !== undefined && propValue !== '' && propValue !== false ) {
					updatedCookie += "; " + propName + "=" + propValue;
				}
			}

			document.cookie = updatedCookie;
		}

	});
})(jQuery);