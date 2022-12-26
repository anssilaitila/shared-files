<?php

class SharedFilesAdminAllowMoreFileTypes {

  public function add_file_types( $mimes ) {

    $s = get_option('shared_files_settings');

    $file_types = [
      'webp'  => 'image/webp', 
      'avif'  => 'image/avif', 
      'svg'   => 'image/svg+xml', 
      'json'  => 'text/plain', 
      'csv'   => 'text/csv', 
      'ttf'   => 'font/ttf', 
      'woff'  => 'font/woff', 
      'woff2' => 'font/woff2'
    ];

    foreach ( $file_types as $key => $value ) {

      $ext = $key;
      $mime = $value;
      
      $is_allowed = 0;

      if ( isset($s['allow_file_type_' . $ext]) && !isset($mimes[$ext]) ) {
        $mimes[$ext] = $mime;
      }
      
    }

    $custom_file_types_cnt = 2;
    
    if ( isset($s['custom_file_types_cnt']) ) {
      $custom_file_types_cnt = intval( $s['custom_file_types_cnt'] ) + 1;
    }
    
    for ($n = 1; $n < $custom_file_types_cnt; $n++) {
    
      if ( isset($s['cft_' . $n . '_active']) && isset($s['cft_' . $n . '_extension']) ) {
        
        $custom_ext = sanitize_title( $s['cft_' . $n . '_extension'] );
        
        $custom_mime = '';
        
        if ( isset($s['cft_' . $n . '_mime_type']) ) {
          $custom_mime = sanitize_text_field( $s['cft_' . $n . '_mime_type'] );
        }
    
        if ( !isset($mimes[$custom_ext]) ) {
          $mimes[$custom_ext] = $custom_mime;
        }
    
      }
    
    }
    
    return $mimes;

  }

}
