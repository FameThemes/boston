<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Boston
 */

?>
		</div><!-- .container -->
	</div><!-- #content -->

	<?php do_action('boston_before_footer'); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">

		<?php do_action('boston_footer_start'); ?>

		<div class="container">
			<div class="site-info">
				<p>
					<?php printf( esc_html__( 'Copyright &copy; %1$s %2$s. All Rights Reserved.', 'boston' ), date('Y'), get_bloginfo( 'name' ) ); ?>
				</p>
			</div><!-- .site-info -->
			<div class="theme-info">
				<?php do_action('boston_theme_info'); ?>
			</div>
		</div>
	</footer><!-- #colophon -->

	<?php do_action('boston_after_footer'); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
