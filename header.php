<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Boston
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'boston' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-topbar">
			<div class="container">
				<nav id="site-navigation" class="main-navigation" role="navigation">
					<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'boston' ); ?></button>
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
				</nav><!-- #site-navigation -->
				<?php do_action('boston_before_top_searchform'); ?>
				<div class="topbar-search">
					<?php do_action('boston_top_searchform'); ?>
					<form action="/" method="get">
					    <input type="text" name="s" id="search" value="<?php the_search_query(); ?>" placeholder="<?php esc_html_e('Search and hit enter...', 'boston') ?>" />
						<span class="genericon genericon-search"></span>
						<!-- <i class="fa fa-search" aria-hidden="true"></i> -->
					</form>
				</div>
			</div>
		</div>

		<div class="site-branding">
			<div class="container">
				<?php
				if ( function_exists( 'the_custom_logo' ) ) {
					the_custom_logo();
				}

				if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php else : ?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
				endif;

				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
					<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
				<?php
				endif; ?>
				<?php do_action('boston_after_site_description'); ?>
			</div>
		</div><!-- .site-branding -->

	</header><!-- #masthead -->

	<?php if ( is_archive() ) { ?>
		<header class="page-header archive-header">
			<div class="container">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</div>
		</header><!-- .page-header -->
	<?php } ?>

	<?php if ( is_home() || is_front_page() ) : ?>
		<div id="featured-content">
			<?php get_template_part( 'template-parts/loop', 'featured' ); ?>
		</div>
	<?php endif; ?>

	<div id="content" class="site-content">
		<div class="container">
