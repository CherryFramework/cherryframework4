/**
 * Ace editor
 */
(function($){
	"use strict";

	CHERRY_API.utilites.namespace('ui_elements.ace_editor');
	CHERRY_API.ui_elements.ace_editor = {
		init: function ( target ) {
			var self = this;
			if( CHERRY_API.status.document_ready ){
				self.render( target );
			}else{
				CHERRY_API.variable.$document.on('ready', self.render( target ) );
			}
		},
		render: function ( target ) {
			$('.ace-editor-wrapper', target).each(
				function( index, element ){
					var
						_this = $( this )
					,	editor = $( '.ace-editor', _this).data( 'editor' )
					,	editorMode = $( '.ace-editor', _this).data( 'editor-mode' )
					,	editorTheme = $( '.ace-editor', _this).data( 'editor-theme' )
					,	aceEditor = ace.edit( editor )
					,	params = { "minLines":15,"maxLines":30 }
					;
					aceEditor.getSession().setMode( "ace/mode/" + editorMode );
					aceEditor.setTheme( "ace/theme/" + editorTheme );
					aceEditor.setOptions( params );
					aceEditor.on(
						'change', function( e ) {
							$('.ace-editor', _this).val( aceEditor.getSession().getValue() );
							aceEditor.resize();
						}
					);
				}
			)
		}
	}
	//CHERRY_API.ui_elements.ace_editor.init( $('body') );
}(jQuery));
