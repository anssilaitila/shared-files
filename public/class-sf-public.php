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
class Shared_Files_Public {

  /**
   * The ID of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $plugin_name    The ID of this plugin.
   */
  private $plugin_name;

  /**
   * The version of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $version    The current version of this plugin.
   */
  private $version;

  /**
   * Initialize the class and set its properties.
   *
   * @since    1.0.0
   * @param    string    $plugin_name       The name of the plugin.
   * @param    string    $version           The version of this plugin.
   */
  public function __construct($plugin_name, $version) {
    $this->plugin_name = $plugin_name;
    $this->version = $version;
  }

  /**
   * Register the stylesheets for the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function enqueue_styles() {
    wp_enqueue_style($this->plugin_name, SHARED_FILES_URI . 'dist/css/main.css', array(), $this->version, 'all');
  }

  /**
   * Register the JavaScript for the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function enqueue_scripts() {
    wp_enqueue_script($this->plugin_name, SHARED_FILES_URI . 'dist/js/main.js', array('jquery'), $this->version, false);
  }

  /**
   * Register the shortcodes.
   *
   * @since    1.0.0
   */
  public function register_shortcodes() {
    add_shortcode('shared_files', array('ShortcodeSharedFiles', 'shared_files'));
    add_shortcode('shared_files_search', array('ShortcodeSharedFilesSearch', 'shared_files_search'));
    add_shortcode('shared_files_categories', array('ShortcodeSharedFilesCategories', 'shared_files_categories'));
    add_shortcode('shared_files_simple', array('Shared_Files_Public', 'shared_files_simple'));
  }

  public static function shared_files_simple($atts = [], $content = null, $tag = '') {

    $html = '';
    
    $html .= ShortcodeSharedFilesSimple::view($atts);
    
    return $html;
  }
    
}
