<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Cherry Framework
 */

// add breadcrumbs to template
add_action( 'cherry_content_before', 'cherry_get_breadcrumbs', 5 );
// add related posts output
add_action( 'cherry_entry_after',    'cherry_get_related_posts', 15 );


/**
 * Add breadcrumbs output to template
 *
 * @since 4.0.0
 */
function cherry_get_breadcrumbs() {

	$show = cherry_get_option( 'breadcrumbs', 'true' );

	if ( 'true' != $show ) {
		return;
	}

	$browse_label = array();
	$browse_label['browse'] = cherry_get_option( 'breadcrumbs-prefix-path' );

	$show_on = cherry_get_option( 'breadcrumbs-display' );

	$show_mobile = ( is_array( $show_on ) && in_array( 'mobile', $show_on ) ) ? true : false;
	$show_tablet = ( is_array( $show_on ) && in_array( 'tablet', $show_on ) ) ? true : false;

	$show_on_front = cherry_get_option( 'breadcrumbs-show-on-front', 'false' );
	$show_on_front = ( 'true' == $show_on_front ) ? true : false;

	$show_title = cherry_get_option( 'breadcrumbs-show-title', 'false' );
	$show_title = ( 'true' == $show_title ) ? true : false;

	$user_args = apply_filters( 'cherry_breadcrumbs_custom_args', array() );

	$wrapper_format = '<div class="row">
		<div class="col-md-5">%s</div>
		<div class="col-md-7">%s</div>
	</div>';

	$options_args = array(
		'separator'      => cherry_get_option( 'breadcrumbs-separator', '&#47;' ),
		'show_mobile'    => $show_mobile,
		'show_tablet'    => $show_tablet,
		'show_on_front'  => $show_on_front,
		'show_title'     => $show_title,
		'labels'         => $browse_label,
		'wrapper_format' => $wrapper_format
	);

	$args = array_merge( $options_args, $user_args );

	$breadcrumbs = new cherry_breadcrumbs( $args );
	$breadcrumbs->get_trail();
}

// add paginction to blog loop
add_action( 'cherry_loop_before', 'cherry_paging_nav' );
add_action( 'cherry_loop_after', 'cherry_paging_nav' );

if ( !function_exists( 'cherry_paging_nav' ) ) :
/**
 * Display pged navigation for posts loop when applicable.
 *
 * @since  4.0.0
 */
function cherry_paging_nav() {

	$current_hook = current_filter();
	$position     = cherry_get_option( 'pagination-position', 'after' );

	// if position in option set only 'before' and this is not 'cherry_loop_before' hook - do anything
	if ( 'before' == $position && 'cherry_loop_before' != $current_hook ) {
		return;
	}

	// if position in option set only 'after' and this is not 'cherry_loop_after' hook - do anything
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

	// get slider args from options
	$options_args = array(
		'prev_next'          => $prev_next,
		'prev_text'          => cherry_get_option( 'pagination-previous-page' ),
		'next_text'          => cherry_get_option( 'pagination-next-page' ),
		'screen_reader_text' => cherry_get_option( 'pagination-label' ),
		'show_all'           => $show_all,
		'end_size'           => cherry_get_option( 'pagination-end-size', 1 ),
		'mid_size'           => cherry_get_option( 'pagination-mid-size', 2 )
	);

	// get additional pagination args
	$custom_args = apply_filters(
		'cherry_pagination_custom_args',
		array(
			'add_fragment' => '',
			'add_args'     => false
		)
	);

	$args = array_merge( $options_args, $custom_args );

	if ( function_exists( 'the_posts_pagination' ) ) {
		// Previous/next page navigation.
		the_posts_pagination( $args );
	}

}
endif;

add_action( 'cherry_post_after', 'cherry_post_nav' );

if ( !function_exists( 'cherry_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function cherry_post_nav() {

	if ( !is_singular( get_post_type() ) || is_attachment() ) {
		return;
	}

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( !$next && !$previous ) {
		return;
	} ?>
	<nav class="navigation post-navigation" role="navigation">
		<div class="paging-navigation">
			<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'cherry' ); ?></h1>
			<div class="nav-links">
				<?php
					previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&larr;</span>&nbsp;%title', 'Previous post link', 'cherry' ) );
					next_post_link(     '<div class="nav-next">%link</div>',     _x( '%title&nbsp;<span class="meta-nav">&rarr;</span>', 'Next post link',     'cherry' ) );
				?>
			</div><!-- .nav-links -->
		</div>
	</nav><!-- .navigation -->
	<?php
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function cherry_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'cherry_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'cherry_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so cherry_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so cherry_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in cherry_categorized_blog.
 */
function cherry_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'cherry_categories' );
}
add_action( 'edit_category', 'cherry_category_transient_flusher' );
add_action( 'save_post',     'cherry_category_transient_flusher' );

/**
 * Retrieves an attachment ID based on an attachment file URL.
 *
 * @since  4.0.0
 * @param  string  $url
 * @return int
 */
function cherry_get_attachment_id_from_url( $url ) {
	global $wpdb;

	$prefix = $wpdb->prefix;

	$posts = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM " . $prefix . "posts" . " WHERE guid='%s';", $url ) );

	return array_shift( $posts );
}

