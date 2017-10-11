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
            // Add recommend plugin css
            wp_enqueue_style( 'plugin-install' );
            wp_enqueue_script( 'plugin-install' );
            wp_enqueue_script( 'updates' );
            add_thickbox();
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

            <div class="about-text"><?php esc_html_e("Whether you're looking to share your own thoughts, write about your latest findings, Boston WordPress theme is designed to fulfill these and a lot more.", 'boston') ?></div>
            <a target="_blank" href="<?php echo esc_url('https://www.famethemes.com/?utm_source=theme_dashboard_page&utm_medium=badge_link&utm_campaign=theme_admin'); ?>"
               class="famethemes-badge wp-badge"><span><?php echo esc_html('FameThemes', 'boston'); ?></span></a>

            <h2 class="nav-tab-wrapper">
                <a href="<?php echo esc_url( add_query_arg( array( 'page'=>'boston' ), admin_url( 'themes.php' ) ) ); ?>" class="nav-tab <?php echo ( ! $tab || $tab == 'boston' ) ? ' nav-tab-active' : ''; ?>"><?php echo esc_html($theme_data->Name); ?></a>
                <a href="<?php echo esc_url( add_query_arg( array( 'page'=>'boston', 'tab' => 'demo-data-importer' ), admin_url( 'themes.php' ) ) ); ?>" class="nav-tab<?php echo $tab == 'demo-data-importer' ? ' nav-tab-active' : null; ?>"><?php esc_html_e( 'One Click Demo Import', 'boston' ); ?></span></a>
                <a href="<?php echo esc_url( add_query_arg( array( 'page'=>'boston', 'tab' => 'free_pro' ), admin_url( 'themes.php' ) ) ); ?>" class="nav-tab<?php echo $tab == 'free_pro' ? ' nav-tab-active' : null; ?>"><?php esc_html_e( 'Free vs PRO', 'boston' ); ?></span></a>
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
                                <a href="http://docs.famethemes.com/category/114-boston" target="_blank" class="button button-secondary"><?php esc_html_e('Boston Documentation', 'boston'); ?></a>
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
                        <div id="plugin-filter" class="demo-import-boxed">
                            <?php
                            $plugin_name = 'famethemes-demo-importer';
                            $status = is_dir( WP_PLUGIN_DIR . '/' . $plugin_name );
                            $button_class = 'install-now button';
                            $button_txt = esc_html__( 'Install Now', 'boston' );
                            if ( ! $status ) {
                                $install_url = wp_nonce_url(
                                    add_query_arg(
                                        array(
                                            'action' => 'install-plugin',
                                            'plugin' => $plugin_name
                                        ),
                                        network_admin_url( 'update.php' )
                                    ),
                                    'install-plugin_'.$plugin_name
                                );

                            } else {
                                $install_url = add_query_arg(array(
                                    'action' => 'activate',
                                    'plugin' => rawurlencode( $plugin_name . '/' . $plugin_name . '.php' ),
                                    'plugin_status' => 'all',
                                    'paged' => '1',
                                    '_wpnonce' => wp_create_nonce('activate-plugin_' . $plugin_name . '/' . $plugin_name . '.php'),
                                ), network_admin_url('plugins.php'));
                                $button_class = 'activate-now button-primary';
                                $button_txt = esc_html__( 'Active Now', 'boston' );
                            }

                            $detail_link = add_query_arg(
                                array(
                                    'tab' => 'plugin-information',
                                    'plugin' => $plugin_name,
                                    'TB_iframe' => 'true',
                                    'width' => '772',
                                    'height' => '349',

                                ),
                                network_admin_url( 'plugin-install.php' )
                            );

                            echo '<p>';
                            printf( esc_html__(
                                'Hey, you will need to install and activate the %1$s plugin first.', 'boston' ),
                                '<a class="thickbox open-plugin-details-modal" href="'.esc_url( $detail_link ).'">'.esc_html__( 'FameThemes Demo Importer', 'boston' ).'</a>'
                            );
                            echo '</p>';

                            echo '<p class="plugin-card-'.esc_attr( $plugin_name ).'"><a href="'.esc_url( $install_url ).'" data-slug="'.esc_attr( $plugin_name ).'" class="'.esc_attr( $button_class ).'">'.$button_txt.'</a></p>';

                            ?>
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

	        <?php if ( $tab == 'free_pro' ) { ?>
                <div id="free_pro" class="freepro-tab-content info-tab-content">
                    <table class="free-pro-table">
                        <thead><tr><th></th><th>Boston</th><th>Boston Pro</th></tr></thead>
                        <tbody>
                        <tr>
                            <td>
                                <h4>Responsive Design</h4>
                            </td>
                            <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                            <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                        </tr>
                        <tr>
                            <td>
                                <h4>Translation Ready</h4>
                            </td>
                            <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                            <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                        </tr>
                        <tr>
                            <td>
                                <h4>Upload Your Own Logo</h4>
                            </td>
                            <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                            <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                        </tr>
                        <tr>
                            <td>
                                <h4>Featured Content</h4>
                            </td>
                            <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                            <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                        </tr>

                        <tr>
                            <td>
                                <h4>Sidebar Layout</h4>
                            </td>
                            <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                            <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                        </tr>

                        <tr>
                            <td>
                                <h4>Featured Content Slider</h4>
                            </td>
                            <td class="only-pro"><span class="dashicons-before dashicons-no-alt"></span></td>
                            <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                        </tr>
                        <tr>
                            <td>
                                <h4>4 Article Listing Layout</h4>
                            </td>
                            <td class="only-pro"><span class="dashicons-before dashicons-no-alt"></span></td>
                            <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                        </tr>

                        <tr>
                            <td>
                                <h4>600+ Google fonts</h4>
                            </td>
                            <td class="only-pro"><span class="dashicons-before dashicons-no-alt"></span></td>
                            <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                        </tr>
                        <tr>
                            <td>
                                <h4>600+ Google fonts</h4>
                            </td>
                            <td class="only-pro"><span class="dashicons-before dashicons-no-alt"></span></td>
                            <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                        </tr>
                        <tr>
                            <td>
                                <h4>Social Media Icons</h4>
                            </td>
                            <td class="only-pro"><span class="dashicons-before dashicons-no-alt"></span></td>
                            <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                        </tr>
                        <tr>
                            <td>
                                <h4>Instagram Feed Widget</h4>
                            </td>
                            <td class="only-pro"><span class="dashicons-before dashicons-no-alt"></span></td>
                            <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                        </tr>
                        <tr>
                            <td>
                                <h4>Footer Widget Area</h4>
                            </td>
                            <td class="only-pro"><span class="dashicons-before dashicons-no-alt"></span></td>
                            <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                        </tr>
                        <tr>
                            <td>
                                <h4>Footer Copyright Editor</h4>
                            </td>
                            <td class="only-pro"><span class="dashicons-before dashicons-no-alt"></span></td>
                            <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                        </tr>

                        <tr>
                            <td>
                                <h4>24/7 Priority Support</h4>
                            </td>
                            <td class="only-pro"><span class="dashicons-before dashicons-no-alt"></span></td>
                            <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                        </tr>


                        <tr class="ti-about-page-text-center"><td></td><td colspan="2"><a href="https://www.famethemes.com/themes/boston-pro/?utm_source=theme_dashboard&utm_medium=compare_table&utm_campaign=boston" target="_blank" class="button button-primary button-hero">Get Boston Pro now!</a></td></tr>
                        </tbody>
                    </table>
                </div>
	        <?php } ?>


        </div> <!-- END .theme_info -->
        <script type="text/javascript">
            jQuery(  document).ready( function( $ ){
                $( 'body').addClass( 'about-php' );
            } );
        </script>
        <?php
    }
}
