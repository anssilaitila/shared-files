<?php

use enshrined\svgSanitize\Sanitizer;

class SharedFilesAdminAllowMoreFileTypes {

  public static function add_file_types( $mimes ) {

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

  public static function sanitize_file( $tmp_name, $filename ) {

    $uploaded_ext = pathinfo($filename, PATHINFO_EXTENSION);

    $file_contents = file_get_contents( $tmp_name );

    $mime_type = '';

    $checked = wp_check_filetype_and_ext( $tmp_name, $filename );

    if ( isset( $checked['type'] ) ) {
      $mime_type = sanitize_text_field( $checked['type'] );
    }

    if ( $mime_type == 'image/svg+xml' ) {

      $sanitizer = new Sanitizer();
      $file_contents_sanitized = $sanitizer->sanitize( $file_contents );
      return $file_contents_sanitized;

    } elseif ( $uploaded_ext != $checked['ext'] ) {

      wp_die( esc_html__( "ERROR: file extension doesn't match mime type", 'shared_files' ) .  ' (' . esc_html( $filename ) . ')' );

    } else {

      return $file_contents;

    }

  }

  public static function allowed_mime_types( $tmp_name, $filename ) {

    $uploaded_file_mime_type = '';

    add_filter('upload_mimes', [ 'SharedFilesAdminAllowMoreFileTypes', 'add_file_types' ] );

    $checked = wp_check_filetype_and_ext( $tmp_name, $filename );

    if ( isset( $checked['type'] ) ) {
      $uploaded_file_mime_type = sanitize_text_field( $checked['type'] );
    }

    $allowed_mime_types = get_allowed_mime_types();
    $disallowed_mime_types = ['text/html', 'application/ttaf+xml'];

    $checked_mime_type = [];

    if ( in_array($uploaded_file_mime_type, $disallowed_mime_types) ) {
      $checked_mime_type = [0, $uploaded_file_mime_type];
    } elseif ( in_array($uploaded_file_mime_type, $allowed_mime_types) ) {
      $checked_mime_type = [1, $uploaded_file_mime_type];
    } else {
      $checked_mime_type = [0, $uploaded_file_mime_type];
    }

    remove_filter('upload_mimes', [ 'SharedFilesAdminAllowMoreFileTypes', 'add_file_types' ] );

    return $checked_mime_type;

  }

}
