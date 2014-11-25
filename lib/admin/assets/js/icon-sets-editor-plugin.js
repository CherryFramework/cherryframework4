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
				;

				_constructor();
				function _constructor(){
					addEventsFunction();
				}

				function addEventsFunction(){

				}
			});
		},
		destroy    : function( ) { },
		update     : function( content ) { }
	};

	$.fn.cherryIconSetsEditor = function( method ){
		if ( methods[method] ) {
			return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method with name ' +  method + ' is not exist for jQuery.cherryIconSetsEditor' );
		}
	}//end plugin
})(jQuery)
