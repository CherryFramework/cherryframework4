/**
 * Static page
 */

(function($){
	"use strict";

	CHERRY_API.utilites.namespace('admin_page.statics');
	CHERRY_API.admin_page.statics = {
		init: function ( ) {
			var self = this;
			if( CHERRY_API.status.document_ready ){
				self.render();
			}else{
				CHERRY_API.variable.$document.on('ready', self.render() );
			}
		},
		render: function ( target ) {
			var
				self = this
			,	ajaxSaveStaticsRequest = null
			,	ajaxRestoreStaticsRequest = null
			,	ajaxRequestSuccess = true
			,	sectionsWrap = jQuery('#cherry-statics')
			,	saveSections = jQuery('#cherry-save-statics', sectionsWrap)
			,	restoreSections = jQuery('#cherry-restore-statics', sectionsWrap)
			,	defaultSectionsBackup = jQuery('#cherry-default-statics-backup', sectionsWrap)
			,	eventStatus = null
			;

			if ( self.isLocalStorageAvailable() ) {
				eventStatus = localStorage.getItem('statics-event-status');
				switch ( eventStatus ){
					case 'statics-restore':
						// restore options notice
						self.noticeCreate( 'info-notice', cherry_statics_page_data.statics_restore );
						localStorage.removeItem('statics-event-status');
					break;
					/*case 'import-options-success':
						// import success notice
						$.cherryOptionsPage.noticeCreate( 'success-notice', cherry_options_page_data.success );
						localStorage.removeItem('options-event-status');
					break;*/
				}
			}

			saveSections.on('click', ajaxSaveStatics );
			restoreSections.on('click', ajaxRestoreStatics );
			defaultSectionsBackup.on('click', ajaxDefaultSectionsBackup );

			// Save sections
			function ajaxSaveStatics( event ){
				var
					serializeObject = $('#cherry-statics').serializeObject()
				,	data = {
						action: 'cherry_save_statics',
						static_array: serializeObject.statics,
					}
				;

				if( ajaxSaveStaticsRequest != null && !ajaxRequestSuccess ){
					ajaxSaveStaticsRequest.abort();
				}

				ajaxSaveStaticsRequest = jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: data,
					cache: false,
					beforeSend: function(){
						ajaxRequestSuccess = false;
						$('#cherry-save-statics').addClass('spinner-state');
					},
					success: function(response){
						ajaxRequestSuccess = true;
						setTimeout( function () { $('#cherry-save-statics').removeClass('spinner-state'); }, 1000 );
						self.noticeCreate( response.type, response.message );
					},
					dataType: 'json'
				});

				return false;
			}
			// Restore sections
			function ajaxRestoreStatics( event ){
				var
					data = {
						action: 'cherry_restore_statics'
					};

					if( ajaxRestoreStaticsRequest != null && !ajaxRequestSuccess ){
						ajaxRestoreStaticsRequest.abort();
					}

					ajaxRestoreStaticsRequest = jQuery.ajax({
						type: 'POST',
						url: ajaxurl,
						data: data,
						cache: false,
						beforeSend: function(){
							ajaxRequestSuccess = false;
							localStorage.setItem('statics-event-status', 'statics-restore' );
						},
						success: function(response){
							ajaxRequestSuccess = true;
							window.location.href = cherry_statics_page_data.redirect_url;
						},
						dataType: 'json'
					});

				return false;
			}
			// Default sections
			function ajaxDefaultSectionsBackup( event ){
				var
					serializeObject = $('#cherry-statics').serializeObject()
				,	data = {
						action: 'default_statics_backup',
						static_array: serializeObject.statics,
					}
				;

				if( ajaxSaveStaticsRequest != null && !ajaxRequestSuccess ){
					ajaxSaveStaticsRequest.abort();
				}

				ajaxSaveStaticsRequest = jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: data,
					cache: false,
					beforeSend: function(){
						ajaxRequestSuccess = false;
						$('#cherry-default-statics-backup').addClass('spinner-state');
					},
					success: function(response){
						ajaxRequestSuccess = true;
						setTimeout( function () { $('#cherry-default-statics-backup').removeClass('spinner-state'); }, 1000 );
						self.noticeCreate( response.type, response.message );
					},
					dataType: 'json'
				});

				return false;
			}

		},// end render
		noticeCreate: function( type, message ){
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
		},
		isLocalStorageAvailable: function(){
			try {
				return 'localStorage' in window && window['localStorage'] !== null;
			} catch (e) {
				return false;
			}
		}
	}// end admin_page.statics

	CHERRY_API.admin_page.statics.init();

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
	///
}(jQuery));

			// Save statics
			/**/