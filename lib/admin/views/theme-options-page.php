<?php

	class Cherry_Options_Framework_Interface{
		private $optionsSectionArray;
		private $option_inteface_builder;

		function __construct(){

			$this->option_inteface_builder = new Cherry_Interface_Builder(array('pattern' => 'grid'));

			require_once "theme-options-sets.php";
///////////////////options section data array //////////////////////////////////
			$this->optionsSectionArray = array(
				array(
						'id' => 'general-options',
						'name' => 'General',
						'icon' => 'dashicons dashicons-admin-generic',
						'parent' => '',
						'option-list' => $general_options
				),
				array(
						'id' => 'homepage-options',
						'name' => 'Home page',
						'icon' => 'dashicons dashicons-admin-home',
						'parent' => '',
						'option-list' => $homepage_options
				),
				array(
						'id' => 'header-options',
						'name' => 'Header',
						'icon' => 'dashicons dashicons-admin-appearance',
						'parent' => '',
						'option-list' => $header_options
				),
				array(
						'id' => 'footer-options',
						'name' => 'Footer',
						'icon' => 'dashicons dashicons-admin-tools',
						'parent' => '',
						'option-list' => $footer_options
				),
				array(
						'id' => 'typography-options',
						'name' => 'Typography',
						'icon' => 'dashicons dashicons-media-text',
						'parent' => '',
						'option-list' => $typography_options
				),
				array(
						'id' => 'logo-options',
						'name' => 'Logo',
						'icon' => 'dashicons dashicons-star-filled',
						'parent' => '',
						'option-list' => $logo_options
				),
				array(
						'id' => 'navigation-options',
						'name' => 'Navigation',
						'icon' => 'dashicons dashicons-menu',
						'parent' => '',
						'option-list' => $navigation_options
				),
				array(
						'id' => 'dropdown-options',
						'name' => 'Dropdown',
						'icon' => 'dashicons dashicons-arrow-right',
						'parent' => 'navigation-options',
						'option-list' => $dropdown_options
				),
				array(
						'id' => 'mobile-navigation-options',
						'name' => 'Mobile menu',
						'icon' => 'dashicons dashicons-arrow-right',
						'parent' => 'navigation-options',
						'option-list' => $mobile_navigation_options
				),
				array(
						'id' => 'blog-options',
						'name' => 'Blog',
						'icon' => 'dashicons dashicons-editor-bold',
						'parent' => '',
						'option-list' => $blog_options
				),
				array(
					'id' => 'blog-meta-options',
					'name' => 'Blog meta',
					'icon' => 'dashicons dashicons-arrow-right',
					'parent' => 'blog-options',
					'option-list' => $blog_meta_options
				),
				array(
					'id' => 'blog-single-post-options',
					'name' => 'Single post',
					'icon' => 'dashicons dashicons-arrow-right',
					'parent' => 'blog-options',
					'option-list' => $blog_single_post_options
				),
				array(
						'id' => 'portfolio-options',
						'name' => 'Portfolio',
						'icon' => 'dashicons dashicons-format-gallery',
						'parent' => '',
						'option-list' => $portfolio_options
				),
				array(
						'id' => 'demo-options',
						'name' => 'All interface elements',
						'icon' => 'dashicons dashicons-lightbulb',
						'parent' => '',
						'option-list' => $demo_options
				)
			);

			$dom_part_output = '';
			$dom_part_output .= '<form id="cherry_options">';
				$dom_part_output .= '<div class="options-framework-wrapper">';
					$dom_part_output .= '<ul class="cherry-tab-menu">';
						foreach ($this->optionsSectionArray as $section_key => $section_value) {
							($section_value["parent"] != '')? $subClass = 'subitem' : $subClass = '';
							$dom_part_output .= '<li class="'.$section_value["parent"].' '.$subClass.' tabitem-'.$section_key.'"><a href="javascript:void(0)"><i class="'.$section_value["icon"].'"></i><span>'.$section_value["name"].'</span></a></li>';
						}
					$dom_part_output .= '</ul>';
					$dom_part_output .= '<div class="cherry-option-group-list">';
						foreach ($this->optionsSectionArray as $section_key => $section_value) {
							$dom_part_output .= '<div class="options_group">'.$this->option_inteface_builder->multi_output_items($section_value["option-list"]).'</div>';
						}
					$dom_part_output .= '</div><div class="clear"></div>';
				$dom_part_output .= '</div>';
			$dom_part_output .= '<div class="cherry-option-submit-wrapper">'.$this->option_inteface_builder->multi_output_items($submitSection).'</div>';
			$dom_part_output .= '</form>';
			echo $dom_part_output;
		}//end __constructor

		public function option_page_build(){

		}
	}
	//Cherry options page
	function cherry_options() {
		$optionsframework_interfece = new Cherry_Options_Framework_Interface;
		$optionsframework_interfece->option_page_build();
	}

?>