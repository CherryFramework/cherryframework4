(function( $ ) {
	CHERRY_API.utilites.namespace('ui_elements.notice');

	CHERRY_API.ui_elements.notice = {
		notice_box : $('.notice'),
		init : function(){
			if(CHERRY_API.status.on_load === !0){
				CHERRY_API.ui_elements.notice.notice_show();
			}else{
				CHERRY_API.variable.$window.on( 'load', function () { CHERRY_API.ui_elements.notice.notice_show(); } );
			}
		},
		notice_show:function(){
			this.notice_box.slideDown(400);
		}
	}
	CHERRY_API.ui_elements.notice.init();
})( jQuery );