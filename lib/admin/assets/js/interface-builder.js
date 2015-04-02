var Call_Interface_Bilder;

jQuery(document).ready(function() {
	// This function call media library window on click upload button
	var initMediaLibraryElement = function( target ){
		jQuery('.upload-button', target).on('click', function () {
			var button_parent = jQuery(this).parents('.cherry-section'),
				input = jQuery('.cherry-upload-input', button_parent),
				img_holder = jQuery('.cherry-upload-preview', button_parent),
				title_text = jQuery(this).data('title'),
				multiple = jQuery(this).data('multi-upload'),
				library_type = jQuery(this).data('library-type'),
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
					new_img = jQuery('.cherry-all-images-wrap', img_holder).html();
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
										'<div class="preview-holder"  data-id-attr="' + return_data +'">' + thumb + '</div>'+
										'<a class="cherry-remove-image" href="#"><i class="dashicons dashicons-no"></i></a>'+
										'<span class="title">' + img_data.title + '</span>'+
									'</div>'+
								'</div>';

					input_value += delimiter+return_data;
					count++;
				}

				input.val(input_value.replace(/(^,)/, ''));
				jQuery('.cherry-all-images-wrap', img_holder).html(new_img);
				img_holder.css({'display':'block'});
				jQuery('.cherry-remove-image').on('click', function () {
					removeMediaPreview( jQuery(this) );
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
	// Media library End

	// Stepper functions
	var initStepperElement = function( target ){
		jQuery('.step-up', target).on('click', function () {
			var
				item = jQuery(this).parent().prev('.cherry-stepper-input')
			,	values = get_value(item)
			,	change_value = values['input_value'] + values['step_value']
			;

			if(change_value <= values['max_value']){
				item.val(change_value);
				item.trigger('change');
			}
		})
		jQuery('.step-down', target).on('click', function () {
			var
				item = jQuery(this).parent().prev('.cherry-stepper-input')
			,	values = get_value(item)
			,	change_value = values['input_value'] - values['step_value']
			;

			if(change_value >= values['min_value']){
				item.val(change_value);
				item.trigger('change');
			}
		})
		jQuery('.cherry-stepper-input', target).on('change', function () {
			var
				item = jQuery(this)
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
	// Stepper End

	//Switcher functions
	var initSwitcherElement = function( target ){
		jQuery('.cherry-switcher-wrap', target).each(function(){
			var inputValue = jQuery('.cherry-input', this).attr('value');
				if(inputValue == "false"){
					jQuery('.sw-enable', this).removeClass('selected');
					jQuery('.sw-disable', this).addClass('selected');
				}else{
					jQuery('.sw-enable', this).addClass('selected');
					jQuery('.sw-disable', this).removeClass('selected');
				}
		})

		jQuery('.cherry-switcher-wrap', target).on('click', function () {
			var
				input = jQuery('.cherry-input', this)
			,	inputValue = input.attr('value')
			;

			if(inputValue == "false"){
				jQuery('.sw-enable', this).addClass('selected');
				jQuery('.sw-disable', this).removeClass('selected');
				input.attr('value', true );
			}
			if(inputValue == "true"){
				jQuery('.sw-disable', this).addClass('selected');
				jQuery('.sw-enable', this).removeClass('selected');
				input.attr('value', false );

			}
		})
	}
	//Switcher End

	//Toolltip
	var initTooltipElement = function( target ){
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
	//Toolltip

	// Slider
	var initSliderElement = function( target ){
		var
			sliderSelector = jQuery( ".cherry-slider-unit", target )
		;
		sliderSelector.slider({
			range: "min",
			animate: true,
			create: function( event, ui ) {
				jQuery( this ).slider( "option", "min", jQuery( this ).data('left-limit') );
				jQuery( this ).slider( "option", "max", jQuery( this ).data('right-limit') );
				jQuery( this ).slider( "option", "value", jQuery( this ).data('value') );
			},
			slide: function( event, ui ) {
				jQuery( this ).parent().siblings('.cherry-slider-input').find('input').val(ui.value);
			}
		});
		jQuery('.slider-input', target).on('change', function(){
			jQuery(this).parent().siblings('.cherry-slider-holder').find('.cherry-slider-unit').slider( "option", "value", jQuery(this).val() );
		})
	}
	// Slider

	// Range Slider
	var initRangeSliderElement = function( target ){
		var
			rangeSliderSelector = jQuery( ".cherry-range-slider-unit", target )
		;
		rangeSliderSelector.slider({
			animate: true,
			create: function( event, ui ) {
				jQuery( this ).slider( "option", "min", jQuery( this ).data('left-limit') );
				jQuery( this ).slider( "option", "max", jQuery( this ).data('right-limit') );
				jQuery( this ).slider( "option", "values", [ jQuery( this ).data('left-value'), jQuery( this ).data('right-value')] );
				jQuery( this ).slider( "option", "range", true );
			},
			slide: function( event, ui ) {
				var values = ui.values;
				jQuery( this ).parent().siblings('.cherry-rangeslider-left-input').find('input').val( values[ 0 ] );
				jQuery( this ).parent().siblings('.cherry-rangeslider-left-input').find('input').data({'max-value': values[ 1 ] });
				jQuery( this ).parent().siblings('.cherry-rangeslider-right-input').find('input').val( values[ 1 ] );
				jQuery( this ).parent().siblings('.cherry-rangeslider-right-input').find('input').data({'min-value': values[ 0 ] });
			}
		});
		jQuery('.slider-input-left', target).on('change', function(){
			var valuesRange = jQuery(this).parent().siblings('.cherry-range-slider-holder').find('.cherry-range-slider-unit').slider( "option", "values");
			valuesRange[0] = jQuery(this).val();
			jQuery(this).parent().siblings('.cherry-range-slider-holder').find('.cherry-range-slider-unit').slider( "option", "value", valuesRange );
		});
		jQuery('.slider-input-right', target).on('change', function(){
			var valuesRange = jQuery(this).parent().siblings('.cherry-range-slider-holder').find('.cherry-range-slider-unit').slider( "option", "values");
			valuesRange[1] = jQuery(this).val();
			jQuery(this).parent().siblings('.cherry-range-slider-holder').find('.cherry-range-slider-unit').slider( "option", "value", valuesRange );
		});
	}
	// Range Slider

	var
		first_select_character
	,	first_select_style
	,	ajaxRequest = null
	,	ajaxRequestSuccess = true
	;
	// Change font in typography
	var initTypographyElement = function( target ){
		var
			cherryTypography = jQuery('.cherry-typography', target)
		;


		jQuery('.cherry-font-family', cherryTypography).on('change', function(){
			change_font( jQuery(this) );
			previewRender( jQuery( this ) );
			google_font_include( jQuery( this ) );
		}).trigger('change');
		jQuery('.cherry-font-style', cherryTypography).on('change', function(){
			previewRender( jQuery( this ) );
			google_font_include( jQuery( this ) );
		});
		jQuery('.cherry-font-character', cherryTypography).on('change', function(){
			previewRender( jQuery( this ) );
		});
		jQuery('.font-size', cherryTypography).on('change', function(){
			previewRender( jQuery( this ) );
		});
		jQuery('.font-lineheight', cherryTypography).on('change', function(){
			previewRender( jQuery( this ) );
		});
		jQuery('.font-letterspacing', cherryTypography).on('change', function(){
			previewRender( jQuery( this ) );
		});
		jQuery('.cherry-text-align', cherryTypography).on('change', function(){
			previewRender( jQuery( this ) );
		});
		jQuery('.cherry-color-picker', cherryTypography).wpColorPicker({
			change: function( event, ui ) {
				previewRender( jQuery( this ) );
			}
		});
	}
	function google_font_include( target ){
		var
			thisTypography = jQuery( target ).parents( '.cherry-typography:first' )
		,	fontFamily = jQuery(".cherry-font-family", thisTypography ).val()
		,	fontStyle = jQuery(".cherry-font-style", thisTypography ).val()
		,	fontCharacter = jQuery(".cherry-font-character", thisTypography ).val()
		,	fontData
		;

		fontData = { 'family':fontFamily, 'style':fontStyle, 'character': fontCharacter }
		ajaxGetGoogleFont( fontData, thisTypography );
	}
	function previewRender( target ){
		var
			thisTypography = jQuery( target ).parents( '.cherry-typography:first' )
		,	previewContainer = jQuery(".cherry-font-preview", thisTypography )
		,	fontFamily = jQuery(".cherry-font-family", thisTypography ).val()
		,	fontStyle = jQuery(".cherry-font-style", thisTypography ).val()
		,	fontCharacter = jQuery(".cherry-font-character", thisTypography ).val()
		,	fontSize = jQuery(".font-size", thisTypography ).val()
		,	fontLineheight = jQuery(".font-lineheight", thisTypography ).val()
		,	fontLetterspacing = jQuery(".font-letterspacing", thisTypography ).val()
		,	fontTextAlign = jQuery(".cherry-text-align", thisTypography ).val()
		,	fontColor = jQuery(".cherry-color-picker", thisTypography ).val()
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
			select_character = jQuery('.cherry-font-character option', parent_wrap),
			select_style = jQuery('.cherry-font-style option', parent_wrap);
			imput_category = jQuery('.cherry-font-category', parent_wrap);


		first_select_character = false;
		first_select_style = false;
		imput_category.val(selected_option.data('category'));

		select_style.each(function(){
			disabled_options (jQuery(this), style_type, 'style');
		});
		select_character.each(function(){
			disabled_options (jQuery(this), character_type, 'character');
		});

	}
	function disabled_options (item, option_array, first_select){
		if(jQuery.inArray(item.val(), option_array) == -1){
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
		,	previewContainer = jQuery(".cherry-font-preview", target )
		;

			if( ajaxRequest != null && !ajaxRequestSuccess){
				ajaxRequest.abort();
			}

			ajaxRequest = jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: data,
				cache: false,
				beforeSend: function(){
					ajaxRequestSuccess = false;
				},
				success: function(response){
					ajaxRequestSuccess = true;
					jQuery( 'head' ).append(jQuery("<link rel='stylesheet' href='" + response + "' type='text/css' media='screen'>"));
				},
				dataType: 'html'
			});
	}
	// Typography End
	// Change image radio buttons
	var initImageRadioElement = function( target ){
		jQuery('.cherry-input[type="radio"]', target).on('change', function(event){
			jQuery(this).parents('.cherry-section').find('.checked').removeClass('checked');
			jQuery(this).parent().addClass('checked');
		})
	}

	// All js in this function will initialized when re-calling this function
	Call_Interface_Bilder = function( target ){
		// This call color picker
		if(jQuery('.cherry-color-picker')[0]){
			jQuery('.cherry-color-picker').wpColorPicker();
		}
		// Color Picker End

		//jQuery('.cherry-font-family').each(function(){ change_font(jQuery(this)) });

		// init MediaLibrary
		initMediaLibraryElement( target );

		// init ui slider
		initSliderElement( target );

		// init ui range slider
		initRangeSliderElement( target );

		// init typography
		initTypographyElement( target );

		// init switcher element
		initSwitcherElement( target );

		// init stepper element
		initStepperElement( target );

		// init image radio
		initImageRadioElement( target );

		// init tooltip element
		initTooltipElement( target );

		// init filter-select element
		jQuery('.cherry-filter-select', target).select2();

		// init multi-select element
		jQuery('.cherry-multi-select', target).select2();

		// init static_editor
		jQuery('.cherry-static-area-editor-wrap', target).cherryStaticEditor();

		// init repeater
		jQuery('.cherry-repeater-wrap', target).cherryRepeater();
	}
	Call_Interface_Bilder( jQuery('body') );
});
