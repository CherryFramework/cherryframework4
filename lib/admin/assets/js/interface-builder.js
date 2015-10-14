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
			this.ui_checkbox_init( target );
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
			// init Tooltip
			CHERRY_API.ui_elements.tooltip.init( target );
			// init Webfont
			CHERRY_API.ui_elements.webfont.init( target );
		},
		ui_checkbox_init: function ( target ) {
			$('.cherry-checkbox-input[type="hidden"]', target).each(function(){
				var
					$this = $(this)
				,	this_slave = $this.data('slave')
				,	state = ( $this.val() === "true" )
				;

				if( !state ){
					$('.'+this_slave, target).stop().hide();
				}
			})
			$('.cherry-checkbox-input[type="hidden"]', target).on('checkbox_change_event', function( event, slave, state ){
				if( state ){
					$('.' + slave, target).stop().slideDown(300);
				}else{
					$('.' + slave, target).stop().slideUp(300);
				}
			})
		},
		ui_radio_init: function ( target ) {
			$('.cherry-radio-group', target).each(function(){
				$('.cherry-radio-input[type="radio"]', this).each(function(){
					var
						$this = $(this)
					,	this_slave = $this.data('slave')
					;
					if( !$this.is(':checked') ){
						$('.' + this_slave, target).stop().hide();
					}

				})
			})
			$('.cherry-radio-input[type="radio"]', target).on('radio_change_event', function( event, slave, grouplist ){
				$('.' + slave, target).stop().slideDown(300);
				grouplist.each(function(){
					var
						$this = $(this)
					,	this_slave = $this.data('slave')
					;

					if( this_slave !== slave ){
						$('.' + this_slave, target).stop().slideUp(300);
					}
				})
			})
		},
		ui_switcher_init: function ( target ) {
			$('.cherry-switcher-wrap', target).each(function(){
				var
					input = $('.cherry-input-switcher', this)
				,	inputValue = ( input.val() === "true" )
				,	true_slave = input.data('true-slave')
				,	false_slave = input.data('false-slave')
				;

				if(!inputValue){
					if( $('.' + true_slave, target)[0] ){
						$('.' + true_slave, target).hide();
					}
				}else{
					if( $('.' + false_slave, target)[0] ){
						$('.' + false_slave, target).hide();
					}
				}
			})

			$('.cherry-input-switcher', target).on('switcher_disabled_event', function( event, true_slave, false_slave ){
				if( $('.' + true_slave, target)[0] ){
					$('.' + true_slave, target).stop().slideUp(300);
				}
				if( $('.' + false_slave, target)[0] ){
					$('.' + false_slave, target).stop().slideDown(300);
				}
			})
			$('.cherry-input-switcher', target).on('switcher_enabled_event', function( event, true_slave, false_slave ){
				if( $('.' + true_slave, target)[0] ){
					$('.' + true_slave , target).stop().slideDown(300);
				}
				if( $('.' + false_slave, target)[0] ){
					$('.' + false_slave, target).stop().slideUp(300);
				}
			})
		}
	}
	CHERRY_API.interface_builder.init( $('body') );
}(jQuery));

