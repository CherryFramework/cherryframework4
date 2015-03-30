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

	$options_args = array(
		'separator'     => cherry_get_option( 'breadcrumbs-separator', '&#47;' ),
		'show_mobile'   => $show_mobile,
		'show_tablet'   => $show_tablet,
		'show_on_front' => $show_on_front,
		'show_title'    => $show_title,
		'labels'        => $browse_label
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