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

    require_once get_template_directory().'/inc/customizer-controls.php';

	// Custom WP default control & settings.
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';


    /*------------------------------------------------------------------------*/

    $wp_customize->add_panel( 'theme_options' ,
        array(
            'title'       => esc_html__( 'Theme Options', 'boston' ),
            'description' => ''
        )
    );

    /**
     * Featured Content
     */

    // Support jetpack tag
    $jetpack_featured = get_option( 'featured-content' );
    $default_tag = '';
    if( is_array( $jetpack_featured ) && isset( $jetpack_featured['tag-name'] ) ) {
        $default_tag = wp_strip_all_tags( $jetpack_featured['tag-name'], true );
    }

    $wp_customize->add_section( 'featured_section' ,
        array(
            'panel'       => 'theme_options',
            'title'       => esc_html__( 'Featured Content', 'boston' ),
            'description' => esc_html__( 'Easily feature all posts with the "featured" tag or a tag of your choice.', 'boston' ),
        )
    );

        $wp_customize->add_setting( 'featured_tags', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default' => ( $default_tag ) ?  $default_tag: 'featured',
        ) );

        $wp_customize->add_control(
            'featured_tags',
            array(
                'type' => 'text',
                'label'      => esc_html__( 'Tag name', 'boston' ),
                'section'    => 'featured_section',
            )
        );

        $wp_customize->add_setting( 'featured_number', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default' => 10,
        ) );

        $wp_customize->add_control(
            'featured_number',
            array(
                'type' => 'text',
                'label'      => esc_html__( 'Number post to show', 'boston' ),
                'section'    => 'featured_section',
            )
        );

        $wp_customize->add_setting( 'featured_hide_tag', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default' => 1,
        ) );

        $wp_customize->add_control(
            'featured_hide_tag',
            array(
                'type' => 'checkbox',
                'label'      => esc_html__( 'Hide tag from displaying in post meta and tag clouds.', 'boston' ),
                'section'    => 'featured_section',
            )
        );

        $wp_customize->add_setting( 'featured_thumb_only', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default' => 1,
        ) );

        $wp_customize->add_control(
            'featured_thumb_only',
            array(
                'type' => 'checkbox',
                'label'      => esc_html__( 'Show posts which have featured image only.', 'boston' ),
                'section'    => 'featured_section',
            )
        );

    $wp_customize->add_section( 'archive_section' ,
        array(
            'panel'       => 'theme_options',
            'title'       => esc_html__( 'Archive Content', 'boston' ),
            'description' => esc_html__( 'Select archive content layout to display.', 'boston' ),
        )
    );

    $wp_customize->add_setting( 'archive_layout', array(
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'layout_1',
    ) );

    $wp_customize->add_control(
       new Boston_Customize_Radio_Image_Control(
           $wp_customize,
           'archive_layout',
           array(
               'choices'     =>array(
                   'layout_1' =>  array(
                       'img' => get_template_directory_uri() . '/assets/images/layout1.png',
                       'label' => esc_html__( 'Layout 1', 'boston' ),
                   ),
                   'layout_2' =>  array(
                       'img' => get_template_directory_uri() . '/assets/images/layout2.png',
                       'label' => esc_html__( 'Layout 2', 'boston' ),
                       'pro' => true,
                       'link' => 'https://www.famethemes.com/themes/boston-pro/'
                   ),
                   'layout_3' =>  array(
                       'img' => get_template_directory_uri() . '/assets/images/layout3.png',
                       'label' => esc_html__( 'Layout 3', 'boston' ),
                       'pro' => true,
                       'link' => 'https://www.famethemes.com/themes/boston-pro/'
                   ),
                   'layout_4' =>  array(
                       'img' => get_template_directory_uri() . '/assets/images/layout4.png',
                       'label' => esc_html__( 'Layout 4', 'boston' ),
                       'pro' => true,
                       'link' => 'https://www.famethemes.com/themes/boston-pro/'
                   ),
               ),
               'label'      => esc_html__( 'Homepage articles listing layout', 'boston' ),
               'section'    => 'archive_section',
           )
       )
    );



    /**
     * Theme Styling
     */
    $wp_customize->add_section( 'styling' ,
        array(
            'title'       => esc_html__( 'Styling', 'boston' ),
            'description' => '',
            'priority' => 48
            //'panel' => 'theme_options',
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


        /**
         * Theme boston-pro
         */
        $wp_customize->add_section( 'boston_pro' ,
            array(
                'title'       => esc_html__( 'Boston Pro', 'boston' ),
                'description' => '',
            )
        );

            $wp_customize->add_setting( 'boston_pro', array() );
            $wp_customize->add_control(
                new Boston_Customize_Pro_Control(
                    $wp_customize,
                    'boston_pro',
                    array(
                        'label'      => esc_html__( 'Boston Pro', 'boston' ),
                        'description'   => esc_html__( 'Something about Boston Pro description', 'boston' ),
                        'section'    => 'boston_pro',
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


/**
 * Load customizer css
 */
function boston_customizer_load_css(){
    wp_enqueue_style( 'boston-customizer', get_template_directory_uri() . '/assets/css/customizer.css' );
}
add_action('customize_controls_print_styles', 'boston_customizer_load_css');
