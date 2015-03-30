<?php
/**
 * Cherry Framework - The most delicious WordPress framework.
 *
 * CHERRY_FRAMEWORK_DESCRIPTION_TYPE_HERE
 *
 * @package   Cherry_Framework
 * @version   4.0.0
 * @author    Cherry Team <support@cherryframework.com>
 * @copyright Copyright (c) 2012 - 2014, Cherry Team
 * @link      http://www.cherryframework.com/
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

if ( !class_exists( 'Cherry_Framework' ) ) {
	/**
	 * The Cherry_Framework class launches the framework.
	 * It's the organizational structure behind the entire framework.
	 * This class should be loaded and initialized before anything
	 * else within the theme is called to properly use the framework.
	 *
	 * @since 4.0.0
	 */
	class Cherry_Framework {

		/**
		 * Constructor method for the Cherry_Framework class.
		 * This method adds other methods of the class to specific hooks within WordPress.
		 * It controls the load order of the required files for running the framework.
		 *
		 * @since  4.0.0
		 */
		function __construct() {
			// Global variables.
			global $cherry, $cherry_registered_static_areas, $cherry_registered_statics;

			// Set up an empty class for the global $cherry object.
			$cherry = new stdClass;

			// Set up a stores the static areas.
			$cherry_registered_static_areas = array();

			// Set up a stores the registered static elements.
			$cherry_registered_statics = array();

			// Define framework, parent theme, and child theme constants.
			add_action( 'after_setup_theme', array( $this, 'constants' ), 1 );

			// Load the core functions/classes required by the rest of the framework.
			add_action( 'after_setup_theme', array( $this, 'core' ), 2 );

			// Initialize the framework's default actions and filters.
			add_action( 'after_setup_theme', array( $this, 'default_filters' ), 3 );

			// Language functions and translations setup.
			// add_action( 'after_setup_theme', array( $this, 'lang' ), 4 );

			// Handle theme supported features.
			add_action( 'after_setup_theme', array( $this, 'theme_support' ), 5 );

			// Load the framework includes.
			add_action( 'after_setup_theme', array( $this, 'includes' ), 12 );

			// Load the framework extensions.
			add_action( 'after_setup_theme', array( $this, 'extensions' ), 13 );

			// Load admin files.
			add_action( 'wp_loaded', array( $this, 'admin' ) );
		}

		/**
		 * Defines the constant paths for use within the core framework, parent theme, and child theme.
		 *
		 * @since  4.0.0
		 */
		function constants() {
			/**
			 * Fires before definitions the constant.
			 *
			 * @since  4.0.0
			 */
			do_action( 'cherry_constants_before' );

			/** Sets the framework version number. */
			define( 'CHERRY_VERSION', '4.0.0' );

			/** Sets the path to the parent theme directory. */
			define( 'PARENT_DIR', get_template_directory() );

			/** Sets the path to the parent theme directory URI. */
			define( 'PARENT_URI', get_template_directory_uri() );

			/** Sets the path to the child theme directory. */
			define( 'CHILD_DIR', get_stylesheet_directory() );

			/** Sets the path to the child theme directory URI. */
			define( 'CHILD_URI', get_stylesheet_directory_uri() );

			/** Sets the path to the core framework directory. */
			define( 'CHERRY_DIR', trailingslashit( PARENT_DIR ) . basename( dirname( __FILE__ ) ) );

			/** Sets the path to the core framework directory URI. */
			define( 'CHERRY_URI', trailingslashit( PARENT_URI ) . basename( dirname( __FILE__ ) ) );

			/** Sets the path to the core framework functions directory. */
			define( 'CHERRY_FUNCTIONS', trailingslashit( CHERRY_DIR ) . 'functions' );

			/** Sets the path to the core framework classes directory. */
			define( 'CHERRY_CLASSES', trailingslashit( CHERRY_DIR ) . 'classes' );

			/** Sets the path to the core framework admin directory. */
			define( 'CHERRY_ADMIN', trailingslashit( CHERRY_DIR ) . 'admin' );

			/** Sets the path to the core framework extensions directory. */
			define( 'CHERRY_EXTENSIONS', trailingslashit( CHERRY_DIR ) . 'extensions' );

			/** Sets the path to the theme config folder. */
			define( 'PARENT_CONFIG_DIR', '/init/config/' );

			/** Sets relative path to the theme statics folder. */
			define( 'PARENT_STATICS_DIR', '/init/statics/' );
		}

		/**
		 * Loads the core framework functions. These files are needed before loading anything else in the
		 * framework because they have required functions for use.
		 *
		 * @since  4.0.0
		 */
		function core() {
			/**
			 * Fires before loads the core framework functions.
			 *
			 * @since  4.0.0
			 */
			do_action( 'cherry_core_before' );

			// Load the core framework functions.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'core.php' );

			// Load the core framework internationalization functions.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'lang.php' );

			// Load the <head> functions.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'head.php' );

			// Load media-related functions.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'media.php' );

			// Load the sidebar functions.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'sidebars.php' );

			// Load the scripts functions.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'scripts.php' );

			// Load the styles functions.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'styles.php' );

			// Load the color control functions.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'colors.php' );

			// Load the typography control functions.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'typography.php' );

			// Utility functions.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'utilities.php' );

			// Load the Cherry_Static class.
			require_once( trailingslashit( CHERRY_CLASSES ) . 'class-cherry-statics.php' );

			// Load CSS compiler.
			require_once( trailingslashit( CHERRY_CLASSES ) . 'class-cherry-css-compiler.php' );

			// Load Breadcrumbs builder.
			require_once( trailingslashit( CHERRY_CLASSES ) . 'class-cherry-breadcrumbs.php' );

			// Load abstract class for static registration.
			require_once( trailingslashit( CHERRY_CLASSES ) . 'class-abstract-cherry-register-static.php' );
		}

		/**
		 * Adds the default framework actions and filters.
		 *
		 * @since 4.0.0
		 */
		function default_filters() {

			// Enable shortcodes.
			add_filter( 'widget_text',      'do_shortcode' );
			add_filter( 'the_excerpt',      'do_shortcode' );
			add_filter( 'term_description', 'do_shortcode' );
			add_filter( 'comment_text',     'do_shortcode' );

			add_filter( 'cherry_the_post_meta',       'do_shortcode', 20 );
			add_filter( 'cherry_the_post_footer',     'do_shortcode', 20 );
			add_filter( 'cherry_get_the_post_meta',   'do_shortcode', 20 );
			add_filter( 'cherry_get_the_post_footer', 'do_shortcode', 20 );

			// Load the core filters.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'filters.php' );
		}

		/**
		 * Loads both the parent and child theme translation files. If a locale-based functions file exists
		 * in either the parent or child theme (child overrides parent), it will also be loaded.  All translation
		 * and locale functions files are expected to be within the theme's '/languages' folder, but the
		 * framework will fall back on the theme root folder if necessary.  Translation files are expected
		 * to be prefixed with the template or stylesheet path (example: 'templatename-en_US.mo').
		 *
		 * @since  4.0.0
		 */
		function lang() {
			global $cherry;

			// Get parent and child theme textdomains.
			$parent_textdomain = cherry_get_parent_textdomain();
			$child_textdomain  = cherry_get_child_textdomain();

			// Load theme textdomain.
			$cherry->textdomain_loaded[ $parent_textdomain ] = load_theme_textdomain( $parent_textdomain );

			// Load child theme textdomain.
			$cherry->textdomain_loaded[ $child_textdomain ] = is_child_theme() ? load_child_theme_textdomain( $child_textdomain ) : false;
		}

		/**
		 * Adds theme supported features.
		 *
		 * @since  4.0.0
		 */
		function theme_support() {

			// Add default posts and comments RSS feed links to head.
			add_theme_support( 'automatic-feed-links' );

			// Enable support for Post Thumbnails.
			add_theme_support( 'post-thumbnails' );

			// Enable HTML5 markup structure.
			add_theme_support( 'html5', array(
				'comment-list', 'comment-form', 'search-form', 'gallery', 'caption',
			) );

			/**
			 * Enable support for Infinite Scroll.
			 *
			 * @link http://jetpack.me/support/infinite-scroll/
			 */
			add_theme_support( 'infinite-scroll', array(
				'container' => 'main',
				'footer'    => 'page',
			) );

		}

		/**
		 * Loads the framework files supported by themes and template-related functions/classes.
		 *
		 * @since 4.0.0
		 */
		function includes() {

			// Load Cherry_Wrapping class.
			require_once( trailingslashit( CHERRY_CLASSES ) . 'class-cherry-wrapping.php' );

			// Load Cherry_Sidebar class.
			require_once( trailingslashit( CHERRY_CLASSES ) . 'class-cherry-sidebar.php' );

			// Load Cherry_Interface_Builder class.
			require_once( trailingslashit( CHERRY_CLASSES ) . 'class-cherry-interface-builder.php' );

			// Load Cherry_Options_Framework class.
			require_once( trailingslashit( CHERRY_CLASSES ) . 'class-cherry-optionsframework.php' );

			// Load Cherry_Options_Framework_Admin class.
			require_once( trailingslashit( CHERRY_CLASSES ) . 'class-cherry-optionsframework-admin.php' );

			// Load the HTML attributes functions.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'attr.php' );

			// Load the template functions.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'template.php' );

			// Load the comments functions.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'template-comments.php' );

			// Load the general template functions.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'template-general.php' );

			// Load the media template functions.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'template-media.php' );

			// Load the custom template tags.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'template-tags.php' );

			// Load the post template functions.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'template-post.php' );

			// Load the custom functions that act independently of the theme templates.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'extras.php' );

			// Load the structure functions.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'structure.php' );

			// Load the shortcodes if supported.
			require_if_theme_supports( 'cherry-shortcodes', trailingslashit( CHERRY_FUNCTIONS ) . 'shortcodes.php' );

			// Load the post format functionality if post formats are supported.
			require_if_theme_supports( 'post-formats', trailingslashit( CHERRY_FUNCTIONS ) . 'post-formats.php' );
		}

		/**
		 * Load extensions (external projects). Extensions are projects that are included within the
		 * framework but are not a part of it. They are external projects developed outside of the
		 * framework. Themes must use add_theme_support( $extension ) to use a specific extension
		 * within the theme. This should be declared on 'after_setup_theme' no later than a priority of 11.
		 *
		 * @since 4.0.0
		 */
		function extensions() {

			// Load if supported.
			// require_if_theme_supports();
		}

		/**
		 * Load admin files for the framework.
		 *
		 * @since 4.0.0
		 */
		function admin() {

			// Check if in the WordPress admin.
			if ( is_admin() ) {

				// Load the main admin file.
				require_once( trailingslashit( CHERRY_ADMIN ) . 'admin.php' );
			}
		}

	}
}