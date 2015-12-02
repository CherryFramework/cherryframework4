/**
 * layout_editor
 */
(function($){
	"use strict";

	CHERRY_API.utilites.namespace('ui_elements.layout_editor');
	CHERRY_API.ui_elements.layout_editor = {
		init: function ( target ) {
			var self = this;
			if( CHERRY_API.status.document_ready ){
				self.render( target );
			}else{
				CHERRY_API.variable.$document.on('ready', self.render( target ) );
			}
		},
		render: function ( target ) {
			var
				cherryLayoutEditor = $('.cherry-layout-editor-wrap', target)
			;

			$('.ui-layout-editor-input', cherryLayoutEditor).on('change', function(){
				$(this).val( CHERRY_API.ui_elements.layout_editor.css_units_validator( $(this).val() ) );
			})

			$('.cherry-border-style', cherryLayoutEditor).on('change', function(){
				borderPreviewRender( $( this ) );
			}).trigger('change');

			$('.cherry-border-radius', cherryLayoutEditor).on('change', function(){
				$(this).val( CHERRY_API.ui_elements.layout_editor.css_units_validator( $(this).val() ) );
				borderPreviewRender( $( this ) );
			});

			$('.cherry-border-color', cherryLayoutEditor).wpColorPicker({
				change: function( event, ui ) {
					borderPreviewRender( $( this ) );
				}
			});
			function borderPreviewRender( target ){
				var
					thisLayoutEditor = $( target ).parents( '.cherry-layout-editor-wrap:first' )
				,	previewBorderContainer = $(".border-inner", thisLayoutEditor )
				,	borderStyle = $(".cherry-border-style", thisLayoutEditor ).val()
				,	borderRadius = $(".cherry-border-radius", thisLayoutEditor ).val()
				,	borderColor = $(".cherry-border-color", thisLayoutEditor ).val()
				;

				previewBorderContainer.css({ 'border-style': borderStyle });
				previewBorderContainer.css({ 'border-radius': borderRadius });
				previewBorderContainer.css({ 'border-color': borderColor });
			}
		},
		css_units_validator: function ( value ) {
			var
				currentValue = value
			,	onlyDigit = ''
			,	units = ''
			,	resultValue = ''
			;
			if( currentValue.length !== 0 || currentValue !== '' ){
				onlyDigit = currentValue.match(/[-]?\d/g);
				( onlyDigit !== null ) ? onlyDigit = onlyDigit.join('') : onlyDigit = '';

				if( /%|px|in|cm|mm|em|rem|ex|pt|pc/.test( currentValue ) == false ){
					units = 'px';
				}else{
					units = currentValue.match(/%|px|in|cm|mm|em|rem|ex|pt|pc/g)[0];
				}
				resultValue = (onlyDigit.length != 0) ? onlyDigit + units : '';
				if( currentValue == 'auto' ){ resultValue = 'auto'; }
			}
			return resultValue;
		}
	}
	$( window ).on( 'cherry-ui-elements-init',
		function( event, data ) {
			CHERRY_API.ui_elements.layout_editor.init( data.target );
		}
	);
}(jQuery));
