/**
 * Switcher
 */
(function( $ ) {
	'use strict';

	$.uiElements = $.uiElements || {};
	$.uiElements.UIswitcher = $.uiElements.UIswitcher || {};

	$.uiElements.UIswitcher.init = function( target ) {
		$('.cherry-switcher-wrap', target).each(function(){
			var inputValue = $('.cherry-input-switcher', this).attr('value');
				if(inputValue == "false"){
					$('.sw-enable', this).removeClass('selected');
					$('.sw-disable', this).addClass('selected');
				}else{
					$('.sw-enable', this).addClass('selected');
					$('.sw-disable', this).removeClass('selected');
				}
		})

		$('.cherry-switcher-wrap', target).on('click', function () {
			var
				input = $('.cherry-input-switcher', this)
			,	inputValue = input.attr('value')
			;
			if(inputValue == "false"){
				$('.sw-enable', this).addClass('selected');
				$('.sw-disable', this).removeClass('selected');
				input.attr('value', true );
			}
			if(inputValue == "true"){
				$('.sw-disable', this).addClass('selected');
				$('.sw-enable', this).removeClass('selected');
				input.attr('value', false );

			}
		})
	}

})( jQuery );