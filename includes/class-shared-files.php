<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://anssilaitila.fi
 * @since      1.0.0
 *
 * @package    Shared_Files
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Shared_Files
 * @subpackage Shared_Files/includes
 * @author     Anssi Laitila <anssi.laitila@gmail.com>
 */
class Shared_Files {

  /**
   * The loader that's responsible for maintaining and registering all hooks that power
   * the plugin.
   *
   * @since    1.0.0
   * @access   protected
   * @var      Shared_Files_Loader    $loader    Maintains and registers all hooks for the plugin.
   */
  protected $loader;

  /**
   * The unique identifier of this plugin.
   *
   * @since    1.0.0
   * @access   protected
   * @var      string    $plugin_name    The string used to uniquely identify this plugin.
   */
  protected $plugin_name;

  /**
   * The current version of the plugin.
   *
   * @since    1.0.0
   * @access   protected
   * @var      string    $version    The current version of the plugin.
   */
  protected $version;

  /**
   * Define the core functionality of the plugin.
   *
   * Set the plugin name and the plugin version that can be used throughout the plugin.
   * Load the dependencies, define the locale, and set the hooks for the admin area and
   * the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function __construct() {
    
    if (defined('SHARED_FILES_VERSION')) {
      $this->version = SHARED_FILES_VERSION;
    }
    
    $this->plugin_name = 'shared-files';

    $this->load_dependencies();
    $this->set_locale();
    $this->define_admin_hooks();
    $this->define_public_hooks();
  }

  /**
   * Load the required dependencies for this plugin.
   *
   * Include the following files that make up the plugin:
   *
   * - Shared_Files_Loader. Orchestrates the hooks of the plugin.
   * - Shared_Files_i18n. Defines internationalization functionality.
   * - Shared_Files_Admin. Defines all hooks for the admin area.
   * - Shared_Files_Public. Defines all hooks for the public side of the site.
   *
   * Create an instance of the loader which will be used to register the hooks
   * with WordPress.
   *
   * @since    1.0.0
   * @access   private
   */
  private function load_dependencies() {

    /**
     * The class responsible for orchestrating the actions and filters of the
     * core plugin.
     */
    require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-shared-files-loader.php';

    /**
     * The class responsible for defining internationalization functionality
     * of the plugin.
     */
    require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-shared-files-i18n.php';
    require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-shared-files-helpers.php';

    require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-sf-admin.php';
    require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-sf-admin-cpt.php';
    require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-sf-admin-taxonomy.php';
    require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-sf-admin-maintenance.php';
    require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-sf-admin-send-mail.php';
    require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-sf-admin-query.php';
    require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-sf-admin-list.php';
    require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-sf-admin-metadata.php';
    require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-sf-admin-help-support.php';
    require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-sf-admin-helpers.php';
    require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-sf-admin-settings.php';
    require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-sf-admin-notifications.php';

    require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-sf-public.php';
    require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-sf-public-ajax.php';
    require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-sf-public-helpers.php';
    require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-sf-public-file-upload.php';

    require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-shortcode-shared_files.php';
    require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-shortcode-shared_files_search.php';
    require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-shortcode-shared_files_categories.php';

    $this->loader = new Shared_Files_Loader();

  }

  /**
   * Define the locale for this plugin for internationalization.
   *
   * Uses the Shared_Files_i18n class in order to set the domain and to register the hook
   * with WordPress.
   *
   * @since    1.0.0
   * @access   private
   */
  private function set_locale() {

    $plugin_i18n = new Shared_Files_i18n();
    $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
  }

