/**
 * Typography
 */
(function($){
	"use strict";

	CHERRY_API.utilites.namespace('ui_elements.typography');
	CHERRY_API.ui_elements.typography = {
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
				cherryTypography = $('.cherry-ui-typography-wrap', target)
			,	first_select_character = false
			,	first_select_style = false
			,	ajaxRequest = null
			,	ajaxFontVariantsRequest = null
			,	ajaxFontSubsetsRequest = null
			,	ajaxRequest = null
			,	ajaxVariantsSuccess = true
			,	ajaxSubsetsSuccess = true
			,	ajaxRequestSuccess = true
			;

			if( cherryTypography.length !== 0){
				//previewRender( $('.cherry-font-family', cherryTypography), true );
				$('.cherry-font-family', cherryTypography).each(function(){
					//change_font( $(this) );
					previewRender( $( this ), true );
				})
				$('.cherry-font-family', cherryTypography).on('change', function(){
					change_font( $(this) );
					previewRender( $( this ), true );

					get_fonts_variants( $(this) );
					get_fonts_subsets( $(this) );
				});
				//}).trigger('change');
				$( cherryTypography ).on('change', '.cherry-font-style', function(){
					previewRender( $( this ), true );
				});
				$('.cherry-font-character', cherryTypography).on('change', function(){
					//previewRender( $( this ), false );
				});
				$('.font-size .cherry-ui-stepper-input', cherryTypography).on('change', function(){
					previewRender( $( this ), false );
				});
				$('.font-lineheight .cherry-ui-stepper-input', cherryTypography).on('change', function(){
					previewRender( $( this ), false );
				});
				$('.font-letterspacing .cherry-ui-stepper-input', cherryTypography).on('change', function(){
					previewRender( $( this ), false );
				});
				$('.cherry-text-align', cherryTypography).on('change', function(){
					previewRender( $( this ), false );
				});
				$('.cherry-color-picker', cherryTypography).wpColorPicker({
					change: function( event, ui ) {
						previewRender( $( this ), false );
					}
				});
			}

			var thisTypography = 0;

			function previewRender( target, fontInclud ){

				var
					thisTypography = $( target ).parents( '.cherry-ui-typography-wrap:first' )
				,	previewContainer = $(".cherry-font-preview", thisTypography )
				,	fontFamily = $("select.cherry-font-family", thisTypography ).val()
				,	fontStyle = $(".cherry-font-style", thisTypography ).val()
				,	fontCharacter = $(".cherry-font-character", thisTypography ).val()
				,	fontSize = $(".font-size .cherry-ui-stepper-input", thisTypography ).val()
				,	fontLineheight = $(".font-lineheight .cherry-ui-stepper-input", thisTypography ).val()
				,	fontLetterspacing = $(".font-letterspacing .cherry-ui-stepper-input", thisTypography ).val()
				,	fontTextAlign = $(".cherry-text-align", thisTypography ).val()
				,	fontColor = $(".cherry-color-picker", thisTypography ).val()
				,	fontType = $(".font-type", thisTypography ).val()
				;

				if( fontType == 'web'){
					//$('.field-font-character', thisTypography).css({ display: "block" });
					if(fontInclud){
						google_font_include( target );
					}
				}else{
					//$('.field-font-character', thisTypography).css({ display: "none" });
				}

				previewContainer.css({ 'display': 'block' });
				previewContainer.css({ 'font-family': fontFamily + ', sans-serif' });

				if ( fontStyle.indexOf( "italic" ) !== -1 ) {
					previewContainer.css({ 'font-style': 'italic' });
					fontStyle = fontStyle.replace( 'italic', '' );
				} else {
					previewContainer.css({ 'font-style': 'normal' });
				}
				previewContainer.css({ 'font-weight': fontStyle });

				previewContainer.css({ 'font-size': fontSize + 'px' });
				previewContainer.css({ 'line-height': fontLineheight + 'px' });
				previewContainer.css({ 'letter-spacing': fontLetterspacing + 'px' });
				previewContainer.css({ 'text-align': fontTextAlign });
				previewContainer.css({ 'color': fontColor });
				previewContainer.css({ 'background-color': contrastColour( fontColor ) });
			}

			function google_font_include( target ){
				var
					thisTypography = $( target ).parents( '.cherry-ui-typography-wrap:first' )
				,	fontFamily = $(".cherry-font-family", thisTypography ).val()
				,	fontStyle = $(".cherry-font-style", thisTypography ).val()
				,	fontCharacter = $(".cherry-font-character", thisTypography ).val()
				,	fontData = { 'family':fontFamily, 'style':fontStyle, 'character': fontCharacter }
				;
				ajaxGetGoogleFont( fontData, thisTypography );
			}

			function get_fonts_variants( item ){
				var
					parent_wrap = item.parents('.cherry-ui-typography-wrap')
				,	$font_select = $('.cherry-font-family', parent_wrap)
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

			function change_font(item){
				var
					parent_wrap = item.parents('.cherry-ui-typography-wrap')
				,	selected_option = item.find(":selected")
				,	input_category = $('.cherry-font-category', parent_wrap)
				,	fontType = get_font_type( item )
				;

				$('.font-type', parent_wrap).val( fontType );

				input_category.val(selected_option.data('category'));

				if( fontType == 'web'){
					$('.field-font-character', thisTypography).css({ display: "block" });
				}else{
					$('.field-font-character', thisTypography).css({ display: "none" });
				}
			}
			// get type option
			function get_font_type(item){
				var
					selected_option = item.find(":selected")
				,	parentOptGroup = selected_option.parents('optgroup:first')
				;

				return parentOptGroup.data('font-type');
			}

			function disabled_options (item, option_array, first_select){

				if($.inArray(item.val(), option_array) == -1){
					item.removeAttr('selected').attr('disabled', 'disabled').css({'display':'none'});
				}else{
					item.removeAttr('disabled').css({'display':'block'});
					//item.removeAttr('selected').removeAttr('disabled').css({'display':'block'});
					/*if(first_select == 'style' && !first_select_style){
						console.log("first_select_style");
						item.attr('selected', 'selected');
						first_select_style = true;
					}
					if(first_select == 'character' && !first_select_character){
						console.log("first_select_character");
						item.attr('selected', 'selected');
						first_select_character = true;
					}*/
				}
			}

			function contrastColour( hexcolour ) {
				var result = '#222222';

				if ( hexcolour !== '' ) {
					hexcolour = hexcolour.replace( '#', '' );
					var r = parseInt( hexcolour.substr( 0, 2 ), 16 );
					var g = parseInt( hexcolour.substr( 2, 2 ), 16 );
					var b = parseInt( hexcolour.substr( 4, 2 ), 16 );
					var res = ((r * 299) + (g * 587) + (b * 114)) / 1000;

					result = (res >= 128) ? '#222222' : '#ffffff';
				}

				return result;
			};

			function ajaxGetGoogleFont( fontData, target ){
				var
					data = {
						action: 'get_google_font_link',
						font_data: fontData,
					}
				,	previewContainer = $(".cherry-font-preview", target )
				,	fontFamilyName = fontData.family.replace(' ', '-') + fontData.style + fontData.character + '.css'
				;

				if( ajaxRequest != null && !ajaxRequestSuccess){
					//ajaxRequest.abort();
				}

				ajaxRequest = $.ajax({
					type: 'POST',
					url: ajaxurl,
					data: data,
					cache: false,
					beforeSend: function(){
						ajaxRequestSuccess = false;
						//$('span', previewContainer)
					},
					success: function(response){
						ajaxRequestSuccess = true;

						if( $.inArray( fontFamilyName, CHERRY_API.variable.loaded_assets.style ) == -1 ){
							CHERRY_API.variable.loaded_assets.style.push( fontFamilyName );
							$( 'head' ).append($("<link rel='stylesheet' href='" + response + "' type='text/css' media='all'>"));
						}

					},
					dataType: 'html'
				});
			}//end

			function ajaxGetFontVariants( parent_wrap ){
				var
					$font_select = $('select.cherry-font-family', parent_wrap)
				,	$variant_select = $('.field-font-style', parent_wrap)
				,	selected_value = $font_select.val()
				,	id = parent_wrap.data('id')
				,	name = parent_wrap.data('name')
				,	data = {
						action: 'get_fonts_variants',
						font: selected_value,
						id: id,
						name: name
					}
				;

				if( ajaxFontVariantsRequest != null && !ajaxVariantsSuccess){
					ajaxFontVariantsRequest.abort();
				}

				ajaxFontVariantsRequest = $.ajax({
					type: 'POST',
					url: ajaxurl,
					data: data,
					cache: false,
					beforeSend: function(){
						ajaxVariantsSuccess = false;
						$variant_select.fadeTo(100, 0.3);
					},
					success: function( response ){
						ajaxVariantsSuccess = true;
						$variant_select.fadeTo(100, 1);
						$variant_select.html( response );
						CHERRY_API.ui_elements.select.init( $variant_select );
					},
					dataType: 'html'
				});
			}// end ajaxGetFontVariants

			function ajaxGetFontSubsets( parent_wrap ){
				var
					$font_select = $('select.cherry-font-family', parent_wrap)
				,	$character_select = $('.field-font-character', parent_wrap)
				,	selected_value = $font_select.val()
				,	id = parent_wrap.data('id')
				,	name = parent_wrap.data('name')
				,	data = {
						action: 'get_fonts_subsets',
						font: selected_value,
						id: id,
						name: name
					}
				;

				if( ajaxFontSubsetsRequest != null && !ajaxSubsetsSuccess){
					ajaxFontSubsetsRequest.abort();
				}

				ajaxFontSubsetsRequest = $.ajax({
					type: 'POST',
					url: ajaxurl,
					data: data,
					cache: false,
					beforeSend: function(){
						ajaxSubsetsSuccess = false;
						$character_select.fadeTo(100, 0.3);
					},
					success: function( response ){
						ajaxSubsetsSuccess = true;
						$character_select.fadeTo(100, 1);
						$character_select.html( response );
						CHERRY_API.ui_elements.select.init( $character_select );
					},
					dataType: 'html'
				});
			}// end ajaxGetFontVariants
		}
	}
	$( window ).on( 'cherry-ui-elements-init',
		function( event, data ) {
			CHERRY_API.ui_elements.typography.init( data.target );
		}
	);
}(jQuery));
