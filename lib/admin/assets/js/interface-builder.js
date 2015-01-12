var Call_Interface_Bilder;

jQuery(document).ready(function() {

	// This function call media library window on click upload button
	jQuery('.button-default_').live('click', function () {
		var button_parent = jQuery(this).parents('.cherry-section'),
			input = jQuery('.cherry-upload-input', button_parent),
			img_holder = jQuery('.cherry-upload-preview', button_parent),
			title_text = jQuery(this).data('title'),
			data_type = jQuery(this).data('return-data'),
			multiple = jQuery(this).data('multi-upload'),
			cherry_uploader;

		cherry_uploader = wp.media.frames.file_frame = wp.media({
			title: title_text,
			button: {text: title_text},
			multiple: multiple
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
				var img_data=attachment[count],
					return_data = data_type == 'url' ? img_data.url : img_data.id,
					img_src = img_data.sizes.thumbnail ? img_data.sizes.thumbnail.url : img_data.sizes.full.url;

				new_img += '<div class="cherry-image-wrap"><img  src="' +img_src+ '" alt="" data-img-attr="'+return_data+'"><a class="media-modal-icon cherry-remove-image" title=""></a></div>';
				input_value += delimiter+return_data;
				count++;
			}

			input.val(input_value.replace(/(^,)/, ''));
			jQuery('.cherry-all-images-wrap', img_holder).html(new_img);
			img_holder.css({'display':'block'});

		}).open();

		return !1;
	});
	// Media library End

	// This function remove upload image
	jQuery('.cherry-remove-image').live('click', function () {
		var button_parent = jQuery(this).parents('.cherry-section'),
			input = jQuery('.cherry-upload-input', button_parent),
			img_holder = jQuery(this).parent('.cherry-image-wrap'),
			img_attr = jQuery('img', img_holder).data('img-attr'),
			imput_value = input.attr('value'),
			pattern = new RegExp(''+img_attr+'(,*)', 'i');

		imput_value = imput_value.replace(pattern, '');
		imput_value = imput_value.replace(/(,$)/, '');
		input.attr({'value':imput_value});
		img_holder.remove();
		if(!imput_value){
			jQuery('.cherry-upload-preview', button_parent).css({'display':'none'})
		}
		return !1;
	})
	// Upload End

	// Stepper functions
	jQuery('.step-up').on('click', function () {
		var
			item = jQuery(this).parent().prev('.cherry-stepper-input')
		,	values = get_value(item)
		,	change_value = values['input_value']+values['step_value']
		;

		if(change_value <= values['max_value']){
			item.val(change_value);
			item.trigger('change');
		}
	})
	jQuery('.step-down').on('click', function () {
		var
			item = jQuery(this).parent().prev('.cherry-stepper-input')
		,	values = get_value(item)
		,	change_value = values['input_value']-values['step_value']
		;

		if(change_value >= values['min_value']){
			item.val(change_value);
			item.trigger('change');
		}
	})
	jQuery('.cherry-stepper-input').on('change', function () {
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
	// Stepper End

	//Switcher functions
	jQuery('.cherry-switcher-wrap').each(function(){
		var inputValue = jQuery('.cherry-input', this).attr('value');
			if(inputValue == "false"){
				jQuery('.sw-enable', this).removeClass('selected');
				jQuery('.sw-disable', this).addClass('selected');
			}else{
				jQuery('.sw-enable', this).addClass('selected');
				jQuery('.sw-disable', this).removeClass('selected');
			}
	})
	jQuery('.cherry-switcher-wrap').on('click', function () {
		var input = jQuery('.cherry-input', this);
		var inputValue = input.attr('value');
		if(inputValue == "false"){
			jQuery('.sw-enable', this).addClass('selected');
			jQuery('.sw-disable', this).removeClass('selected');
			input.attr('value', 'true');
		}
		if(inputValue == "true"){
			jQuery('.sw-disable', this).addClass('selected');
			jQuery('.sw-enable', this).removeClass('selected');
			input.attr('value', 'false');

		}
	})
	//Switcher End

	//Multiselect functions
	jQuery('.cherry-multi-select').select2();
	jQuery('.cherry-filter-select').select2();
	//Multiselect functions

	//Toolltip
	jQuery( document ).tooltip({
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
		hide: {duration: 300},
		close: function(event, ui){
			jQuery(ui.tooltip).off('mouseenter');
				ui.tooltip.one('mouseenter', function(){
					var clone = jQuery(ui.tooltip).clone();
					jQuery(this).parent().append(clone);
					clone.mouseleave(function(){
						clone.fadeOut(300, function(){ clone.remove(); } )
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
	//Toolltip

	// Slider
	var
		sliderSelector = jQuery( ".cherry-slider-unit" )
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
	jQuery('.slider-input').on('change', function(){
		jQuery(this).parent().siblings('.cherry-slider-holder').find('.cherry-slider-unit').slider( "option", "value", jQuery(this).val() );
	})
	// Slider

	// Range Slider
	var
		rangeSliderSelector = jQuery( ".cherry-range-slider-unit" )
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
			jQuery( this ).parent().siblings('.cherry-rangeslider-left-input').find('input').val(ui.values[ 0 ]);
			jQuery( this ).parent().siblings('.cherry-rangeslider-right-input').find('input').val(ui.values[ 1 ]);
		}
	});
	jQuery('.slider-input-left').on('change', function(){
		var valuesRange = jQuery(this).parent().siblings('.cherry-range-slider-holder').find('.cherry-range-slider-unit').slider( "option", "values");
		valuesRange[0] = jQuery(this).val();
		jQuery(this).parent().siblings('.cherry-range-slider-holder').find('.cherry-range-slider-unit').slider( "option", "value", valuesRange );
	});
	jQuery('.slider-input-right').on('change', function(){
		var valuesRange = jQuery(this).parent().siblings('.cherry-range-slider-holder').find('.cherry-range-slider-unit').slider( "option", "values");
		valuesRange[1] = jQuery(this).val();
		jQuery(this).parent().siblings('.cherry-range-slider-holder').find('.cherry-range-slider-unit').slider( "option", "value", valuesRange );
	});
	// Range Slider

	// static_editor
	jQuery('.cherry-static-area-editor-wrap').cherryStaticEditor();
	// static_editor

	// static_editor
	//jQuery('.cherry-icon-editor-wrap').cherryIconEditor();
	// static_editor


	// Change font in typography
	var first_select_character,
		first_select_style;

	jQuery('.cherry-font-family').live('change', function(){
		change_font(jQuery(this));
	});
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
	// Typography End
	// Change image radio buttons
	jQuery('.cherry-input[type="radio"]').live('change', function(event){
		jQuery(this).parents('.cherry-section').find('.checked').removeClass('checked');
		jQuery(this).parent().addClass('checked');
	})
	// All js in this function will initialized when re-calling this function
	Call_Interface_Bilder = function(){
		// This call color picker
		if(jQuery('.cherry-color-picker')[0]){
			jQuery('.cherry-color-picker').wpColorPicker();
		}
		// Color Picker End

		jQuery('.cherry-font-family').each(function(){ change_font(jQuery(this)) });
	}
	Call_Interface_Bilder();
});
