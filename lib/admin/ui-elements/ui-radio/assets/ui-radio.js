/**
 * Radio
 */
(function($){
	"use strict";

	CHERRY_API.utilites.namespace('ui_elements.radio');
	CHERRY_API.ui_elements.radio = {
		init: function ( target ) {
			var self = this;
			if( CHERRY_API.status.document_ready ){
				self.render( target );
			}else{
				CHERRY_API.variable.$document.on('ready', self.render( target ) );
			}
		},
		render: function ( target ) {
			$('.cherry-radio-input[type="radio"]', target).on('change', function(event){
				$(this).parents('.cherry-radio-group').find('.checked').removeClass('checked');
				$(this).parent().addClass('checked');
			})
		}
	}
	//CHERRY_API.ui_elements.radio.init( $('body') );
}(jQuery));
