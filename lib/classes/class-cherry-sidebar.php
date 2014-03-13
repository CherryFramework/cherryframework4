<?php
/**
 * Determines whether or not to display the sidebar based on an array of conditional tags or page templates.
 * If any of the is_* conditional tags or is_page_template(template_file) checks return true,
 * the sidebar will NOT be displayed.
 *
 * @package    Cherry_Framework
 * @subpackage Classes
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2014, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Class for determines whether or not to display the sidebar.
 *
 * @since  4.0.0
 *
 * @access public
 * @return boolean true Will display the sidebar, false - will not
 */
class Cherry_Sidebar {
	/**
	 * Stores the conditional tags.
	 *
	 * @since 4.0.0
	 *
	 * @var   array
	 */
	private $conditionals;

	/**
	 * Stores the templates filename with ext.
	 *
	 * @since 4.0.0
	 *
	 * @var   array
	 */
	private $templates;

	/**
	 * Display or not the sidebar?
	 *
	 * @since 4.0.0
	 *
	 * @var   boolean
	 */
	public $display = true;

	/**
	 * Initialize new Cherry_Sidebar's instance.
	 *
	 * @since 4.0.0
	 *
	 * @param array $conditionals List of conditional tags (http://codex.wordpress.org/Conditional_Tags)
	 * @param array $templates    List of page templates. These will be checked via is_page_template()
	 */
	public function __construct( $conditionals = array(), $templates = array() ) {
		$this->conditionals = $conditionals;
		$this->templates    = $templates;

		$conditionals = array_map( array( $this, 'check_conditional_tag' ), $this->conditionals );
		$templates    = array_map( array( $this, 'check_page_template' ), $this->templates );

		if ( in_array( true, $conditionals ) || in_array( true, $templates ) ) {
			$this->display = false;
		}
	}

	/**
	 * This function to execute conditional tag(s)
	 *
	 * @since  4.0.0
	 *
	 * @param  string|array $conditional_tag
	 * @return boolean
	 */
	private function check_conditional_tag( $conditional_tag ) {

		// Used the concept of variable functions (http://www.php.net/manual/en/functions.variable-functions.php)
		if ( is_array( $conditional_tag ) ) {
			return $conditional_tag[0]( $conditional_tag[1] );
		} else {
			return $conditional_tag();
		}
	}

	/**
	 * This function allows to determine if you are in any page template.
	 *
	 * @since  4.0.0
	 *
	 * @param  string $page_template Full template filename with ext
	 * @return boolean
	 */
	private function check_page_template( $page_template ) {
		return is_page_template( $page_template );
	}
}