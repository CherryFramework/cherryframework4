var CHERRY_API;

(function($){
	'use strict';

	CHERRY_API = {
		name : 'Cherry Js API',
		varsion : '1.0.0',
		autor : 'Cherry Team',

		variable : {
			$document: $(document),
			$window: $(window),
			browser: $.browser,
			browser_supported: true
		},

		status : {
			on_load: false,
			is_ready: false
		},

		init : function(){

			CHERRY_API.set_variable();

			$( document ).ready( CHERRY_API.ready );

			$( window ).load( CHERRY_API.load );
		},

		set_variable : function(){
			//set variable browser_supported
			CHERRY_API.variable.browser_supported = (function (){
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
			}())
		},

		ready : function(){
			CHERRY_API.status.is_ready = true;
		},

		load : function(){
			CHERRY_API.status.on_load = true;
		},

		utilites : {
			namespace : function(space_path){
				var parts = space_path.split('.'),
					parent = CHERRY_API,
					length = parts.length,
					i = 0;

					for(i = 0; i < length; i += 1 ){
						if(typeof parent[parts[i]] === 'undefined'){
							parent[parts[i]] = {};
						}
						parent = parent[parts[i]];
					}
				return parent;
			}
		}
	};

	CHERRY_API.init();
}(jQuery));