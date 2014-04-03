<?php
	//Cherry options page
	function cherry_options() {
		$inteface = new Cherry_Interface_Bilder(array('pattern' => 'grid'));

		$options =array();

		$options['text'] = array(
					'type'			=> 'text',
					'title'			=> 'title text',
					'label'			=> 'label text',
					'decsription'	=> 'decsription text',
					'value'			=> 'value',
					'default_value'	=> 'default_value',
					/*'class'			=> 'width-small'*/
						);

		$options['textarea'] = array(
					'type'			=> 'textarea',
					'title'			=> 'title textarea',
					'label'			=> 'label textarea',
					'decsription'	=> 'decsription textarea',
					'value'			=> 'value',
					'default_value'	=> 'default_value',
					/*'class'			=> 'width-medium'*/
				);

		$options['select'] = array(
					'type'			=> 'select',
					'title'			=> 'title select',
					'label'			=> 'label select',
					'decsription'	=> 'decsription select',
					'value'			=> 'select_1',
					'default_value'	=> 'select_1',
					'class'			=> 'width-full',
					'options'		=> array(
						'select_1'	=> 'select 1',
						'select_2'	=> 'select 2',
						'select_3'	=> 'select 3'
					)
				);

		$options['checkbox'] = array(
					'type'			=> 'checkbox',
					'title'			=> 'title checkbox',
					'label'			=> 'label checkbox',
					'decsription'	=> 'decsription checkbox',
					'value'			=> 'value',
					'default_value'	=> 'default_value'
				);

		$options['multicheckbox'] = array(
					'type'			=> 'multicheckbox',
					'title'			=> 'title multicheckbox',
					'label'			=> 'label multicheckbox',
					'decsription'	=> 'decsription multicheckbox',
					'class'			=> '',
					'value'			=> array(
						'checkbox_1'	=> false,
						'checkbox_2'	=> true,
						'checkbox_3'	=> true
					),
					'default_value'	=> array(
						'checkbox_1'	=> false,
						'checkbox_2'	=> false,
						'checkbox_3'	=> true
					),
					'options'		=> array(
						'checkbox_1'	=> 'checkbox 1',
						'checkbox_2'	=> 'checkbox 2',
						'checkbox_3'	=> 'checkbox 3'
					)
				);

		$options['radio'] = array(
					'type'			=> 'radio',
					'title'			=> 'title radio',
					'label'			=> 'label radio',
					'decsription'	=> 'decsription radio',
					'value'			=> 'radio_2',
					'default_value'	=> 'radio_1',
					'class'			=> '',
					'display_input'	=> true,
					'options'		=> array(
						'radio_1' => array(
							'label' => 'radio 1',
							'img_src' => ''
						),
						'radio_2' => array(
							'label' => 'radio 2',
							'img_src' => ''
						),
						'radio_3' => array(
							'label' => 'radio 3',
							'img_src' => ''
						),
					)
				);

		$options['radio_image'] = array(
					'type'			=> 'radio',
					'title'			=> 'title radio',
					'label'			=> 'label radio',
					'decsription'	=> 'decsription radio',
					'value'			=> 'radio_image_1',
					'default_value'	=> 'radio_image_1',
					'class'			=> '',
					'display_input'	=> false,
					'options'		=> array(
						'radio_image_1' => array(
							'label' => 'radio image 1',
							'img_src' => PARENT_URI.'/screenshot.png'
						),
						'radio_image_2' => array(
							'label' => 'radio image 2',
							'img_src' => PARENT_URI.'/screenshot.png'
						),
						'radio_image_3' => array(
							'label' => 'radio image 3',
							'img_src' => PARENT_URI.'/screenshot.png'
						),
					)
				);

		$options['image'] = array(
					'type'				=> 'image',
					'title'				=> 'title image',
					'label'				=> 'label image',
					'decsription'		=> 'decsription image',
					'value'				=> '',
					'default_value'		=> 'http://192.168.9.76/wordpress_git/01_new_wordpress/wp-content/uploads/2014/03/logo.png',
					'display_image'		=> true,
					'multi_upload'		=> true,
					'return_data_type'	=> 'url'
				);

		$options['image_2'] = array(
					'type'				=> 'image',
					'title'				=> 'title image',
					'label'				=> 'label image',
					'decsription'		=> 'decsription image',
					'value'				=> '',
					'default_value'		=> 'http://192.168.9.76/wordpress_git/01_new_wordpress/wp-content/uploads/2014/03/logo.png',
					'display_image'		=> true,
					'multi_upload'		=> true,
					'return_data_type'	=> 'url'
				);

		$options['colorpicker'] = array(
					'type'			=> 'colorpicker',
					'title'			=> 'title colorpicker',
					'label'			=> 'label colorpicker',
					'decsription'	=> 'decsription colorpicker',
					'value'			=> '#ff0000',
					'default_value'	=> '#ff0000'
				);

		$options['stepper'] = array(
					'type'			=> 'stepper',
					'title'			=> 'title stepper',
					'label'			=> 'label stepper',
					'decsription'	=> 'decsription stepper',
					'value'			=> '0',
					'default_value'	=> '0',
					'value_step'	=> '1',
					'max_value'		=> '50',
					'min_value'		=> '-50'
			);

		$options['editor'] = array(
			'type'			=> 'editor',
			'title'			=> 'title editor',
			'label'			=> 'label editor',
			'decsription'	=> 'decsription editor',
			'value'			=> 'editor',
			'default_value'	=> 'editor'
		);

		$options['background'] = array(
							'type'			=> 'background',
							'title'			=> 'title background',
							'label'			=> 'label background',
							'decsription'	=> 'decsription background',
							'return_data_type'	=> 'id',
							'value'			=> array(
									'image'	=> '5',
									'color'	=> '#ff0000',
									'repeat'	=> 'repeat',
									'position'	=> 'left',
									'attachment'=> 'fixed'
								)
						);

		$options['info'] = array(
							'type'			=> 'info',
							'title'			=> 'title info',
							'decsription'	=> 'decsription info',
							'value'			=> '<h2>info</h2>'
								);

		$options['typography'] = array(
						'type'			=> 'typography',
						'title'			=> 'title typography',
						'label'			=> 'label typography',
						'decsription'	=> 'decsription typography',
						'value'			=> array(
							'size'			=> '10',
							'lineheight'	=> '10',
							'color'			=> 'blue',
							'family'		=> 'Abril Fatface',
							'character'		=> 'latin-ext',
							'style'			=> 'italic'
						)
				);

		$options['submit'] = array(
					'type'			=> 'submit',
					'value'			=> 'get value'
				);

		echo '<form id="cherry_options">'.$inteface -> multi_output_items($options).'</form>';
	}
?>