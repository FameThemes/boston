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

    $layout = get_theme_mod( 'layout', 'right' );

    $classes[] = $layout.'-layout';

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
    $primary_color = esc_attr( get_theme_mod( 'styling_color_primary' ) );
    if ( $primary_color ) {
        $primary_color = '#'.$primary_color;

        /**
         * @TODO beautiful output code
         */
$css .= '.archive__layout1 .entry-more a:hover {
    border-color: '.$primary_color.';
    background: '.$primary_color.';
}
a.entry-category {
    background: '.$primary_color.';
}
.entry-content a, .comment-content a,
.sticky .entry-title:before,
.search-results .page-title span,
.widget_categories li a,
.footer-widget-area a {
	color: '.$primary_color.';
}
.entry-footer a {
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

function boston_get_featured_tags(){
    $jetpack_featured = get_option( 'featured-content' );
    $default_tag = '';
    if( is_array( $jetpack_featured ) && isset( $jetpack_featured['tag-name'] ) ) {
        $default_tag = wp_strip_all_tags( $jetpack_featured['tag-name'], true );
    }

    if ( ! $default_tag ) {
        $default_tag = 'featured';
    }

    $tags = wp_strip_all_tags( get_theme_mod( 'featured_tags', $default_tag ), true );
    $tags = explode( ',', $tags );
    $tags = array_map( 'trim', $tags );
    $tags = array_filter( $tags );
    if ( empty( $tags ) ) {
        return false;
    }
    return $tags;
}

function boston_setup_featured_content( $query ){
    if ( is_admin() ) {
        return ;
    }
    if ( $query->is_main_query() ) {
        if ( is_home() || is_front_page() || is_page_template() ) {
            if (!isset($GLOBALS['boston_featured_posts'])) {

                $tags = boston_get_featured_tags();
                if ( empty( $tags ) ) {
                   return;
                }

                $num_post = absint( get_theme_mod( 'featured_number', 10 ) );
                $featured_content_args = array(
                    'post_type' => 'post',
                    'meta_key' => '_thumbnail_id',
                    'tag' => join( ',', $tags ),
                    'order' => 'DESC',
                    'orderby' => 'date',
                    'posts_per_page' => $num_post,
                );

                if ( ! get_theme_mod( 'featured_thumb_only', 1 ) ) {
                    unset( $featured_content_args['meta_key'] );
                }

                $f_query = new WP_Query($featured_content_args);
                $GLOBALS['boston_featured_posts'] = ( array )$f_query->get_posts();
                $featured_ids = wp_list_pluck($GLOBALS['boston_featured_posts'], 'ID');
                $query->set('post__not_in', $featured_ids);
            }
        }

    }

}

/**
 * Get feature content posts.
 */
function boston_get_featured_posts() {
    return isset( $GLOBALS['boston_featured_posts'] ) ? $GLOBALS['boston_featured_posts'] : array();
}
add_action( 'pre_get_posts', 'boston_setup_featured_content' );


/**
 * Maybe Hide featured tags
 *
 * @param $terms
 * @param string $taxonomies
 * @return mixed
 */
function boston_hide_featured_tags( $terms, $taxonomies = '' ){
    if ( is_admin() ) {
        return $terms;
    }
    if ( ! get_theme_mod( 'featured_hide_tag', 1 ) ) {
        return $terms;
    }
    if ( is_array( $taxonomies ) ) {
        if ( ! in_array( 'post_tag', $taxonomies ) ) {
            return $terms;
        }
    } else if( is_string( $taxonomies ) ){
        if ( 'post_tag' != $taxonomies ) {
            return $terms;
        }
    } else {
        return $terms;
    }

    $tags = boston_get_featured_tags();
    if ( empty( $tags ) ) {
        return $terms;
    }

    foreach ( $terms as $k => $t ) {
        if ( is_array( $t ) ) {
            $slug = $t['slug'];
        } else {
            $slug = $t->slug;
        }
        if ( in_array( $slug, $tags ) ) {
            unset( $terms[ $k ] );
        }
    }

    return $terms;

}

add_filter( 'get_terms', 'boston_hide_featured_tags', 90, 2 );

/**
 * Hide the featured tag in single posts
 *
 * @param $terms
 * @param null $post_id
 * @param string $tax
 */
function boston_hide_post_featured_tags( $terms, $post_id = null, $tax = '' ){

    if ( is_admin() ) {
        return $terms;
    }

    if ( ! get_theme_mod( 'featured_hide_tag', 1 ) ) {
        return $terms;
    }

    if ( 'post_tag' != $tax ) {
        return $terms;
    }

    $tags = boston_get_featured_tags();
    if ( empty( $tags ) ) {
        return $terms;
    }

    foreach ( $terms as $k => $t ) {
        if ( is_array( $t ) ) {
            $slug = $t['slug'];
        } else {
            $slug = $t->slug;
        }
        if ( in_array( $slug, $tags ) ) {
            unset( $terms[ $k ] );
        }
    }

    return $terms;

}
add_filter( 'get_the_terms', 'boston_hide_post_featured_tags', 90, 3 );
