/**
 * static_area_editor
 */
(function($){
	"use strict";

	CHERRY_API.utilites.namespace('ui_elements.static_area_editor');
	CHERRY_API.ui_elements.static_area_editor = {
		init: function ( target ) {
			var self = this;
			if( CHERRY_API.status.document_ready ){
				self.render( target );
			}else{
				CHERRY_API.variable.$document.on('ready', self.render( target ) );
			}
		},
		render: function ( target ) {
			$('.cherry-static-area-editor-wrap', target).cherryStaticEditor();
		}
	}
	CHERRY_API.ui_elements.static_area_editor.init( $('body') );
}(jQuery));
