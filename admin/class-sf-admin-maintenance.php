<?php

class SharedFilesAdminMaintenance {

  public function update_db_check() {

//    wp_clear_scheduled_hook('check_expired_files');

    if (!wp_next_scheduled('check_expired_files')) {
      wp_schedule_event(time(), 'daily', 'check_expired_files');
    }

    $sf_dir = wp_get_upload_dir()['basedir'];
    $sf_file = $sf_dir . '/shared-files/index.php';

    if (!file_exists($sf_file)) {
      touch($sf_file);
    }
    
  }

}
