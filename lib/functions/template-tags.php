<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Cherry Framework
 */
add_action( 'cherry_endwhile_after', 'cherry_paging_nav' );

if ( !function_exists( 'cherry_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function cherry_paging_nav() {

	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	} ?>

	<nav class="navigation paging-navigation" role="navigation">
		<div class="<?php echo cherry_get_container_class( 'paging-navigation' ); ?>">
			<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'cherry' ); ?></h1>
			<div class="nav-links">

				<?php if ( get_next_posts_link() ) : ?>
				<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'cherry' ) ); ?></div>
				<?php endif; ?>

				<?php if ( get_previous_posts_link() ) : ?>
				<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'cherry' ) ); ?></div>
				<?php endif; ?>

			</div><!-- .nav-links -->
		</div>
	</nav><!-- .navigation -->
	<?php
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
		<div class="<?php echo cherry_get_container_class( 'paging-navigation' ); ?>">
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