<?php
/**
 * Add theme dashboard page
 */

add_action('admin_menu', 'boston_theme_info');
if ( ! function_exists( 'boston_theme_info' ) ) {
    function boston_theme_info()
    {
        $theme_data = wp_get_theme();
        add_theme_page(sprintf(esc_html__('%s Theme Dashboard', 'boston'), $theme_data->Name), sprintf(esc_html__('%s theme', 'boston'), $theme_data->Name), 'edit_theme_options', 'boston', 'boston_theme_info_page');
    }
}

if ( ! function_exists( 'boston_admin_scripts' ) ) {
    /**
     * Enqueue scripts for admin page only: Theme info page
     */
    function boston_admin_scripts( $hook )
    {
        if ($hook === 'appearance_page_boston') {
            wp_enqueue_style('boston-admin-css', get_template_directory_uri() . '/assets/css/admin.css');
        }
    }
}
add_action('admin_enqueue_scripts', 'boston_admin_scripts');

if ( ! function_exists( 'boston_theme_info_page' ) ) {
    function boston_theme_info_page()
    {
        $theme_data = wp_get_theme(); ?>

        <div class="wrap about-wrap theme_info_wrapper">
            <h1><?php printf(esc_html__('Welcome to %1s - Version %2s', 'boston'), $theme_data->Name, $theme_data->Version); ?></h1>

            <div
                class="about-text"><?php esc_html_e('Whether you’re looking to share your own thoughts, write about your latest findings, Boston WordPress theme is designed to fulfill these and a lot more.', 'boston') ?></div>
            <a target="_blank" href="<?php echo esc_url('http://www.famethemes.com/?utm_source=theme_dashboard_page&utm_medium=badge_link&utm_campaign=theme_admin'); ?>"
               class="famethemes-badge wp-badge"><span><?php esc_html('FameThemes', 'boston'); ?></span></a>

            <h2 class="nav-tab-wrapper">
                <a href="<?php echo esc_url( add_query_arg( array( 'page'=>'boston' ), admin_url( 'themes.php' ) ) ); ?>" class="nav-tab nav-tab-active"><?php echo esc_html($theme_data->Name); ?></a>
            </h2>

            <div class="theme_info">
                <div class="theme_info_column clearfix">
                    <div class="theme_info_left">
                        <div class="theme_link">
                            <h3><?php esc_html_e('Theme Customizer', 'boston'); ?></h3>

                            <p class="about"><?php printf(esc_html__('%s supports the Theme Customizer for all theme settings. Click "Customize" to start customize your site.', 'boston'), $theme_data->Name); ?></p>

                            <p>
                                <a href="<?php echo esc_url(admin_url('customize.php')); ?>" class="button button-primary"><?php esc_html_e('Start Customize', 'boston'); ?></a>
                            </p>
                        </div>
                        <div class="theme_link">
                            <h3><?php esc_html_e('Theme Documentation', 'boston'); ?></h3>

                            <p class="about"><?php printf(esc_html__('Need any help to setup and configure %s? Please have a look at our documentations instructions.', 'boston'), $theme_data->Name); ?></p>

                            <p>
                                <a href="http://docs.famethemes.com/category/83-boston" target="_blank" class="button button-secondary"><?php esc_html_e('Online Documentation', 'boston'); ?></a>
                            </p>
                        </div>
                        <div class="theme_link">
                            <h3><?php esc_html_e('Having Trouble, Need Support?', 'boston'); ?></h3>

                            <p class="about"><?php printf(esc_html__('Support for %s WordPress theme is conducted through FameThemes support ticket system.', 'boston'), $theme_data->Name); ?></p>

                            <p>
                                <a class="button button-secondary" target="_blank" href="https://www.famethemes.com/dashboard/tickets/"><?php esc_html_e( 'Create a support ticket', 'boston' ) ?></a>
                            </p>
                        </div>
                    </div>

                    <div class="theme_info_right">
                        <img src="<?php echo get_template_directory_uri(); ?>/screenshot.png" alt="<?php esc_attr_e('Theme Screenshot', 'boston'); ?>"/>
                    </div>
                </div>
            </div>

        </div> <!-- END .theme_info -->
        <?php
    }
}
