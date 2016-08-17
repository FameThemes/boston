<?php
/**
 * Boston Theme Customizer.
 *
 * @package Boston
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function boston_customize_register( $wp_customize ) {

	// Custom WP default control & settings.
	$wp_customize->get_section( 'title_tagline' )->title = esc_html__('Site Title, Tagline & Logo', 'boston');
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';


    /*------------------------------------------------------------------------*/

    $wp_customize->add_section( 'styling' ,
        array(
            'priority'    => 24,
            'title'       => esc_html__( 'Styling', 'boston' ),
            'description' => '',
        )
    );
    $wp_customize->add_setting( 'styling_color_primary', array(
        'default'     => '#d65456',
        'sanitize_callback' => 'sanitize_hex_color_no_hash',
        'sanitize_js_callback' => 'maybe_hash_hex_color',
    ) );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'styling_color_primary',
            array(
                'label'      => esc_html__( 'Primary Color', 'boston' ),
                'section'    => 'styling',
            )
        )
    );




}
add_action( 'customize_register', 'boston_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function boston_customize_preview_js() {
	wp_enqueue_script( 'boston_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'boston_customize_preview_js' );
