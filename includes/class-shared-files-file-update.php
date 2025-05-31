<?php

class SharedFilesFileUpdate {

  public static function uFilesize($file_id, $_sf_file_size = 0, $filename_and_path = '') {

    $filesize = 0;
    $filesize_alt = 0;
    
    if ( $_sf_file_size ) {
      $filesize = sanitize_text_field( $_sf_file_size );
    }
    
    if ( $filename_and_path ) {
      $filesize_alt = sanitize_text_field( filesize( $filename_and_path ) );
    }
    
    if ( $filesize ) {
      update_post_meta($file_id, '_sf_filesize', $filesize);
    } elseif ( $filesize_alt ) {
      update_post_meta($file_id, '_sf_filesize', $filesize_alt);
    } else {
      update_post_meta($file_id, '_sf_filesize', 0);
    }

  }

}
