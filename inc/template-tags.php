<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Boston
 */

if ( ! function_exists( 'boston_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function boston_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$posted_on = sprintf(
		esc_html_x( '%s', 'post date', 'boston' ),
		'<span class="entry-date">' . $time_string . '</span>'
	);
	$byline = sprintf(
		esc_html_x( '%s', 'post author', 'boston' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);


	$category = get_the_category();
	$cate = '';
	if ( $category[0] ) {
		$cate = '<span class="entry-cate"><a class="entry-category" href="'.esc_url( get_category_link($category[0]->term_id ) ).'">'.$category[0]->cat_name.'</a></span>';
	}


	echo $cate.$byline.$posted_on;
	if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		echo '<i class="genericon genericon-comment"></i>';
		comments_popup_link( '0', '1', '%' );
		echo '</span>';
	}

}
endif;

if ( ! function_exists( 'boston_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function boston_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'boston' ) );
		if ( $categories_list && boston_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'boston' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'boston' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'boston' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		/* translators: %s: post title */
		comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'boston' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'boston' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function boston_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'boston_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'boston_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so boston_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so boston_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in boston_categorized_blog.
 */
function boston_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'boston_categories' );
}
add_action( 'edit_category', 'boston_category_transient_flusher' );
add_action( 'save_post',     'boston_category_transient_flusher' );

/**
 * Output the theme info to 'boston_theme_info' hook.
 */
if ( ! function_exists( 'boston_footer_credit' ) ) {
    /**
     * Add Copyright and Credit text to footer
     * @since 1.1.3
     */
    function boston_footer_credit()
    {
        ?>
		<span class="theme-info-text">
        <?php printf( esc_html__( 'Boston Theme by %1$s', 'boston' ), '<a href="https://www.famethemes.com/">FameThemes</a>' ); ?>
		</span>
        <?php
    }
}
add_action( 'boston_theme_info', 'boston_footer_credit' );
