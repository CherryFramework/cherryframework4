<?php
	// global name for Cherry Options Framework
	global $cherry_options_framework;
	
	$cherry_options_framework = new Cherry_Options_Framework;
	$options_framework_admin = new Cherry_Options_Framework_Admin;

	
	//$cherry_options_framework->add_new_settings(new_cherry_set());
	//var_dump(Cherry_Options_Framework::get_option_value('accordion-demo'));


	add_filter('cherry_defaults_settings', 'new_cherry_set');

	function new_cherry_set($result_array) {
		$optSectionsArray = array();


////////// Megamenu options ///////////////////////////////////////////////////

		$megamenu_options = array();
		$megamenu_options['megamenu-options'] = array(
					'type'			=> 'info',
					'title'			=> '',
					'decsription'	=> 'decsription info',
					'value'			=> '<h2>Megamenu</h2>'
		);
		$megamenu_options['megamenu-dropdown'] = array(
					'type'			=> 'switcher',
					'title'			=> 'Megamenu',
					'label'			=> 'Dropdown menu',
					'decsription'	=> 'Enable/Disable dropdown menu.',
					'value'			=> 'true',
					'default-value'	=> 'default-value'
		);
		$megamenu_options['megamenu-fadein-animation'] = array(
					'type'			=> 'switcher',
					'title'			=> 'Drop down fade-in animation',
					'label'			=> 'Fade-in animation',
					'decsription'	=> 'Enable/Disable drop down fade-in animation.',
					'value'			=> 'true',
					'default-value'	=> 'default-value'
		);
		$megamenu_options['megamenu-slidedown-animation'] = array(
					'type'			=> 'switcher',
					'title'			=> 'Drop down Slide-down animation',
					'label'			=> 'Slide-down animation',
					'decsription'	=> 'Enable/Disable drop down slide-down animation.',
					'value'			=> 'false',
					'default-value'	=> 'default-value'
		);
		$megamenu_options['megamenu-animation-speed'] = array(
					'type'			=> 'select',
					'title'			=> 'Drop down animation speed',
					'label'			=> 'Animation speed',
					'decsription'	=> 'Drop down animation speed',
					'value'			=> 'Normal',
					'default_value'	=> 'Normal',
					'class'			=> 'width-full',
					'options'		=> array(
						'select-1'	=> 'Slow',
						'select-2'	=> 'Normal',
						'select-3'	=> 'Fast'
					)
		);
		$megamenu_options['dropdown-animation-delay'] = array(
					'type'			=> 'text',
					'title'			=> 'Drop down animation delay',
					'label'			=> 'Animation delay',
					'decsription'	=> 'Miliseconds delay on mouseout.',
					'value'			=> '1000',
					'default-value'	=> 'default-value'
		);
		$optSectionsArray['megamenu-options'] = array(
				'name' => 'Megamenu',
				'icon' => 'dashicons dashicons-arrow-right',
				'parent' => 'navigation-options-section',
				'priority' => 1,
				'options-list' => $megamenu_options
		);





////////// Dropdown ///////////////////////////////////////////////////
		/*
		$dropdown_options = array();
		$dropdown_options['sub-navigation-options'] = array(
					'type'			=> 'info',
					'title'			=> '',
					'decsription'	=> 'decsription info',
					'value'			=> '<h2>Sub menu options</h2>'
		);
		$dropdown_options['dropdown'] = array(
					'type'			=> 'switcher',
					'title'			=> 'Megamenu',
					'label'			=> 'Dropdown menu',
					'decsription'	=> 'Enable/Disable dropdown menu.',
					'value'			=> 'true',
					'default_value'	=> 'default_value'
		);
		$dropdown_options['dropdown-fadein-animation'] = array(
					'type'			=> 'switcher',
					'title'			=> 'Drop down fade-in animation',
					'label'			=> 'Fade-in animation',
					'decsription'	=> 'Enable/Disable drop down fade-in animation.',
					'value'			=> 'true',
					'default_value'	=> 'default_value'
		);
		$dropdown_options['dropdown-slidedown-animation'] = array(
					'type'			=> 'switcher',
					'title'			=> 'Drop down Slide-down animation',
					'label'			=> 'Slide-down animation',
					'decsription'	=> 'Enable/Disable drop down slide-down animation.',
					'value'			=> 'false',
					'default_value'	=> 'default_value'
		);
		$dropdown_options['dropdown-animation-speed'] = array(
					'type'			=> 'select',
					'title'			=> 'Drop down animation speed',
					'label'			=> 'Animation speed',
					'decsription'	=> 'dDrop down animation speed',
					'value'			=> 'Normal',
					'default_value'	=> 'Normal',
					'class'			=> 'width-full',
					'options'		=> array(
						'select_1'	=> 'Slow',
						'select_2'	=> 'Normal',
						'select_3'	=> 'Fast'
					)
		);
		$dropdown_options['dropdown-animation-delay'] = array(
					'type'			=> 'text',
					'title'			=> 'Drop down animation delay',
					'label'			=> 'Animation delay',
					'decsription'	=> 'Miliseconds delay on mouseout.',
					'value'			=> '1000',
					'default_value'	=> 'default_value'
		);
		$optSectionsArray['dropdown-options'] = array(
				'name' => 'Megamenu',
				'icon' => 'dashicons dashicons-arrow-right',
				'parent' => 'navigation-options-section',
				'priority' => 1,
				'options-list' => $dropdown_options
		);*/





		foreach ($optSectionsArray as $section_value => $value) {
			$result_array[$section_value] = $value;
		}
		return $result_array;		
	}

?>