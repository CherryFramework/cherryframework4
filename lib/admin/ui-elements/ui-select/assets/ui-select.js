/**
 * Select
 */
(function($){
	"use strict";

	CHERRY_API.utilites.namespace('ui_elements.select');
	CHERRY_API.ui_elements.select = {
		init: function ( target ) {
			var self = this;
			if( CHERRY_API.status.document_ready ){
				self.render( target );
			}else{
				CHERRY_API.variable.$document.on('ready', self.render( target ) );
			}
		},
		render: function ( target ) {
			// init filter-select
			$('.cherry-filter-select', target).select2();
			// init multi-select
			$('.cherry-multi-select', target).select2();
		}
	}
	$( window ).on( 'cherry-ui-elements-init',
		function( event, data ) {
			CHERRY_API.ui_elements.select.init( data.target );
		}
	);
}(jQuery));
