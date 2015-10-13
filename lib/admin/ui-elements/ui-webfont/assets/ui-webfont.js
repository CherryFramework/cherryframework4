/**
 * Typography
 */
(function($){
	"use strict";

	CHERRY_API.utilites.namespace('ui_elements.webfont');
	CHERRY_API.ui_elements.webfont = {
		ajaxRequest: null,
		ajaxRequestSuccess: true,
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
				self = this
			,	cherryWebfont = $('.cherry-ui-webfont-wrap', target)
			,	$addButton = $('.add-button', cherryWebfont)
			,	$newFontSelect = $('.new-font-select', cherryWebfont)
			,	ajaxRequest = null
			,	ajaxRequestSuccess = true
			;

			if( cherryWebfont.length !== 0){
				$addButton.on('click', function(){
					if( !self.fontExitsCheck( $newFontSelect ) ){
						if( self.ajaxRequestSuccess ){
							get_new_font( $newFontSelect );
						}
					}
				})
				cherryWebfont.on('click', '.remove-button', function(){
					self.removeFontItem( $(this) );
				})
			}

			function get_new_font( item ){
				var
					parent_wrap = item.parents('.cherry-ui-webfont-wrap')
				,	$font_select = $('.new-font-select', parent_wrap)
				,	selected_value = $font_select.val()
				;

				self.ajaxAddFontItem( parent_wrap, selected_value );
			}
		},
		fontExitsCheck: function ( select ) {
			var
				parentWrap = select.parents('.cherry-ui-webfont-wrap')
			,	$font_select = $('.new-font-select', parentWrap)
			,	$fontItem_List = $('.font-list .font-item input.font-family', parentWrap)
			,	selected_value = $font_select.val()
			,	isExist = false
			;

			$fontItem_List.each(
				function( index ){
					if( $(this).val() == selected_value ){
						var
							parentItem = $(this).parents('.font-item')
						,	timeout
						;
						//var timeout = setTimeout(function(){});
						if( !parentItem.hasClass('shake-effect') ){
							parentItem.addClass('shake-effect');
							clearTimeout(timeout);
							timeout = setTimeout(function(){ parentItem.removeClass('shake-effect'); }, 3000);
						}

						isExist = true;
					}
				}
			);
			return isExist;
		},
		ajaxAddFontItem: function ( parentWrap ) {
			var
				$addButton = $('.add-button', parentWrap)
			,	$font_select = $('.new-font-select', parentWrap)
			,	$font_list_wrap = $('.font-list', parentWrap)
			,	fontItemLength = $('.font-item', $font_list_wrap).length
			,	selected_value = $font_select.val()
			,	id = parentWrap.data('id')
			,	name = parentWrap.data('name')
			,	data = {
					action: 'get_fonts_variants_subsets',
					font: selected_value,
					id: id,
					name: name,
					font_item_length: fontItemLength
				}
			;

			if( this.ajaxRequest != null && !this.ajaxRequestSuccess){
				this.ajaxRequest.abort();
			}

			this.ajaxRequest = $.ajax({
				type: 'POST',
				url: ajaxurl,
				data: data,
				cache: false,
				beforeSend: function(){
					this.ajaxRequestSuccess = false;
					$addButton.addClass('loading');
				},
				success: function( response ){
					this.ajaxRequestSuccess = true;
					$addButton.removeClass('loading');
					$font_list_wrap.prepend( response );
					setTimeout(function(){
						$('.font-item', $font_list_wrap).eq(0).removeClass('add-item-effect');
					}, 1000);
					CHERRY_API.ui_elements.select.init( $font_list_wrap );
				},
				dataType: 'html'
			});
		},
		removeFontItem: function ( removeButton ) {
			var
				fontItem = removeButton.parents('.font-item')
			,	inner = $('.inner', fontItem)
			;
			fontItem.remove();
		}
	}
	//CHERRY_API.ui_elements.webfont.init( $('body') );
}(jQuery));
