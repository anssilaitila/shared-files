<?php

class SharedFilesHelpers {

  public static function getFiletypes() {

    $filetypes = array(
      'image/png' => 'image',
      'image/jpg' => 'image',
      'image/jpeg' => 'image',
      'application/pdf' => 'pdf',
      'application/postscript' => 'ai',
      'application/msword' => 'doc',
      'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'doc',
      'application/vnd.ms-fontobject' => 'font',
      'font/otf' => 'font',
      'font/ttf' => 'font',
      'font/woff' => 'font',
      'font/woff2' => 'font',
      'text/html' => 'html',
      'audio/mpeg3' => 'mp3',
      'audio/x-mpeg-3' => 'mp3',
      'audio/mpeg' => 'mp3',
      'video/x-msvideo' => 'video',
      'video/mpeg' => 'video',
      'video/x-mpeg' => 'video',
      'video/ogg' => 'video',
      'video/webm' => 'video',
      'video/3gpp' => 'video',
      'video/3gpp2' => 'video',
      'application/vnd.ms-excel' => 'xlsx',
      'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
      'application/zip' => 'zip',
      'application/x-7z-compressed' => 'zip'
    );
    
    return $filetypes;
    
  }

  public static function getCustomIcons() {

    $s = get_option('shared_files_settings');

    $filetypes = array(
      'image/png' => $s['icon_for_image'],
      'image/jpg' => $s['icon_for_image'],
      'image/jpeg' => $s['icon_for_image'],
      'application/pdf' => $s['icon_for_pdf'],
      'application/postscript' => $s['icon_for_ai'],
      'application/msword' => $s['icon_for_doc'],
      'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => $s['icon_for_doc'],
      'application/vnd.ms-fontobject' => $s['icon_for_font'],
      'font/otf' => $s['icon_for_font'],
      'font/ttf' => $s['icon_for_font'],
      'font/woff' => $s['icon_for_font'],
      'font/woff2' => $s['icon_for_font'],
      'text/html' => $s['icon_for_html'],
      'audio/mpeg3' => $s['icon_for_mp3'],
      'audio/x-mpeg-3' => $s['icon_for_mp3'],
      'audio/mpeg' => $s['icon_for_mp3'],
      'video/x-msvideo' => $s['icon_for_video'],
      'video/mpeg' => $s['icon_for_video'],
      'video/x-mpeg' => $s['icon_for_video'],
      'video/ogg' => $s['icon_for_video'],
      'video/webm' => $s['icon_for_video'],
      'video/3gpp' => $s['icon_for_video'],
      'video/3gpp2' => $s['icon_for_video'],
      'application/vnd.ms-excel' => $s['icon_for_xlsx'],
      'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => $s['icon_for_xlsx'],
      'application/zip' => $s['icon_for_zip'],
      'application/x-7z-compressed' => $s['icon_for_zip']
    );
    
    return $filetypes;
    
  }
  
  public static function getExternalFiletypes() {
  
    $external_filetypes = array(
      'png' => 'image',
      'jpg' => 'image',
      'pdf' => 'pdf',
      'ai' => 'ai',
      'doc' => 'doc',
      'docx' => 'doc',
      'mp3' => 'mp3',
      'mpeg' => 'video',
      'mpg' => 'video',
      'ogg' => 'video',
      'webm' => 'video',
      'xls' => 'xlsx',
      'xlsx' => 'xlsx',
      'zip' => 'zip',
    );
    
    return $external_filetypes;
  
  }

