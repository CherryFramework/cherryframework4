<?php
	// global name for Cherry Options Framework
	global $cherry_options_framework;
	
	$cherry_options_framework = new Cherry_Options_Framework;
	$options_framework_admin = new Cherry_Options_Framework_Admin;

	
	//$cherry_options_framework->add_new_settings(new_cherry_set());
	
	//var_dump(Cherry_Options_Framework::get_option_value('text_demo'));
	
	//add_filter('cherry_defaults_settings', 'new_cherry_set');

	function new_cherry_set($result_array) {
		$optSectionsArray = array();
		$navigation_options = array();
		$navigation_options['navigation-options'] = array(
				'type'			=> 'info',
				'title'			=> '',
				'decsription'	=> 'decsription info',
				'value'			=> '<h2>Navigation options</h2>'
		);
		$navigation_options['stickup-menu'] = array(
				'type'			=> 'switcher',
				'title'			=> 'StickUp menu',
				'label'			=> 'Using stickUp menu',
				'decsription'	=> 'Do you want to use stickUp menu?',
				'value'			=> 'true',
				'default_value'	=> 'default_value'
		);
		$navigation_options['menu-typography'] = array(
				'type'			=> 'typography',
				'title'			=> 'Menu Typography',
				'label'			=> 'Menu Typography style',
				'decsription'	=> 'Choose your prefered font for menu.',
				'value'			=> array(
					'size'			=> '14',
					'lineheight'	=> '14',
					'color'			=> '#aa00aa',
					'family'		=> 'Abril Fatface',
					'character'		=> 'latin-ext',
					'style'			=> 'italic'
				)
		);
		$optSectionsArray['navigation-options-section'] = array(
				'name' => 'Navigation',
				'icon' => 'dashicons dashicons-menu',
				'parent' => '',
				'priority' => 40,
				'options-list' => $navigation_options
		);

		foreach ($optSectionsArray as $section_value => $value) {
			$result_array[$section_value] = $value;
		}
		return $result_array;		
	}

?>