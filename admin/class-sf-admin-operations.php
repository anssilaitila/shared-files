<?php

class SharedFilesAdminOperations {

  public function operations() {

    if (isset($_POST) && isset($_POST['_shared_files_empty_download_log']) && isset($_REQUEST['_wpnonce']) && is_super_admin()) {

      $wp_nonce = sanitize_text_field( $_REQUEST['_wpnonce'] );

      if ( wp_verify_nonce($wp_nonce, '_shared-files-empty-download-log')) {

        global $wpdb;
        $delete = $wpdb->query("TRUNCATE TABLE {$wpdb->prefix}shared_files_download_log");

        $goto_url = get_admin_url(null, './edit.php?post_type=shared_file&page=shared-files-download-log&download_log_emptied=1');

        wp_safe_redirect( esc_url_raw( $goto_url ) );

        exit;

      } else {

        $goto_url = get_admin_url(null, './edit.php?post_type=shared_file&page=shared-files-download-log&download_log_emptied_error=1');

        wp_safe_redirect( esc_url_raw( $goto_url ) );

      }

    } elseif (isset($_POST) && isset($_POST['_shared_files_empty_contacts']) && isset($_REQUEST['_wpnonce']) && is_super_admin()) {

      $wp_nonce = sanitize_text_field( $_REQUEST['_wpnonce'] );

      if ( wp_verify_nonce($wp_nonce, '_shared-files-empty-contacts')) {

        global $wpdb;
        $delete = $wpdb->query("TRUNCATE TABLE {$wpdb->prefix}shared_files_contacts");

        $goto_url = get_admin_url(null, './edit.php?post_type=shared_file&page=shared-files-contacts&contacts_emptied=1');

        wp_safe_redirect( esc_url_raw( $goto_url ) );

        exit;

      } else {

        $goto_url = get_admin_url(null, './edit.php?post_type=shared_file&page=shared-files-contacts&contacts_emptied_error=1');

        wp_safe_redirect( esc_url_raw( $goto_url ) );

      }

   } elseif (isset($_POST) && isset($_POST['_shared_files_empty_search_log']) && isset($_REQUEST['_wpnonce']) && is_super_admin()) {

     $wp_nonce = sanitize_text_field( $_REQUEST['_wpnonce'] );

     if ( wp_verify_nonce($wp_nonce, '_shared-files-empty-search-log')) {

       global $wpdb;
       $delete = $wpdb->query("TRUNCATE TABLE {$wpdb->prefix}shared_files_search_log");

       $goto_url = get_admin_url(null, './edit.php?post_type=shared_file&page=shared-files-search-log&search_log_emptied=1');

       wp_safe_redirect( esc_url_raw( $goto_url ) );

       exit;

     } else {

       $goto_url = get_admin_url(null, './edit.php?post_type=shared_file&page=shared-files-search-log&search_log_emptied_error=1');

       wp_safe_redirect( esc_url_raw( $goto_url ) );

     }

   }


  }

}