<?php
/**
 * @package    Cherry_Framework
 * @subpackage Class
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Footer Info static.
 */
class cherry_footer_info_static extends cherry_register_static {

	/**
	 * Callback-method for registered static.
	 * @since 4.0.0
	 */
	public function callback() {

		$footer_text = cherry_get_option( 'footer-text' );

		if ( ! empty( $footer_text ) ) {

			$footer_text = preg_replace_callback(
				'/%%([a-zA-Z0-9-_]+)%%/',
				array( $this, 'texturize_links' ),
				$footer_text
			);

			printf( '<div class="site-info">%s</div>', $footer_text );
			return;
		}

		$format = apply_filters( 'cherry_default_footer_info_format', '%2$s &copy; %1$s. %3$s' );

		$output = '<div class="site-info">';
		$output .= sprintf(
			$format,
			date_i18n( 'Y' ), cherry_get_site_link( 'footer-site-link' ), cherry_get_link_by_slug( 'privacy-policy' )
		);
		$output .= '</div>';
		echo $output;
	}

	/**
	 * Replace page link makros with real links
	 *
	 * @since 4.0.0
	 * @param mixed $matches text to search macros in
	 */
	public function texturize_links( $matches ) {

		if ( ! isset( $matches[1] ) ) {
			return $matches[0];
		} else {
			return cherry_get_link_by_slug( $matches[1] );
		}

	}

}

/**
 * Registration for Footer Info static.
 */
new cherry_footer_info_static(
	array(
		'id'      => 'footer_info',
		'name'    => __( 'Footer Info', 'cherry' ),
		'options' => array(
			'col-lg'   => 'col-lg-4',
			'col-md'   => 'col-md-4',
			'col-sm'   => 'col-sm-12',
			'col-xs'   => 'col-xs-12',
			'position' => 2,
			'area'     => 'footer-bottom',
		)
	)
);