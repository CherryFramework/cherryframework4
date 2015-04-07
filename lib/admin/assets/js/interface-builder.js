(function( $ ) {
	'use strict';

	$.cherryInterfaceBuilder = $.cherryInterfaceBuilder || {};

	$.cherryInterfaceBuilder.CallInterfaceBuilder = function( target ) {
		// init Media
		$.cherryInterfaceBuilder.initMediaLibraryElement( target );
		// init Stepper
		$.cherryInterfaceBuilder.initStepperElement( target );
		// init Switcher
		$.cherryInterfaceBuilder.initSwitcherElement( target );
		// init Tooltip
		$.cherryInterfaceBuilder.initTooltipElement( target );
		// init Slider
		$.cherryInterfaceBuilder.initSliderElement( target );
		// init Range Slider
		$.cherryInterfaceBuilder.initRangeSliderElement( target );
		// init Image radio
		$.cherryInterfaceBuilder.initImageRadioElement( target );
		//init Typography
		$.cherryInterfaceBuilder.initTypographyElement( target );
		// init Collor Pickers
		$.cherryInterfaceBuilder.initColorPicker( target );
		// init Layou tEditor
		$.cherryInterfaceBuilder.initLayoutEditor( target );
		// init filter-select
		$('.cherry-filter-select', target).select2();
		// init multi-select
		$('.cherry-multi-select', target).select2();
		// init static_editor
		$('.cherry-static-area-editor-wrap', target).cherryStaticEditor();
		// init repeater
		$('.cherry-repeater-wrap', target).cherryRepeater();
	}

	// ---------- Media library ---------------------------------------------------------------
	$.cherryInterfaceBuilder.initMediaLibraryElement = function( target ){
		$('.upload-button', target).on('click', function () {
			var button_parent = $(this).parents('.cherry-section'),
				input = $('.cherry-upload-input', button_parent),
				img_holder = $('.cherry-upload-preview', button_parent),
				title_text = $(this).data('title'),
				multiple = $(this).data('multi-upload'),
				library_type = $(this).data('library-type'),
				cherry_uploader;

			cherry_uploader = wp.media.frames.file_frame = wp.media({
				title: title_text,
				button: {text: title_text},
				multiple: multiple,
				library : { type : library_type }
			});

			cherry_uploader.on('select', function() {
				var attachment = cherry_uploader.state().get('selection').toJSON(),
					count = 0,
					input_value = '',
					new_img = '',
					delimiter = '';

				if(multiple){
					input_value = input.val();
					delimiter = ',';
					new_img = $('.cherry-all-images-wrap', img_holder).html();
				}

				while(attachment[count]){
					var img_data = attachment[count],
						return_data = img_data.id,
						mimeType = img_data.mime,
						img_src = '',
						thumb = '';

						switch (mimeType) {
							case 'image/jpeg':
							case 'image/png':
							case 'image/gif':
									if( img_data.sizes != undefined){
										img_src = img_data.sizes.thumbnail ? img_data.sizes.thumbnail.url : img_data.sizes.full.url;
									}
									thumb = '<img  src="' + img_src + '" alt="" data-img-attr="'+return_data+'">';
								break
							case 'video/mpeg':
							case 'video/mp4':
							case 'video/quicktime':
							case 'video/webm':
							case 'video/ogg':
									thumb = '<span class="dashicons dashicons-format-video"></span>';
								break;
							case 'audio/mpeg':
							case 'audio/wav':
							case 'audio/ogg':
									thumb = '<span class="dashicons dashicons-format-audio"></span>';
								break;
						}

						new_img += '<div class="cherry-image-wrap">'+
									'<div class="inner">'+
										'<div class="preview-holder"  data-id-attr="' + return_data +'"><div class="centered">' + thumb + '</div></div>'+
										'<a class="cherry-remove-image" href="#"><i class="dashicons dashicons-no"></i></a>'+
										'<span class="title">' + img_data.title + '</span>'+
									'</div>'+
								'</div>';

					input_value += delimiter+return_data;
					count++;
				}

				input.val(input_value.replace(/(^,)/, ''));
				$('.cherry-all-images-wrap', img_holder).html(new_img);
				img_holder.css({'display':'block'});
				$('.cherry-remove-image').on('click', function () {
					removeMediaPreview( $(this) );
					return !1;
				})
			}).open();

			return !1;
		});

		// This function remove upload image
		jQuery('.cherry-remove-image', target).on('click', function () {
			removeMediaPreview( jQuery(this) );
			return !1;
		})
		var removeMediaPreview = function( item ){
			var button_parent = item.parents('.cherry-section'),
				input = jQuery('.cherry-upload-input', button_parent),
				img_holder = item.parent().parent('.cherry-image-wrap'),
				img_attr = jQuery('.preview-holder', img_holder).data('id-attr'),
				imput_value = input.attr('value'),
				pattern = new RegExp(''+img_attr+'(,*)', 'i');

				imput_value = imput_value.replace(pattern, '');
				imput_value = imput_value.replace(/(,$)/, '');
				input.attr({'value':imput_value});
				img_holder.remove();
				if(!imput_value){
					jQuery('.cherry-upload-preview', button_parent).css({'display':'none'})
				}

		}
		// Upload End
		// Image ordering
		jQuery('.cherry-all-images-wrap', target).sortable({
			items: 'div.cherry-image-wrap',
			cursor: 'move',
			scrollSensitivity:40,
			forcePlaceholderSize: true,
			forceHelperSize: false,
			helper: 'clone',
			opacity: 0.65,
			placeholder: 'cherry-media-thumb-sortable-placeholder',
			start:function(event,ui){},
			stop:function(event,ui){},
			update: function(event, ui) {
				var attachment_ids = '';
					jQuery('.cherry-image-wrap', this).each(
						function() {
							var attachment_id = jQuery('.preview-holder', this).data( 'id-attr' );
								attachment_ids = attachment_ids + attachment_id + ',';
						}
					);
					attachment_ids = attachment_ids.substr(0, attachment_ids.lastIndexOf(',') );
					jQuery(this).parent().siblings('.cherry-element-wrap').find('input.cherry-upload-input').val(attachment_ids);
			}
		});
		// End Image ordering
	}
	// ---------- Stepper ---------------------------------------------------------------------
	$.cherryInterfaceBuilder.initStepperElement = function( target ){
		$('.step-up', target).on('click', function () {
			var
				item = $(this).parent().prev('.cherry-stepper-input')
			,	values = get_value(item)
			,	change_value = values['input_value'] + values['step_value']
			;

			if(change_value <= values['max_value']){
				item.val(change_value);
				item.trigger('change');
			}
		})
		$('.step-down', target).on('click', function () {
			var
				item = $(this).parent().prev('.cherry-stepper-input')
			,	values = get_value(item)
			,	change_value = values['input_value'] - values['step_value']
			;

			if(change_value >= values['min_value']){
				item.val(change_value);
				item.trigger('change');
			}
		})
		$('.cherry-stepper-input', target).on('change', function () {
			var
				item = $(this)
			,	values = get_value(item)
			;
			if(values['input_value'] > values['max_value']){
				item.val(values['max_value']);
			}
			if(values['input_value'] < values['min_value']){
				item.val(values['min_value']);
			}
		})
		function get_value (item) {
			var values = [];
				values['max_value'] = parseFloat(item.data('max-value'));
				values['min_value'] = parseFloat(item.data('min-value'));
				values['step_value'] = parseFloat(item.data('value-step'));
				values['input_value'] = parseFloat(item.attr('value'));
			return values;
		}
	}
	// ---------- Switcher --------------------------------------------------------------------
	$.cherryInterfaceBuilder.initSwitcherElement = function( target ){
		$('.cherry-switcher-wrap', target).each(function(){
			var inputValue = $('.cherry-input', this).attr('value');
				if(inputValue == "false"){
					$('.sw-enable', this).removeClass('selected');
					$('.sw-disable', this).addClass('selected');
				}else{
					$('.sw-enable', this).addClass('selected');
					$('.sw-disable', this).removeClass('selected');
				}
		})

		$('.cherry-switcher-wrap', target).on('click', function () {
			var
				input = $('.cherry-input', this)
			,	inputValue = input.attr('value')
			;

			if(inputValue == "false"){
				$('.sw-enable', this).addClass('selected');
				$('.sw-disable', this).removeClass('selected');
				input.attr('value', true );
			}
			if(inputValue == "true"){
				$('.sw-disable', this).addClass('selected');
				$('.sw-enable', this).removeClass('selected');
				input.attr('value', false );

			}
		})
	}
	// ---------- Toolltip --------------------------------------------------------------------
	$.cherryInterfaceBuilder.initTooltipElement = function( target ){
		jQuery( target ).tooltip({
			items: ".hint-text, .hint-image, .hint-video",
			content: function() {
				var element = jQuery( this );
				//console.log(element);
				if ( element.is( "[title]" ) ) {
					return element.attr( "title" );
				}
				if ( element.is( "[data-hint-image]" ) ) {
					var imgSrc = jQuery(this).data('hint-image');
					return "<img src="+imgSrc+" alt=''>";
				}
				if ( element.is( "[data-hint-video]" ) ) {
					var videoSrc = jQuery(this).html();
					return videoSrc;
				}
			},
			hide: {duration: 200},
			close: function(event, ui){
				jQuery(ui.tooltip).off('mouseenter');
					ui.tooltip.one('mouseenter', function(){
						var clone = jQuery(ui.tooltip).clone();
						jQuery(this).parent().append(clone);
						clone.mouseleave(function(){
							//clone.fadeOut(300, function(){ clone.remove(); } )
							clone.remove();
						});
						//clone.css({opacity: 1, visibility: 'visible'});
					});
			},
			tooltipClass: "custom-tooltip-styling",
			position: {
				my: "left+10 center",
				at: "right center"
			}
		});
	}
	// ---------- Slider ----------------------------------------------------------------------
	$.cherryInterfaceBuilder.initSliderElement = function( target ){
		var
			sliderSelector = $( ".cherry-slider-unit", target )
		;
		sliderSelector.slider({
			range: "min",
			animate: true,
			create: function( event, ui ) {
				$( this ).slider( "option", "min", $( this ).data('left-limit') );
				$( this ).slider( "option", "max", $( this ).data('right-limit') );
				$( this ).slider( "option", "value", $( this ).data('value') );
			},
			slide: function( event, ui ) {
				$( this ).parent().siblings('.cherry-slider-input').find('input').val(ui.value);
			}
		});
		$('.slider-input', target).on('change', function(){
			$(this).parent().siblings('.cherry-slider-holder').find('.cherry-slider-unit').slider( "option", "value", $(this).val() );
		})
	}
	// ---------- Range Slider ----------------------------------------------------------------
	$.cherryInterfaceBuilder.initRangeSliderElement = function( target ){
		var
			rangeSliderSelector = $( ".cherry-range-slider-unit", target )
		;
		rangeSliderSelector.slider({
			animate: true,
			create: function( event, ui ) {
				$( this ).slider( "option", "min", $( this ).data('left-limit') );
				$( this ).slider( "option", "max", $( this ).data('right-limit') );
				$( this ).slider( "option", "values", [ $( this ).data('left-value'), $( this ).data('right-value')] );
				$( this ).slider( "option", "range", true );
			},
			slide: function( event, ui ) {
				var values = ui.values;
				$( this ).parent().siblings('.cherry-rangeslider-left-input').find('input').val( values[ 0 ] );
				$( this ).parent().siblings('.cherry-rangeslider-left-input').find('input').data({'max-value': values[ 1 ] });
				$( this ).parent().siblings('.cherry-rangeslider-right-input').find('input').val( values[ 1 ] );
				$( this ).parent().siblings('.cherry-rangeslider-right-input').find('input').data({'min-value': values[ 0 ] });
			}
		});
		$('.slider-input-left', target).on('change', function(){
			var valuesRange = $(this).parent().siblings('.cherry-range-slider-holder').find('.cherry-range-slider-unit').slider( "option", "values");
			valuesRange[0] = $(this).val();
			$(this).parent().siblings('.cherry-range-slider-holder').find('.cherry-range-slider-unit').slider( "option", "value", valuesRange );
		});
		$('.slider-input-right', target).on('change', function(){
			var valuesRange = $(this).parent().siblings('.cherry-range-slider-holder').find('.cherry-range-slider-unit').slider( "option", "values");
			valuesRange[1] = $(this).val();
			$(this).parent().siblings('.cherry-range-slider-holder').find('.cherry-range-slider-unit').slider( "option", "value", valuesRange );
		});
	}
	// ---------- Image radio buttons ---------------------------------------------------------
	$.cherryInterfaceBuilder.initImageRadioElement = function( target ){
		$('.cherry-input[type="radio"]', target).on('change', function(event){
			$(this).parents('.cherry-section').find('.checked').removeClass('checked');
			$(this).parent().addClass('checked');
		})
	}
	// ---------- Typography ------------------------------------------------------------------
	$.cherryInterfaceBuilder.initTypographyElement = function( target ){
		var
			cherryTypography = $('.cherry-typography', target)
		,	first_select_character
		,	first_select_style
		,	ajaxRequest = null
		,	ajaxRequestSuccess = true
		;

		$('.cherry-font-family', cherryTypography).on('change', function(){
			change_font( $(this) );
			previewRender( $( this ) );
			google_font_include( $( this ) );
		});
		$('.cherry-font-style', cherryTypography).on('change', function(){
			previewRender( $( this ) );
			google_font_include( $( this ) );
		}).trigger('change');
		$('.cherry-font-character', cherryTypography).on('change', function(){
			previewRender( $( this ) );
		});
		$('.font-size', cherryTypography).on('change', function(){
			previewRender( $( this ) );
		});
		$('.font-lineheight', cherryTypography).on('change', function(){
			previewRender( $( this ) );
		});
		$('.font-letterspacing', cherryTypography).on('change', function(){
			previewRender( $( this ) );
		});
		$('.cherry-text-align', cherryTypography).on('change', function(){
			previewRender( $( this ) );
		});
		$('.cherry-color-picker', cherryTypography).wpColorPicker({
			change: function( event, ui ) {
				previewRender( $( this ) );
			}
		});

		function google_font_include( target ){
			var
				thisTypography = $( target ).parents( '.cherry-typography:first' )
			,	fontFamily = $(".cherry-font-family", thisTypography ).val()
			,	fontStyle = $(".cherry-font-style", thisTypography ).val()
			,	fontCharacter = $(".cherry-font-character", thisTypography ).val()
			,	fontData
			;

			fontData = { 'family':fontFamily, 'style':fontStyle, 'character': fontCharacter }

			ajaxGetGoogleFont( fontData, thisTypography );
		}
		function previewRender( target ){
			var
				thisTypography = $( target ).parents( '.cherry-typography:first' )
			,	previewContainer = $(".cherry-font-preview", thisTypography )
			,	fontFamily = $(".cherry-font-family", thisTypography ).val()
			,	fontStyle = $(".cherry-font-style", thisTypography ).val()
			,	fontCharacter = $(".cherry-font-character", thisTypography ).val()
			,	fontSize = $(".font-size", thisTypography ).val()
			,	fontLineheight = $(".font-lineheight", thisTypography ).val()
			,	fontLetterspacing = $(".font-letterspacing", thisTypography ).val()
			,	fontTextAlign = $(".cherry-text-align", thisTypography ).val()
			,	fontColor = $(".cherry-color-picker", thisTypography ).val()
			;

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
		function change_font(item){
			var parent_wrap = item.parents('.cherry-typography'),
				selected_option = item.find(":selected"),
				style_type = selected_option.data('style').split(','),
				character_type = selected_option.data('character').split(','),
				select_character = $('.cherry-font-character option', parent_wrap),
				select_style = $('.cherry-font-style option', parent_wrap),
				input_category = $('.cherry-font-category', parent_wrap);


			first_select_character = false;
			first_select_style = false;
			input_category.val(selected_option.data('category'));

			select_style.each(function(){
				disabled_options ($(this), style_type, 'style');
			});
			select_character.each(function(){
				disabled_options ($(this), character_type, 'character');
			});

		}
		function disabled_options (item, option_array, first_select){
			if($.inArray(item.val(), option_array) == -1){
				item.removeAttr('selected').attr('disabled', 'disabled').css({'display':'none'});
			}else{
				item.removeAttr('selected').removeAttr('disabled').css({'display':'block'});
				if(first_select == 'style' && !first_select_style){
					item.attr('selected', 'selected');
					first_select_style = true;
				}
				if(first_select == 'character' && !first_select_character){
					item.attr('selected', 'selected');
					first_select_character = true;
				}
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
					$( 'head' ).append($("<link rel='stylesheet' href='" + response + "' type='text/css' media='all'>"));
				},
				dataType: 'html'
			});
		}
	}
	// ---------- LayoutEditor ----------------------------------------------------------------
	$.cherryInterfaceBuilder.initLayoutEditor = function( target ){
		var
			cherryLayoutEditor = $('.cherry-layout-editor-wrap', target)
		;

		$('.layout-editor-input', cherryLayoutEditor).on('change', function(){
			$(this).val( $.cherryInterfaceBuilder.cssUnitsValidator( $(this).val() ) );
		})

		$('.cherry-border-style', cherryLayoutEditor).on('change', function(){
			borderPreviewRender( $( this ) );
		}).trigger('change');

		$('.cherry-border-radius', cherryLayoutEditor).on('change', function(){
			$(this).val( $.cherryInterfaceBuilder.cssUnitsValidator( $(this).val() ) );
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
		function cssUnitsValidator( value ){

		}
	}
	// ----------- Color Picker ---------------------------------------------------------------
	$.cherryInterfaceBuilder.initColorPicker = function( target ){
		if($('.cherry-color-picker', target)[0]){
			$('.cherry-color-picker', target).wpColorPicker();
		}
	}

	$.cherryInterfaceBuilder.cssUnitsValidator = function( value ){
		var
			currentValue = value
		,	onlyDigit = ''
		,	units = ''
		,	resultValue = ''
		;
		if( currentValue.length !== 0 || currentValue !== '' ){
			onlyDigit = currentValue.match(/\d/g);
			( onlyDigit !== null ) ? onlyDigit = onlyDigit.join('') : onlyDigit = '';

			if( /%|px|in|cm|mm|em|rem|ex|pt|pc/.test( currentValue ) == false ){
				units = 'px';
			}else{
				units = currentValue.match(/%|px|in|cm|mm|em|rem|ex|pt|pc/g)[0];
			}
			resultValue = (onlyDigit.length != 0)? onlyDigit + units : '';
		}
		return resultValue;
	}

	$(document).ready(function() {
		$.cherryInterfaceBuilder.CallInterfaceBuilder( $('body') );
	})

})(jQuery)
