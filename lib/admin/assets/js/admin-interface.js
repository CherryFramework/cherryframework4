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

			jQuery('.options-page-wrapper .current-theme').append('<div class="ajax-section-spinner"><div class="cherry-spinner cherry-spinner-chasing-dots"><div class="cherry-dot cherry-dot1"></div><div class="cherry-dot cherry-dot2"></div></div></div>');
			jQuery('.options-page-wrapper').on('click', '#cherry-import-options-file', uploadImportFile);
			jQuery('.options-page-wrapper').on('click', '#cherry-import-options-start', ajaxProcessImport);
			jQuery('.options-page-wrapper').on('click', '#cherry-import-options', switchImportBox);
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
							ajaxSpinner.fadeOut();

							cherryOptionsGroupList.prepend( response );
							jQuery.cherryInterfaceBuilder.CallInterfaceBuilder( jQuery('.options-group',cherryOptionsGroupList).eq(0) );
						},
						dataType: 'html'
					});
			}

			function uploadImportFile( event ) {

				event.preventDefault();

				var import_block = $(this).parents('.cherry-options-import'),
					input_id     = $('#cherry-import-options-file-id', import_block),
					input_type   = $('#cherry-import-options-file-type', import_block),
					name_holder  = $('.cherry-import-file-name', import_block),
					title_text   = $(this).text(),
					file_uploader;

				file_uploader = wp.media.frames.file_frame = wp.media({
					title: title_text,
					button: {text: title_text},
					multiple: false,
					library : { type : 'cherry/options' }
				});

				file_uploader.on('select', function() {
					var attachment = file_uploader.state().get('selection').toJSON(),
						file_data  = attachment[0],
						file_id    = file_data.id,
						file_type  = file_data.mime,
						file_title = file_data.title;

					name_holder.html('<span>' + file_title + '</span>');
					input_id.val(file_id);
					input_type.val(file_type);

				}).open();

				return !1;

			}

			function switchImportBox( event ) {

				event.preventDefault();

				var import_block = jQuery('.cherry-options-import');

				if ( import_block.hasClass('active') ) {
					import_block.removeClass('active').fadeOut('fast');
				} else {
					import_block.addClass('active').fadeIn('fast');
				}

			}

			function ajaxProcessImport( event ) {

				event.preventDefault();

				var button      = jQuery(this),
					nonce       = jQuery('#import-options-nonce').val(),
					file_id     = jQuery('#cherry-import-options-file-id').val(),
					file_type   = jQuery('#cherry-import-options-file-type').val(),
					import_wrap = jQuery('.cherry-options-import');

				jQuery( '.error', import_wrap ).remove();

				if ( button.hasClass( 'in-progress' ) ) {
					return !1;
				}

				if ( '' == file_id ) {
					import_wrap.append('<div class="error"><p>' + cherry_import_messages.no_file + '</p></div>');
					return !1;
				}

				if ( 'cherry/options' != file_type ) {
					import_wrap.append('<div class="error"><p>' + cherry_import_messages.invalid_type + '</p></div>');
					return !1;
				}

				jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {
						action: 'cherry_import_options',
						nonce: nonce,
						file: file_id,
						type: file_type
					},
					cache: false,
					beforeSend: function(){
						button.addClass('in-progress');
						button.next('.spinner').css('visibility', 'visible');
					},
					success: function(response){
						button.removeClass('in-progress');
						button
							.next('.spinner')
							.css('visibility', 'hidden')
							.after('<div class="updated"><p>' + cherry_import_messages.success + '</p></div>');
						window.location.href = cherry_import_messages.redirect_url;
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

