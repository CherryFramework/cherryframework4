/**
 * Custom scripts needed for the cherry options page.
 */

jQuery(document).ready(function() {
	var
		cherryOptionsWrap = jQuery('#cherry-options')
	,	cherryTabMenuList = jQuery('.vertical-tabs_ > li', cherryOptionsWrap)
	,	cherryOptionGroupList = jQuery('.cherry-option-group-list > .options-group', cherryOptionsWrap)
	,	fixedControlHolder = jQuery('.fixed-control-holder')
	,	currentTabIndex = 0
	,	currentSectionName = ''
	,	active_section = ''
	,	isFixedControlBox = "closed"
	,	activeSectionInput = jQuery('.active-section-field')
	;


	// Find if a selected tab is saved in localStorage
	if (isLocalStorageAvailable()) {
		active_section = localStorage.getItem('active-section');
	}
	if(active_section != '' && active_section != null){
		cherryTabMenuList.each(function(){
			if(jQuery(this).data().sectionName == active_section){
				currentTabIndex = jQuery(this).index();
				optionTabSwitcher(jQuery(this).index());
			}
		})
	}else{
		optionTabSwitcher(currentTabIndex);
	}

	// Tab item click event
	cherryTabMenuList.on('click', function () {
		if(jQuery(this).index() != currentTabIndex){
			currentTabIndex = jQuery(this).index();
			optionTabSwitcher(currentTabIndex);
			if (isLocalStorageAvailable()) {
				sectionData = jQuery(this).data();
				localStorage.setItem('active-section', sectionData.sectionName );
			}
		}
	})

	// Tab switcher
	function optionTabSwitcher(index){
		cherryTabMenuList.removeClass('active').eq(index).addClass('active');
		currentSectionName = cherryTabMenuList.eq(index).data();
		cherryOptionGroupList.hide();
		cherryOptionGroupList.eq(index).fadeIn();

		activeSectionInput.attr('value', currentSectionName.sectionName);
	}

	// Find if a selected tab is saved in localStorage
	if (isLocalStorageAvailable()) {
		isFixedControlBox = localStorage.getItem('fixed_control_box');
		if(isFixedControlBox != '' && isFixedControlBox != null){
			switch(isFixedControlBox){
				case 'opened':
					fixedControlHolder.addClass('opened').css({right:5});
				break;
				case 'closed':
					fixedControlHolder.removeClass('opened').css({right:-fixedControlHolder.outerWidth(true)});
				break;
			}
		}else{
			isFixedControlBox = 'closed';
			localStorage.setItem( 'fixed_control_box' , isFixedControlBox );
			fixedControlHolder.removeClass('opened').css({right:-fixedControlHolder.outerWidth(true)});
		}
	}
	// Fixed click event
	jQuery('.marker', fixedControlHolder).on('click', function(){
		switch(isFixedControlBox){
			case 'opened':
				isFixedControlBox = 'closed';
				fixedControlHolderSwitcher(isFixedControlBox);
				localStorage.setItem( 'fixed_control_box' , isFixedControlBox );
			break;
			case 'closed':
				isFixedControlBox = 'opened';
				fixedControlHolderSwitcher(isFixedControlBox);
				localStorage.setItem( 'fixed_control_box' , isFixedControlBox );
			break;
		}
	})

	function fixedControlHolderSwitcher(state){
		switch(state){
			case 'opened':
				fixedControlHolder.addClass('opened').stop(true).animate({right:5}, 500);
			break;
			case 'closed':
				fixedControlHolder.removeClass('opened').stop(true).animate({right:-fixedControlHolder.outerWidth(true)}, 500);
			break;
		}
	}

	// click trigger save button
	jQuery('.fixed-control-holder .save-button').on('click', function(){
		jQuery('#wrap-cherry-save-options input').click();
	})
	// click trigger restore button
	jQuery('.fixed-control-holder .restore-section-button').on('click', function(){
		jQuery('#wrap-cherry-restore-section input').click();
	})
	// click trigger restore button
	jQuery('.fixed-control-holder .restore-button').on('click', function(){
		jQuery('#wrap-cherry-restore-options input').click();
	})
	// slide up notice
	jQuery(".options-page-wrapper .slide_up").delay(2000).slideUp(500);
});//end document ready
jQuery(window).load(function() {
	jQuery('.options-group').css({ visibility: 'visible' });
})
//check localStorage browser support
function isLocalStorageAvailable() {
    try {
        return 'localStorage' in window && window['localStorage'] !== null;
    } catch (e) {
        return false;
    }
}