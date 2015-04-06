/**
 * Custom scripts needed for the cherry options page.
 */
(function( $ ) {
	'use strict';

	$.cherryOptionsPage = $.cherryOptionsPage || {};

	$.cherryOptionsPage.init = function( target ) {
		$( document ).ready(function() {
			var
				ajaxRequest = null
			,	ajaxRequestSuccess = true
			,	cherryOptionsWrap = jQuery('#cherry-options')
			,	cherryTabMenuList = jQuery('.vertical-tabs_ > li', cherryOptionsWrap)
			,	cherryOptionsGroupList = jQuery('.cherry-option-group-list', cherryOptionsWrap)
			,	cherryOptionGroupList = jQuery('.cherry-option-group-list > .options-group', cherryOptionsWrap)
			,	ajaxSpinner
			,	currentSectionName = ''
			,	active_section = ''
			,	activeSectionInput = jQuery('.active-section-field')
			,	activeSection = null
			;

			jQuery('.options-page-wrapper .current-theme').append('<span class="ajax-section-spinner"></span>');
			ajaxSpinner = jQuery('.options-page-wrapper .current-theme .ajax-section-spinner');

			// Find if a selected tab is saved in localStorage
			if ( $.cherryOptionsPage.isLocalStorageAvailable() ) {
				activeSection = localStorage.getItem('active-section');
			}
			if(activeSection != '' && activeSection != null){
				cherryTabMenuList.each(function(){
					if(jQuery(this).data('section-name') == activeSection){
						optionTabSwitcher( activeSection );
					}
				})
			}else{
				activeSection = cherryTabMenuList.eq(0).data('section-name');
				optionTabSwitcher( activeSection );
			}

			// Tab item click event
			cherryTabMenuList.on('click', function () {
				activeSection = jQuery(this).data('section-name');

				optionTabSwitcher( activeSection );

				if ( $.cherryOptionsPage.isLocalStorageAvailable() ) {
					localStorage.setItem('active-section', activeSection );
				}
			})

			// Tab switcher
			function optionTabSwitcher( section ){
				cherryTabMenuList.removeClass('active');
				cherryTabMenuList.each(function(){
					if( jQuery(this).data('section-name') == section ){
						jQuery(this).addClass('active');
					}
				})

				if( jQuery('.'+section, cherryOptionsGroupList).length !== 0 ){
					jQuery('.options-group', cherryOptionsGroupList).hide();
					jQuery('.'+section, cherryOptionsGroupList).fadeIn();
				}else{
					jQuery('.options-group', cherryOptionsGroupList).hide();
					ajaxRequestFunction();
				}

				activeSectionInput.attr('value', section);
			}

			function ajaxRequestFunction(){
				var
					data = {
						action: 'get_options_section',
						active_section: activeSection,
					};

					if( ajaxRequest != null && !ajaxRequestSuccess){
						ajaxRequest.abort();
					}

					ajaxRequest = jQuery.ajax({
						type: 'POST',
						url: ajaxurl,
						data: data,
						cache: false,
						beforeSend: function(){
							ajaxRequestSuccess = false;
							ajaxSpinner.fadeIn();
						},
						success: function(response){
							ajaxRequestSuccess = true;
							ajaxSpinner.hide();
							cherryOptionsGroupList.prepend( response );
							jQuery.cherryInterfaceBuilder.CallInterfaceBuilder( jQuery('.options-group',cherryOptionsGroupList).eq(0) );
						},
						dataType: 'html'
					});
			}

			// slide up notice
			jQuery(".options-page-wrapper .slide_up").delay(2000).slideUp(500);
		});//end document ready
	}
	$.cherryOptionsPage.isLocalStorageAvailable = function(){
		try {
			return 'localStorage' in window && window['localStorage'] !== null;
		} catch (e) {
			return false;
		}
	}
	$.cherryOptionsPage.init();
})(jQuery)

