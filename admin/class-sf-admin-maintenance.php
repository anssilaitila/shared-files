<?php

class SharedFilesAdminMaintenance {

  public function update_db_check() {

    $s = get_option('shared_files_settings');

    if (!get_option('shared-files-sc')) {

      $rand_code = sanitize_text_field( md5(uniqid(rand(), true)) );

      add_option('shared-files-sc', $rand_code, '', 'yes');

    }

    if (!wp_next_scheduled('check_expired_files')) {
      wp_schedule_event(time(), 'daily', 'check_expired_files');
    }

    if ($s === false) {

      $wp_subdir = SharedFilesHelpers::getWPSubdir();

      $default_settings = [
        'hide_bandwidth_usage'          => 'on',
        'card_background'               => 'light_gray',
        'preview_service'               => 'microsoft',
        'uncheck_hide_from_other_pages' => 'on',
        'always_preview_pdf'            => 'on',
        'bypass_preview_pdf'            => 'on',
        'pagination_type'               => 'improved',
        'wp_engine_compatibility_mode'  => 'on',
        'show_file_upload_checkboxes_on_multiple_columns' => 'on',
        'show_download_button'          => 'on',
        'show_download_counter'         => 'on',
        'simple_list_show_titles_for_columns'  => 'on',
        'simple_list_show_download_counter' => 'on',
        'simple_list_show_tag'          => 'on',
        'tag_slug'                      => 'shared-file-tag',
        'log_enable_user_data'          => 'on',
        'log_enable_ip'                 => 'on',
        'log_enable_user_agent'         => 'on',
        'log_enable_referer_url'        => 'on',
        'prevent_search_engines_from_indexing_uploaded_file_urls' => 'on',
        'show_tag_dropdown_on_file_upload'  => 'on',
        'lead_show_name'                => 'on',
        'lead_show_phone'               => 'on',
        'lead_show_description'         => 'on',
        'wp_location'                   => $wp_subdir,
      ];

      add_option('shared_files_settings', $default_settings);

      update_option('shared_files_how_to_show_notice', 1, false);

    }

  }

