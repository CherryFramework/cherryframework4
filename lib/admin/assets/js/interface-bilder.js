var Call_Interface_Bilder;

jQuery(document).ready(function() {

	// This function call media library window on click upload button
	jQuery('.cherry-upload-image, .cherry-upload-preview img').live('click', function () {
		var button_parent = jQuery(this).parents('.section'),
			input = jQuery('.cherry-upload-input', button_parent),
			img = jQuery('.cherry-upload-preview', button_parent),
			title_text = jQuery(this).data('title'),
			cherry_uploader;

		cherry_uploader = wp.media.frames.file_frame = wp.media({
			title: title_text,
			button: {text: title_text},
			multiple: false
		});

		cherry_uploader.live('select', function() {
			var attachment = cherry_uploader.state().get('selection').first().toJSON();
			input.val(attachment.url);
			img.css({'display':'block'}).find('img').attr({'src':attachment.url});
		}).open();

		return !1;
	});
	// Media library End

	// This function remove upload image
	jQuery('.cherry-remove-image').live('click', function () {
		var button_parent = jQuery(this).parent(),
			input = jQuery('.cherry-upload-input', button_parent),
			img = jQuery('.cherry-upload-preview', button_parent);

		input.attr({'value':''});
		img.css({'display':'none'}).find('img').attr({'src':''});

		return !1;
	})
	// Upload End

	// Stepper functions
	jQuery('.step-up').live('click', function () {
		var item = jQuery(this).parent('.cherry-stepper-controls').prev('.cherry-stepper'),
			values = get_value(item),
			change_value = values['input_value']+values['step_value'];

		if(change_value <= values['max_value']){
			item.val(change_value);
		}
		return !1;
	})
	jQuery('.step-down').live('click', function () {
		var item = jQuery(this).parent('.cherry-stepper-controls').prev('.cherry-stepper'),
			values = get_value(item),
			change_value = values['input_value']-values['step_value'];

		if(change_value >= values['min_value']){
			item.val(change_value);
		}
		return !1;
	})
	jQuery('.cherry-stepper').live('change', function () {
		var item = jQuery(this),
			values = get_value(item);

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

	/*jQuery('#cherry-submit').on('click', function(){
		console.log(jQuery('#cherry_options').serializeArray());
		return !1;
	})*/

});