<?php
/**
 * Featured content loop.
 * @package Boston
 */

?>
<div class="site-featured-content">
    <?php
    $featured_posts = boston_get_featured_posts();

	// if we have no posts, our work is done here.
	if ( empty( $featured_posts ) )
		return;
    global $post;
	// Let's loop through our posts ?>
	<div class="featured_posts">
		<?php foreach ( $featured_posts as $post ) : setup_postdata( $post ); ?>
            <?php if ( has_post_thumbnail( ) ) { ?>
			<?php get_template_part( 'template-parts/content', 'featured' ); ?>
            <?php } ?>
		<?php endforeach; ?>
	</div>
	<?php wp_reset_postdata(); ?>
</div><!-- .site-feature-content -->
