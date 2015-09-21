/**
 * Typography
 */
(function($){
	"use strict";

	CHERRY_API.utilites.namespace('ui_elements.webfont');
	CHERRY_API.ui_elements.webfont = {
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
				cherryWebfont = $('.cherry-ui-webfont-wrap', target)
			,	$addButton = $('.add-button', cherryWebfont)
			,	$newFontSelect = $('.new-font-select', cherryWebfont)
			,	ajaxRequest = null
			,	ajaxRequestSuccess = true
			;

			if( cherryWebfont.length !== 0){
				$addButton.on('click', function(){
					get_fonts_variants( $newFontSelect );
				})
				$('.new-font-select', cherryWebfont).each(function(){
					//change_font( $(this) );
				})
				$('.new-font-select', cherryWebfont).on('change', function(){
					//get_fonts_variants( $(this) );
					//get_fonts_subsets( $(this) );
				});
			}

			var thisTypography = 0;

			function get_fonts_variants( item ){
				var
					parent_wrap = item.parents('.cherry-ui-webfont-wrap')
				,	$font_select = $('.new-font-select', parent_wrap)
				,	selected_value = $font_select.val()
				;

				ajaxGetFontVariants( parent_wrap, selected_value );
			}

			function get_fonts_subsets( item ){
				var
					parent_wrap = item.parents('.cherry-ui-typography-wrap')
				,	$font_select = $('.cherry-font-family', parent_wrap)
				,	selected_value = $font_select.val()
				;

				ajaxGetFontSubsets( parent_wrap, selected_value );
			}

			function ajaxGetFontVariants( parent_wrap ){
				var
					$font_select = $('.new-font-select', parent_wrap)
				,	$font_list_wrap = $('.font-list', parent_wrap)
				,	selected_value = $font_select.val()
				,	id = parent_wrap.data('id')
				,	name = parent_wrap.data('name')
				,	data = {
						action: 'get_fonts_variants_subsets',
						font: selected_value,
						id: id,
						name: name
					}
				;

				if( ajaxRequest != null && !ajaxRequestSuccess){
					ajaxRequest.abort();
				}

				ajaxRequest = $.ajax({
					type: 'POST',
					url: ajaxurl,
					data: data,
					cache: false,
					beforeSend: function(){
						ajaxRequestSuccess = false;
						$addButton.addClass('loading');
					},
					success: function( response ){
						ajaxRequestSuccess = true;
						$addButton.removeClass('loading');
						$font_list_wrap.prepend( response );
						CHERRY_API.ui_elements.select.init( $font_list_wrap );
					},
					dataType: 'html'
				});
			}// end ajaxGetFontVariants

		}
	}
	CHERRY_API.ui_elements.webfont.init( $('body') );
}(jQuery));
