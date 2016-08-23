<?php
/**
 * Template part for displaying featured posts.
 *
 * @package Boston
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail( ) ) { ?>
	<aside class="entry-thumbnail">
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			<?php the_post_thumbnail( 'boston-featured-medium' ); ?>
		</a>
	</aside>
	<?php } ?>
	<header class="entry-header">
		<?php
		$category = get_the_category();
		$cate = '';
		if ( $category[0] ) {
			echo $cate = '<a class="featured-posts-cate" href="' . esc_url( get_category_link($category[0]->term_id ) ) . '">'.$category[0]->cat_name.'</a>';
		} ?>
		<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
	</header><!-- .entry-header -->
</article><!-- #post-## -->
