/**
 * Checkbox
 */
(function($){
	"use strict";

	CHERRY_API.utilites.namespace('ui_elements.checkbox');
	CHERRY_API.ui_elements.checkbox = {
		init: function ( target ) {
			var self = this;
			if( CHERRY_API.status.document_ready ){
				self.render( target );
			}else{
				CHERRY_API.variable.$document.on('ready', self.render( target ) );
			}
		},
		render: function ( target ) {
			$('.cherry-checkbox-item', target).on('click', function(event){
				var
					input = $( this ).siblings('.cherry-checkbox-input[type="hidden"]')
				;
				if( $( this ).hasClass('checked') ){
					$( this ).removeClass('checked');
					input.val('false');
				}else{
					$( this ).addClass('checked');
					input.val('true');
				}
			});
			$('.cherry-checkbox-label', target).on('click', function(event){
				var
					input = $( this ).siblings('.cherry-checkbox-input[type="hidden"]')
				,	item = $( this ).siblings('.cherry-checkbox-item')
				;
				if( item.hasClass('checked') ){
					item.removeClass('checked');
					input.val('false');
				}else{
					item.addClass('checked');
					input.val('true');
				}
			});
		}
	}
	//CHERRY_API.ui_elements.checkbox.init( $('body') );
}(jQuery));
