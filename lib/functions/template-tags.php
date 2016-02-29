<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Cherry Framework
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Add breadcrumbs.
add_action( 'cherry_content_before', 'cherry_get_breadcrumbs', 5 );

// Add pagination to the blog loop.
add_action( 'cherry_loop_before', 'cherry_paging_nav' );
add_action( 'cherry_loop_after',  'cherry_paging_nav' );

// Add post navigation.
add_action( 'cherry_entry_after', 'cherry_post_nav' );

// Add `About Author` section.
add_action( 'cherry_entry_after', 'cherry_get_author_bio', 15 );

// Add `Related Post` section.
add_action( 'cherry_entry_after', 'cherry_get_related_posts', 20 );

// Add `Maintenance Mode`.
add_action( 'cherry_body_start', 'cherry_maintenance_mode', 0 );

/**
 * Add breadcrumbs output to template.
 *
 * @since 4.0.0
 */
function cherry_get_breadcrumbs() {
	$show       = cherry_get_option( 'breadcrumbs', 'true' );
	$show       = ( 'true' == $show ) ? true : false;
	$show_title = cherry_get_option( 'breadcrumbs-show-title', 'false' );
	$show_title = ( 'true' == $show_title ) ? true : false;

	if ( ! $show && ! $show_title ) {
		return;
	}

	$browse_label = array();
	$browse_label['browse'] = cherry_get_option( 'breadcrumbs-prefix-path' );

	$show_on = cherry_get_option( 'breadcrumbs-display' );

	$show_mobile = ( is_array( $show_on ) && in_array( 'mobile', $show_on ) ) ? true : false;
	$show_tablet = ( is_array( $show_on ) && in_array( 'tablet', $show_on ) ) ? true : false;

	$show_on_front = cherry_get_option( 'breadcrumbs-show-on-front', 'false' );
	$show_on_front = ( 'true' == $show_on_front ) ? true : false;

	/**
	 * Filter a custom arguments.
	 *
	 * @since 4.0.0
	 * @param array $user_args Arguments.
	 */
	$user_args = apply_filters( 'cherry_breadcrumbs_custom_args', array() );

	$wrapper_format = '<div class="row">
		<div class="col-md-5 col-sm-12">%s</div>
		<div class="col-md-7 col-sm-12">%s</div>
	</div>';

	$options_args = array(
		'separator'      => cherry_get_option( 'breadcrumbs-separator', '&#47;' ),
		'show_mobile'    => $show_mobile,
		'show_tablet'    => $show_tablet,
		'show_on_front'  => $show_on_front,
		'show_title'     => $show_title,
		'show_items'     => $show,
		'labels'         => $browse_label,
		'wrapper_format' => $wrapper_format,
	);

	$args = array_merge( $options_args, $user_args );

	$breadcrumbs = new cherry_breadcrumbs( $args );
	$breadcrumbs->get_trail();
}

/**
 * Display paged navigation for posts loop when applicable.
 *
 * @since 4.0.0
 */
function cherry_paging_nav() {
	$current_hook = current_filter();
	$position     = cherry_get_option( 'pagination-position', 'after' );

	// If position in option set only 'before' and this is not 'cherry_loop_before' hook - do anything.
	if ( 'before' == $position && 'cherry_loop_before' != $current_hook ) {
		return;
	}

	// If position in option set only 'after' and this is not 'cherry_loop_after' hook - do anything.
	if ( 'after' == $position && 'cherry_loop_after' != $current_hook ) {
		return;
	}

	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}

	$prev_next = cherry_get_option( 'pagination-next-previous' );
	$show_all  = cherry_get_option( 'pagination-show-all' );

	$prev_next = ( 'true' == $prev_next ) ? true : false;
	$show_all  = ( 'true' == $show_all ) ? true : false;

	// Get slider args from options.
	$options_args = array(
		'prev_next'          => $prev_next,
		'prev_text'          => cherry_get_option( 'pagination-previous-page' ),
		'next_text'          => cherry_get_option( 'pagination-next-page' ),
		'screen_reader_text' => cherry_get_option( 'pagination-label' ),
		'show_all'           => $show_all,
		'end_size'           => cherry_get_option( 'pagination-end-size', 1 ),
		'mid_size'           => cherry_get_option( 'pagination-mid-size', 2 ),
	);

	/**
	 * Filters additional pagination args.
	 *
	 * @since 4.0.0
	 * @param array $custom_args Pagination arguments.
	 */
	$custom_args = apply_filters(
		'cherry_pagination_custom_args',
		array(
			'add_fragment' => '',
			'add_args'     => false,
		)
	);

	$args = array_merge( $options_args, $custom_args );

	if ( function_exists( 'the_posts_pagination' ) ) {
		the_posts_pagination( $args );
	}
}

