<?php

	if(!function_exists('framework_options')){
		function framework_options() {
			$options = array();
// ---------------------------------------------------------
// General
// ---------------------------------------------------------
			$options["general"] = array(
				"name" => theme_locals('general'),
				"type" => "heading"
			);
// ---------------------------------------------------------
// Logo & Favicon
// ---------------------------------------------------------
			$options['logo_favicon'] = array(
				"name" => theme_locals('logo_favicon'),
				"type" => "heading"
			);
// ---------------------------------------------------------
// Navigation
// ---------------------------------------------------------

			$options['navigation'] = array(
				"name" => theme_locals('navigation'),
				"type" => "heading"
			);

// ---------------------------------------------------------
// Slider
// ---------------------------------------------------------
			$options['slider'] = array(
				"name" => theme_locals('slider'),
				"type" => "heading"
			);
// ---------------------------------------------------------
// Blog
// ---------------------------------------------------------
			$options['blog'] = array(
				"name" => theme_locals('blog'),
				"type" => "heading"
			);
// ---------------------------------------------------------
// Portfolio
// ---------------------------------------------------------
			$options['portfolio'] = array(
				"name" => theme_locals("portfolio"),
				"type" => "heading"
			);
// ---------------------------------------------------------
// Footer
// ---------------------------------------------------------
			$options['footer'] = array(
				"name" => theme_locals("footer"),
				"type" => "heading"
			);
			return $options;
		}
	}

?>