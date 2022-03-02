<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://anssilaitila.fi
 * @since      1.0.0
 *
 * @package    Shared_Files
 * @subpackage Shared_Files/public
 */
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Shared_Files
 * @subpackage Shared_Files/public
 * @author     Anssi Laitila <anssi.laitila@gmail.com>
 */
class Shared_Files_Public
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
     * @param    string    $plugin_name       The name of the plugin.
     * @param    string    $version           The version of this plugin.
     */
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }
    
    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles( $hook )
    {
        $s = get_option( 'shared_files_settings' );
        wp_enqueue_style(
            $this->plugin_name,
            SHARED_FILES_URI . 'dist/css/p.css',
            array(),
            $this->version,
            'all'
        );
        wp_enqueue_style(
            $this->plugin_name . '-basiclightbox',
            SHARED_FILES_URI . 'dist/basiclightbox/basicLightbox.min.css',
            array(),
            $this->version,
            'all'
        );
        if ( isset( $s['card_font'] ) && $s['card_font'] ) {
            
            if ( $s['card_font'] == 'roboto' ) {
                wp_enqueue_style( $this->plugin_name . '-google-fonts', 'https://fonts.googleapis.com/css?family=Roboto&display=swap', false );
            } elseif ( $s['card_font'] == 'ubuntu' ) {
                wp_enqueue_style( $this->plugin_name . '-google-fonts', 'https://fonts.googleapis.com/css?family=Ubuntu&display=swap', false );
            }
        
        }
    }
    
    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts( $hook )
    {
        wp_enqueue_script(
            $this->plugin_name,
            SHARED_FILES_URI . 'dist/js/p.js',
            array( 'jquery' ),
            $this->version,
            false
        );
        wp_enqueue_script(
            $this->plugin_name . '-basiclightbox',
            SHARED_FILES_URI . 'dist/basiclightbox/basicLightbox.min.js',
            array( 'jquery' ),
            $this->version,
            false
        );
        $inline_js = $this->get_inline_scripts();
        wp_add_inline_script( $this->plugin_name, $inline_js );
    }
    
    public function get_inline_scripts()
    {
        $s = get_option( 'shared_files_settings' );
        $js = '';
        $js .= "jQuery(document).ready(function(\$) {";
        $js .= "\n      if (typeof ajaxurl === 'undefined') {\n        ajaxurl = '" . esc_url_raw( admin_url( 'admin-ajax.php' ) ) . "'; // get ajaxurl\n      }\n      ";
        if ( !isset( $s['file_upload_file_not_required'] ) && 0 ) {
            $js .= "\n        \$('.shared-files-frontend-file-upload').submit(function (e) {\n        \n          let elem_class = \$(this).closest('.shared-files-main-container').data('elem-class');\n          \n          if (\$('.' + elem_class + ' #sf_file').prop('files').length == 0) {\n            alert('Please choose the file first.');\n            return false;\n          }\n        \n        });\n        ";
        }
        $js .= "});";
        return $js;
    }
    
    /**
     * Register the shortcodes.
     *
     * @since    1.0.0
     */
    public function register_shortcodes()
    {
        add_shortcode( 'shared_files', array( 'ShortcodeSharedFiles', 'shared_files' ) );
        add_shortcode( 'shared_files_search', array( 'ShortcodeSharedFilesSearch', 'shared_files_search' ) );
        add_shortcode( 'shared_files_categories', array( 'ShortcodeSharedFilesCategories', 'shared_files_categories' ) );
        add_shortcode( 'shared_files_simple', array( 'Shared_Files_Public', 'shared_files_simple' ) );
        add_shortcode( 'shared_files_info', array( 'ShortcodeSharedFilesInfo', 'shared_files_info' ) );
        add_shortcode( 'shared_files_accordion', array( 'ShortcodeSharedFilesAccordion', 'shared_files_accordion' ) );
        add_shortcode( 'shared_files_favorites', array( 'ShortcodeSharedFilesFavorites', 'shared_files_favorites' ) );
        add_shortcode( 'shared_files_restricted', array( 'ShortcodeSharedFilesRestricted', 'shared_files_restricted' ) );
        add_shortcode( 'shared_files_exact_search', array( 'ShortcodeSharedFilesExactSearch', 'shared_files_exact_search' ) );
    }
    
    public static function shared_files_simple( $atts = array(), $content = null, $tag = '' )
    {
        $html = '';
        $html .= ShortcodeSharedFilesSimple::view( $atts );
        return $html;
    }

}