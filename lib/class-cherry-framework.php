<?php
/**
 * Cherry Framework - The most delicious WordPress framework.
 *
 * MAYBE_CHERRY_FRAMEWORK_DESCRIPTION_TYPE_HERE
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
			global $cherry;

			// Set up an empty class for the global $cherry object.
			$cherry = new stdClass;

			// Define framework, parent theme, and child theme constants.
			add_action( 'after_setup_theme', array( $this, 'constants' ), 1 );

			// Load the core functions/classes required by the rest of the framework.
			add_action( 'after_setup_theme', array( $this, 'core' ), 2 );

			// Initialize the framework's default actions and filters.
			add_action( 'after_setup_theme', array( $this, 'default_filters' ), 3 );

			// Language functions and translations setup.
			// add_action( 'after_setup_theme', array( $this, 'lang' ), 4 );

			// Handle theme supported features.
			add_action( 'after_setup_theme', array( $this, 'theme_support' ), 12 );

			// Load the framework functions.
			add_action( 'after_setup_theme', array( $this, 'functions' ), 13 );

			// Load the framework extensions.
			add_action( 'after_setup_theme', array( $this, 'extensions' ), 14 );

			// Load admin files.
			add_action( 'wp_loaded', array( $this, 'admin' ) );
		}

		/**
		 * Defines the constant paths for use within the core framework, parent theme, and child theme.
		 * Constants prefixed with 'CHERRY_' are for use only within the core framework and don't
		 * reference other areas of the parent or child theme.
		 *
		 * @since  4.0.0
		 */
		function constants() {

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
		}

		/**
		 * Loads the core framework functions. These files are needed before loading anything else in the
		 * framework because they have required functions for use.
		 *
		 * @since  4.0.0
		 */
		function core() {

			// Load the core framework functions.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'core.php' );

			// Load the core framework internationalization functions.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'lang.php' );

			// Load the <head> functions.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'head.php' );

			// Load the sidebar functions.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'sidebars.php' );

			// Load the scripts functions.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'scripts.php' );

			// Load the styles functions.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'styles.php' );
		}

		/**
		 * Adds the default framework actions and filters.
		 *
		 * @since 4.0.0
		 */
		function default_filters() {

			// Make text widgets, excerpt and term descriptions shortcode aware.
			add_filter( 'widget_text', 'do_shortcode' );
			add_filter( 'the_excerpt', 'do_shortcode' );
			add_filter( 'term_description', 'do_shortcode' );

			// Prevents autop in text widgets, excerpt
			add_filter( 'widget_text', 'shortcode_unautop' );
			add_filter( 'the_excerpt', 'shortcode_unautop' );
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

			// Enable support for Post Thumbnails on posts and pages.
			add_theme_support( 'post-thumbnails' );

			// Enable support for Post Formats.
			add_theme_support( 'post-formats', array( 'aside', 'audio', 'image', 'gallery', 'link', 'quote', 'video' ) );

			// Adds core WordPress HTML5 support.
			add_theme_support( 'html5', array(
				'comment-list',
				'search-form',
				'comment-form',
				'gallery',
			) );

			// Add theme support for Infinite Scroll.
			// see: http://jetpack.me/support/infinite-scroll/
			add_theme_support( 'infinite-scroll', array(
				'container' => 'main',
				'footer'    => 'page',
			) );
		}

		/**
		 * Loads the framework functions. Many of these functions are needed to properly run the
		 * framework. Some components are only loaded if the theme supports them.
		 *
		 * @since 4.0.0
		 */
		function functions() {

			// Load Cherry_Wrapping class.
			require_once( trailingslashit( CHERRY_DIR ) . 'classes/class-cherry-wrapping.php' );

			// Load Cherry_Sidebar class.
			require_once( trailingslashit( CHERRY_DIR ) . 'classes/class-cherry-sidebar.php' );

			// Load Cherry_Interface_Bilder class.
			require_once( trailingslashit( CHERRY_DIR ) . 'classes/class-interface-builder.php' );

			// Load the HTML attributes functions.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'attr.php' );

			// Load the template functions.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'template.php' );

			// Load the general template functions.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'template-general.php' );

			// Load the custom template tags.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'template-tags.php' );

			// Load the custom functions that act independently of the theme templates.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'extras.php' );

			// Load the structure functions.
			require_once( trailingslashit( CHERRY_FUNCTIONS ) . 'structure.php' );
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

			// Load the Some Extension if supported.
			require_if_theme_supports( 'cherry-some-extension', trailingslashit( CHERRY_DIR ) . 'extensions/some-extension.php' );
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
				require_once( trailingslashit( CHERRY_DIR ) . 'admin/admin.php' );
			}
		}

	}
}