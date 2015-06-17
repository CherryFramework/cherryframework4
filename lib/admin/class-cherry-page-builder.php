<?php
/**
 *
 * @package    Cherry_Framework
 * @subpackage Class
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

if ( !class_exists( 'Cherry_Page_Builder' ) ) {
	class Cherry_Page_Builder {

		private static $pages = array('parent' => array() , 'child' => array() );

		private static $parent_attr = array(
			'page_title' => '',
			'menu_title' => '',
			'capability' => '',
			'menu_slug' => '',
			'function' => '',
			'icon_url' => '',
			'position' => '',
			'before_content' => '',
			'after_content' => '');

		private static $child_attr = array(
			'parent_slug' => '',
			'page_title'  => '',
			'menu_title' => '',
			'capability' => '',
			'menu_slug' => '',
			'function' => '',
			'before_content' => '',
			'after_content' => '');

		/**
		* Cherry_Options_Framework constructor
		*
		* @since 4.0.0
		*/
		function __construct() {
			// Add the options page and menu item.
			add_action( 'admin_menu', array( __CLASS__, 'add_menu' ) );
			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_admin_scripts' ) );
		}

		public function add_parent_menu_item( $attr ){
			$attr = array_merge(self::$parent_attr, $attr);
			$page_key = 'toplevel_page_' . $attr[ 'menu_slug' ];

			self::$pages[ 'parent' ][ $page_key ] = $attr;
		}

		public function add_child_menu_item( $attr ){
			$attr = array_merge(self::$child_attr, $attr);
			$prefix = ( false !== strpos( $attr[ 'parent_slug' ], '_page_') ) ? '_' : '_page_' ;

			$page_key = $attr[ 'parent_slug' ] . $prefix . $attr[ 'menu_slug' ];

			self::$pages[ 'child' ][ $page_key ] = $attr;
		}

		public static function add_menu(){
			if( !empty( self::$pages[ 'parent' ] ) ){
				foreach ( self::$pages[ 'parent' ] as $page_title => $page_settings ) {
					add_menu_page(
						$page_settings[ 'page_title' ],
						$page_settings[ 'menu_title' ],
						$page_settings[ 'capability' ],
						$page_settings[ 'menu_slug' ],
						array( __CLASS__, 'build_page' ),
						$page_settings[ 'icon_url' ],
						$page_settings[ 'position' ]
					);
				}
			}

			if( !empty( self::$pages[ 'child' ] ) ){
				foreach ( self::$pages[ 'child' ] as $page_title => $page_settings ) {
					add_submenu_page(
						$page_settings[ 'parent_slug' ],
						$page_settings[ 'page_title' ],
						$page_settings[ 'menu_title' ],
						$page_settings[ 'capability' ],
						$page_settings[ 'menu_slug' ],
						array( __CLASS__, 'build_page' )
					);
				}
			}
		}

		public static function build_page(){
			$page_hook = current_action();

			$page_attr = array_key_exists ( $page_hook , self::$pages[ 'parent' ] ) ? self::$pages[ 'parent' ][ $page_hook ] : self::$pages[ 'child' ][ $page_hook ] ;

			$page_content = is_array($page_attr[ 'function' ]) ? $page_attr[ 'function' ][0].'::'.$page_attr[ 'function' ][1] : $page_attr[ 'function' ] ; ?>
			<div id = "<?php echo $page_attr['menu_slug']; ?>" class="cherry-page-wrapper">
		<?php if($page_attr[ 'page_title' ]){ ?>
				<div class="cherry-page-title">
					<span><?php  echo $page_attr[ 'page_title' ]; ?></span>
				</div>
		<?php }
			echo $page_attr[ 'before_content' ];
		?>
				<div class="cherry-page-content cherry-ui-core">
					<?php call_user_func ($page_content); ?>
				</div>
			</div>
			<?php
			echo $page_attr[ 'after_content' ];
		}

		public static function enqueue_admin_scripts( $page_hook ){
			if ( array_key_exists ( $page_hook , self::$pages[ 'parent' ] ) || array_key_exists ( $page_hook , self::$pages[ 'child' ] ) ) {
				wp_enqueue_style( 'page-builder', trailingslashit( CHERRY_URI ) . 'admin/assets/css/page-builder.css', array(), CHERRY_VERSION, 'all' );
			}
		}
	}
}
?>