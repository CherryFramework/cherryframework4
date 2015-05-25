(function( $ ) {
	CHERRY_API.utilites.namespace('interfacebuilder.notice');

	CHERRY_API.interfacebuilder.notice = {
		notice_box : $('.notice'),
		init : function(){
			if(CHERRY_API.status.on_load === !0){
				CHERRY_API.interfacebuilder.notice.notice_show();
			}else{
				CHERRY_API.variable.$window.on( 'load', function () { CHERRY_API.interfacebuilder.notice.notice_show(); } );
			}
		},
		notice_show:function(){
			this.notice_box.slideDown(400);
		}
	}
	CHERRY_API.interfacebuilder.notice.init();
})( jQuery );