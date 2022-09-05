<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.sharedfilespro.com
 * @since             1.0.0
 * @package           Shared_Files
 *
 * @wordpress-plugin
 * Plugin Name:       Shared Files
 * Description:       A simple yet effective tool to list downloadable files on your site.
 * Version:           1.6.84
 * Author:            Tammersoft
 * Author URI:        https://www.sharedfilespro.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       shared-files
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}

if ( function_exists( 'shared_files_fs' ) ) {
    shared_files_fs()->set_basename( false, __FILE__ );
} else {
    
    if ( !function_exists( 'shared_files_fs' ) ) {
        // Create a helper function for easy SDK access.
        function shared_files_fs()
        {
            global  $shared_files_fs ;
            $s = get_option( 'shared_files_settings' );
            
            if ( !isset( $shared_files_fs ) ) {
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/freemius/start.php';
                $settings_contact = false;
                $settings_support = true;
                $shared_files_fs = fs_dynamic_init( array(
                    'id'             => '5144',
                    'slug'           => 'shared-files',
                    'premium_slug'   => 'shared-files-pro',
                    'type'           => 'plugin',
                    'public_key'     => 'pk_f414b8738adada8a01641686165dc',
                    'is_premium'     => false,
                    'premium_suffix' => 'Pro',
                    'has_addons'     => false,
                    'has_paid_plans' => true,
                    'trial'          => array(
                    'days'               => 7,
                    'is_require_payment' => true,
                ),
                    'menu'           => array(
                    'slug'    => 'shared-files',
                    'contact' => $settings_contact,
                    'support' => $settings_support,
                    'parent'  => array(
                    'slug' => 'options-general.php',
                ),
                ),
                    'is_live'        => true,
                ) );
            }
            
            return $shared_files_fs;
        }
        
        // Init Freemius.
        shared_files_fs();
        // Signal that SDK was initiated.
        do_action( 'shared_files_fs_loaded' );
    }
    
    function shared_files_fs_custom_connect_message( $message, $user_first_name )
    {
        return sprintf( __( 'Hey %1$s' ) . ',<br>' . __( 'never miss an important update -- opt-in to our security and feature updates notifications, and non-sensitive diagnostic tracking with freemius.com.' ), $user_first_name );
    }
    
    shared_files_fs()->add_filter(
        'connect_message',
        'shared_files_fs_custom_connect_message',
        10,
        6
    );
    shared_files_fs()->add_filter( 'show_deactivation_feedback_form', '__return_false' );
    function shared_files_freemius_custom_is_submenu_visible( $is_visible, $menu_id )
    {
        
        if ( $menu_id == 'contact' ) {
            return shared_files_fs()->can_use_premium_code();
        } elseif ( $menu_id == 'support' ) {
            return !shared_files_fs()->can_use_premium_code();
        }
        
        return $is_visible;
    }
    
    shared_files_fs()->add_filter(
        'is_submenu_visible',
        'shared_files_freemius_custom_is_submenu_visible',
        10,
        2
    );
    function shared_files_fs_custom_connect_message_on_update(
        $message,
        $user_first_name,
        $plugin_title,
        $user_login,
        $site_link,
        $freemius_link
    )
    {
        return sprintf(
            __( 'Hey %1$s' ) . ',<br>' . __( 'Please help us improve %2$s! If you opt-in, some data about your usage of %2$s will be sent to %5$s. If you skip this, that\'s okay! %2$s will still work just fine.' ),
            $user_first_name,
            '<b>' . $plugin_title . '</b>',
            '<b>' . $user_login . '</b>',
            $site_link,
            $freemius_link
        );
    }
    
    shared_files_fs()->add_filter(
        'connect_message_on_update',
        'shared_files_fs_custom_connect_message_on_update',
        10,
        6
    );
    /**
     * Currently plugin version.
     * Start at version 1.0.0 and use SemVer - https://semver.org
     * Rename this for your plugin and update it as you release new versions.
     */
    define( 'SHARED_FILES_VERSION', '1.6.84' );
    define( 'SHARED_FILES_URI', plugin_dir_url( __FILE__ ) );
    define( 'SHARED_FILES_PATH', plugin_dir_path( __FILE__ ) );
    /**
     * The code that runs during plugin activation.
     * This action is documented in includes/class-shared-files-activator.php
     */
    function activate_shared_files()
    {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-shared-files-activator.php';
        Shared_Files_Activator::activate();
    }
    
    /**
     * The code that runs during plugin deactivation.
     * This action is documented in includes/class-shared-files-deactivator.php
     */
    function deactivate_shared_files()
    {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-shared-files-deactivator.php';
        Shared_Files_Deactivator::deactivate();
    }
    
    register_activation_hook( __FILE__, 'activate_shared_files' );
    register_deactivation_hook( __FILE__, 'deactivate_shared_files' );
    /**
     * The core plugin class that is used to define internationalization,
     * admin-specific hooks, and public-facing site hooks.
     */
    require plugin_dir_path( __FILE__ ) . 'includes/class-shared-files.php';
    /**
     * Begins execution of the plugin.
     *
     * Since everything within the plugin is registered via hooks,
     * then kicking off the plugin from this point in the file does
     * not affect the page life cycle.
     *
     * @since    1.0.0
     */
    function run_shared_files()
    {
        $plugin = new Shared_Files();
        $plugin->run();
    }
    
    run_shared_files();
}
