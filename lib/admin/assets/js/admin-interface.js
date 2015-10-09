/**
 * Custom scripts needed for the cherry options page.
 */
(function( $ ) {
	'use strict';

	$.cherryOptionsPage = $.cherryOptionsPage || {};
	$.cherryOptionsPage.init = function( target ) {
		$( document ).ready(function() {
			var
				ajaxGetSectionOptionsRequest = null
			,	ajaxSetDefaultOptions = null
			,	ajaxSaveOptionsRequest = null
			,	ajaxExportOptionsRequest = null
			,	ajaxRestoreOptionsRequest = null
			,	ajaxRestoreSectionRequest = null
			,	ajaxRequestSuccess = true
			,	cherryOptionsWrap = jQuery('#cherry-options')
			,	cherryTabMenuList = jQuery('.vertical-tabs_ > li', cherryOptionsWrap)
			,	cherrySectionsList = jQuery('.cherry-option-section-tab', cherryOptionsWrap)
			,	cherryOptionsGroupList = jQuery('.cherry-option-group-list', cherryOptionsWrap)
			,	cherryOptionGroupList = jQuery('.cherry-option-group-list > .options-group', cherryOptionsWrap)
			,	cherryOptionPageWrapper = jQuery('#options')
			,	ajaxSpinner
			,	currentSectionName = ''
			,	active_section = ''
			,	activeSectionInput = jQuery('.active-section-field')
			,	activeSection = null
			,	eventStatus = null
			,	noticeCounter = 0
			,	confirm_yes = cherry_options_page_data.confirm_button
			,	confirm_no = cherry_options_page_data.cancel_button
			;

			// append ajax spinner
			jQuery('.cherry-page-title', cherryOptionPageWrapper).append('<div class="ajax-section-spinner"><div class="cherry-spinner-wordpress spinner-wordpress-type-1"><span class="cherry-inner-circle"></span></div></div>');
			ajaxSpinner = jQuery('.cherry-page-title .ajax-section-spinner', cherryOptionPageWrapper);

			// set cherryOptionsGroupList min-height
			cherryOptionsGroupList.css({ 'min-height': cherrySectionsList.outerHeight(true) });

			// Tab item click event
			cherryTabMenuList.on('click', function () {
				activeSection = jQuery(this).data('section-name');

				optionTabSwitcher( activeSection );

				if ( $.cherryOptionsPage.isLocalStorageAvailable() ) {
					localStorage.setItem('active-section', activeSection );
				}
			})
			//save options
			jQuery('#cherry-save-options', cherryOptionsWrap).on('click', ajaxSaveOptions );
			//save restore section
			jQuery('#cherry-restore-section', cherryOptionsWrap).on('click', function(){
				$( "#restore-section-confirm" ).dialog('open');
			} );
			//save restore options
			jQuery('#cherry-restore-options', cherryOptionsWrap).on('click', function(){
				$( "#restore-options-confirm" ).dialog('open');
			});

			$( "#restore-options-confirm" ).dialog({
				autoOpen: false,
				resizable: true,
				modal: true,
				height: 185,
				buttons: [
					{
						text: confirm_yes,
						click: function() {
							$( this ).dialog( "close" );
							ajaxRestoreOptions();
						}
					},
					{
						text: confirm_no,
						click: function() {
							$( this ).dialog( "close" );
						}
					}
				],
				create: function (event, ui) {
					$(event.target).parent().css('position', 'fixed');
				}
			});

			$( "#restore-section-confirm" ).dialog({
				autoOpen: false,
				resizable: true,
				modal: true,
				height: 185,
				buttons: [
					{
						text: confirm_yes,
						click: function() {
							$( this ).dialog( "close" );
							ajaxRestoreSection();
						}
					},
					{
						text: confirm_no,
						click: function() {
							$( this ).dialog( "close" );
						}
					}
				],
				create: function (event, ui) {
					$(event.target).parent().css('position', 'fixed');
				}
			});

			// Import/Export Event Listeners
			cherryOptionPageWrapper.on('click', '#cherry-import-options-file', uploadImportFile )
				.on('click', '#cherry-import-options-start', ajaxProcessImport )
				.on('click', '#cherry-export-import-options', switchImportBox )
				.on('click', '#cherry-default-options-backup', defaultOptionsBackup )
				.on('click', '#cherry-partial-export-options', partialExportOptions );

			// Find if a selected tab is saved in localStorage
			if ( $.cherryOptionsPage.isLocalStorageAvailable() ) {
				activeSection = localStorage.getItem('active-section');
				eventStatus = localStorage.getItem('options-event-status');
				switch ( eventStatus ){
					case 'section-restore':
						// restore section notice
						var message = '<b>' + $('[data-section-name='+activeSection+'] a span').html()+'</b> '+cherry_options_page_data.section_restore;
						$.cherryOptionsPage.noticeCreate( 'info-notice', message );
						localStorage.removeItem('options-event-status');
					break;
					case 'options-restore':
						// restore options notice
						$.cherryOptionsPage.noticeCreate( 'info-notice', cherry_options_page_data.options_restore );
						localStorage.removeItem('options-event-status');
					break;
					case 'import-options-success':
						// import success notice
						$.cherryOptionsPage.noticeCreate( 'success-notice', cherry_options_page_data.success );
						localStorage.removeItem('options-event-status');
					break;
				}
			}
			if(activeSection != '' && activeSection != null){
				cherryTabMenuList.each(function(){
					if(jQuery(this).data('section-name') == activeSection){
						optionTabSwitcher( activeSection );
					}
					if( $('[data-section-name=' + activeSection + ']').length == 0 ){
						activeSection = cherryTabMenuList.eq(0).data('section-name');
						optionTabSwitcher( activeSection );
					}
				})
			}else{
				activeSection = cherryTabMenuList.eq(0).data('section-name');
				optionTabSwitcher( activeSection );
			}

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
					getSectionOptions();
				}

				activeSectionInput.attr('value', section);
			}

			// Get options section
			function getSectionOptions(){
				var
					data = {
						action: 'get_options_section',
						active_section: activeSection,
					};

					if( ajaxGetSectionOptionsRequest != null && !ajaxRequestSuccess){
						ajaxGetSectionOptionsRequest.abort();
					}

					ajaxGetSectionOptionsRequest = jQuery.ajax({
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
							/*jQuery('.options-group',cherryOptionsGroupList).eq(0).css({display: 'none'});
							CHERRY_API.utilites.get_compress_assets( CHERRY_API.ui_elements.tmp_assets, function(){
								jQuery('.options-group',cherryOptionsGroupList).eq(0).css({display: 'block'});
							} );*/
							var message = '<b>' + $('[data-section-name='+activeSection+'] a span').html()+'</b> '+cherry_options_page_data.section_loaded;
							$.cherryOptionsPage.noticeCreate( 'success-notice', message );
							CHERRY_API.interface_builder.init( jQuery('.options-group',cherryOptionsGroupList).eq(0) );

							var import_block = jQuery('.export-import-wrapper');
							if ( import_block.hasClass('active') ) {
								jQuery('.exclusion-check').show();
							}
						},
						dataType: 'html'
					});
			}
			// Upload import file
			function uploadImportFile( event ) {
				event.preventDefault();

				var import_block = $(this).parents('.export-import-wrapper'),
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
			// Switch import box
			function switchImportBox( event ) {
				event.preventDefault();

				var import_block = jQuery('.export-import-wrapper');

				if ( import_block.hasClass('active') ) {
					import_block.removeClass('active').slideUp('fast');
					jQuery('.exclusion-check').hide();
				} else {
					import_block.addClass('active').slideDown('fast');
					jQuery('.exclusion-check').show();
				}
			}

			// Process Import
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
					$.cherryOptionsPage.noticeCreate( 'error-notice', cherry_options_page_data.no_file );
					return !1;
				}

				if ( 'cherry/options' != file_type ) {
					$.cherryOptionsPage.noticeCreate( 'error-notice', cherry_options_page_data.invalid_type );
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
						localStorage.setItem('options-event-status', 'import-options-success' );
						$('#cherry-import-options-start').addClass('spinner-state');
					},
					success: function(response){
						$('#cherry-import-options-start').removeClass('spinner-state');
						button.removeClass('in-progress');
						$.cherryOptionsPage.noticeCreate( 'success-notice', cherry_options_page_data.success );
						window.location.href = cherry_options_page_data.redirect_url;
					},
					dataType: 'html'
				});
			}
			// Partial Export options
			function partialExportOptions( event ) {
				var
					serializeObject = $('#cherry-options').serializeObject()
				,	serializeCherry = serializeObject.cherry
				,	serializeExclusion = serializeObject.exclusion
				,	data = {}
				;

				for( var key in serializeCherry ) {
					if( 'false' === serializeExclusion[key] ){
						delete serializeCherry[key]
					}
				}
				// empty object check
				if( $.isEmptyObject(serializeCherry) ){
					$.cherryOptionsPage.noticeCreate( 'error-notice', cherry_options_page_data.partial_empty );
					return false;
				}

				data = {
					action: 'cherry_partial_export_url',
					export_array: serializeCherry,
					_wpnonce: jQuery('#partial-export-nonce').val()
				}
				if( ajaxExportOptionsRequest != null && !ajaxRequestSuccess ){
					ajaxExportOptionsRequest.abort();
				}

				ajaxExportOptionsRequest = jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: data,
					cache: false,
					beforeSend: function(){
						ajaxRequestSuccess = false;
						$('#cherry-partial-export-options').addClass('spinner-state');
					},
					success: function(response){
						ajaxRequestSuccess = true;
						$('#cherry-partial-export-options').removeClass('spinner-state');
						$.cherryOptionsPage.noticeCreate( 'success-notice', cherry_options_page_data.download_started );
						document.location.href = response;
					},
					dataType: 'html'
				});

				return false;
			}
			// Save options
			function ajaxSaveOptions( event ){
				var
					serializeObject
				,	data = {}
				;

				$('#cherry-options .cherry-multi-select').each(function(){
					if( $(this).val() == null ){
						$(this).val('');
					}
				})

				serializeObject = $('#cherry-options').serializeObject()
				data = {
					action: 'cherry_save_options',
					post_array: serializeObject.cherry,
				}

				if( ajaxSaveOptionsRequest != null && !ajaxRequestSuccess ){
					ajaxSaveOptionsRequest.abort();
				}

				ajaxSaveOptionsRequest = jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: data,
					cache: false,
					beforeSend: function(){
						ajaxRequestSuccess = false;
						$('#cherry-save-options').addClass('spinner-state');
					},
					success: function(response){
						ajaxRequestSuccess = true;
						setTimeout( function () { $('#cherry-save-options').removeClass('spinner-state'); }, 1000 );
						$.cherryOptionsPage.noticeCreate( response.type, response.message );
						if( response.success ){
							//console.log("json");
						}
					},
					dataType: 'json'
				});

				return false;
			}
			// Restore section
			function ajaxRestoreSection( event ){
				var
					data = {
						action: 'cherry_restore_section'
					,	current_section: $('input.active-section-field').val()
					};

					if( ajaxRestoreSectionRequest != null && !ajaxRequestSuccess ){
						ajaxRestoreSectionRequest.abort();
					}

					ajaxRestoreSectionRequest = jQuery.ajax({
						type: 'POST',
						url: ajaxurl,
						data: data,
						cache: false,
						beforeSend: function(){
							ajaxRequestSuccess = false;
							localStorage.setItem('options-event-status', 'section-restore' );
						},
						success: function(response){
							ajaxRequestSuccess = true;
							window.location.href = cherry_options_page_data.redirect_url;
						},
						dataType: 'json'
					});

				return false;
			}
			// Restore options
			function ajaxRestoreOptions( event ){

				var
					data = {
						action: 'cherry_restore_options'
					};

					if( ajaxRestoreOptionsRequest != null && !ajaxRequestSuccess ){
						ajaxRestoreOptionsRequest.abort();
					}

					ajaxRestoreOptionsRequest = jQuery.ajax({
						type: 'POST',
						url: ajaxurl,
						data: data,
						cache: false,
						beforeSend: function(){
							ajaxRequestSuccess = false;
							localStorage.setItem('options-event-status', 'options-restore' );
						},
						success: function(response){
							ajaxRequestSuccess = true;
							window.location.href = cherry_options_page_data.redirect_url;
						},
						dataType: 'json'
					});

				return false;
			}
			// Create defaults options
			function defaultOptionsBackup( event ){
				var
					serializeObject = $('#cherry-options').serializeObject()
				,	data = {
						action: 'default_options_backup',
						post_array: serializeObject.cherry,
					}
				;

				if( ajaxSetDefaultOptions != null && !ajaxRequestSuccess){
					ajaxSetDefaultOptions.abort();
				}

				ajaxSetDefaultOptions = jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: data,
					cache: false,
					beforeSend: function(){
						ajaxRequestSuccess = false;

						$('#cherry-default-options-backup').addClass('spinner-state');
					},
					success: function(response){
						ajaxRequestSuccess = true;
						setTimeout( function () { $('#cherry-default-options-backup').removeClass('spinner-state'); }, 1000 );
						$.cherryOptionsPage.noticeCreate( response.type, response.message );
					},
					dataType: 'json'
				});

				return false;
			}

		});//end document ready
	}
	$.cherryOptionsPage.noticeCreate = function( type, message ){
		var
			notice = $('<div class="notice-box ' + type + '"><span class="dashicons"></span><div class="inner">' + message + '</div></div>')
		,	rightDelta = 0
		,	timeoutId
		;

		jQuery('body').prepend( notice );
		reposition();
		rightDelta = -1*(notice.outerWidth( true ) + 10);
		notice.css({'right' : rightDelta });

		timeoutId = setTimeout( function () { notice.css({'right' : 10 }).addClass('show-state') }, 100 );
		timeoutId = setTimeout( function () {
			rightDelta = -1*(notice.outerWidth( true ) + 10);
			notice.css({ right: rightDelta }).removeClass('show-state');
		}, 4000 );
		timeoutId = setTimeout( function () { notice.remove(); clearTimeout(timeoutId); }, 4500 );

			function reposition(){
				var
					topDelta = 100
				;
				$('.notice-box').each(function( index ){
					$( this ).css({ top: topDelta });
					topDelta += $(this).outerHeight(true);
				})
			}
	}
	$.cherryOptionsPage.isLocalStorageAvailable = function(){
		try {
			return 'localStorage' in window && window['localStorage'] !== null;
		} catch (e) {
			return false;
		}
	}
	$.cherryOptionsPage.init();

	///////////////////
	$.fn.serializeObject = function(){

		var self = this,
			json = {},
			push_counters = {},
			patterns = {
				"validate": /^[a-zA-Z][a-zA-Z0-9_-]*(?:\[(?:\d*|[a-zA-Z0-9_-]+)\])*$/,
				"key":      /[a-zA-Z0-9_-]+|(?=\[\])/g,
				"push":     /^$/,
				"fixed":    /^\d+$/,
				"named":    /^[a-zA-Z0-9_-]+$/
			};

		this.build = function(base, key, value){
			base[key] = value;
			return base;
		};

		this.push_counter = function(key){
			if(push_counters[key] === undefined){
				push_counters[key] = 0;
			}
			return push_counters[key]++;
		};

		$.each($(this).serializeArray(), function(){
			// skip invalid keys
			if(!patterns.validate.test(this.name)){
				return;
			}

			var k,
				keys = this.name.match(patterns.key),
				merge = this.value,
				reverse_key = this.name;

			while((k = keys.pop()) !== undefined){

				// adjust reverse_key
				reverse_key = reverse_key.replace(new RegExp("\\[" + k + "\\]$"), '');

				// push
				if(k.match(patterns.push)){
					merge = self.build([], self.push_counter(reverse_key), merge);
				}

				// fixed
				else if(k.match(patterns.fixed)){
					merge = self.build([], k, merge);
				}

				// named
				else if(k.match(patterns.named)){
					merge = self.build({}, k, merge);
				}
			}

			json = $.extend(true, json, merge);
		});

		return json;
	};
	///////////////////
})(jQuery)
