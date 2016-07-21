<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Boston
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<div class="comments-title">
			<span class="comment_number_count">
			<?php
				printf( // WPCS: XSS OK.
					esc_html( _nx( 'One comment', '%1$s comments', get_comments_number(), 'comments title', 'boston' ) ),
					number_format_i18n( get_comments_number() )
				);
			?>
			</span>
			<?php if ( comments_open() ) { ?>
			<span class="add_yours">
				<a href="#respond"><?php esc_html_e( 'Add yours', 'boston' ); ?></a>
			</span>
			<?php } ?>
		</div>

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size' => 42,
				) );
			?>
		</ol><!-- .comment-list -->

		<?php the_comments_navigation(); ?>

		<?php
	endif; // Check for have_comments().


	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'boston' ); ?></p>
	<?php
	endif;
	comment_form( array(
		'title_reply_before' => '<h4 id="reply-title" class="comment-reply-title">',
		'title_reply_after'  => '</h4>',
	) );
	?>

</div><!-- #comments -->
