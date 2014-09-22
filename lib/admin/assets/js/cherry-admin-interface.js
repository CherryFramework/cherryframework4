//cherry option page
jQuery(document).ready(function() {
	var
		cherryOptionsWrap = jQuery('#cherry_options')
	,	cherryTabMenuList = jQuery('.cherry-tab-menu > li', cherryOptionsWrap)// tab list
	,	cherryOptionGroupList = jQuery('.cherry-option-group-list > .options_group', cherryOptionsWrap)
	,	currentTabIndex = 0
	;

	cherryTabMenuList.on('click', function () {
		if(jQuery(this).index() != currentTabIndex){
			currentTabIndex = jQuery(this).index();
			optionTabSwitcher(currentTabIndex);
		}
	})

	optionTabSwitcher(currentTabIndex);
	function optionTabSwitcher(index){
		cherryTabMenuList.removeClass('active').eq(index).addClass('active').blur();
		//cherryOptionGroupList.css({display:'none'}).eq(index).css({display:'block'});
		cherryOptionGroupList.hide();
		cherryOptionGroupList.eq(index).fadeIn();
	}

	jQuery('.fixedControlHolder .saveButton').on('click', function(){
		jQuery('#cherry-save-options').click();
	})
	jQuery('.fixedControlHolder .restoreButton').on('click', function(){
		jQuery('#cherry-restore-options').click();
	})

	jQuery(".options-page-wrapper .settings-error").delay(2000).slideUp(500);
});