/**
 * Get related posts data array
 *
 * @since 4.0.0
 *
 * @param array $args    arguments list
 * @param int   $post_id post ID to get related for
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
	 * @since  4.0.0
	 * @param  bool   false     false by default
	 * @param  array  $args     arguments list
	 * @param  int    $post_id  ost ID to get related for
	 */
	$related_query = apply_filters( 'cherry_pre_get_related_query', false, $args, $post_id );
	if ( false !== $related_query ) {
		return $related_query;
	}

	$default_query_args = array(
		'post_type'           => $post_type,
		'post__not_in'        => array( $post_id ),
		'ignore_sticky_posts' => true,
		'posts_per_page'      => $args['num']
	);

	$related_query_args = $default_query_args;
	$search_query       = false;

	// if passed taxonomies to search posts in - process post terms
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

		if ( empty( $tax_query ) ) {
			break;
		}

		if ( 1 < count( $tax_query ) ) {
			$tax_query = array_merge( array( 'relation' => $args['relation'] ), $tax_query );
		}

		$related_query_args['tax_query'] = $tax_query;

	}

	$date_query = false;

	// if limited posts age
	if ( false !== $args['age'] && 0 != intval( $args['age'] ) ) {

		$age = intval( $args['age'] );

		$age_after = strtotime( date( 'F j, Y' ) . ' -' . $age . ' months' );

		$date_query = array(
			array(
				'after' => date( 'F j, Y', $age_after )
			)
		);

		$related_query_args['date_query'] = $date_query;
	}

	// if enabled search related by title
	if ( false !== $args['get_by_title'] ) {

		preg_match( '/^(\w+)\W+(\w+)/i', get_the_title( $post_id ), $matches );

		if ( ! is_array( $matches ) ) {
			break;
		}

		$search_request = '';

		if ( isset( $matches[1] ) ) {
			$search_request .= $matches[1];
		}

		if ( isset( $matches[2] ) ) {
			$search_request .= ' ' . $matches[2];
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
 * Get related posts
 *
 * @since  4.0.0
 */
function cherry_get_related_posts() {

	if ( 'false' == cherry_get_option( 'blog-related-posts' ) ) {
		return;
	}

	if ( ! is_single() ) {
		return;
	}

	$related_query = cherry_get_related_post_list( array( 'num' => 4, 'relation' => 'OR' ) );

	if ( ! $related_query->have_posts() ) {
		return;
	}

	$default_args = array(
		'format_block'  => '<div class="related-posts">%1$s%2$s</div>',
		'format_list'   => '<%1$s class="related-posts_list">%2$s</%1$s>',
		'format_title'  => '<h3 class="related-posts_title">%1$s</h3>',
		'wrapper_list'  => 'ul',
		'wrapper_item'  => 'li',
		'template_item' => false
	);

	/**
	 * Filter related posts output arguments
	 */
	$args = apply_filters( 'cherry_related_posts_output_args', $default_args );
	$args = wp_parse_args( $args, $default_args );

	$block_title = sprintf( $args['format_title'], __( 'Related Posts', 'cherry' ) );

	$content = '';

	while ( $related_query->have_posts() ) {

		$related_query->the_post();

		ob_start();

		include( locate_template( array( 'content/related-post.tmpl' ), false, false ) );

		$template = ob_get_contents();
		ob_end_clean();

		$item_body = preg_replace_callback( "/%%.+?%%/", 'cherry_do_content', $template );
		$content  .= sprintf( '<%1$s class="related-posts_item">%2$s</%1$s>', $args['wrapper_item'], $item_body );
	}

	wp_reset_postdata();

	$content = sprintf( $args['format_list'], $args['wrapper_list'], $content );

	$result = sprintf(
		$args['format_block'],
		$block_title, $content
	);

	echo $result;
}

add_action( 'cherry_body_start', 'cherry_maintenance_mode', 0 );

/**
 * Maintenance mode
 *
 * @since 4.0.0
 */
function cherry_maintenance_mode() {

	$enabled = cherry_get_option( 'general-maintenance-mode', false );

	if ( 'true' !== $enabled ) {
		return;
	}

	if ( is_user_logged_in() && current_user_can( 'manage_options' ) ) {
		return;
	}

	ob_start();

	include( locate_template( array( 'content/maintenance.tmpl' ), false, false ) );

	$template = ob_get_contents();
	ob_end_clean();

	$result = preg_replace_callback( "/%%.+?%%/", 'cherry_do_content', $template );

	echo $result;

	?>
	<?php wp_footer(); ?>
	</body>
	</html>
	<?php
	die();
}

/**
 * Get site logo and description to show it via template macros
 *
 * @since 4.0.0
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
 * Get maintenance page content to show it via template macros
 *
 * @since 4.0.0
 */
function cherry_get_the_post_maintenance_content() {

	$page_id = cherry_get_option( 'general-maintenance-page', false );

	if ( ! $page_id ) {
		return;
	}

	$page = get_post( $page_id );

	return $page->post_content;

}