  /**
   * Register all of the hooks related to the admin area functionality
   * of the plugin.
   *
   * @since    1.0.0
   * @access   private
   */
  private function define_admin_hooks() {

    $plugin_admin = new Shared_Files_Admin($this->get_plugin_name(), $this->get_version());
    $plugin_admin_cpt = new SharedFilesAdminCPT();
    $plugin_admin_taxonomy = new SharedFilesAdminTaxonomy();
    $plugin_admin_maintenance = new SharedFilesAdminMaintenance();
    $plugin_admin_help_support = new SharedFilesAdminHelpSupport();
    $plugin_admin_query = new SharedFilesAdminQuery();
    $plugin_admin_send_mail = new SharedFilesAdminSendMail();
    $plugin_admin_list = new SharedFilesAdminList();
    $plugin_admin_metadata = new SharedFilesAdminMetadata();
    $plugin_admin_notifications = new SharedFilesAdminNotifications();
    $plugin_settings = new Shared_Files_Settings();

    // Enqueue CSS + JS (+ other)    
    $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
    $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
    $this->loader->add_action('before_delete_post', $plugin_admin, 'delete_shared_file');
    $this->loader->add_action('admin_menu', $plugin_admin, 'add_settings_link');

    // Maintenance
    $this->loader->add_action('plugins_loaded', $plugin_admin_maintenance, 'update_db_check');

    // Send mail
    $this->loader->add_action('check_expired_files', $plugin_admin_send_mail, 'file_expired_send_email');

    // CPT
    $this->loader->add_action('init', $plugin_admin_cpt, 'create_custom_post_type');
    
    // Custom metadata for a file
    $this->loader->add_action('save_post', $plugin_admin_metadata, 'save_custom_meta_data');
    $this->loader->add_action('add_meta_boxes_shared_file', $plugin_admin_metadata, 'adding_custom_meta_boxes');

    // Help & support    
    $this->loader->add_action('admin_menu', $plugin_admin_help_support, 'register_support_page');

    // Custom taxonomy
    $this->loader->add_action('init', $plugin_admin_taxonomy, 'create_shared_files_custom_taxonomy', 0);

    // Settings
    $this->loader->add_action('admin_menu', $plugin_settings, 'shared_files_add_admin_menu');
    $this->loader->add_action('admin_init', $plugin_settings, 'shared_files_settings_init');

    // Query
    $this->loader->add_filter('request', $plugin_admin_query, 'alter_the_query');

    // Admin list
    $this->loader->add_action('manage_shared_file_posts_custom_column', $plugin_admin_list, 'shared_file_custom_columns_content', 10, 2);
    $this->loader->add_action('restrict_manage_posts', $plugin_admin_list, 'filter_files_by_taxonomies', 10, 2);
    $this->loader->add_filter('manage_shared_file_posts_columns', $plugin_admin_list, 'shared_file_custom_columns', 10);
    $this->loader->add_filter('manage_edit-shared_file_sortable_columns', $plugin_admin_list, 'set_custom_shared_files_sortable_columns');
    $this->loader->add_filter('parse_query', $plugin_admin_list, 'sort_posts_by_meta_value');
    $this->loader->add_filter('posts_clauses', $plugin_admin_list, 'sort_by_custom_taxonomy', 10, 2);

    // Notifications
    $this->loader->add_action('admin_notices', $plugin_admin_notifications, 'notifications_html', 8);
    $this->loader->add_action('admin_init', $plugin_admin_notifications, 'process_notifications');

    if (SharedFilesHelpers::isPremium() == 0) {
      $this->loader->add_action('admin_menu', $plugin_admin_taxonomy, 'register_categories_info_page');
    }

    if (SharedFilesHelpers::isPremium() == 0) {
      $this->loader->add_action('admin_menu', $plugin_admin, 'add_upgrade_link');
    }

  }

  /**
   * Register all of the hooks related to the public-facing functionality
   * of the plugin.
   *
   * @since    1.0.0
   * @access   private
   */
  private function define_public_hooks() {

    $plugin_public = new Shared_Files_Public($this->get_plugin_name(), $this->get_version());
    $plugin_public_ajax = new SharedFilesPublicAjax();
    $plugin_public_file_upload = new SharedFilesFileUpload();

    // Enqueue CSS + JS + register shortcodes
    $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
    $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
    $this->loader->add_action('init', $plugin_public, 'register_shortcodes');

    // Ajax
    $this->loader->add_action('wp_ajax_nopriv_sf_get_files', $plugin_public_ajax, 'sf_get_files');
    $this->loader->add_action('wp_ajax_sf_get_files', $plugin_public_ajax, 'sf_get_files');
    $this->loader->add_action('wp_footer', $plugin_public_ajax, 'my_ajax_without_file');

    // Front-end file upload
    $this->loader->add_filter('request', $plugin_public_file_upload, 'file_upload');

  }

  /**
   * Run the loader to execute all of the hooks with WordPress.
   *
   * @since    1.0.0
   */
  public function run() {
    $this->loader->run();
  }

  /**
   * The name of the plugin used to uniquely identify it within the context of
   * WordPress and to define internationalization functionality.
   *
   * @since     1.0.0
   * @return    string    The name of the plugin.
   */
  public function get_plugin_name() {
    return $this->plugin_name;
  }

  /**
   * The reference to the class that orchestrates the hooks with the plugin.
   *
   * @since     1.0.0
   * @return    Shared_Files_Loader    Orchestrates the hooks of the plugin.
   */
  public function get_loader() {
    return $this->loader;
  }

  /**
   * Retrieve the version number of the plugin.
   *
   * @since     1.0.0
   * @return    string    The version number of the plugin.
   */
  public function get_version() {
    return $this->version;
  }

}