/**
 * Display navigation to next/previous post when applicable.
 *
 * @since 4.0.0
 * @since 4.0.5   Using a native WordPress function `the_post_navigation`.
 * @since 4.0.5.1 Stop using a native function `the_post_navigation` - absence a important
 *                CSS-class `.paging-navigation`
 */
function cherry_post_nav() {
	$post_type         = get_post_type();
	$navigation_status = cherry_get_option( 'blog-post-navigation', 'true' );

	if ( ( 'page' === $post_type )
		|| ! is_singular( $post_type )
		|| is_attachment()
		|| ( 'false' === $navigation_status ) ) {
		return;
	}

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	} ?>
	<nav class="navigation post-navigation" role="navigation">
		<div class="paging-navigation">
			<div class="nav-links">
				<?php
					previous_post_link( '<div class="nav-previous">%link</div>', '%title' );
					next_post_link( '<div class="nav-next">%link</div>', '%title' );
				?>
			</div>
		</div>
	</nav>
	<?php
}

/**
 * Retrieves an attachment ID based on an attachment file URL.
 *
 * @since  4.0.0
 * @param  string $url Attachment URL.
 * @return int         Attachment ID.
 */
function cherry_get_attachment_id_from_url( $url ) {
	global $wpdb;

	$prefix = $wpdb->prefix;

	$posts = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM " . $prefix . "posts" . " WHERE guid='%s';", $url ) );

	return array_shift( $posts );
}

/**
 * Retrieve a related posts data array.
 *
 * @since  4.0.0
 * @param  array $args    Arguments list.
 * @param  int   $post_id Post ID to get related for.
 * @return array          Array with related posts data.
 */
