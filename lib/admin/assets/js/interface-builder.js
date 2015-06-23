/**
 * Interface builder
 */
(function($){
	"use strict";

	CHERRY_API.utilites.namespace('interface_builder');
	CHERRY_API.interface_builder = {
		init: function ( target ) {
			var self = this;
			if( CHERRY_API.status.document_ready ){
				self.render( target );
			}else{
				CHERRY_API.variable.$document.on('ready', self.render( target ) );
			}
		},
		render: function ( target ) {
			// init Checkbox
			CHERRY_API.ui_elements.checkbox.init( target );
			// init Select
			CHERRY_API.ui_elements.select.init( target );
			// init Radio
			CHERRY_API.ui_elements.radio.init( target );
			// init Switcher
			CHERRY_API.ui_elements.switcher.init( target );
			// init Colorpickers
			CHERRY_API.ui_elements.colorpicker.init( target );
			// init Repeater
			CHERRY_API.ui_elements.repeater.init( target );
			// init Media
			CHERRY_API.ui_elements.media.init( target );
			// init Stepper
			CHERRY_API.ui_elements.stepper.init( target );
			// init Slider
			CHERRY_API.ui_elements.slider.init( target );
			// init Range Slider
			CHERRY_API.ui_elements.range_slider.init( target );
			//init Typography
			CHERRY_API.ui_elements.typography.init( target);
			// init Ace Editor
			CHERRY_API.ui_elements.ace_editor.init( target );
			// init Layout Editor
			CHERRY_API.ui_elements.layout_editor.init( target );
			// init static_editor
			CHERRY_API.ui_elements.static_area_editor.init( target );
			// init Tooltip
			CHERRY_API.ui_elements.tooltip.init( target );
		}
	}
	CHERRY_API.interface_builder.init( $('body') );
}(jQuery));

