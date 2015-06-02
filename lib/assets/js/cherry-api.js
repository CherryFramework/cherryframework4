var CHERRY_API;

(function($){
	'use strict';

	CHERRY_API = {
		name : 'Cherry Js API',
		varsion : '1.0.0',
		autor : 'Cherry Team',

		variable : {
			$document : $( document ),
			$window : $( window ),
			browser : $.browser,
			browser_supported : true
		},

		status : {
			on_load : false,
			is_ready : false
		},

		loaded_assets : {
			script : wp_load_style,
			style : wp_load_script
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
			get_assets: function ( url, callback ){
				var reg_name = /([\S.]+\/)/gmi,
					reg_type = /(\.js|\.css)/gmi,
					args = Array.prototype.slice.call( arguments ),
					load_status = {},
					callback_function = callback || function(){};

				if( !$.isArray( args[ 0 ] ) ){
					args[ 0 ] = [ args[ 0 ] ];
				}

				for( var index in args[ 0 ] ){
					var file_url = args[ 0 ][ index ],
						file_name = file_url.replace( reg_name, '' ),
						file_type = file_url.match( reg_type )[ 0 ];

					if( $.inArray( file_name, CHERRY_API.loaded_assets.script ) == -1
						|| $.inArray( file_name, CHERRY_API.loaded_assets.style ) == -1 ){

						switch (file_type) {
							case '.js':
								load_script( file_url, file_name );
							break;

							case '.css':
								load_css( file_url, file_name );
							break;
						}
					}else{
						check_download(file_name);
					};
				}

				function load_script(file_url, file_name){
					$.getScript( file_url, function( data, textStatus, jqxhr) {
							CHERRY_API.loaded_assets.script.push( file_name );
							check_download(file_name);

						}
					);
				}

				function load_css(file_url, file_name){
					$( '<link/>', { rel : 'stylesheet', href : file_url, type :"text/css", media : "all" } ).appendTo( 'head' );
					CHERRY_API.loaded_assets.style.push( file_name );
					check_download(file_name);
				}

				function check_download(file_name){
					load_status[ file_name ] = true;
					if( Object.keys( load_status ).length == args[ 0 ].length){
						return callback_function( load_status )
					}
				}
			}
		}
	};

	CHERRY_API.init();
}(jQuery));