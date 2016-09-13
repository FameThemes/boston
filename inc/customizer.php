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
     * Theme Styling
     */
    $wp_customize->add_section( 'styling' ,
        array(
            'title'       => esc_html__( 'Styling', 'boston' ),
            'description' => '',
            'panel'       => 'theme_options',
            'priority'     => 5
        )
    );

    $wp_customize->add_setting( 'styling_color_primary', array(
        'default'              => '#d65456',
        'sanitize_callback'    => 'sanitize_hex_color_no_hash',
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
     * Theme Styling
     */
    $wp_customize->add_section( 'layout' ,
        array(
            'title'       => esc_html__( 'Layout', 'boston' ),
            'description' => '',
            'panel'       => 'theme_options',
            'priority'     => 5
        )
    );

        $wp_customize->add_setting( 'layout', array(
            'default'              => 'right',
            'sanitize_callback'    => 'sanitize_text_field',
        ) );

        $wp_customize->add_control(
            'layout',
            array(
                'label'      => esc_html__( 'Site Layout', 'boston' ),
                'section'    => 'layout',
                'type'       => 'select',
                'choices'    => array(
                    'right' => esc_html__( 'Right sidebar', 'boston' ),
                    'left' => esc_html__( 'Left sidebar', 'boston' ),
                )
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
            'priority'     => 15
        )
    );

        $wp_customize->add_setting( 'featured_display', array(
            'sanitize_callback' => 'boston_sanitize_sanitize_select',
            'default' => 'carousel',
            //'transport' => 'postMessage',
            'validate_callback' => 'boston_upgrade_pro_notice'
        ) );

        $wp_customize->add_control(
            'featured_display',
            array(
                'type'       => 'select',
                'label'      => esc_html__( 'Display', 'boston' ),
                'section'    => 'featured_section',
                'choices' => array(
                    'carousel' => esc_html__( 'Carousel', 'boston' ),
                    'slider' => esc_html__( 'Slider', 'boston' ),
                )
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
            'sanitize_callback' => 'boston_sanitize_absint',
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
            'sanitize_callback' => 'boston_sanitize_checkbox',
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
            'sanitize_callback' => 'boston_sanitize_checkbox',
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


    $wp_customize->add_section( 'articles_listing_section' ,
        array(
            'panel'       => 'theme_options',
            'title'       => esc_html__( 'Articles Listing Layout', 'boston' ),
            'priority'     => 20
        )
    );


    $wp_customize->add_setting( 'articles_listing_layout', array(
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'layout_1',
    ) );

    $wp_customize->add_control(
       new Boston_Customize_Radio_Image_Control(
           $wp_customize,
           'articles_listing_layout',
           array(
               'choices'     =>array(
                   'layout_1' =>  array(
                       'img'   => get_template_directory_uri() . '/assets/images/layout1.png',
                       'label' => esc_html__( 'Layout 1', 'boston' ),
                   ),
                   'layout_2' =>  array(
                       'img'   => get_template_directory_uri() . '/assets/images/layout2.png',
                       'label' => esc_html__( 'Layout 2', 'boston' ),
                       'pro'   => true,
                       'link'  => 'https://www.famethemes.com/themes/boston-pro/'
                   ),
                   'layout_3' =>  array(
                       'img'   => get_template_directory_uri() . '/assets/images/layout3.png',
                       'label' => esc_html__( 'Layout 3', 'boston' ),
                       'pro'   => true,
                       'link'  => 'https://www.famethemes.com/themes/boston-pro/'
                   ),
                   'layout_4' =>  array(
                       'img'   => get_template_directory_uri() . '/assets/images/layout4.png',
                       'label' => esc_html__( 'Layout 4', 'boston' ),
                       'pro'   => true,
                       'link'  => 'https://www.famethemes.com/themes/boston-pro/'
                   ),
               ),
               'label'      => esc_html__( 'Homepage articles listing layout', 'boston' ),
               'section'    => 'articles_listing_section',
           )
       )
    );

    $wp_customize->add_section( 'boston_pro' ,
        array(
            'title'       => esc_html__( 'Upgrade to Boston Pro', 'boston' ),
            'description' => '',
        )
    );

        $wp_customize->add_setting( 'boston_pro_features', array(
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new Boston_Customize_Pro_Control(
                $wp_customize,
                'boston_pro_features',
                array(
                    'label'      => esc_html__( 'Boston Pro Features', 'boston' ),
                    'description'   => '<span>Featured content slider (<a target="_blank" href="http://demos.famethemes.com/boston-pro/?featured_type=slider">Demo</a>)</span><span>4 Article Listing Layout</span><span>600+ Google Fonts</span><span>Social Media Icons</span><span>Custom Posts Widget</span><span>Instagram Feed Widget</span><span>Instagram Feed Before Footer</span><span>4 Footer Widget Area</span><span>Footer Copyright Editor</span><span>Remove Footer Link via Customizer</span><span>... and much more </span>',
                    'section'    => 'boston_pro',
                )
            )
        );
        $wp_customize->add_setting( 'boston_pro_links', array(
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new Boston_Customize_Pro_Control(
                $wp_customize,
                'boston_pro_links',
                array(
                    'description'   => '<a target="_blank" class="boston-pro-buy-button" href="https://www.famethemes.com/themes/boston-pro/">Buy Now</a>', 'boston',
                    'section'    => 'boston_pro',
                )
            )
        );
}
add_action( 'customize_register', 'boston_customize_register' );

function boston_upgrade_pro_notice( $validity, $value ){
    if ( $value == 'slider' ) {
        $validity->add( 'notice', esc_html__( 'Upgrade to Boston Pro to display featured content as a slider.', 'boston' ) );
    }
    return $validity;
}

function boston_sanitize_checkbox( $input ){
    if ( $input == 1 || $input == 'true' || $input === true ) {
        return 1;
    } else {
        return 0;
    }
}

function boston_sanitize_absint( $number, $setting ) {
    // Ensure $number is an absolute integer (whole number, zero or greater).
    $number = absint( $number );

    // If the input is an absolute integer, return it; otherwise, return the default
    return ( $number ? $number : $setting->default );
}


function boston_sanitize_sanitize_select( $input, $setting ) {
    // Ensure input is a slug.
    $input = sanitize_key( $input );

    // Get list of choices from the control associated with the setting.
    $choices = $setting->manager->get_control( $setting->id )->choices;

    // If the input is a valid key, return it; otherwise, return the default.
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

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
