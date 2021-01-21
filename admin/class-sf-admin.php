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
class Shared_Files_Admin {

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
   * @param    string    $plugin_name       The name of this plugin.
   * @param    string    $version    The version of this plugin.
   */
  public function __construct($plugin_name, $version) {
    $this->plugin_name = $plugin_name;
    $this->version = $version;
  }

  public function enqueue_styles() {
    wp_enqueue_style($this->plugin_name, SHARED_FILES_URI . 'dist/css/a.css', array(), $this->version, 'all');
  }

  public function enqueue_scripts() {
    wp_enqueue_script($this->plugin_name, SHARED_FILES_URI . 'dist/js/a.js', array('jquery'), $this->version, false);
  }

  /**
   * Set the file itself when permanentyly deleting post.
   *
   * @since    1.0.0
   */
  function delete_shared_file($post_id) {
    $file = get_post_meta($post_id, '_sf_file', true);
    if (isset($file['file']) && file_exists($file['file'])) {
      unlink($file['file']);
    }
  }

  public function add_affiliation_link() {
    global $submenu;
    $permalink = './options-general.php?page=shared-files-affiliation';
    $menuitem = 'edit.php?post_type=shared_file';
    $submenu[$menuitem][] = array(__('Affiliation&nbsp;&nbsp;➤', 'shared-files'), 'manage_options', $permalink);
  }

  public function add_settings_link() {
    global $submenu;
    $permalink = './options-general.php?page=shared-files';
    $submenu['edit.php?post_type=shared_file'][] = array(__('Settings&nbsp;&nbsp;➤', 'shared-files'), 'manage_options', $permalink);
  }

  public function add_upgrade_link() {
    global $submenu;
    $permalink = './options-general.php?page=shared-files-pricing';
    $submenu['edit.php?post_type=shared_file'][] = array(__('Upgrade&nbsp;&nbsp;➤', 'shared-files'), 'manage_options', $permalink, '', 'shared-files-upgrade');
  }

}
