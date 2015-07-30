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
			this.ui_radio_init( target );
			// init Switcher
			CHERRY_API.ui_elements.switcher.init( target );
			this.ui_switcher_init( target );
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
		},
		ui_radio_init: function ( target ) {
			$('.cherry-radio-group', target).each(function(){
				$('.cherry-radio-input[type="radio"]', this).each(function(){
					var
						$this = $(this)
					,	this_slave = $this.data('slave')
					;
					if( !$this.is(':checked') ){
						$('[data-master=' + this_slave + ']', target).stop().hide();
					}

				})
			})
			$('.cherry-radio-input[type="radio"]', target).on('radio_change_event', function( event, slave, grouplist ){
				$('[data-master=' + slave + ']', target).stop().slideDown(300);
				grouplist.each(function(){
					var
						$this = $(this)
					,	this_slave = $this.data('slave')
					;

					if( this_slave !== slave ){
						$('[data-master=' + this_slave + ']', target).stop().slideUp(300);
					}
				})
			})
		},
		ui_switcher_init: function ( target ) {
			$('.cherry-switcher-wrap', target).each(function(){
				var
					input = $('.cherry-input-switcher', this)
				,	inputValue = input.attr('value')
				,	true_slave = input.data('true-slave')
				,	false_slave = input.data('false-slave')
				;

				if(inputValue == "false"){

					if( $('[data-master=' + true_slave + ']', target)[0] ){
						$('[data-master=' + true_slave + ']', target).hide();
					}
					if( $('[data-master=' + false_slave + ']', target)[0] ){
						$('[data-master=' + false_slave + ']', target).show();
					}
				}else{
					if( $('[data-master=' + true_slave + ']', target)[0] ){
						$('[data-master=' + true_slave + ']', target).show();
					}
					if( $('[data-master=' + false_slave + ']', target)[0] ){
						$('[data-master=' + false_slave + ']', target).hide();
					}

				}
			})

			$('.cherry-input-switcher', target).on('switcher_disabled_event', function( event, true_slave, false_slave ){
				if( $('[data-master=' + true_slave + ']', target)[0] ){
					$('[data-master=' + true_slave + ']', target).stop().slideUp(300);
				}
				if( $('[data-master=' + false_slave + ']', target)[0] ){
					$('[data-master=' + false_slave + ']', target).stop().slideDown(300);
				}
			})
			$('.cherry-input-switcher', target).on('switcher_enabled_event', function( event, true_slave, false_slave ){
				if( $('[data-master=' + true_slave + ']', target)[0] ){
					$('[data-master=' + true_slave + ']', target).stop().slideDown(300);
				}
				if( $('[data-master=' + false_slave + ']', target)[0] ){
					$('[data-master=' + false_slave + ']', target).stop().slideUp(300);
				}
			})
		}
	}
	CHERRY_API.interface_builder.init( $('body') );
}(jQuery));