function cherry_get_related_post_list( $args = array(), $post_id = null ) {
	$post_id   = ( null !== $post_id ) ? $post_id : get_the_id();
	$post_type = get_post_type( $post_id );

	$default_args = array(
		'num'          => 4,
		'get_by_tax'   => 'category,post_tag', // taxonomy name or false, may pass comma separated taxes
		'relation'     => 'AND', // if multiplie taxonomies passed - relation between tax queries
		'get_by_title' => false, // search related post by current post title or not (higher priority to tax)
		'age'          => false, // false - search all, integer - search post not older than passed num months
	);

	$args = wp_parse_args( $args, $default_args );

	/**
	 * Early filter related query output to rewrite it from child theme or third party plugins.
	 *
	 * @since 4.0.0
	 * @param bool  false    False by default.
	 * @param array $args    Arguments list.
	 * @param int   $post_id Post ID to get related for.
	 */
	$related_query = apply_filters( 'cherry_pre_get_related_query', false, $args, $post_id );

	if ( false !== $related_query ) {
		return $related_query;
	}

	$default_query_args = array(
		'post_type'           => $post_type,
		'post__not_in'        => array( $post_id ),
		'ignore_sticky_posts' => true,
		'posts_per_page'      => $args['num'],
	);

	$related_query_args = $default_query_args;
	$search_query       = false;

	// If passed taxonomies to search posts in - process post terms.
	if ( false !== $args['get_by_tax'] && true !== $args['get_by_title'] ) {

		$taxes     = explode( ',', $args['get_by_tax'] );
		$tax_query = array();

		foreach ( $taxes as $tax ) {
			$post_terms = wp_get_post_terms( $post_id, $tax );

			if ( is_wp_error( $post_terms ) ) {
				continue;
			}

			$terms = wp_list_pluck( $post_terms, 'term_id' );
			$tax_query[] = array(
				'taxonomy' => $tax,
				'field'    => 'id',
				'terms'    => $terms
			);
		}

		if ( 1 < count( $tax_query ) ) {
			$tax_query = array_merge( array( 'relation' => $args['relation'] ), $tax_query );
		}

		$related_query_args['tax_query'] = $tax_query;
	}

	$date_query = false;

	// If limited posts age.
	if ( false !== $args['age'] && 0 != intval( $args['age'] ) ) {

		$age = intval( $args['age'] );

		$age_after = strtotime( date( 'F j, Y' ) . ' -' . $age . ' months' );

		$date_query = array(
			array(
				'after' => date( 'F j, Y', $age_after ),
			)
		);

		$related_query_args['date_query'] = $date_query;
	}

	// If enabled search related by title.
	if ( false !== $args['get_by_title'] ) {

		preg_match( '/^(\w+)\W+(\w+)/i', get_the_title( $post_id ), $matches );

		$search_request = '';

		if ( is_array( $matches ) ) {

			if ( isset( $matches[1] ) ) {
				$search_request .= $matches[1];
			}

			if ( isset( $matches[2] ) ) {
				$search_request .= ' ' . $matches[2];
			}
		}

		$search_args = array_merge(
			$default_query_args,
			array( 's' => $search_request )
		);

		if ( $date_query ) {
			$search_args['date_query'] = $date_query;
		}

		$search_query = new WP_Query( $search_args );
	}

	$related_query = new WP_Query( $related_query_args );

	if ( $search_query ) {
		return $search_query;
	} else {
		return $related_query;
	}
}

/**
 * Display a related posts.
 *
 * @since 4.0.0
 */
function cherry_get_related_posts() {
	global $post;

	if ( 'false' == cherry_get_option( 'blog-related-posts' ) ) {
		return;
	}

	if ( ! is_singular( 'post' ) ) {
		return;
	}

	/**
	 * Filter a related posts arguments.
	 *
	 * @since 4.0.0
	 * @param array $related_args Arguments.
	 */
	$related_args = apply_filters( 'cherry_related_posts_args', array(
		'num'      => 4,
		'relation' => 'OR',
	) );
	$related_query = cherry_get_related_post_list( $related_args );

	if ( ! $related_query->have_posts() ) {
		return;
	}

	$default_args = array(
		'format_block' => '<div class="related-posts">%1$s%2$s</div>',
		'format_list'  => '<%1$s class="related-posts_list row list-unstyled">%2$s</%1$s>',
		'format_item'  => '<%1$s class="related-posts_item col-xs-12 col-sm-6 col-md-%3$s">%2$s</%1$s>',
		'format_title' => '<h3 class="related-posts_title">%1$s</h3>',
		'wrapper_list' => 'ul',
		'wrapper_item' => 'li',
	);

	/**
	 * Filter related posts output arguments.
	 *
	 * @since 4.0.0
	 * @param array $default_args Default arguments.
	 */
	$args = apply_filters( 'cherry_related_posts_output_args', $default_args );
	$args = wp_parse_args( $args, $default_args );

	$block_title = sprintf( $args['format_title'], __( 'Related Posts', 'cherry' ) );

	$content = '';

	foreach ( $related_query->posts as $post ) {

		// Sets up global post data.
		setup_postdata( $post );

		/**
		 * Filter a template for related post.
		 *
		 * @since 4.0.0
		 * @param array $templates Set of templates.
		 */
		$templates = apply_filters( 'cherry_related_post_template_hierarchy', array( 'content/related-post.tmpl' ) );

		$item_body = cherry_parse_tmpl( $templates );

		$content .= sprintf( $args['format_item'], $args['wrapper_item'], $item_body, floor( 12 / $related_args['num'] ) );
	}

	wp_reset_postdata();
	wp_reset_query();

	$content = sprintf( $args['format_list'], $args['wrapper_list'], $content );

	$result = sprintf(
		$args['format_block'],
		$block_title, $content
	);

	echo $result;
}

