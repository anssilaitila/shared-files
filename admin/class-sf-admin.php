<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://anssilaitila.fi
 * @since      1.0.0
 *
 * @package    Shared_Files
 * @subpackage Shared_Files/admin
 */
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Shared_Files
 * @subpackage Shared_Files/admin
 * @author     Anssi Laitila <anssi.laitila@gmail.com>
 */
class Shared_Files_Admin
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private  $plugin_name ;
    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private  $version ;
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    string    $plugin_name       The name of this plugin.
     * @param    string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }
    
    public function enqueue_styles( $hook )
    {
        $current_screen = get_current_screen();
        $current_screen_id = '';
        if ( isset( $current_screen->id ) ) {
            $current_screen_id = $current_screen->id;
        }
        $inline_css = SharedFilesAdminInlineStyles::generateInlineStyles();
        wp_enqueue_style(
            $this->plugin_name,
            SHARED_FILES_URI . 'dist/css/a.css',
            array(),
            $this->version,
            'all'
        );
        wp_add_inline_style( $this->plugin_name, $inline_css );
        
        if ( $current_screen_id === 'edit-shared_file' || $current_screen_id === 'edit-shared-file-category' || $current_screen_id === 'shared_file_page_shared-files-shortcodes' || $current_screen_id === 'shared_file_page_shared-files-support' ) {
            wp_enqueue_style(
                $this->plugin_name . '-tipso',
                SHARED_FILES_URI . 'dist/tipso.min.css',
                array(),
                $this->version,
                'all'
            );
        } elseif ( $current_screen_id === 'shared_file_page_shared-files-sync-files' || $current_screen_id === 'shared_file_page_shared-files-sync-media-library' ) {
            wp_enqueue_style( $this->plugin_name . '-google-fonts', 'https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap', false );
        }
    
    }
    
    public function enqueue_scripts( $hook )
    {
        $current_screen = get_current_screen();
        $current_screen_id = '';
        if ( isset( $current_screen->id ) ) {
            $current_screen_id = $current_screen->id;
        }
        $is_premium = 0;
        if ( !$is_premium ) {
            wp_enqueue_script(
                $this->plugin_name,
                SHARED_FILES_URI . 'dist/js/a.js',
                array( 'jquery' ),
                $this->version,
                false
            );
        }
        $inline_js = SharedFilesAdminInlineScripts::inline_scripts();
        wp_add_inline_script( $this->plugin_name, $inline_js );
        
        if ( $current_screen_id === 'edit-shared_file' || $current_screen_id === 'edit-shared-file-category' || $current_screen_id === 'shared_file_page_shared-files-shortcodes' || $current_screen_id === 'shared_file_page_shared-files-support' ) {
            wp_enqueue_script(
                $this->plugin_name . '-tipso',
                SHARED_FILES_URI . 'dist/tipso.min.js',
                array( 'jquery' ),
                $this->version,
                true
            );
            wp_enqueue_script(
                $this->plugin_name . '-clipboard',
                '/wp-includes/js/clipboard.js',
                array( 'jquery' ),
                $this->version,
                true
            );
        }
    
    }
    
    /**
     * Delete the file itself when permanently deleting post.
     *
     * @since    1.0.0
     */
    function delete_shared_file( $post_id )
    {
        $post_id = intval( $post_id );
        $file = get_post_meta( $post_id, '_sf_file', true );
        
        if ( isset( $file['file'] ) && $file['file'] ) {
            $filename_with_path = SharedFilesFileOpen::getUpdatedPathAndFilenameOnDisk( $file['file'] );
            $filename_with_path = str_replace( '../', '', $filename_with_path );
            
            if ( file_exists( $filename_with_path ) ) {
                if ( strpos( $filename_with_path, '/wp-content/uploads/shared-files/' ) !== false ) {
                    unlink( $filename_with_path );
                }
            } else {
                //        wp_die( sanitize_text_field( __('File not found:', 'shared-files') ) . '<br />' . $filename_with_path );
            }
        
        }
        
        
        if ( has_post_thumbnail( $post_id ) ) {
            $thumbnail_id = intval( get_post_thumbnail_id( $post_id ) );
            if ( $thumbnail_id ) {
                // Delete all thumbnails generated for featured image
                wp_delete_attachment( $thumbnail_id, true );
            }
        }
    
    }
    
    public function add_settings_link()
    {
        global  $submenu ;
        $permalink = './options-general.php?page=shared-files';
        $submenu['edit.php?post_type=shared_file'][] = array( sanitize_text_field( __( 'Settings', 'shared-files' ) ) . '&nbsp;&nbsp;➤', 'manage_options', $permalink );
    }
    
    public function add_upgrade_link()
    {
        global  $submenu ;
        $permalink = './options-general.php?page=shared-files-pricing';
        $submenu['edit.php?post_type=shared_file'][] = array(
            sanitize_text_field( __( 'Upgrade', 'shared-files' ) ) . '&nbsp;&nbsp;➤',
            'manage_options',
            $permalink,
            '',
            'shared-files-upgrade'
        );
    }

}