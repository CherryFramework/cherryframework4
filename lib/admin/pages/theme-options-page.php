<?php
	//Cherry options page
	function cherry_options() {
		$inteface = new Cherry_Interface_Bilder(array('html_wrappers' => array('before_title' => '<h3>', 'after_title' => '</h3>')));

		$options =array();

		$options['background'] = array(
							'type'			=> 'background',
							'label'			=> 'text',
							'value'		=> array(
									'image'	=> 'http://192.168.9.76/wordpress_git/01_new_wordpress/wp-content/uploads/2014/03/Koala1.jpg',
									'color'	=> '#ff0000',
									'repeat'	=> 'repeat',
									'position'	=> 'left',
									'attachment'=> 'fixed',
								)
						);

		$options['image'] = array(
							'type'			=> 'image',
							'value'			=> '',
							'label'			=> 'image_1',
							'title'			=> 'image',
							'display_image'	=> true,
						);

		$options['typography'] = array(
							'type'			=> 'typography',
							'value'			=> array(
												'size'			=> '10',
												'lineheight'	=> '10',
												'color'			=> 'blue',
												'family'		=> 'Abril Fatface',
												'character'		=> 'latin-ext',
												'style'			=> 'italic'
												),
							'label'			=> 'typography',
							'title'			=> 'typography',
						);

		$options['info'] = array(
							'type'			=> 'info',
							'value'			=> '<h2>asdasdasdasd</h2>',
							'label'			=> 'info',
							'title'			=> 'info'
								);

		$options['colorpicker'] = array(
							'type'			=> 'colorpicker',
							'value'			=> '#ff0000',
							'label'			=> 'colorpicker'
						);

		$options['editor'] = array(
							'type'			=> 'editor',
							'value'			=> 'editor',
							'title'			=> 'editor',
							'label'			=> 'editor',
							'decsription'	=> 'decsription'

						);

		$options['stepper'] = array(
							'type'			=> 'stepper',
							'value'			=> '0',
							'value_step'	=> '10',
							'max_value'		=> '50',
							'min_value'		=> '-50',
							'label'			=> 'stepper'
						);

		$options['radio'] = array(
					'type'			=> 'radio',
					'value'			=> 'radio',
					'label'			=> 'radio',
					'display_input' => true,
					'options'		=> array(
						'radio' => array(
							'label' => 'radio_1',
							'img_src' => ''
						),
						'radio_2' => array(
							'label' => 'radio_2',
							'img_src' => ''
						),
						'radio_3' => array(
							'label' => 'radio_3',
							'img_src' => ''
						)
					)
				);

		$options['submit'] = array(
					'type'			=> 'submit',
					'value'			=> 'get value',
					'label'			=> 'get value'
				);
/**/

		echo '<form id="cherry_options">'.$inteface -> multi_output_items($options).'</form>';
	}
?>