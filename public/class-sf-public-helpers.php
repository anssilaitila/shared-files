<?php

class SharedFilesPublicHelpers
{
    public static function proFeaturePublicMarkup()
    {
        $html = '';
        $html .= '<div class="shared-files-public-pro-feature">';
        $html .= '<span class="shared-files-public-pro-feature-title">';
        $html .= __( 'This feature is available in the Pro version.', 'shared-files' );
        $html .= '</span>';
        $html .= '<span>';
        $html .= __( 'You can use the shortcodes', 'shared-files' ) . ' [shared_files] ' . __( 'and', 'shared-files' ) . ' [shared_files_simple].';
        $html .= '</span>';
        $html .= '<span>';
        $html .= __( 'More info on shortcodes at', 'shared-files' ) . ' <a href="https://www.sharedfilespro.com/support/shortcodes/" target="_blank">sharedfilespro.com</a>.';
        $html .= '</span>';
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
    
    public static function fileListItemV2(
        $c,
        $imagefile,
        $hide_description,
        $show_tags = 0
    )
    {
        $html = '';
        $s = get_option( 'shared_files_settings' );
        $file_id = get_the_id();
        $date_format = get_option( 'date_format' );
        $password = get_post_meta( $file_id, '_sf_password', true );
        $external_url = ( isset( $c['_sf_external_url'] ) ? $c['_sf_external_url'][0] : '' );
        $left_style = '';
        
        if ( isset( $s['hide_file_type_icon_from_card'] ) ) {
            $left_style = 'width: 6px; background: none;';
        } else {
            $left_style = 'background: url(' . $imagefile . ') right top no-repeat; background-size: 48px;';
        }
        
        $html .= '<li>';
        $html .= '<div class="shared-files-main-elements shared-files-main-elements-v2">';
        $html .= '<div class="shared-files-main-elements-top"><img src="' . $imagefile . '" /></div>';
        if ( isset( $s['card_featured_image_align'] ) && $s['card_featured_image_align'] == 'left' && isset( $s['card_featured_image_as_extra'] ) && !$password && !SharedFilesPublicHelpers::limitActive( $file_id ) && ($featured_img_url = get_the_post_thumbnail_url( $file_id, 'thumbnail' )) ) {
            $html .= '<div class="shared-files-main-elements-featured-image"><img src="' . $featured_img_url . '" /></div>';
        }
        $file_url = ( isset( $c['_sf_filename'] ) ? SharedFilesHelpers::sf_root() . '/shared-files/' . get_the_id() . '/' . SharedFilesHelpers::wp_engine() . $c['_sf_filename'][0] : '' );
        $data_file_type = '';
        $data_file_url = '';
        $data_external_url = '';
        $data_image_url = '';
        
        if ( !$password && !SharedFilesPublicHelpers::limitActive( $file_id ) ) {
            $data_file_type = ' data-file-type="' . self::getFileType( $file_id ) . '" ';
            $data_file_url = ' data-file-url="' . self::getFileURL( $file_id ) . '" ';
            $data_external_url = ' data-external-url="' . $external_url . '" ';
            $data_image_url = ' data-image-url="' . get_the_post_thumbnail_url( $file_id, 'large' ) . '" ';
        }
        
        $html .= '<div class="shared-files-main-elements-bottom">';
        $html .= '<a class="shared-files-file-title"' . $data_file_type . $data_image_url . $data_external_url . $data_image_url . 'href="' . $file_url . '" target="_blank">' . get_the_title() . '</a>';
        if ( isset( $c['_sf_filesize'] ) && !isset( $s['hide_file_size_from_card'] ) ) {
            $html .= '<span class="shared-file-size">' . SharedFilesAdminHelpers::human_filesize( $c['_sf_filesize'][0] ) . '</span>';
        }
        $html .= SharedFilesHelpers::getPreviewButton( $file_id, $file_url );
        
        if ( !isset( $s['hide_date_from_card'] ) ) {
            $main_date = get_post_meta( $file_id, '_sf_main_date', true );
            $expiration_date_formatted = '';
            
            if ( $main_date instanceof DateTime ) {
                $main_date_formatted = $main_date->format( $date_format );
                $html .= '<span class="shared-file-date">' . $main_date_formatted . '</span>';
            } else {
                $html .= '<span class="shared-file-date">' . get_the_date() . '</span>';
            }
        
        }
        
        
        if ( $show_tags ) {
            $tags = get_the_tags();
            
            if ( $tags ) {
                $html .= '<div class="shared-files-tags-container">';
                foreach ( $tags as $tag ) {
                    
                    if ( $show_tags == 1 ) {
                        $html .= '<a href="?sf_tag=' . $tag->slug . '" data-tag-slug="' . $tag->slug . '" data-hide-description="' . $hide_description . '" class="shared-files-tag-link">' . $tag->name . '</a>';
                    } elseif ( $show_tags == 2 ) {
                        $html .= '<span>' . $tag->name . '</span>';
                    }
                
                }
                $html .= '</div>';
            }
        
        }
        
        if ( isset( $c['_sf_description'] ) && !$hide_description ) {
            
            if ( isset( $s['textarea_for_file_description'] ) && $s['textarea_for_file_description'] ) {
                $html .= '<p class="shared-file-description">' . nl2br( $c['_sf_description'][0] ) . '</p>';
            } else {
                $html .= '<p class="shared-file-description">' . $c['_sf_description'][0] . '</p>';
            }
        
        }
        if ( !$password && !SharedFilesPublicHelpers::limitActive( $file_id ) ) {
            
            if ( self::getFileType( $file_id ) == 'image' ) {
                $html .= '<a href="' . self::getFileURL( $file_id, 1 ) . '" id="shared-files-download-button" class="shared-files-download-button shared-files-download-button-image">' . __( 'Download original', 'shared-files' ) . '</a>';
            } elseif ( isset( $s['show_download_button'] ) && self::getFileType( $file_id ) != 'youtube' ) {
                $html .= '<a href="' . self::getFileURL( $file_id, 1 ) . '" id="shared-files-download-button" class="shared-files-download-button">' . __( 'Download', 'shared-files' ) . '</a>';
            }
        
        }
        
        if ( is_user_logged_in() ) {
            $user = wp_get_current_user();
            $bare_url = './?_sf_delete_file=' . $file_id;
            if ( isset( $c['_sf_user_id'] ) && $c['_sf_user_id'][0] == $user->ID ) {
                $html .= '<a href="' . wp_nonce_url( $bare_url, 'sf_delete_file_' . $user->ID, 'sc' ) . '" id="shared-files-public-delete-file" class="shared-files-public-delete-file" onclick="return confirm(\'' . __( 'Are you sure?', 'shared-files' ) . '\')">' . __( 'Delete', 'shared-files' ) . '</a>';
            }
        }
        
        $html .= '</div>';
        if ( (!isset( $s['card_featured_image_align'] ) || $s['card_featured_image_align'] == '') && isset( $s['card_featured_image_as_extra'] ) && !$password && !SharedFilesPublicHelpers::limitActive( $file_id ) && ($featured_img_url = get_the_post_thumbnail_url( $file_id, 'thumbnail' )) ) {
            $html .= '<div class="shared-files-main-elements-featured-image"><img src="' . $featured_img_url . '" /></div>';
        }
        $html .= '</div>';
        $html .= '</li>';
        return $html;
    }
    
    public static function getFileURL( $file_id = 0, $download = 0 )
    {
        $c = get_post_custom( $file_id );
        $file_url = '';
        
        if ( isset( $c['_sf_filename'] ) ) {
            $file_url = SharedFilesHelpers::sf_root() . '/shared-files/' . $file_id . '/' . SharedFilesHelpers::wp_engine() . $c['_sf_filename'][0];
            
            if ( $download && SharedFilesHelpers::wp_engine() ) {
                $file_url .= '&download=1';
            } elseif ( $download ) {
                $file_url .= '?download=1';
            }
        
        }
        
        return $file_url;
    }
    
    public static function getFileType( $file_id = 0 )
    {
        $c = get_post_custom( $file_id );
        $file = get_post_meta( $file_id, '_sf_file', true );
        $file_type = '';
        $file_ext = '';
        $external_url = ( isset( $c['_sf_external_url'] ) ? $c['_sf_external_url'][0] : '' );
        
        if ( $external_url && (substr( $external_url, 0, strlen( 'https://www.youtube.com' ) ) === 'https://www.youtube.com' || substr( $external_url, 0, strlen( 'https://youtu.be' ) ) === 'https://youtu.be') ) {
            $file_type = 'youtube';
        } elseif ( isset( $file['file'] ) ) {
            $file_ext = pathinfo( $file['file'], PATHINFO_EXTENSION );
            switch ( $file_ext ) {
                case 'jpg':
                case 'jpeg':
                case 'jpe':
                case 'png':
                case 'gif':
                    $file_type = 'image';
                    break;
                case 'mp4':
                case 'webm':
                case 'ogg':
                case 'mov':
                    $file_type = 'video/' . $file_ext;
                    break;
            }
        }
        
        return $file_type;
    }
    
    public static function limitActive( $file_id )
    {
        $load_cnt = (int) get_post_meta( $file_id, '_sf_load_cnt', true );
        $load_limit = (int) get_post_meta( $file_id, '_sf_limit_downloads', true );
        $limit_active = 0;
        if ( $load_limit && $load_cnt >= $load_limit ) {
            $limit_active = 1;
        }
        return $limit_active;
    }
    
    public static function fileListItem(
        $c,
        $imagefile,
        $hide_description,
        $show_tags = 0
    )
    {
        $s = get_option( 'shared_files_settings' );
        $file_id = get_the_id();
        $file_url = self::getFileURL( $file_id );
        $date_format = get_option( 'date_format' );
        $password = get_post_meta( $file_id, '_sf_password', true );
        $external_url = ( isset( $c['_sf_external_url'] ) ? $c['_sf_external_url'][0] : '' );
        
        if ( isset( $s['card_align_elements_vertically'] ) ) {
            $html = SharedFilesPublicHelpers::fileListItemV2(
                $c,
                $imagefile,
                $hide_description,
                $show_tags
            );
            return $html;
        }
        
        $html = '';
        $left_style = '';
        
        if ( isset( $s['hide_file_type_icon_from_card'] ) ) {
            $left_style = 'width: 6px; background: none;';
        } else {
            $left_style = 'background: url(' . $imagefile . ') right top no-repeat; background-size: 48px;';
        }
        
        $html .= '<li>';
        $html .= '<div class="shared-files-main-elements">';
        $html .= '<div class="shared-files-main-elements-left" style="' . $left_style . '"></div>';
        if ( isset( $s['card_featured_image_align'] ) && $s['card_featured_image_align'] == 'left' && isset( $s['card_featured_image_as_extra'] ) && !$password && !SharedFilesPublicHelpers::limitActive( $file_id ) && ($featured_img_url = get_the_post_thumbnail_url( $file_id, 'thumbnail' )) ) {
            $html .= '<div class="shared-files-main-elements-featured-image"><img src="' . $featured_img_url . '" /></div>';
        }
        $html .= '<div class="shared-files-main-elements-right">';
        $data_file_type = '';
        $data_file_url = '';
        $data_external_url = '';
        $data_image_url = '';
        
        if ( !$password && !SharedFilesPublicHelpers::limitActive( $file_id ) ) {
            $data_file_type = ' data-file-type="' . self::getFileType( $file_id ) . '" ';
            $data_file_url = ' data-file-url="' . self::getFileURL( $file_id ) . '" ';
            $data_external_url = ' data-external-url="' . $external_url . '" ';
            $data_image_url = ' data-image-url="' . get_the_post_thumbnail_url( $file_id, 'large' ) . '" ';
        }
        
        $html .= '<a class="shared-files-file-title"' . $data_file_type . $data_file_url . $data_external_url . $data_image_url . 'href="' . $file_url . '" target="_blank">' . get_the_title() . '</a>';
        if ( isset( $c['_sf_filesize'] ) && !isset( $s['hide_file_size_from_card'] ) ) {
            $html .= '<span class="shared-file-size">' . SharedFilesAdminHelpers::human_filesize( $c['_sf_filesize'][0] ) . '</span>';
        }
        $html .= SharedFilesHelpers::getPreviewButton( $file_id, $file_url );
        
        if ( !isset( $s['hide_date_from_card'] ) ) {
            $main_date = get_post_meta( $file_id, '_sf_main_date', true );
            $expiration_date_formatted = '';
            
            if ( $main_date instanceof DateTime ) {
                $main_date_formatted = $main_date->format( $date_format );
                $html .= '<span class="shared-file-date">' . $main_date_formatted . '</span>';
            } else {
                $html .= '<span class="shared-file-date">' . get_the_date() . '</span>';
            }
        
        }
        
        
        if ( $show_tags ) {
            $tags = get_the_tags();
            
            if ( $tags ) {
                $html .= '<div class="shared-files-tags-container">';
                foreach ( $tags as $tag ) {
                    
                    if ( $show_tags == 1 ) {
                        $html .= '<a href="?sf_tag=' . $tag->slug . '" data-tag-slug="' . $tag->slug . '" data-hide-description="' . $hide_description . '" class="shared-files-tag-link">' . $tag->name . '</a>';
                    } elseif ( $show_tags == 2 ) {
                        $html .= '<span>' . $tag->name . '</span>';
                    }
                
                }
                $html .= '</div>';
            }
        
        }
        
        if ( isset( $c['_sf_description'] ) && !$hide_description ) {
            
            if ( isset( $s['textarea_for_file_description'] ) && $s['textarea_for_file_description'] ) {
                $html .= '<p class="shared-file-description">' . nl2br( $c['_sf_description'][0] ) . '</p>';
            } else {
                $html .= '<p class="shared-file-description">' . $c['_sf_description'][0] . '</p>';
            }
        
        }
        if ( !$password && !SharedFilesPublicHelpers::limitActive( $file_id ) ) {
            
            if ( self::getFileType( $file_id ) == 'image' ) {
                $html .= '<a href="' . self::getFileURL( $file_id, 1 ) . '" id="shared-files-download-button" class="shared-files-download-button shared-files-download-button-image">' . __( 'Download original', 'shared-files' ) . '</a>';
            } elseif ( isset( $s['show_download_button'] ) && self::getFileType( $file_id ) != 'youtube' ) {
                $html .= '<a href="' . self::getFileURL( $file_id, 1 ) . '" id="shared-files-download-button" class="shared-files-download-button">' . __( 'Download', 'shared-files' ) . '</a>';
            }
        
        }
        
        if ( is_user_logged_in() ) {
            $user = wp_get_current_user();
            $bare_url = './?_sf_delete_file=' . $file_id;
            if ( isset( $c['_sf_user_id'] ) && $c['_sf_user_id'][0] == $user->ID ) {
                $html .= '<a href="' . wp_nonce_url( $bare_url, 'sf_delete_file_' . $user->ID, 'sc' ) . '" id="shared-files-public-delete-file" class="shared-files-public-delete-file" onclick="return confirm(\'' . __( 'Are you sure?', 'shared-files' ) . '\')">' . __( 'Delete', 'shared-files' ) . '</a>';
            }
        }
        
        $html .= '</div>';
        if ( (!isset( $s['card_featured_image_align'] ) || $s['card_featured_image_align'] == '') && isset( $s['card_featured_image_as_extra'] ) && !$password && !SharedFilesPublicHelpers::limitActive( $file_id ) && ($featured_img_url = get_the_post_thumbnail_url( $file_id, 'thumbnail' )) ) {
            $html .= '<div class="shared-files-main-elements-featured-image"><img src="' . $featured_img_url . '" /></div>';
        }
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
        $html .= '<h1>' . __( 'Please enter password', 'shared-files' ) . '</h1>';
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
      color: #000;
    }

    .shared-files-password-protected a {
      color: #000;
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
        $s = get_option( 'shared_files_settings' );
        $html .= '<div class="shared-files-password-protected-container">';
        $html .= '<div class="shared-files-password-protected">';
        $html .= '<h1>' . __( 'Download limit reached', 'shared-files' ) . '</h1>';
        
        if ( isset( $s['download_limit_msg'] ) && $s['download_limit_msg'] ) {
            $str = $s['download_limit_msg'];
            $str = preg_replace( '@(https?://([-\\w\\.]+[-\\w])+(:\\d+)?(/([\\w/_\\.#-~]*(\\?\\S+)?)?)?)@', '<a href="$1">$1</a>', $str );
            $html .= '<p>' . nl2br( $str ) . '</p>';
        } else {
            $html .= '<p>' . __( 'This file is no longer available for download.', 'shared-files' ) . '</p>';
        }
        
        $html .= '</body>';
        $html .= '</html>';
        return $html;
    }
    
    public static function sharedFilesSimpleMarkup( $wp_query, $include_children = 0 )
    {
        $html = '';
        $html .= '<div class="shared-files-search">';
        $html .= '<div class="shared-files-simple-list">';
        if ( $wp_query->have_posts() ) {
            while ( $wp_query->have_posts() ) {
                $wp_query->the_post();
                $id = get_the_id();
                $html .= SharedFilesPublicHelpers::singleFileSimpleMarkup( $id );
            }
        }
        $html .= '</div><hr class="clear" />';
        $html .= '</div>';
        wp_reset_postdata();
        return $html;
    }
    
    public static function singleFileSimpleMarkup( $id, $showGroups = 0 )
    {
        $s = get_option( 'shared_files_settings' );
        $c = get_post_custom( $id );
        $file_id = get_the_id();
        $password = get_post_meta( $file_id, '_sf_password', true );
        $external_url = ( isset( $c['_sf_external_url'] ) ? $c['_sf_external_url'][0] : '' );
        $html = '';
        $html .= '<div class="shared-files-simple-list-row">';
        $html .= '<div class="shared-files-simple-list-col shared-files-simple-list-col-name"><span>';
        $file_url = ( isset( $c['_sf_filename'] ) ? SharedFilesHelpers::sf_root() . '/shared-files/' . get_the_id() . '/' . SharedFilesHelpers::wp_engine() . $c['_sf_filename'][0] : '' );
        $data_file_type = '';
        $data_file_url = '';
        $data_external_url = '';
        $data_image_url = '';
        
        if ( !$password && !SharedFilesPublicHelpers::limitActive( $file_id ) ) {
            $data_file_type = ' data-file-type="' . self::getFileType( $file_id ) . '" ';
            $data_file_url = ' data-file-url="' . self::getFileURL( $file_id ) . '" ';
            $data_external_url = ' data-external-url="' . $external_url . '" ';
            $data_image_url = ' data-image-url="' . get_the_post_thumbnail_url( $file_id, 'large' ) . '" ';
        }
        
        $html .= '<a class="shared-files-file-title"' . $data_file_type . $data_file_url . $data_external_url . $data_image_url . 'href="' . $file_url . '" target="_blank">' . get_the_title() . '</a>';
        if ( isset( $c['_sf_filesize'] ) && !isset( $s['hide_file_size_from_card'] ) ) {
            $html .= '<span class="shared-file-size">' . SharedFilesAdminHelpers::human_filesize( $c['_sf_filesize'][0] ) . '</span>';
        }
        $html .= SharedFilesHelpers::getPreviewButton( $id, $file_url );
        if ( isset( $c['_sf_description'] ) ) {
            
            if ( isset( $s['textarea_for_file_description'] ) && $s['textarea_for_file_description'] && isset( $c['_sf_description'][0] ) && $c['_sf_description'][0] ) {
                $html .= '<p>' . nl2br( $c['_sf_description'][0] ) . '</p>';
            } else {
                $html .= $c['_sf_description'][0];
            }
        
        }
        $html .= '</span></div>';
        $html .= '</div>';
        return $html;
    }

}