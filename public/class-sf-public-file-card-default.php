<?php

class SharedFilesPublicFileCardDefault
{
    public static function fileListItem(
        $c,
        $imagefile,
        $hide_description,
        $show_tags = 0,
        $atts = array(),
        $favorites = 0
    )
    {
        $s = get_option( 'shared_files_settings' );
        $file_id = intval( get_the_id() );
        $file_url = SharedFilesPublicHelpers::getFileURL( $file_id );
        $file_url_for_preview = SharedFilesPublicHelpers::getFileURL( $file_id, 0, 1 );
        $date_format = get_option( 'date_format' );
        $file_metadata = get_post_meta( $file_id, '_sf_file', true );
        $file_realpath = '';
        if ( isset( $file_metadata['file'] ) && $file_metadata['file'] ) {
            $file_realpath = SharedFilesFileOpen::getUpdatedPathAndFilename( sanitize_text_field( $file_metadata['file'] ) );
        }
        
        if ( !isset( $s['bypass_file_exists_check'] ) && $file_realpath && !is_readable( $file_realpath ) ) {
            $html = '<li><div class="shared-files-permission-denied-for"><b>' . sanitize_text_field( __( "Can't read file (permission denied or file not found):", 'shared-files' ) ) . '</b><br />' . sanitize_text_field( $file_realpath ) . '</div></li>';
            return $html;
        }
        
        $password = '';
        $cat_password = '';
        $file_password = '';
        $external_url = ( isset( $c['_sf_external_url'] ) ? esc_url_raw( $c['_sf_external_url'][0] ) : '' );
        
        if ( isset( $s['card_align_elements_vertically'] ) ) {
            $html = SharedFilesPublicFileCardVertical::fileListItem(
                $c,
                $imagefile,
                $hide_description,
                $show_tags,
                $atts,
                $favorites
            );
            return $html;
        }
        
        $html = '';
        $left_style = '';
        
        if ( isset( $s['hide_file_type_icon_from_card'] ) ) {
            $left_style = 'width: 6px; background: none;';
        } else {
            $left_style = 'background: url(' . esc_attr( $imagefile ) . ') right top no-repeat; background-size: 48px;';
        }
        
        $html .= '<li>';
        $html .= '<div class="shared-files-main-elements">';
        $html .= '<div class="shared-files-main-elements-left" style="' . esc_attr( $left_style ) . '"></div>';
        
        if ( isset( $s['card_featured_image_align'] ) && $s['card_featured_image_align'] == 'left' && isset( $s['card_featured_image_as_extra'] ) && (!$password || isset( $s['show_featured_image_for_password_protected_files'] )) && !SharedFilesPublicHelpers::limitActive( $file_id ) && ($featured_img_url = esc_url_raw( get_the_post_thumbnail_url( $file_id, 'thumbnail' ) )) ) {
            $featured_img_width_px = 150;
            $featured_img_height_px = 0;
            $featured_img_style = 'width: ' . esc_attr( $featured_img_width_px ) . 'px; height: auto;';
            $html .= '<div class="shared-files-main-elements-featured-image" style="' . $featured_img_style . '"><img src="' . esc_url_raw( $featured_img_url ) . '" /></div>';
        }
        
        $html .= '<div class="shared-files-main-elements-right">';
        $data_file_type = '';
        $data_file_url = '';
        $data_video_url_redir = '';
        $data_external_url = '';
        $data_image_url = '';
        
        if ( !$password && !SharedFilesPublicHelpers::limitActive( $file_id ) ) {
            $this_file_type = SharedFilesPublicHelpers::getFileType( $file_id );
            $data_file_type = ' data-file-type="' . esc_attr( SharedFilesPublicHelpers::getFileType( $file_id ) ) . '" ';
            $data_file_url = ' data-file-url="' . esc_url_raw( SharedFilesPublicHelpers::getFileURL( $file_id ) ) . '" ';
            $data_external_url = ' data-external-url="' . esc_url_raw( $external_url ) . '" ';
            $data_image_url = ' data-image-url="' . esc_url_raw( get_the_post_thumbnail_url( $file_id, 'large' ) ) . '" ';
            if ( isset( $s['file_open_method'] ) && $s['file_open_method'] == 'redirect' ) {
                
                if ( substr( $this_file_type, 0, strlen( 'video' ) ) === 'video' ) {
                    $file_uri = SharedFilesFileOpen::getRedirectTarget( $file_id );
                    $data_video_url_redir = ' data-video-url-redir="' . esc_url_raw( $file_uri ) . '" ';
                }
            
            }
        }
        
        $show_file_link = 1;
        
        if ( $show_file_link ) {
            $html .= '<a class="shared-files-file-title" ' . $data_file_type . $data_file_url . $data_video_url_redir . $data_external_url . $data_image_url . 'href="' . esc_url( $file_url ) . '" target="_blank">' . sanitize_text_field( get_the_title() ) . '</a>';
            if ( isset( $c['_sf_filesize'] ) && !isset( $s['hide_file_size_from_card'] ) ) {
                $html .= '<span class="shared-file-size">' . sanitize_text_field( SharedFilesAdminHelpers::human_filesize( $c['_sf_filesize'][0] ) ) . '</span>';
            }
            $html .= SharedFilesHelpers::getPreviewButton( $file_id, $file_url_for_preview, $atts );
        }
        
        
        if ( !isset( $s['hide_date_from_card'] ) ) {
            $main_date = get_post_meta( $file_id, '_sf_main_date', true );
            $expiration_date_formatted = '';
            
            if ( $main_date instanceof DateTime ) {
                $main_date_formatted = $main_date->format( $date_format );
                $html .= '<span class="shared-file-date">' . sanitize_text_field( $main_date_formatted ) . '</span>';
            } else {
                $html .= '<span class="shared-file-date">' . sanitize_text_field( get_the_date() ) . '</span>';
            }
        
        }
        
        if ( isset( $s['show_download_counter'] ) && $s['show_download_counter'] ) {
            $html .= SharedFilesHelpers::getDownloadCounter( $file_id );
        }
        $hide_tags = 0;
        
        if ( $show_tags && !$hide_tags ) {
            $tags = get_the_tags();
            
            if ( $tags ) {
                $html .= '<div class="shared-files-tags-container">';
                foreach ( $tags as $tag ) {
                    
                    if ( $show_tags == 1 ) {
                        $html .= '<a href="?sf_tag=' . esc_attr( $tag->slug ) . '" data-tag-slug="' . esc_attr( $tag->slug ) . '" data-hide-description="' . esc_attr( $hide_description ) . '" class="shared-files-tag-link">' . sanitize_text_field( $tag->name ) . '</a>';
                    } elseif ( $show_tags == 2 ) {
                        $html .= '<span>' . sanitize_text_field( $tag->name ) . '</span>';
                    }
                
                }
                $html .= '</div>';
            }
        
        }
        
        
        if ( !isset( $s['hide_file_uploader_info'] ) && is_user_logged_in() && isset( $c['_sf_frontend_uploader'][0] ) && $c['_sf_frontend_uploader'][0] ) {
            $html .= '<div class="shared-files-file-uploaded-by">';
            
            if ( isset( $c['_sf_user_id'][0] ) && $c['_sf_user_id'][0] ) {
                $user = get_user_by( 'id', intval( $c['_sf_user_id'][0] ) );
                $user_fullname = $user->user_login;
                
                if ( $user->first_name && $user->last_name ) {
                    $user_fullname = $user->first_name . ' ' . $user->last_name;
                } elseif ( $user->last_name ) {
                    $user_fullname = $user->last_name;
                } elseif ( $user->first_name ) {
                    $user_fullname = $user->first_name;
                }
                
                
                if ( is_super_admin() ) {
                    $html .= sanitize_text_field( __( 'Uploaded by', 'shared-files' ) ) . ' <a href="' . esc_url_raw( get_admin_url( null, 'user-edit.php?user_id=' . intval( $c['_sf_user_id'][0] ) ) ) . '" target="_blank">' . sanitize_text_field( $user_fullname ) . '</a>';
                } else {
                    $html .= sanitize_text_field( __( 'Uploaded by', 'shared-files' ) ) . ' ' . sanitize_text_field( $user_fullname );
                }
            
            } else {
                $html .= sanitize_text_field( __( 'Uploaded by a visitor', 'shared-files' ) );
            }
            
            $html .= '</div>';
        }
        
        if ( isset( $c['_sf_description'] ) && !$hide_description ) {
            
            if ( isset( $s['textarea_for_file_description'] ) && $s['textarea_for_file_description'] ) {
                $html .= '<div class="shared-file-description-container">' . wp_kses_post( nl2br( $c['_sf_description'][0] ) ) . '</div>';
            } else {
                $html .= '<div class="shared-file-description-container">' . wp_kses_post( $c['_sf_description'][0] ) . '</div>';
            }
        
        }
        
        if ( !SharedFilesPublicHelpers::limitActive( $file_id ) ) {
            $wait_page_active = 0;
            if ( !$wait_page_active ) {
                
                if ( isset( $s['show_download_button'] ) && $password ) {
                } elseif ( SharedFilesPublicHelpers::getFileType( $file_id ) == 'image' ) {
                    $html .= '<a href="' . esc_url_raw( SharedFilesPublicHelpers::getFileURL( $file_id, 1 ) ) . '" class="shared-files-download-button shared-files-download-button-image" download>' . sanitize_text_field( __( 'Download', 'shared-files' ) ) . '</a>';
                } elseif ( isset( $s['show_download_button'] ) && SharedFilesPublicHelpers::getFileType( $file_id ) != 'youtube' ) {
                    $html .= '<a href="' . esc_url_raw( SharedFilesPublicHelpers::getFileURL( $file_id, 1 ) ) . '" class="shared-files-download-button" download>' . sanitize_text_field( __( 'Download', 'shared-files' ) ) . '</a>';
                }
            
            }
        }
        
        $html .= '<div class="shared-files-edit-actions">';
        
        if ( is_user_logged_in() && !isset( $atts['edit'] ) && !$favorites ) {
            $user = wp_get_current_user();
            $bare_url = './?_sf_delete_file=' . $file_id;
            if ( isset( $c['_sf_user_id'] ) && $c['_sf_user_id'][0] == $user->ID ) {
                $html .= '<a href="' . wp_nonce_url( $bare_url, 'sf_delete_file_' . intval( $user->ID ), 'sc' ) . '" id="shared-files-public-delete-file" class="shared-files-public-delete-file" onclick="return confirm(\'' . esc_js( __( 'Are you sure?', 'shared-files' ) ) . '\')">' . sanitize_text_field( __( 'Delete', 'shared-files' ) ) . '</a>';
            }
        }
        
        $html .= '</div>';
        $html .= '</div>';
        
        if ( (!isset( $s['card_featured_image_align'] ) || $s['card_featured_image_align'] == '') && isset( $s['card_featured_image_as_extra'] ) && (!$password || isset( $s['show_featured_image_for_password_protected_files'] )) && !SharedFilesPublicHelpers::limitActive( $file_id ) && ($featured_img_url = get_the_post_thumbnail_url( $file_id, 'thumbnail' )) ) {
            $featured_img_width_px = 150;
            $featured_img_height_px = 0;
            $featured_img_style = 'width: ' . esc_attr( $featured_img_width_px ) . 'px; height: auto;';
            $html .= '<div class="shared-files-main-elements-featured-image" style="' . $featured_img_style . '"><img src="' . esc_url( $featured_img_url ) . '" alt="" /></div>';
        }
        
        $html .= '</div>';
        $html .= '</li>';
        return $html;
    }

}