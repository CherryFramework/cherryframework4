/**
 * Range Slider
 */
(function($){
	"use strict";

	CHERRY_API.utilites.namespace('ui_elements.range_slider');
	CHERRY_API.ui_elements.range_slider = {
		init: function ( target ) {
			var self = this;

			if( CHERRY_API.status.document_ready ){
				self.render( target );
			}else{
				CHERRY_API.variable.$document.on('ready', self.render( target ) );
			}
		},
		render: function ( target ) {
			var
				rangeSliderSelector = $( ".cherry-range-slider-unit", target )
			;
			rangeSliderSelector.slider({
				animate: true,
				create: function( event, ui ) {
					$( this ).slider( "option", "min", $( this ).data('left-limit') );
					$( this ).slider( "option", "max", $( this ).data('right-limit') );
					$( this ).slider( "option", "values", [ $( this ).data('left-value'), $( this ).data('right-value')] );
					$( this ).slider( "option", "range", true );
				},
				slide: function( event, ui ) {
					var values = ui.values;
					$( this ).parent().siblings('.cherry-range-slider-left-input').find('input').val( values[ 0 ] );
					$( this ).parent().siblings('.cherry-range-slider-left-input').find('input').data({'max-value': values[ 1 ] });
					$( this ).parent().siblings('.cherry-range-slider-right-input').find('input').val( values[ 1 ] );
					$( this ).parent().siblings('.cherry-range-slider-right-input').find('input').data({'min-value': values[ 0 ] });
				}
			});
			$('.range-slider-left-stepper .cherry-ui-stepper-input', target).on('change', function(){
				var valuesRange = $(this).parent().parent().siblings('.cherry-range-slider-holder').find('.cherry-range-slider-unit').slider( "option", "values");
				valuesRange[0] = parseFloat($(this).val());
				$(this).parent().parent().siblings('.cherry-range-slider-holder').find('.cherry-range-slider-unit').slider( "option", "value", valuesRange );
			});
			$('.range-slider-right-stepper .cherry-ui-stepper-input', target).on('change', function(){
				var valuesRange = $(this).parent().parent().siblings('.cherry-range-slider-holder').find('.cherry-range-slider-unit').slider( "option", "values");
				valuesRange[1] = parseFloat($(this).val());
				$(this).parent().parent().siblings('.cherry-range-slider-holder').find('.cherry-range-slider-unit').slider( "option", "value", valuesRange );
			});
		}
	}
	$( window ).on( 'cherry-ui-elements-init',
		function( event, data ) {
			CHERRY_API.ui_elements.range_slider.init( data.target );
		}
	);
}(jQuery));
