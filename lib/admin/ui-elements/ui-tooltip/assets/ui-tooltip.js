(function($){
	"use strict";

	CHERRY_API.utilites.namespace('ui_elements.tooltip');
	CHERRY_API.ui_elements.tooltip = {
		init: function ( target ) {
			var self = this;
			if( CHERRY_API.status.document_ready ){
				self.render( target );
			}else{
				CHERRY_API.variable.$document.on('ready', self.render( target ) );
			}
		},
		render: function ( target ) {
			jQuery( target ).tooltip({
				items: ".hint-text, .hint-image, .hint-video",
				content: function() {
					var element = jQuery( this );

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
				show: { duration: 100, delay: 200 },
				hide: { duration: 200 },
				close: function(event, ui){
					jQuery(ui.tooltip).off('mouseenter');
						ui.tooltip.one('mouseenter', function(){
							var clone = jQuery(ui.tooltip).clone();
							jQuery(this).parent().append(clone);
							clone.mouseleave(function(){
								clone.fadeOut(300, function(){ clone.remove(); } )
								//clone.remove();
							});
							//clone.css({opacity: 1, visibility: 'visible'});
						});
				},
				tooltipClass: "custom-tooltip-styling",
				position: {
					my: "left+1 center",
					at: "right center"
				}
			});
		}
	}
	$( window ).on( 'cherry-ui-elements-init',
		function( event, data ) {
			CHERRY_API.ui_elements.tooltip.init( data.target );
		}
	);
}(jQuery));