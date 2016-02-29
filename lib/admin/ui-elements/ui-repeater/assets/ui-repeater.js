/**
 * Repeater
 */
(function($){
	"use strict";

	CHERRY_API.utilites.namespace('ui_elements.repeater');
	CHERRY_API.ui_elements.repeater = {
		init: function ( target ) {
			var self = this;
			if( CHERRY_API.status.document_ready ){
				self.render( target );
			}else{
				CHERRY_API.variable.$document.on('ready', self.render( target ) );
			}
		},
		render: function ( target ) {
			$('.cherry-repeater-wrap', target).cherryRepeater();
		}
	}
	$( window ).on( 'cherry-ui-elements-init',
		function( event, data ) {
			CHERRY_API.ui_elements.repeater.init( data.target );
		}
	);
}(jQuery));