  public function update_db_check_v2() {

    $installed_version = get_option('shared_files_version');

    if ($installed_version != SHARED_FILES_VERSION) {

      global $wpdb;

      $charset_collate = $wpdb->get_charset_collate();

      // Table for debug data and general log
      $table_name_log = $wpdb->prefix . 'shared_files_log';

      $wpdb->query("CREATE TABLE IF NOT EXISTS " . $table_name_log . " (
        id              BIGINT(20) NOT NULL auto_increment,
        title           VARCHAR(255) NOT NULL,
        message         TEXT NOT NULL,
        created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
      ) " . $charset_collate . ";" );

      // Table for file download log
      $table_name_download_log = $wpdb->prefix . 'shared_files_download_log';

      $wpdb->query("CREATE TABLE IF NOT EXISTS " . $table_name_download_log . " (
        id              BIGINT(20) NOT NULL auto_increment,
        file_id         VARCHAR(255) NOT NULL,
        file_title      VARCHAR(255) NOT NULL,
        file_name       VARCHAR(255) NOT NULL,
        file_size       VARCHAR(255) NOT NULL,
        ip              VARCHAR(255) NOT NULL,
        download_cnt    MEDIUMINT NOT NULL,
        report          TEXT NOT NULL,
        created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        user_id         BIGINT(20) NOT NULL,
        user_login      VARCHAR(255) NOT NULL,
        user_name       VARCHAR(255) NOT NULL,
        user_country    VARCHAR(255) NOT NULL,
        user_country_code    VARCHAR(255) NOT NULL,
        user_city       VARCHAR(255) NOT NULL,
        user_agent      TEXT NOT NULL,
        referer_url     TEXT NOT NULL,
        PRIMARY KEY (id)
      ) " . $charset_collate . ";" );


      // user_id
      $column_name = 'user_id';
      $column_exists = $wpdb->get_results("SHOW COLUMNS FROM `$table_name_download_log` LIKE '$column_name'");
      if (empty($column_exists)) {
        $wpdb->query("ALTER TABLE `$table_name_download_log` ADD `$column_name` BIGINT(20) NOT NULL");
      }

      // user_login
      $column_name = 'user_login';
      $column_exists = $wpdb->get_results("SHOW COLUMNS FROM `$table_name_download_log` LIKE '$column_name'");
      if (empty($column_exists)) {
        $wpdb->query("ALTER TABLE `$table_name_download_log` ADD `$column_name` VARCHAR(255) NOT NULL");
      }

      // user_name
      $column_name = 'user_name';
      $column_exists = $wpdb->get_results("SHOW COLUMNS FROM `$table_name_download_log` LIKE '$column_name'");
      if (empty($column_exists)) {
        $wpdb->query("ALTER TABLE `$table_name_download_log` ADD `$column_name` VARCHAR(255) NOT NULL");
      }

      // user_country
      $column_name = 'user_country';
      $column_exists = $wpdb->get_results("SHOW COLUMNS FROM `$table_name_download_log` LIKE '$column_name'");
      if (empty($column_exists)) {
        $wpdb->query("ALTER TABLE `$table_name_download_log` ADD `$column_name` VARCHAR(255) NOT NULL");
      }

      // user_country_code
      $column_name = 'user_country_code';
      $column_exists = $wpdb->get_results("SHOW COLUMNS FROM `$table_name_download_log` LIKE '$column_name'");
      if (empty($column_exists)) {
        $wpdb->query("ALTER TABLE `$table_name_download_log` ADD `$column_name` VARCHAR(255) NOT NULL");
      }

      // user_city
      $column_name = 'user_city';
      $column_exists = $wpdb->get_results("SHOW COLUMNS FROM `$table_name_download_log` LIKE '$column_name'");
      if (empty($column_exists)) {
        $wpdb->query("ALTER TABLE `$table_name_download_log` ADD `$column_name` VARCHAR(255) NOT NULL");
      }

      // user_agent
      $column_name = 'user_agent';
      $column_exists = $wpdb->get_results("SHOW COLUMNS FROM `$table_name_download_log` LIKE '$column_name'");
      if (empty($column_exists)) {
        $wpdb->query("ALTER TABLE `$table_name_download_log` ADD `$column_name` TEXT NOT NULL");
      }

      // referer_url
      $column_name = 'referer_url';
      $column_exists = $wpdb->get_results("SHOW COLUMNS FROM `$table_name_download_log` LIKE '$column_name'");
      if (empty($column_exists)) {
        $wpdb->query("ALTER TABLE `$table_name_download_log` ADD `$column_name` TEXT NOT NULL");
      }

      // Table for search log
      $table_name_search_log      = $wpdb->prefix . 'shared_files_search_log';

      $wpdb->query("CREATE TABLE IF NOT EXISTS " . $table_name_search_log . " (
        id              BIGINT(20) NOT NULL auto_increment,
        created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        user_ip         VARCHAR(255) NOT NULL,
        user_country    VARCHAR(255) NOT NULL,
        user_country_code    VARCHAR(255) NOT NULL,
        user_city       VARCHAR(255) NOT NULL,
        user_agent      VARCHAR(255) NOT NULL,
        post_id         BIGINT(20) NOT NULL,
        permalink       VARCHAR(255) NOT NULL,
        referer_url     VARCHAR(255) NOT NULL,
        search          VARCHAR(255) NOT NULL,
        category        VARCHAR(255) NOT NULL,
        tag             VARCHAR(255) NOT NULL,
        custom_field_1  VARCHAR(255) NOT NULL,
        custom_field_2  VARCHAR(255) NOT NULL,
        custom_field_3  VARCHAR(255) NOT NULL,
        custom_field_4  VARCHAR(255) NOT NULL,
        custom_field_5  VARCHAR(255) NOT NULL,
        custom_field_6  VARCHAR(255) NOT NULL,
        PRIMARY KEY (id)
      ) " . $charset_collate . ";" );

      // Table for contacts
      $table_name_contacts = $wpdb->prefix . 'shared_files_contacts';

      $wpdb->query("CREATE TABLE IF NOT EXISTS " . $table_name_contacts . " (
        id                BIGINT(20) NOT NULL auto_increment,
        file_id           VARCHAR(255) NOT NULL,
        file_title        VARCHAR(255) NOT NULL,
        file_name         VARCHAR(255) NOT NULL,
        file_size         VARCHAR(255) NOT NULL,
        embed_id          VARCHAR(255) NOT NULL,
        ask_for_email_id  VARCHAR(255) NOT NULL,
        email             VARCHAR(255) NOT NULL,
        ip                VARCHAR(255) NOT NULL,
        user_country      VARCHAR(255) NOT NULL,
        user_agent        TEXT NOT NULL,
        referer_url       TEXT NOT NULL,
        title             VARCHAR(255) NOT NULL,
        message           TEXT NOT NULL,
        created_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        name              VARCHAR(255) NOT NULL,
        phone             VARCHAR(255) NOT NULL,
        descr             TEXT NOT NULL,
        PRIMARY KEY (id)
      ) " . $charset_collate . ";" );

      // name
      $column_name = 'name';
      $column_exists = $wpdb->get_results("SHOW COLUMNS FROM `$table_name_contacts` LIKE '$column_name'");
      if (empty($column_exists)) {
        $wpdb->query("ALTER TABLE `$table_name_contacts` ADD `$column_name` VARCHAR(255) NOT NULL");
      }

      // phone
      $column_name = 'phone';
      $column_exists = $wpdb->get_results("SHOW COLUMNS FROM `$table_name_contacts` LIKE '$column_name'");
      if (empty($column_exists)) {
        $wpdb->query("ALTER TABLE `$table_name_contacts` ADD `$column_name` VARCHAR(255) NOT NULL");
      }

      // descr
      $column_name = 'descr';
      $column_exists = $wpdb->get_results("SHOW COLUMNS FROM `$table_name_contacts` LIKE '$column_name'");
      if (empty($column_exists)) {
        $wpdb->query("ALTER TABLE `$table_name_contacts` ADD `$column_name` TEXT NOT NULL");
      }


      update_option('shared_files_version', SHARED_FILES_VERSION);

      SharedFilesHelpers::writeLog('Plugin updated to version ' . SHARED_FILES_VERSION, '');

      $sf_dir = wp_get_upload_dir()['basedir'] . '/shared-files/';
      $sf_file = $sf_dir . 'index.php';

      if ( !file_exists( $sf_dir ) || !is_dir( $sf_dir ) ) {

        mkdir( $sf_dir );

        if ( is_dir( $sf_dir ) ) {
          SharedFilesHelpers::writeLog( 'Created ' . $sf_dir, '' );
        }

      }

      if (is_dir($sf_dir) && !file_exists($sf_file) && $file = fopen($sf_file, 'a')) {

        fwrite($file, '<?php // Automatically generated by Shared Files ?>' . PHP_EOL);
        fclose($file);

      }

      $sf_dir = wp_get_upload_dir()['basedir'] . '/shared-files/_export/';
      $sf_file = $sf_dir . 'index.php';

      if ( !file_exists( $sf_dir ) || !is_dir( $sf_dir ) ) {

        mkdir( $sf_dir );

        if ( is_dir( $sf_dir ) ) {
          SharedFilesHelpers::writeLog( 'Created ' . $sf_dir, '' );
        }

      }

      if (is_dir($sf_dir) && !file_exists($sf_file) && $file = fopen($sf_file, 'a')) {

        fwrite($file, '<?php // Automatically generated by Shared Files ?>' . PHP_EOL);
        fclose($file);

      }

    }

  }

  public function add_cron_interval($schedules) {

    $schedules['every_min'] = array(
      'interval'  => 60, // time in seconds
      'display'   => 'Every minute'
    );

    $schedules['every_15_min'] = array(
      'interval'  => 900, // time in seconds
      'display'   => 'Every 15 minutes'
    );

    $schedules['shared_files_every_5_min'] = array(
      'interval'  => 300, // time in seconds
      'display'   => 'Every 5 minutes'
    );

    return $schedules;
  }

}