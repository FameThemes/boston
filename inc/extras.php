<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Boston
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function boston_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'boston_body_classes' );

/**
 * Wrap widget category post count in span
 */
add_filter('wp_list_categories', 'boston_cat_count_span');
function boston_cat_count_span( $links ) {
	$links = str_replace('</a> (', '</a> <span>(', $links);
	$links = str_replace(')', ')</span>', $links);
	return $links;
}

/**
 * Custom excerpt more
 */
function boston_custom_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'boston_custom_excerpt_more' );
