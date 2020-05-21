<?php

class SharedFilesPublicViews
{
    public static function sfProFeaturePublicMarkup()
    {
        $html = '';
        $html .= '<div class="pro-feature">';
        $html .= '<span>' . __( 'This feature is available in the Pro version.', 'contact-list' ) . '</span>';
        $html .= '</div>';
        return $html;
    }
    
    public static function listCategories( $categories )
    {
        $html = '';
        $html .= '<div class="shared-files-categories-container">';
        $html .= '<div class="shared-files-categories">';
        $html .= '<ul class="shared-files-categories-list">';
        foreach ( $categories as $cat ) {
            $html .= '<li>';
            $html .= '<div>';
            $html .= '<a href="?cat=' . $cat->slug . '">' . $cat->name . '</a>';
            $html .= '</div>';
            $html .= '</li>';
        }
        $html .= '</ul>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }
    
    public static function fileListItem( $c, $imagefile, $hide_description )
    {
        $html = '';
        //    $html .= $imagefile;
        $html .= '<li>';
        $html .= '<div class="shared-files-main-elements">';
        $html .= '<div class="shared-files-main-elements-left" style="background: url(' . $imagefile . ') right top no-repeat; background-size: 48px;"></div>';
        $html .= '<div class="shared-files-main-elements-right">';
        $html .= '<a href="' . (( isset( $c['_sf_filename'] ) ? SharedFilesHelpers::sf_root() . '/shared-files/' . get_the_id() . '/' . $c['_sf_filename'][0] : '' )) . '" target="_blank">' . get_the_title() . '</a>';
        if ( isset( $c['_sf_filesize'] ) ) {
            $html .= '<span class="shared-file-size">' . human_filesize( $c['_sf_filesize'][0] ) . '</span>';
        }
        $html .= '<span class="shared-file-date">' . get_the_date() . '</span>';
        if ( isset( $c['_sf_description'] ) && !$hide_description ) {
            $html .= '<p class="shared-file-description">' . $c['_sf_description'][0] . '</p>';
        }
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</li>';
        return $html;
    }
    
    public static function passwordProtectedMarkup()
    {
        $html = '';
        $html .= '<html>';
        $html .= '<head>';
        $html .= '<meta charset="UTF-8">';
        $html .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html .= '<link rel="profile" href="https://gmpg.org/xfn/11">';
        $html .= '<title>' . __( 'Password protected file', 'shared-files' ) . '</title>';
        //	$html .= '<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>';
        $html .= '</head>';
        $html .= '<body>';
        $html .= '
  <style>
  
    body {
      background: #f7f7f7;
      font-family: "Quattrocento", serif;
    }
    
    h1 {
      margin-top: 5px;
      font-size: 24px;
      font-family: "Oswald", sans-serif;
      font-size: 24px;
      text-transform: uppercase;
    }
  
    .shared-files-password-protected-container {
      margin-top: 80px;
    }
  
    .shared-files-invalid-password {
      margin: 5px 0 20px 0;
      padding: 10px;
      color: crimson;
      border: 1px solid crimson;
      text-align: center;
      clear: both;
      font-family: "Oswald", sans-serif;
      text-transform: uppercase;
    }
    
    .shared-files-password-protected {
      max-width: 440px;
      margin: 0 auto;
      background: #fff;
      padding: 40px 30px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }
  
    .shared-files-password-protected .form-field .form-field-left {
      width: 40%;
      float: left;
      min-height: 40px;
    }
  
    .shared-files-password-protected .form-field .form-field-left label {
      padding-top: 3px;
      display: inline-block;
    }
    
    .shared-files-password-protected .form-field .form-field-right {
      width: 60%;
      float: left;
      min-height: 40px;
    }
  
    .shared-files-password-protected .form-field .form-field-right input {
      width: 100%;
      padding: 5px;
      border: none;
      background: #f7f7f7;
      border: 1px solid #ccc;
    }
    
    .shared-files-form-submit {
      color: #fff;
      text-transform: uppercase;
      text-decoration: none;
      background: #333;
      padding: 10px 40px;
      display: inline-block;
      transition: all 0.4s ease 0s;    
      cursor: pointer;
      font-size: 16px;
      margin-bottom: 20px;
      font-weight: bold;
      border: none;
      margin-top: 10px;
    }
  
    .shared-files-form-submit:hover {
      background: #000;
      transition: all 0.4s ease 0s;
    }
  
    @media (max-width: 500px) {
  
      .shared-files-password-protected .form-field .form-field-left {
        width: 100%;
        float: none;
        min-height: auto;
        margin-bottom: 5px;
      }
  
      .shared-files-password-protected .form-field .form-field-right {
        width: 100%;
        float: none;
        margin-bottom: 8px;
      }
  
    }  
  
  </style>
    ';
        $html .= '<link href="https://fonts.googleapis.com/css?family=Oswald|Quattrocento" rel="stylesheet">';
        $html .= '<form method="POST" action="">';
        $html .= '<div class="shared-files-password-protected-container">';
        $html .= '<div class="shared-files-password-protected">';
        $html .= '<h1>' . __( 'Please enter password', 'contact-list' ) . '</h1>';
        //    $html .= wp_nonce_field('_CL_UPDATE', '_wpnonce', true, false);
        $html .= '<div class="form-field">';
        $html .= '<div class="form-field-left"><label for="password">' . __( 'Password', 'shared-files' ) . '</label></div>';
        $html .= '<div class="form-field-right"><input type="password" name="password" id="password" value="" /></div>';
        $html .= '</div>';
        if ( $_POST ) {
            $html .= '<div class="shared-files-invalid-password">' . __( 'Invalid password', 'shared-files' ) . '</div>';
        }
        $html .= '<input type="submit" class="shared-files-form-submit" value="' . __( 'Submit', 'shared-files' ) . '" />';
        $html .= '</form>';
        $html .= '</body>';
        $html .= '</html>';
        return $html;
    }
    
    public static function downloadLimitMarkup()
    {
        $html = '';
        $html .= '<html>';
        $html .= '<head>';
        $html .= '<meta charset="UTF-8">';
        $html .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html .= '<link rel="profile" href="https://gmpg.org/xfn/11">';
        $html .= '<title>' . __( 'Download limit reached', 'shared-files' ) . '</title>';
        //	$html .= '<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>';
        $html .= '<link href="https://fonts.googleapis.com/css?family=Oswald|Quattrocento" rel="stylesheet">';
        $html .= '</head>';
        $html .= '<body>';
        $html .= '
  <style>
  
    body {
      background: #f7f7f7;
      font-family: "Quattrocento", serif;
    }
    
    h1 {
      margin-top: 5px;
      font-size: 24px;
      font-family: "Oswald", sans-serif;
      font-size: 24px;
      text-transform: uppercase;
    }
  
    .shared-files-password-protected-container {
      margin-top: 80px;
    }
  
    .shared-files-invalid-password {
      margin: 5px 0 20px 0;
      padding: 10px;
      color: crimson;
      border: 1px solid crimson;
      text-align: center;
      clear: both;
      font-family: "Oswald", sans-serif;
      text-transform: uppercase;
    }
    
    .shared-files-password-protected {
      max-width: 440px;
      margin: 0 auto;
      background: #fff;
      padding: 40px 30px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }
  
    .shared-files-password-protected .form-field .form-field-left {
      width: 40%;
      float: left;
      min-height: 40px;
    }
  
    .shared-files-password-protected .form-field .form-field-left label {
      padding-top: 3px;
      display: inline-block;
    }
    
    .shared-files-password-protected .form-field .form-field-right {
      width: 60%;
      float: left;
      min-height: 40px;
    }
  
    .shared-files-password-protected .form-field .form-field-right input {
      width: 100%;
      padding: 5px;
      border: none;
      background: #f7f7f7;
      border: 1px solid #ccc;
    }
    
    .shared-files-form-submit {
      color: #fff;
      text-transform: uppercase;
      text-decoration: none;
      background: #333;
      padding: 10px 40px;
      display: inline-block;
      transition: all 0.4s ease 0s;    
      cursor: pointer;
      font-size: 16px;
      margin-bottom: 20px;
      font-weight: bold;
      border: none;
      margin-top: 10px;
    }
  
    .shared-files-form-submit:hover {
      background: #000;
      transition: all 0.4s ease 0s;
    }
  
    @media (max-width: 500px) {
  
      .shared-files-password-protected .form-field .form-field-left {
        width: 100%;
        float: none;
        min-height: auto;
        margin-bottom: 5px;
      }
  
      .shared-files-password-protected .form-field .form-field-right {
        width: 100%;
        float: none;
        margin-bottom: 8px;
      }
  
    }  
  
  </style>
    ';
        $html .= '<div class="shared-files-password-protected-container">';
        $html .= '<div class="shared-files-password-protected">';
        $html .= '<h1>' . __( 'Download limit reached', 'contact-list' ) . '</h1>';
        //    $html .= wp_nonce_field('_CL_UPDATE', '_wpnonce', true, false);
        $html .= '<p>' . __( 'This file is no longer available for download.', 'shared-files' ) . '</p>';
        $html .= '</body>';
        $html .= '</html>';
        return $html;
    }

}