<?php

class SharedFilesAdminHelpers {

  public static function sfProFeatureMarkup() {
  
    $html = '';
  
    $html .= '<div class="sf-admin-pro-feature">';
    $html .= '<span>' . sanitize_text_field( __('This feature is available in the Pro version.', 'shared-files') ) . '</span>';
    $html .= '<a href="' . esc_url_raw( get_admin_url() ) . 'options-general.php?page=shared-files-pricing">' . sanitize_text_field( __('Upgrade here', 'shared-files') ) . '</a>';
    $html .= '</div>';
    
    return $html;
    
  }
  
  public static function sfProMoreFeaturesMarkup() {
  
    $html = '';
  
    $html .= '<div class="sf-admin-pro-feature">';
    $html .= '<span>' . sanitize_text_field( __('More features available in the Pro version.', 'shared-files') ) . '</span>';
    $html .= '<a href="' . esc_url_raw( get_admin_url() ) . 'options-general.php?page=shared-files-pricing">' . sanitize_text_field( __('Upgrade here', 'shared-files') ) . '</a>';
    $html .= '</div>';
    
    return $html;
    
  }
  
  public static function sfProFeatureSettingsMarkup() {
  
    $html = '';
  
    $html .= '<div class="sf-admin-pro-feature">';
    $html .= '<span>' . sanitize_text_field( __('More settings available in the Pro version.', 'shared-files') ) . '</span>';
    $html .= '<a href="' . esc_url_raw( get_admin_url() ) . 'options-general.php?page=shared-files-pricing">' . sanitize_text_field( __('Upgrade here', 'shared-files') ) . '</a>';
    $html .= '</div>';
    
    return $html;
    
  }

  public static function get_mime_type($filename) {

    $idx = explode('.', $filename);
    $count_explode = count($idx);
    $idx = strtolower($idx[$count_explode-1]);

    $mimet = array(
      'txt' => 'text/plain',
      'htm' => 'text/html',
      'html' => 'text/html',
      'php' => 'text/html',
      'css' => 'text/css',
      'js' => 'application/javascript',
      'json' => 'application/json',
      'xml' => 'application/xml',
      'swf' => 'application/x-shockwave-flash',
      'flv' => 'video/x-flv',

      // images
      'png' => 'image/png',
      'jpe' => 'image/jpeg',
      'jpeg' => 'image/jpeg',
      'jpg' => 'image/jpeg',
      'gif' => 'image/gif',
      'bmp' => 'image/bmp',
      'ico' => 'image/vnd.microsoft.icon',
      'tiff' => 'image/tiff',
      'tif' => 'image/tiff',
      'svg' => 'image/svg+xml',
      'svgz' => 'image/svg+xml',

      // archives
      'zip' => 'application/zip',
      'rar' => 'application/x-rar-compressed',
      'exe' => 'application/x-msdownload',
      'msi' => 'application/x-msdownload',
      'cab' => 'application/vnd.ms-cab-compressed',

      // audio/video
      'mp3' => 'audio/mpeg',
      'qt' => 'video/quicktime',
      'mov' => 'video/quicktime',

      // adobe
      'pdf' => 'application/pdf',
      'psd' => 'image/vnd.adobe.photoshop',
      'ai' => 'application/postscript',
      'eps' => 'application/postscript',
      'ps' => 'application/postscript',

      // ms office
      'doc' => 'application/msword',
      'rtf' => 'application/rtf',
      'xls' => 'application/vnd.ms-excel',
      'ppt' => 'application/vnd.ms-powerpoint',
      'docx' => 'application/msword',
      'xlsx' => 'application/vnd.ms-excel',
      'pptx' => 'application/vnd.ms-powerpoint',

      // open office
      'odt' => 'application/vnd.oasis.opendocument.text',
      'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    );

    if (isset($mimet[$idx])) {

      return $mimet[$idx];

    } else {

      return 'application/octet-stream';

    }

  }

  public static function human_filesize($bytes, $decimals = 2) {

    $size = array('bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

    $factor = floor((strlen($bytes) - 1) / 3);

    return $bytes ? sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . @$size[$factor] : 0;

  }

  public static function sf_root() {

    $s = get_option('shared_files_settings');
  
    $sf_root = '';
  
    if (isset($s['wp_location']) && isset($s['wp_location'])) {
  
      $sf_root = rtrim( sanitize_text_field( $s['wp_location'] ), '/');
  
    } else {
  
      $url_parts = parse_url( esc_url_raw( get_admin_url() ) );
      $path_parts = explode('/', $url_parts['path']);
      
      if (isset($path_parts[2]) && $path_parts[2] == 'wp-admin') {
        $sf_root = '/' . $path_parts[1];
      }
      
    }
    
    if ( is_multisite() ) {

      $multisite_path_part = str_replace( '/', '', get_blog_details()->path );
      
      if ($multisite_path_part) {
        $sf_root = '/' . $multisite_path_part . $sf_root;
      }
      
    }
    
    return $sf_root;

  }

}