/**
 * Display a `Author Bio` (Written by username) section.
 *
 * @since  4.0.1
 * @return string
 */
function cherry_get_author_bio() {
	$author_bio_status = ( 'false' == cherry_get_option( 'blog-post-author-bio' ) || ( ! is_singular('post') ) ) ? false : true;

	/**
	 * Filters a author bio status.
	 *
	 * @since 4.0.1
	 * @param bool|mixed $result Value to return instead of the author bio status.
	 */
	$pre = apply_filters( 'cherry_pre_get_author_bio', $author_bio_status );

	if ( false === $pre ) {
		return;
	}

	$defaults = array(
		'wrap' => '<div class="author-bio clearfix">%s</div>',
	);

	/**
	 * Filter a default arguments.
	 *
	 * @since 4.0.1
	 * @param array $defaults Arguments.
	 */
	$args = apply_filters( 'cherry_get_author_bio_defaults', $defaults );
	$args = wp_parse_args( $args, $defaults );

	/**
	 * Filter a set of templates for author bio.
	 *
	 * @since 4.0.1
	 * @param array $templates Set of templates.
	 */
	$templates = apply_filters( 'cherry_author_bio_template_hierarchy', array( 'content/author-bio.tmpl' ) );

	$output = cherry_parse_tmpl( $templates );

	printf( $args['wrap'], $output );
}

/**
 * Dispaly a `Maintenance mode`.
 *
 * @since 4.0.0
 */
function cherry_maintenance_mode() {
	$enabled = cherry_get_option( 'general-maintenance-mode', false );

	if ( isset( $_GET['maintenance-preview'] )
		&& isset( $_GET['nonce'] )
		&& wp_verify_nonce( $_GET['nonce'], 'cherry-maintenance-preview' )
	) {
		$preview_mode = true;
	} else {
		$preview_mode = false;
	}

	if ( 'true' !== $enabled && ! $preview_mode ) {
		return;
	}

	if ( is_user_logged_in() && current_user_can( 'manage_options' ) && ! $preview_mode ) {
		return;
	}

	/**
	 * Filter a set of templates for `Maintenance mode`.
	 *
	 * @since 4.0.1
	 * @param array $templates Set of templates.
	 */
	$templates = apply_filters( 'cherry_maintenance_mode_template_hierarchy', array( 'content/maintenance.tmpl' ) );

	$result = cherry_parse_tmpl( $templates );

	/** This filter is documented in wp-includes/post-template.php */
	echo apply_filters( 'the_content', $result );

	wp_footer(); ?>
	</body>
	</html>
	<?php
	die();
}

/**
 * Retrieve a site logo and description to show it via template macros.
 *
 * @since 4.0.0
 * @return string Site logo and description.
 */
function cherry_get_the_post_logo() {
	$result = '';

	if ( cherry_get_site_logo() || cherry_get_site_description() ) {

		$result = sprintf( '<div class="site-branding">%1$s %2$s</div>',
			cherry_get_site_logo(),
			cherry_get_site_description()
		);
	}

	return $result;
}

/**
 * Retrieve a maintenance page content to show it via template macros.
 *
 * @since 4.0.0
 * @return string Page content.
 */
function cherry_get_the_post_maintenance_content() {
	$page_id = cherry_get_option( 'general-maintenance-page', false );

	if ( ! $page_id ) {
		return;
	}

	$page = get_post( $page_id );

	return $page->post_content;
}
