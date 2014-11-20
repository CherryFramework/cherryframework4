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
							//accordionUnit.accordion( "refresh" );
						},
						stop: function( event, ui ) {
							ui.item.children( "h3" ).triggerHandler( "focusout" );
							//$( this ).accordion( "refresh" );
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

					$('.ui-accordion-content .key-col-xs', newGroup).val('none');
					$('.ui-accordion-content .key-col-sm', newGroup).val('none');
					$('.ui-accordion-content .key-col-md', newGroup).val('none');
					$('.ui-accordion-content .key-col-lg', newGroup).val('none');
					$('.ui-accordion-content .key-custom-class', newGroup).val('custom-class');

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
						staticSelector.val( '' );
						staticSelector.attr('disabled', 'disabled');
						//addStaticButton.attr('disabled', 'disabled');
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
