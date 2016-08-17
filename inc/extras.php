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

/**
 * Custom styling
 *
 * @return string
 */
function boston_get_custom_style(){
    $css = '';
    $primary_color = get_theme_mod( 'styling_color_primary' );
    if ( $primary_color ) {
        $primary_color = '#'.esc_attr( $primary_color );

$css .= '.archive__layout1 .entry-more a:hover {
    border-color: '.$primary_color.';
    background: '.$primary_color.';
}
a.entry-category {
    background: '.$primary_color.';
}
.entry-content a, .comment-content a {
	color: '.$primary_color.';
}
.sticky .entry-title:before {
	color: '.$primary_color.';
}
.search-results .page-title span {
	color: '.$primary_color.';
}
.widget_categories li a {
	color: '.$primary_color.';
}
@media (min-width: 992px) {
	.main-navigation .current_page_item > a,
	.main-navigation .current-menu-item > a,
	.main-navigation .current_page_ancestor > a,
	.main-navigation .current-menu-ancestor > a {
		color: '.$primary_color.';
	}
}';

    }
    return $css;
}
