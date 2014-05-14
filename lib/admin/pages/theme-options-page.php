<?php
	//Cherry options page
	function cherry_options() {
		$inteface = new Cherry_Interface_Bilder(array('pattern' => 'grid'));

		$options =array();

		$options['general-options'] = array(
					'type'			=> 'info',
					'title'			=> '',
					'decsription'	=> 'decsription info',
					'value'			=> '<h2>General options</h2>'
		);

		$options['header-options'] = array(
					'type'			=> 'info',
					'title'			=> '',
					'decsription'	=> 'decsription info',
					'value'			=> '<h2>Header options</h2>'
		);

		$options['footer-options'] = array(
					'type'			=> 'info',
					'title'			=> '',
					'decsription'	=> 'decsription info',
					'value'			=> '<h2>Footer options</h2>'
		);

		$options['typography-options'] = array(
					'type'			=> 'info',
					'title'			=> '',
					'decsription'	=> 'decsription info',
					'value'			=> '<h2>Typography options</h2>'
		);

		$options['logo-options'] = array(
					'type'			=> 'info',
					'title'			=> '',
					'decsription'	=> 'decsription info',
					'value'			=> '<h2>Logo options</h2>'
		);

		$options['navigation-options'] = array(
					'type'			=> 'info',
					'title'			=> '',
					'decsription'	=> 'decsription info',
					'value'			=> '<h2>Navigation options</h2>'
		);

		$options['blog-options'] = array(
					'type'			=> 'info',
					'title'			=> '',
					'decsription'	=> 'decsription info',
					'value'			=> '<h2>Blog options</h2>'
		);

		echo '<div class="options-framework-wrapper"><form id="cherry_options">'.$inteface -> multi_output_items($options).'</form></div>';
	}
?>