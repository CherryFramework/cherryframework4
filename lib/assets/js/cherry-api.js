var CHERRY_API;

(function($){
	'use strict';

	CHERRY_API = {
		name : 'Cherry Js API',
		varsion : '1.0.0',
		author : 'Cherry Team',

		variable : {
			$document : $( document ),
			$window : $( window ),
			browser : $.browser,
			browser_supported : true,
			security : cherry_ajax,
			loaded_assets : {
				script : wp_load_style,
				style : wp_load_script
			}
		},

		status : {
			on_load : false,
			is_ready : false
		},

		init : function(){

			CHERRY_API.set_variable ();

			$( document ).ready( CHERRY_API.ready );

			$( window ).load( CHERRY_API.load );
		},

		set_variable : function(){
			//set variable browser_supported
			CHERRY_API.variable.browser_supported = ( function (){
				var uset_browser = CHERRY_API.variable.browser,
					not_supported = { 'msie' : [8] };

				for ( var browser in not_supported ) {
					if( uset_browser.browser  != 'undefined' ){
						for ( var version in not_supported[ browser ] ) {
							if( uset_browser.version <= not_supported [ browser ] [ version ] ){
								return false;
							}
						}
					}
				};

				return true;
			}() )
		},

		ready : function(){
			CHERRY_API.status.is_ready = true;
		},

		load : function(){
			CHERRY_API.status.on_load = true;
		},

		utilites : {
			namespace : function( space_path ){
				var parts = space_path.split( '.' ),
					parent = CHERRY_API,
					length = parts.length,
					i = 0;

					for(i = 0; i < length; i += 1 ){
						if( typeof parent[ parts[ i ] ] === 'undefined' ){
							parent[ parts[ i ] ] = {};
						}
						parent = parent[ parts[ i ] ];
					}
				return parent;
			},
			get_compress_assets: function ( url, callback ){
				var data = {
					action : 'get_compress_assets',
					security : CHERRY_API.variable.security,
					style : [],
					script : []
					},
					reg_name = /([\S.]+\/)/gmi,
					reg_type = /(\.js|\.css)/gmi,
					callback_function = callback || function(){};

				if( !$.isArray( url ) ){
					url = [ url ];
				}

				for( var index in url ){
					var file_url = url[ index ],
						file_name = file_url.replace( reg_name, '' ),
						file_type = file_url.match( reg_type )[ 0 ];

					if( file_type === '.js' && $.inArray( file_name, CHERRY_API.variable.loaded_assets.script ) == -1 ){
						data.script.push( file_url );
						CHERRY_API.variable.loaded_assets.script.push( file_name );
					}

					if( file_type === '.css' && $.inArray( file_name, CHERRY_API.variable.loaded_assets.style ) == -1 ){
						data.style.push( file_url );
						CHERRY_API.variable.loaded_assets.style.push( file_name );
					}
				}

				$.get(ajaxurl, data, function(response) {
					var json = $.parseJSON(response),
						compress_style = json.style,
						compress_script = json.script;

					if(compress_style){
						var style = document.createElement('style'),
							styleSheet;

						style.type = 'text/css';
						style.media = 'all';
						style.innerHTML = compress_style;

						$('body', document).append(style);

					}

					if(compress_script){
						var script = new Function(compress_script)();
					}

					return callback_function();
				});
			}
		}
	};

	CHERRY_API.init();
}(jQuery));