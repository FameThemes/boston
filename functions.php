<?php
/**
 * Boston functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Boston
 */

if ( ! function_exists( 'boston_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function boston_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Boston, use a find and replace
	 * to change 'boston' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'boston', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for custom logo.
	 *
	 * @link https://developer.wordpress.org/reference/functions/add_theme_support/#custom-logo
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 60,
		'width'       => 240,
		'flex-width'  => true,
		'flex-height' => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	/*
	 * Custom image sizes
	 */
	add_image_size( 'boston-list-medium', 732, 380, true ); /* image size larger for mobile */
	add_image_size( 'boston-featured-medium', 500, 350, true ); /* image size larger for mobile */

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'boston' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'boston_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

}
endif;
add_action( 'after_setup_theme', 'boston_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function boston_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'boston_content_width', 720 );
}
add_action( 'after_setup_theme', 'boston_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function boston_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'boston' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'boston' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget-title">',
		'after_title'   => '</div>',
	) );
}
add_action( 'widgets_init', 'boston_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function boston_scripts() {
	wp_enqueue_style( 'boston-fonts', boston_fonts_url(), array(), null );
	wp_enqueue_style( 'boston-style', get_stylesheet_uri() );
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/assets/fonts/genericons/genericons.css', array(), '3.4.1' );
	wp_enqueue_style( 'boston-norwester-font', get_template_directory_uri() . '/assets/css/font-norwester.css', array() );

	// We don't need to prefix owl-carousel to avoid duplicate load just like genericons.
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array('jquery'), '1.3.3', true );
	wp_enqueue_script( 'boston-themejs', get_template_directory_uri() . '/assets/js/theme.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
    if ( function_exists( 'boston_get_custom_style' ) ) {
        wp_add_inline_style( 'boston-style', boston_get_custom_style() );
    }

}
add_action( 'wp_enqueue_scripts', 'boston_scripts' );

if ( ! function_exists( 'boston_fonts_url' ) ) :
/**
* Register Google fonts.
* Create your own boston_fonts_url() function to override in a child theme.
*/
function boston_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/* translators: If there are characters in your language that are not supported by Open Sans, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'boston' ) ) {
		$fonts[] = 'Open Sans:300,300i,400,400i,600,600i,700,700i';
	}

	/* translators: If there are characters in your language that are not supported by Playfair Display, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Playfair Display font: on or off', 'boston' ) ) {
		$fonts[] = 'Playfair Display:400,400i,700,700i';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Add theme info page
 */
require get_template_directory() . '/inc/dashboard.php';

// Testing gitgutter
