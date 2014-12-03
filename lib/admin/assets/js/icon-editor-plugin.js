// cherryIconSetsEditor plugin
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
				,	listWraper = $('.icon-list-preview > ul', _this)
				,	dataName = _this.data('name');
				;

				_constructor();
				function _constructor(){
					addEventsFunction();
				}

				function addEventsFunction(){
					$('.control > .delete', listWraper).each(function(){
						addClickEventDeteleIcon( $(this) );
					})

					$('.add-new-icon', _this).on('click', function(){
						createIconItem();
					})
				}

				function addClickEventDeteleIcon(target){
					target.on('click', function(){
						removeIconItem( $(this) );
					})
				}
				function removeClickEventDeteleIcon(target){
					target.off('click');
				}

				function createIconItem(){
					var newIconItem, type, label, iconId, iconlink, iconFontClass, iconSpriteClass, iconUploadLink;
					type = $('.icon-type-selector', _this).val();
					label = $('.icon-label', _this).val();
					iconId = $('.icon-id', _this).val();
					iconlink = $('.icon-link', _this).val();
					iconFontClass = $('.icon-font-class', _this).val();
					iconSpriteClass = $('.icon-sprite-class', _this).val();
					iconUploadLink = $('.cherry-upload-input', _this).val();

					newli = document.createElement('li');
					newli.setAttribute('class', 'icon-type-'+ type );
					newIconItem = $(newli);
					newIconItem.append("<div class='inner'></div>");
					$('.inner', newIconItem).append("<div class='icon-info'><span class='icon-title'>"++"</span></div>");
					$('.inner', newIconItem).append("<div class='control'><span class='edit dashicons dashicons-edit'></span><span class='delete dashicons dashicons-no'></span></div><div class='clear'></div>");

					switch ( type ){
						case 'label':

						break;
						case 'image':

						break;
						case 'font':

						break;
						case 'sprite':

						break;
					}

					listWraper.append(newIconItem);
				}
				function removeIconItem( target ){
					removeClickEventDeteleIcon( target );
					target.parent().parent().parent().remove();
				}
			});
		},
		destroy    : function( ) { },
		update     : function( content ) { }
	};

	$.fn.cherryIconEditor = function( method ){
		if ( methods[method] ) {
			return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method with name ' +  method + ' is not exist for jQuery.cherryIconSetsEditor' );
		}
	}//end plugin
})(jQuery)
