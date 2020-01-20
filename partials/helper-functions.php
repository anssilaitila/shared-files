<?php

function sfProFeatureMarkup() {

    $html = '';
  
    $html .= '<div class="pro-feature">';
    $html .= '<span>' . __('This feature is available in the Pro version.', 'contact-list') . '</span>';
    $html .= '<a href="' . get_admin_url() . 'options-general.php?page=shared-files-pricing">' . __('Upgrade here', 'contact-list') . '</a>';
    $html .= '</div>';
    
    return $html;
  
}

function sfProFeaturePublicMarkup() {

    $html = '';
  
    $html .= '<div class="pro-feature">';
    $html .= '<span>' . __('This feature is available in the Pro version.', 'contact-list') . '</span>';
    $html .= '</div>';
    
    return $html;
  
}

function sfProMoreFeaturesMarkup() {

    $html = '';
  
    $html .= '<div class="pro-feature">';
    $html .= '<span>' . __('More features available in the Pro version.', 'contact-list') . '</span>';
    $html .= '<a href="' . get_admin_url() . 'options-general.php?page=shared-files-pricing">' . __('Upgrade here', 'contact-list') . '</a>';
    $html .= '</div>';
    
    return $html;
  
}

function sfProFeatureSettingsMarkup() {

    $html = '';
  
    $html .= '<div class="pro-feature">';
    $html .= '<span>' . __('More settings available in the Pro version.', 'contact-list') . '</span>';
    $html .= '<a href="' . get_admin_url() . 'options-general.php?page=shared-files-pricing">' . __('Upgrade here', 'contact-list') . '</a>';
    $html .= '</div>';
    
    return $html;
  
}

function getFiletypes() {

  $filetypes = array(
    'image/png' => 'image',
    'image/jpg' => 'image',
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

function getExternalFiletypes() {

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
