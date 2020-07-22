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
  }

  public function sf_get_files() {

    $html = '';

    $term_slug = '';

    if (isset($_POST['sf_category']) && $_POST['sf_category']) {
      $term_slug = sanitize_title($_POST['sf_category']);
    }

    if ($term_slug) {

      $wp_query = new WP_Query(array(
        'post_type' => 'shared_file',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'tax_query' => array(
          array (
            'taxonomy' => 'shared-file-category',
            'field' => 'slug',
            'terms' => $term_slug,
            'include_children' => true
          )
      )));

    } else {

      $wp_query = new WP_Query(array(
        'post_type' => 'shared_file',
        'post_status' => 'publish',
        'posts_per_page' => -1,
      ));

    }

    if ($wp_query->have_posts()):
      while ($wp_query->have_posts()): $wp_query->the_post();

        $id = get_the_id();
        $c = get_post_custom($id);

        $external_url = isset($c['_sf_external_url']) ? $c['_sf_external_url'][0] : '';
        $filetype = '';
        $hide_description = isset($atts['hide_description']) ? $atts['hide_description'] : '';

        $imagefile = SharedFilesHelpers::getImageFile($id, $external_url);

        $html .= SharedFilesPublicViews::fileListItem($c, $imagefile, $hide_description);

      endwhile;
    endif;

    if ($wp_query->found_posts == 0) {
      $html .= '<p>' . __('No files found.', 'shared-files') . '</p>';
    }

    echo $html;
  }

  public function my_ajax_without_file() { ?>
  
      <script type="text/javascript" >
      jQuery(document).ready(function($) {
        ajaxurl = "<?= admin_url('admin-ajax.php') ?>"; // get ajaxurl
      });
      </script> 
      <?php
  }
    
}