  public static function getImageFile($file_id, $external_url) {

    $filetypes = SharedFilesHelpers::getFiletypes();
    $external_filetypes = SharedFilesHelpers::getExternalFiletypes();
    $custom_icons = SharedFilesHelpers::getCustomIcons();

    $imagefile = 'generic.png';
    $file_type_icon_url = '';

    if ($external_url) {

      $ext = pathinfo($external_url, PATHINFO_EXTENSION);

      if (array_key_exists($ext, $external_filetypes)) {
        if (isset($external_filetypes[$ext])) {
          $imagefile = $external_filetypes[$ext] . '.png';
        }
      }

    } else {

      $file = get_post_meta($file_id, '_sf_file', true);
      
      if (isset($file['type'])) {

        $filetype = $file['type'];
        
        if (array_key_exists($filetype, $filetypes)) {
          if (isset($custom_icons[$filetype]) && $custom_icons[$filetype]) {
            $file_type_icon_url = $custom_icons[$filetype];
          } elseif (isset($filetypes[$filetype])) {
            $imagefile = $filetypes[$filetype] . '.png';
            $file_type_icon_url = plugins_url('../img/' . $imagefile, __FILE__);
          }
        }
      }

    }
        
    return $file_type_icon_url;
    
  }

  public static function sf_root() {
  
    $s = get_option('shared_files_settings');
  
    $sf_root = '';
  
    if (isset($s['wp_location']) && isset($s['wp_location'])) {
  
      $sf_root = rtrim($s['wp_location'], '/');
  
    } else {
  
      $url_parts = parse_url(get_admin_url());
      $path_parts = explode('/', $url_parts['path']);
      
      if (isset($path_parts[2]) && $path_parts[2] == 'wp-admin') {
        $sf_root = '/' . $path_parts[1];
      }
      
    }
    
    return $sf_root;
  }

  public static function initLayout($s) {

    $html = '';
    
    if (isset($s['card_small_font_size']) && $s['card_small_font_size']) {
      $html .= '<style>.shared-files-main-elements p { font-size: 15px; }</style>';
    }

    if (isset($s['card_font']) && $s['card_font']) {
  
      if ($s['card_font'] == 'roboto') {
        $html .= '<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">';
        $html .= '<style>.shared-files-main-elements * { font-family: "Roboto", sans-serif; }</style>';
      } elseif ($s['card_font'] == 'ubuntu') {
        $html .= '<link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">';
        $html .= '<style>.shared-files-main-elements * { font-family: "Ubuntu", sans-serif; }</style>';
      }
  
    }
  
    if (isset($s['card_background']) && $s['card_background']) {
  
      $html .= '<style>.shared-files-container #myList li { margin-bottom: 5px; } </style>';
  
      if ($s['card_background'] == 'white') {
        $html .= '<style>.shared-files-main-elements { background: #fff; padding: 20px 10px; border-radius: 10px; margin-bottom: 20px; } </style>';
      } elseif ($s['card_background'] == 'light_gray') {
        $html .= '<style>.shared-files-main-elements { background: #f7f7f7; padding: 20px 10px; border-radius: 10px; margin-bottom: 20px; } </style>';
      }
    }
  
    if (isset($s['card_height']) && $s['card_height']) {
        $html .= '<style>.shared-files-2-cards-on-the-same-row #myList li .shared-files-main-elements { height: ' . $s['card_height'] . 'px; } </style>';  
        $html .= '<style>.shared-files-3-cards-on-the-same-row #myList li .shared-files-main-elements { height: ' . $s['card_height'] . 'px; } </style>';  
        $html .= '<style>.shared-files-4-cards-on-the-same-row #myList li .shared-files-main-elements { height: ' . $s['card_height'] . 'px; } </style>';  
        $html .= '<style> @media (max-width: 500px) { .shared-files-2-cards-on-the-same-row #myList li .shared-files-main-elements { height: auto; } } </style>';  
        $html .= '<style> @media (max-width: 500px) { .shared-files-3-cards-on-the-same-row #myList li .shared-files-main-elements { height: auto; } } </style>';  
        $html .= '<style> @media (max-width: 500px) { .shared-files-4-cards-on-the-same-row #myList li .shared-files-main-elements { height: auto; } } </style>';  
    }
    
    return $html;
    
  }

}
