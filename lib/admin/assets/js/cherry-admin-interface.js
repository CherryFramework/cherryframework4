jQuery(document).ready(function() {

	//cherry option page
	var
		cherryOptionsWrap = jQuery('#cherry_options')
	,	cherryTabMenuList = jQuery('.cherry-tab-menu > li', cherryOptionsWrap)
	,	cherryOptionGroupList = jQuery('.cherry-option-group-list > .options_group', cherryOptionsWrap)
	,	currentTabIndex = 0
	;

	cherryTabMenuList.live('click', function () {
		if(jQuery(this).index() != currentTabIndex){
			currentTabIndex = jQuery(this).index();
			optionTabSwitcher(currentTabIndex);
		}
	})

	optionTabSwitcher(currentTabIndex);
	function optionTabSwitcher(index){
		cherryTabMenuList.removeClass('active').eq(index).addClass('active');

		cherryOptionGroupList.css({display:'none'}).eq(index).css({display:'block'});
	}


	
});