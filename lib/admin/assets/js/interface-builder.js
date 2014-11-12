var Call_Interface_Bilder;	

jQuery(document).ready(function() {

	// This function call media library window on click upload button
	jQuery('.cherry-upload-image').live('click', function () {
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
		jQuery('.sw-enable').live('click', function () {
			var input = jQuery(this).siblings('.cherry-input');
			var inputValue = input.attr('value');
			if(inputValue == "false"){
				jQuery(this).addClass('selected');
				jQuery(this).siblings('.sw-disable').removeClass('selected');
				input.attr('value', 'true');
			}
		})
		jQuery('.sw-disable').live('click', function () {
			var input = jQuery(this).siblings('.cherry-input');
			var inputValue = input.attr('value');
			if(inputValue == "true"){
				jQuery(this).siblings('.sw-enable').removeClass('selected');
				jQuery(this).addClass('selected');
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

// cherry-accordion plugin controler
(function($){
    var methods = {
        init : function( options ) {

            var settings = {
                offset: true
            }

            return this.each(function(){
                if ( options ){
                    $.extend(settings, options);
                } 
                
                var 
                    _this = $(this)
                ,	addStaticButton = $('.add-new-btn', _this)
                ,	accordionUnit = $('.accordion-unit', _this)
                ,	groupList = $('.group', _this)
                ,	staticSelector = $('.static-selector', _this)
                ,	staticSelectorLength = $('option', staticSelector).length
                ,	dataName = _this.data('name');
                ;
  
                _constructor();
                function _constructor(){
                	accordionUnit.accordion({
				    	header: "> div > h3",
				    	collapsible: true,
				    	active: false,
				    	icons: { "header": "ui-icon-plus", "activeHeader": "ui-icon-minus" }
				    })
				    .sortable({
				        axis: "y",
				        handle: "h3",
				        placeholder: "ui-state-highlight",
				        connectWith: ".accordion-unit",
				        beforeStop: function( event, ui ) {
				        	all_group = $(ui.item).parent();
				        	$('.group', all_group).each(function(){
				        		index = $(this).index();
				        		$('.key-priority', this).val(index+1);
				        	})
				        },
				        receive: function( event, ui ) {
				        	new_area = $(ui.item).parent().parent().data('area');
				        	$('.key-area', ui.item).val(new_area);
				        	accordionUnit.accordion( "refresh" );
				        },
				        stop: function( event, ui ) {
				         	ui.item.children( "h3" ).triggerHandler( "focusout" );
				          	$( this ).accordion( "refresh" );
				        }
				    }).disableSelection();
                	
                    addEventsFunction(); 
                    updateStaticSelector();                   
                }
                
                function addEventsFunction(){
                	addStaticButton.on('click', function(){
                		if( $('.group', _this).length < staticSelectorLength ){
                			createNewGroup();
                		}
                	});
                	$('.delete-group', _this).on('click', function(){
                		if( !$(this).hasClass('confirm-state') ){
                			$(this).addClass('confirm-state');
                		}else{
                			//$(this).removeClass('confirmState');
                		}
                		return false;
                	});
                	$('.confirm-btn', _this).on('click', function(){
                		deleteGroup( $(this).parent() );
                	});
                	$('.cancle-btn', _this).on('click', function(){
                		$(this).parent().removeClass('confirm-state');
                		return false;
                	});
                	$('.group', _this).on('mouseleave', function(){
				    	mouseLeaveEvent( $(this) );
				    })
                }

                function mouseLeaveEvent(group){
                	$('.delete-group', group).removeClass('confirm-state');
                }

                function createNewGroup(){

                	var
                		newGroup
                	,	selectedText = $(':selected', staticSelector).text()
                	,	selectedPriority = $(':selected', staticSelector).data('priority')
                	,	selectedValue = staticSelector.val()
					;

					newGroup = $(groupList).first().clone();

					$(newGroup).attr('data-static-id', selectedValue);

					$('.ui-accordion-header .label', newGroup).text(selectedText);

					nameKeyColLg = dataName + '[' + selectedValue + '][options][col-lg]';
					$('.ui-accordion-content .key-col-lg', newGroup).attr('name', nameKeyColLg);

					nameKeyColMd = dataName + '[' + selectedValue + '][options][col-md]';
					$('.ui-accordion-content .key-col-md', newGroup).attr('name', nameKeyColMd);

					nameKeyColSm = dataName + '[' + selectedValue + '][options][col-sm]';
					$('.ui-accordion-content .key-col-sm', newGroup).attr('name', nameKeyColSm);

					nameKeyColXs = dataName + '[' + selectedValue + '][options][col-xs]';
					$('.ui-accordion-content .key-col-xs', newGroup).attr('name', nameKeyColXs);

					nameKeyCustomClass = dataName + '[' + selectedValue + '][options][class]';
					$('.ui-accordion-content .key-custom-class', newGroup).attr('name', nameKeyCustomClass);
					
					nameItemName = dataName + '[' + selectedValue + '][name]';
					$('.ui-accordion-content .key-item-name', newGroup).attr({'name': nameItemName, 'value': selectedText});

					nameKeyPriority = dataName + '[' + selectedValue + '][options][priority]';
					$('.ui-accordion-content .key-priority', newGroup).attr({'name': nameKeyPriority, 'value': selectedPriority});
					
					nameKeyArea = dataName + '[' + selectedValue + '][options][area]';
					$('.ui-accordion-content .key-area', newGroup).attr({'name': nameKeyArea});

					$('.delete-group', newGroup).on('click', function(){
                		if( !$(this).hasClass('confirm-state') ){
                			$(this).addClass('confirm-state');
                		}else{
                			$(this).removeClass('confirm-state');
                		}
                		return false;
                	});
                	$('.confirm-btn', newGroup).on('click', function(){
                		deleteGroup( $(this).parent() );
                	});
                	$('.cancle-btn', newGroup).on('click', function(){
                		$(this).parent().removeClass('confirmState');
                		return false;
                	});
                	newGroup.on('mouseleave', function(){
				    	mouseLeaveEvent( $(this) );
				    })

                	accordionUnit.eq(0).append(newGroup).accordion( "refresh" );
                	updateStaticSelector();
                }// end createNewGroup	

                function deleteGroup(deleteButton){
            		var
                		deletedGroup = deleteButton.parent().parent();
					;
					deleteButton.off('click');
					$('.confirm-btn', deleteButton).off('click');
					$('.cancle-btn', deleteButton).off('click');
					deletedGroup.off('mouseleave');
					deletedGroup.remove();
					accordionUnit.accordion( "refresh" );
					updateStaticSelector();
                }// end deleteStatic

                function updateStaticSelector(){
                	$('option', staticSelector).removeClass('hidden');
                	$('.group', _this).each(function(){
			    		staticId = $(this).data('static-id');
			    		$('option', staticSelector).each(function(){
			    			if(staticId == $(this).attr('value')){
			    				$(this).addClass('hidden');
			    			}
			    		})
			    	})
			    	if( $('.group', _this).length == staticSelectorLength ){
			    		staticSelector.val( 'asdasdasd' );
			    		staticSelector.attr('disabled', 'disabled');
			    	}
			    	$('option', staticSelector).each(function(){
			    		if(!$(this).hasClass('hidden')){
			    			staticSelector.val( $(this).attr('value') );
			    			staticSelector.removeAttr("disabled");
			    		}
			    	})
                }// end updateStaticSelector
                
            });
        },
        destroy    : function( ) { },
        update     : function( content ) { }
    };

    $.fn.cherryStaticEditor = function( method ){ 
        if ( methods[method] ) {
            return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
        } else if ( typeof method === 'object' || ! method ) {
            return methods.init.apply( this, arguments );
        } else {
            $.error( 'Method with name ' +  method + ' is not exist for jQuery.cherryAccordion' );
        }
    }//end plugin
})(jQuery)


