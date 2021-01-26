<?php

class SharedFilesAdminQuery {

  /**
   * Serve the file itself and update necessary metadata.
   *
   * @since    1.0.0
   */
  public function alter_the_query($request) {

    global $wp;

    $s = get_option('shared_files_settings');

    $url = home_url($wp->request);

    $sf_query = 0;
    $sf_sub = 0;

    $url_parts = parse_url($url);

    if (isset($url_parts['path'])) {
      $path_parts = explode('/', $url_parts['path']);
    }

    if (isset($path_parts[2]) && $path_parts[2] == 'shared-files') {
      $sf_query = 1;
      $sf_sub = 1;
    } else if (isset($path_parts[1]) && $path_parts[1] == 'shared-files') {
      $sf_query = 1;
    }

    if ($sf_query) {

      $file_id = 0;
      
      if ($sf_sub) {
        $file_id = isset($path_parts[3]) ? (int) $path_parts[3] : 0;
      } else {
        $file_id = isset($path_parts[2]) ? (int) $path_parts[2] : 0;
      }

      if ($file_id) {

        $password = get_post_meta($file_id, '_sf_password', true);
        $given_password = isset($_POST['password']) ? $_POST['password'] : '';
        
        if ($password && (!$given_password || $given_password != $password)) {
          echo SharedFilesPublicHelpers::passwordProtectedMarkup();
          die();
        }

        $external_url = esc_url_raw(get_post_meta($file_id, '_sf_external_url', true));

//        $file_obj = get_post($file_id);

        SharedFilesAdminSendMail::file_load_send_email($file_id, get_post($file_id));

        if ($external_url) {

          // Update load counter and last access
          $load_cnt = (int) get_post_meta($file_id, '_sf_load_cnt', true);
          $load_limit = (int) get_post_meta($file_id, '_sf_limit_downloads', true);

          if ($load_limit && $load_cnt >= $load_limit) {
            SharedFilesAdminSendMail::file_limit_send_email($file_id, get_post($file_id));
            echo SharedFilesPublicHelpers::downloadLimitMarkup();
            die();
          }
          
          update_post_meta($file_id, '_sf_load_cnt', $load_cnt + 1);
          update_post_meta($file_id, '_sf_last_access', current_time('Y-m-d H:i:s'));

          if (!isset($_POST['youtube']) && !isset($_POST['only_meta'])) {
            header('Location: ' . $external_url);
          }
          
          die();

        } elseif ($file = get_post_meta($file_id, '_sf_file', true)) {

          if (!isset($file['file']) || !file_exists($file['file'])) {
            wp_die(__('File not found', 'shared-files'));
          }

          $filename = $file['file'];
          $file_mime = '';

          if (function_exists('mime_content_type')) {
            $file_mime = mime_content_type($filename);
          } elseif (function_exists('finfo_open') && function_exists('finfo_file')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_mime = finfo_file($finfo, $filename);
            finfo_close($finfo);
          }

          if (!$file_mime) {
            $file_mime = SharedFilesAdminHelpers::get_mime_type($filename);
          }

          // Update load counter, last access and bandwidth usage
          $load_cnt = (int) get_post_meta($file_id, '_sf_load_cnt', true);
          $load_limit = (int) get_post_meta($file_id, '_sf_limit_downloads', true);

          if ($load_limit && $load_cnt >= $load_limit) {
            SharedFilesAdminSendMail::file_limit_send_email($file_id, get_post($file_id));
            echo SharedFilesPublicHelpers::downloadLimitMarkup();
            die();
          }

          $bandwidth_usage = get_post_meta($file_id, '_sf_bandwidth_usage', true) || 0;
          $filesize = get_post_meta($file_id, '_sf_filesize', true) || 0;
          update_post_meta($file_id, '_sf_load_cnt', $load_cnt + 1);
          update_post_meta($file_id, '_sf_last_access', current_time( 'Y-m-d H:i:s' ));
          update_post_meta($file_id, '_sf_bandwidth_usage', $bandwidth_usage + $filesize);

          if (isset($s['file_open_method']) && $s['file_open_method'] == 'redirect') {
            $file = get_post_meta($file_id, '_sf_file', true);
            $file_url = $file['url'];
            wp_redirect($file_url);
            exit;
          }

          $path = pathinfo($filename); 
          $header_filename = $path['filename'];
          $header_extension = $path['extension'];
          $header_filename_ext = '';
          
          if ($header_filename && $header_extension) {
            $header_filename_ext = $header_filename . '.' . $header_extension;
          }
          
          if (isset($_GET['download'])) {

            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0'); 
            header('Content-Type: application/force-download');
            header('Content-Type: application/octet-stream');
            header('Content-Type: application/download');
          
            if ($header_filename_ext) {
              header('Content-Disposition: attachment;filename=' . $header_filename_ext);
            }
            
            header('Content-Transfer-Encoding: binary');

          } else {

            // Set headers
            header('Content-Type: ' . $file_mime);
            
            if ($header_filename_ext) {
              header('Content-Disposition: inline; filename="' . $header_filename_ext . '"');
            }
            
            header('Cache-Control: no-cache, must-revalidate');
            header('X-Accel-Buffering: no');
  
            header('Content-Length: ' . filesize($filename));

          }

          if (function_exists('ob_clean')) {
            ob_clean();
          }

          if (function_exists('ob_end_flush')) {
            ob_end_flush();
          }

          if (isset($s['file_open_method']) && $s['file_open_method'] == 'alt') {

            set_time_limit(0);
            $file_alt = @fopen($filename, 'rb');

            while (!feof($file_alt)) {
              print(@fread($file_alt, 1024 * 8));
              ob_flush();
              flush();
            }

          } else {

            readfile($filename);

          }

          exit;
        }

      }

    }

    return $request;
  }

}
