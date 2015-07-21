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
				,	availableStaticsWrapper = $('.available-statics .accordion-unit', _this)
				,	avaliableAreaName = $('.available-statics', _this).data('area')
				,	dataName = _this.data('name')
				,	ajaxRequestSuccess = true
				,	ajaxGetMinorSelectRequest = null
				;

				_constructor();
				function _constructor(){
					accordionUnit
					.accordion({
						header: "> div > h3",
						collapsible: true,
						active: false,
						animate: 300,
						icons: { "header": "ui-icon-plus", "activeHeader": "ui-icon-minus" },
						heightStyle: 'content'
					})
					.sortable({
						//axis: "y",
						handle: "h3",
						placeholder: "ui-state-highlight",
						connectWith: ".accordion-unit",
						beforeStop: function( event, ui ) {
							all_group = $(ui.item).parent();
							$('.group', all_group).each(function(){
								index = $(this).index();
								$('.key-position', this).val(index+1);
							})
						},
						receive: function( event, ui ) {
							new_area = $(ui.item).parent().parent().data('area');
							$('.key-area', ui.item).val( new_area );
							//accordionUnit.accordion( "refresh" );
						},
						start: function( event, ui ){
							var
								curr_area = $(ui.item).parent().parent().data('area')
							;
							$('.area-unit:not([data-area=' + curr_area + '])', _this).addClass('drag-target');

						},
						stop: function( event, ui ) {
							ui.item.children( "h3" ).triggerHandler( "focusout" );
							$('.area-unit', _this).removeClass('drag-target');
							//$( this ).accordion( "refresh" );
						}
					});

					addEventsFunction();
				}

				function addEventsFunction(){
					$('.delete-group', _this).on('click', function(){
						deleteGroup( $(this) );
						return false;
					});

					$('.add-rule-button', _this).on('click', function(){
						addRule( $(this) );
						return false;
					});

					$('.remove-rule-button', _this).on('click', function(){
						removeRule( $(this) );
						return false;
					});

					$('.rule-major-select', _this).on('change', function(){
						ajaxGetMinorSelect( $(this), $(this).val() );
					})
				}

				function deleteGroup(deleteButton){
					var
						deletedGroup = deleteButton.parent().parent()
					,	groupClone = jQuery( deletedGroup ).clone()
					;

					deletedGroup.slideUp( 300, function(){
						deleteButton.off('click');
						$(this).remove();

						availableStaticsWrapper.prepend( groupClone );

						$( '.key-area' , groupClone ).val( avaliableAreaName );
						$('.delete-group', groupClone).on('click', function(){
							deleteGroup( $(this) );
							return false;
						});
						groupClone.slideUp(0).slideDown( 300 );
						accordionUnit.accordion( "refresh" );
					});
				}// end deleteStatic

				function addRule( addButton ){
					var
						conditionsWrap = addButton.parents('.conditions')
					,	rulesWrapper = $('.conditions-rules', conditionsWrap)
					,	rules
					,	dublicateItem = $('.dublicate-item', conditionsWrap)
					,	clonedItem = dublicateItem.clone()
					,	dublicateItemName = dublicateItem.data('name')
					,	newItem = dublicateItem.data('name')
					;

					clonedItem.removeClass('dublicate-item');
					clonedItem.addClass('rule-item');
					rulesWrapper.append( clonedItem );
					rules = $('.rule-item', rulesWrapper);

					if ( rules.length !== 0 ) {
						conditionsWrap.removeClass('empty');
					};

					majorAttrName = dublicateItemName + '[' + (rules.length-1) + ']' + '[major]';
					minorAttrName = dublicateItemName + '[' + (rules.length-1) + ']' + '[minor]';
					$('select.rule-major-select', clonedItem).attr({name: majorAttrName});
					$('select.rule-minor-select', clonedItem).html('');
					$('select.rule-minor-select', clonedItem).attr({name: minorAttrName});

					$('select.rule-major-select', clonedItem).on('change', function(){
						ajaxGetMinorSelect( $(this), $(this).val() );
					})

					$('.remove-rule-button', clonedItem).on('click', function(){
						removeRule( $(this) );
						return false;
					});
				}

				function removeRule( removeButton ){
					var
						removingItem = removeButton.parent()
					,	conditionsWrap = removeButton.parents('.conditions')
					,	rulesList = removeButton.parents('.conditions-rules')
					;

					$('select.rule-major-select', removingItem).off('change');
					$('.remove-rule-button', removingItem).off('click');

					removingItem.remove();

					$('.rule-item', rulesList).each(function( index ){
						majorAttrName = $(this).data('name') + '[' + index + ']' + '[major]';
						minorAttrName = $(this).data('name') + '[' + index + ']' + '[minor]';
						$('select.rule-major-select', this).attr({name: majorAttrName});
						$('select.rule-minor-select', this).attr({name: minorAttrName});
					})
					if ( $('.rule-item', rulesList).length == 0 ) {
						conditionsWrap.addClass('empty');
					};
				}

				function removingReplace( removeButton ){

				}
				// Get minor select
				function ajaxGetMinorSelect( major_select,  majorType ){
					var
						data = {
							action: 'get_minor_select',
							major_type: majorType,
						}
					,	minor_select = major_select.parents('.rule-item').find('.rule-minor-select')
					;

					/*if( ajaxGetMinorSelectRequest != null ){
						ajaxGetMinorSelectRequest.abort();
					}*/

					ajaxGetMinorSelectRequest = jQuery.ajax({
						type: 'POST',
						url: ajaxurl,
						data: data,
						cache: false,
						beforeSend: function(){
							minor_select.attr({'disabled':'disabled'});
							minor_select.addClass('loading-state');
							minor_select.html('');
						},
						success: function( response ){
							minor_select.removeAttr('disabled');
							minor_select.removeClass('loading-state');
							minor_select.append( response );
						},
						dataType: 'html'
					});

					return false;
				}

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
