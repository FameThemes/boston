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
        $theme_data = wp_get_theme();
        // Check for current viewing tab
        $tab = null;
        if ( isset( $_GET['tab'] ) ) {
            $tab = $_GET['tab'];
        } else {
            $tab = null;
        }

        ?>

        <div class="wrap about-wrap theme_info_wrapper">
            <h1><?php printf(esc_html__('Welcome to %1s - Version %2s', 'boston'), $theme_data->Name, $theme_data->Version); ?></h1>

            <div
                class="about-text"><?php esc_html_e('Whether you’re looking to share your own thoughts, write about your latest findings, Boston WordPress theme is designed to fulfill these and a lot more.', 'boston') ?></div>
            <a target="_blank" href="<?php echo esc_url('http://www.famethemes.com/?utm_source=theme_dashboard_page&utm_medium=badge_link&utm_campaign=theme_admin'); ?>"
               class="famethemes-badge wp-badge"><span><?php echo esc_html('FameThemes', 'boston'); ?></span></a>

            <h2 class="nav-tab-wrapper">
                <a href="<?php echo esc_url( add_query_arg( array( 'page'=>'boston' ), admin_url( 'themes.php' ) ) ); ?>" class="nav-tab <?php echo ( ! $tab || $tab == 'boston' ) ? ' nav-tab-active' : ''; ?>"><?php echo esc_html($theme_data->Name); ?></a>
                <a href="<?php echo esc_url( add_query_arg( array( 'page'=>'boston', 'tab' => 'demo-data-importer' ), admin_url( 'themes.php' ) ) ); ?>" class="nav-tab<?php echo $tab == 'demo-data-importer' ? ' nav-tab-active' : null; ?>"><?php esc_html_e( 'One Click Demo Import', 'boston' ); ?></span></a>

                <a href="<?php echo esc_url( add_query_arg( array( 'page'=>'boston', 'tab' => 'contribute' ), admin_url( 'themes.php' ) ) ); ?>" class="nav-tab<?php echo $tab == 'contribute' ? ' nav-tab-active' : null; ?>"><?php esc_html_e( 'Contribute', 'boston' ); ?><span class="dashicons dashicons-thumbs-up"></span></a>
            </h2>

            <?php if ( is_null( $tab ) ) { ?>
            <div class="theme_info">
                <div class="theme_info_column clearfix">
                    <div class="theme_info_left">
                        <div class="theme_link">
                            <h3><?php esc_html_e('Theme Customizer', 'boston'); ?></h3>

                            <p class="about"><?php printf(esc_html__('%s supports the Theme Customizer for all theme settings. Click "Customize" to start customize your site.', 'boston'), $theme_data->Name); ?></p>

                            <p>
                                <a href="<?php echo esc_url(admin_url('customize.php')); ?>" class="button button-secondary"><?php esc_html_e('Start Customize', 'boston'); ?> &#8594;</a>
                            </p>
                        </div>
                        <div class="theme_link">
                            <h3><?php esc_html_e('Having Trouble, Need Support?', 'boston'); ?></h3>

                            <p class="about"><?php printf(esc_html__('Support for %s WordPress theme is conducted through FameThemes support ticket system.', 'boston'), $theme_data->Name); ?></p>

                            <p>
                                <a class="button button-secondary" target="_blank" href="https://www.famethemes.com/contact"><?php esc_html_e( 'Create a support ticket', 'boston' ) ?></a>&nbsp;
                                <a href="http://docs.famethemes.com/category/83-boston" target="_blank" class="button button-secondary"><?php esc_html_e('Boston Documentation', 'boston'); ?></a>
                            </p>
                        </div>
                        <div class="theme_link">
                            <h3 class="boston-upgrade"><?php esc_html_e('Upgrade to Boston Pro', 'boston'); ?></h3>

                            <p class="about"><?php printf(esc_html__('Our #1 blogging WordPress theme with premium features designed for bloggers and content lovers.', 'boston'), $theme_data->Name); ?></p>

                            <p>
                                <a class="button button-secondary" target="_blank" href="http://demos.famethemes.com/boston-pro"><?php _e( 'Boston Pro Demo', 'boston' ) ?> &#8594;</a>&nbsp;
                                <a class="button button-primary" target="_blank" href="https://www.famethemes.com/themes/boston-pro"><?php _e( 'Upgrade Now', 'boston' ) ?> &#8594;</a>
                            </p>
                        </div>
                    </div>

                    <div class="theme_info_right">
                        <img src="<?php echo get_template_directory_uri(); ?>/screenshot.png" alt="<?php esc_attr_e('Theme Screenshot', 'boston'); ?>"/>
                    </div>
                </div>
            </div>
            <?php } ?>

            <?php if ( $tab == 'demo-data-importer' ) { ?>
                <div class="demo-import-tab-content info-tab-content">
                    <?php if ( has_action( 'boston_demo_import_content_tab' ) ) {
                        do_action( 'boston_demo_import_content_tab' );
                    } else { ?>
                        <div class="demo-import-boxed">
                            <p><?php  printf( esc_html__( ' %1$s you will need to install and activate the FameThemes Demo Importer plugin first, %2$s now from Github.', 'boston' ) , '<b>Hey,</b>', '<a href="https://github.com/FameThemes/famethemes-demo-importer/archive/master.zip">'. esc_html__( 'download it', 'boston' ) .'</a>' ); ?></p>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php if ( $tab == 'contribute' ) { ?>
            <div class="contribute-tab-content feature-section three-col">
                <h2>How can I contribute?</h2>
                <div class="col">
                    <div class="theme_info_boxed">
                        <p><strong><?php esc_html_e( 'Found a bug? Want to contribute with a fix or create a new feature?', 'boston' ); ?></strong></p>
                        <p><?php esc_html_e('GitHub is the place to go!', 'boston'); ?></p>
                        <p>
                            <a href="https://github.com/FameThemes/boston" target="_blank" class="button button-primary"><?php esc_html_e('Boston on GitHub', 'boston'); ?> <span class="dashicons dashicons-external"></span></a>
                        </p>
                    </div>
                </div>
                <div class="col">
                    <div class="theme_info_boxed">
                        <p><strong><?php esc_html_e( 'Are you a polyglot? Want to translate Boston into your own language?', 'boston' ); ?></strong></p>
                        <p><?php esc_html_e('Get involved at WordPress.org.', 'boston'); ?></p>
                        <p>
                            <a href="https://translate.wordpress.org/projects/wp-themes/boston" target="_blank" class="button button-primary"><?php esc_html_e('Translate Boston', 'boston'); ?> <span class="dashicons dashicons-external"></span></a>
                        </p>
                    </div>
                </div>
                <div class="col">
                    <div class="theme_info_boxed">
                        <p><strong><?php esc_html_e( 'Are you enjoying Boston theme?', 'boston' ); ?></strong></p>
                        <p><?php printf( esc_html__('Rate our theme on %1s. We\'d really appreciate it!', 'boston'), '<a target="_blank" href="https://wordpress.org/support/theme/boston/reviews/?filter=5#postform">WordPress.org</a>' ); ?></p>
                        <p><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span></p>
                    </div>
                </div>
            </div>
        <?php } ?>

        </div> <!-- END .theme_info -->
        <?php
    }
}
