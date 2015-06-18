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
				,	dataName = _this.data('name');
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
