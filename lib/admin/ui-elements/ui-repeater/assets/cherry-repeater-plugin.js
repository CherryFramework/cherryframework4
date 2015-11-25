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
					_this = $(this) ,
					itemList = $('.cherry-repeater-item-list', _this) ,
					addItemButton = $('.repeater-add-button-holder .repeater-add-button', _this) ,
					dataName = _this.data('name'),
					sortableInit = function(){
						itemList.sortable({
							items: 'div.cherry-repeater-item',
							cursor: 'move',
							scrollSensitivity:40,
							forcePlaceholderSize: true,
							forceHelperSize: false,
							helper: 'clone',
							opacity: 0.65,
							placeholder: 'sortable-placeholder',
							start:function(event,ui){
								itemHeight = $(".cherry-repeater-item", this).innerHeight();
								$(".sortable-placeholder", this).height( itemHeight );
							},
							stop:function(event,ui) {},
							update: function(event, ui) {
								reindexItem();
							}
						});
					},
					addEventsFunction = function(){
						addItemButton.on('click', function(){
							createItem();
						});
						$('.cherry-repeater-item', itemList).each(function(){
							var item = $( this );
							$('.repeater-delete-button', this).on('click', function(){
								deleteItem( item );
							});
						})
					},
					createItem = function(){
						var
							newItem
						,	itemLength = $('.cherry-repeater-item', itemList).length
						;
						newItem = $('.cherry-repeater-dublicate-item', itemList).clone();
						newItem.attr({"class":"cherry-repeater-item"});

						externalLinkName = dataName + '[' + itemLength + '][external-link]';
						$('.external-link', newItem).attr({"name": externalLinkName });

						iconClassName = dataName + '[' + itemLength + '][font-class]';
						$('.font-class', newItem).attr({"name": iconClassName });

						linkLabelName = dataName + '[' + itemLength + '][link-label]';
						$('.link-label', newItem).attr({"name": linkLabelName });

						networkIdName = dataName + '[' + itemLength + '][network-id]';
						$('.network-id', newItem).attr({"name": networkIdName }).val('network-' + itemLength);

						$('.repeater-delete-button', newItem).on('click', function(){
							deleteItem( newItem );
						})
						itemList.append(newItem).sortable( "refresh" );
						itemList = $('.cherry-repeater-item-list', _this);
					},
					deleteItem = function( item ){
						$(item).remove();
						reindexItem();
						itemList.sortable( "refresh" );
					},
					reindexItem = function(){
						$('.cherry-repeater-item', itemList).each(function( index ){
							externalLinkName = dataName + '[' + index + '][external-link]';
							$('.external-link', this).attr({"name": externalLinkName });

							iconClassName = dataName + '[' + index + '][font-class]';
							$('.font-class', this).attr({"name": iconClassName });

							linkLabelName = dataName + '[' + index + '][link-label]';
							$('.link-label', this).attr({"name": linkLabelName });

							linkNetworkName = dataName + '[' + index + '][network-id]';
							$('.network-id', this).attr({"name": linkNetworkName }).val('network-' + index);
						})
					}
					constructor = function(){
						sortableInit();
						addEventsFunction();
					}
				;

				constructor();

			});
		},
		destroy    : function( ) { },
		update     : function( content ) { }
	};

	$.fn.cherryRepeater = function( method ){
		if ( methods[method] ) {
			return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method with name ' +  method + ' is not exist for jQuery.cherryRepeater' );
		}
	}//end plugin
})(jQuery)
