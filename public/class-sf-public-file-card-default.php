<?php

class SharedFilesPublicFileCardDefault {
    public static function fileListItem(
        $c,
        $imagefile,
        $hide_description,
        $show_tags = 0,
        $atts = [],
        $favorites = 0
    ) {
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
        $file_access_logged_in_only = 0;
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
            $left_style = 'background-image: url(' . esc_attr( $imagefile ) . ');';
        }
        $html .= '<li class="shared-files-card-' . $file_id . '">';
        $html .= '<div class="shared-files-main-elements">';
        $html .= '<div class="shared-files-main-elements-left" style="' . esc_attr( $left_style ) . '"></div>';
        if ( isset( $s['card_featured_image_align'] ) && $s['card_featured_image_align'] == 'left' && isset( $s['card_featured_image_as_extra'] ) && (!$password || isset( $s['show_featured_image_for_password_protected_files'] )) && (!$file_access_logged_in_only || isset( $s['file_access_logged_in_only_show_featured_image'] )) && !SharedFilesPublicHelpers::limitActive( $file_id ) && ($featured_img_url = esc_url_raw( get_the_post_thumbnail_url( $file_id, 'thumbnail' ) )) ) {
            $img_size = 'thumbnail';
            $html .= '<div class="shared-files-main-elements-featured-image">' . get_the_post_thumbnail( $file_id, $img_size ) . '</div>';
        }
        $html .= '<div class="shared-files-main-elements-right">';
        $data_file_type = '';
        $data_file_url = '';
        $data_video_url_redir = '';
        $data_external_url = '';
        $data_image_url = '';
        if ( !$password && !SharedFilesPublicHelpers::limitActive( $file_id ) && !$file_access_logged_in_only ) {
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
        $nofollow = '';
        if ( isset( $c['_sf_frontend_uploader'] ) && (isset( $s['prevent_search_engines_from_indexing_uploaded_file_urls'] ) || isset( $s['prevent_search_engines_from_indexing_file_urls'] )) ) {
            $nofollow = 'rel="ugc nofollow" ';
        }
        if ( $show_file_link ) {
            $html .= '<a class="shared-files-file-title" ' . $nofollow . $data_file_type . $data_file_url . $data_video_url_redir . $data_external_url . $data_image_url . 'href="' . esc_url( $file_url ) . '" target="_blank">' . sanitize_text_field( get_the_title() ) . '</a>';
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
        $html .= SharedFilesPublicHooks::get_action_content( 'shared_files_file_card_after_date' );
        if ( isset( $s['show_download_counter'] ) && $s['show_download_counter'] ) {
            $html .= SharedFilesHelpers::getDownloadCounter( $file_id );
        }
        $html .= SharedFilesPublicHooks::get_action_content( 'shared_files_file_card_after_download_counter' );
        $hide_tags = 0;
        if ( $show_tags && !$hide_tags ) {
            $tags = get_the_terms( $file_id, SHARED_FILES_TAG_SLUG );
            if ( $tags ) {
                $html .= '<div class="shared-files-tags-container">';
                foreach ( $tags as $tag ) {
                    $html .= '<span>' . sanitize_text_field( $tag->name ) . '</span>';
                }
                $html .= '</div>';
            }
        }
        if ( !isset( $s['hide_file_uploader_info'] ) && is_user_logged_in() && isset( $c['_sf_frontend_uploader'][0] ) && $c['_sf_frontend_uploader'][0] ) {
            $html .= '<div class="shared-files-file-uploaded-by">';
            if ( isset( $c['_sf_user_id'][0] ) && $c['_sf_user_id'][0] ) {
                $user = get_user_by( 'id', intval( $c['_sf_user_id'][0] ) );
                $user_fullname = '';
                if ( $user ) {
                    if ( isset( $user->user_login ) ) {
                        $user_fullname = $user->user_login;
                    }
                    if ( isset( $user->first_name ) || isset( $user->last_name ) ) {
                        if ( $user->first_name && $user->last_name ) {
                            $user_fullname = $user->first_name . ' ' . $user->last_name;
                        } elseif ( $user->last_name ) {
                            $user_fullname = $user->last_name;
                        } elseif ( $user->first_name ) {
                            $user_fullname = $user->first_name;
                        }
                    }
                } else {
                    $user_fullname = sanitize_text_field( __( '(user not found)', 'shared-files' ) );
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
        $custom_fields_free = 1;
        if ( $custom_fields_free && !isset( $atts['file_id'] ) ) {
            $n = 1;
            if ( isset( $s['file_upload_custom_field_' . $n] ) && ($cf_title = sanitize_text_field( $s['file_upload_custom_field_' . $n] )) ) {
                if ( isset( $c['_sf_file_upload_cf_' . $n] ) && $c['_sf_file_upload_cf_' . $n] ) {
                    $html .= '<div class="shared-files-custom-field"><span>' . $cf_title . '</span> ' . sanitize_text_field( $c['_sf_file_upload_cf_' . $n][0] ) . '</div>';
                }
            }
        }
        $html .= SharedFilesPublicHooks::get_action_content( 'shared_files_file_card_before_description' );
        $description_free = 1;
        if ( $description_free && !isset( $atts['file_id'] ) ) {
            $html .= SharedFilesPublicHelpers::getDescription( $c, $s );
        }
        $html .= SharedFilesPublicHooks::get_action_content( 'shared_files_file_card_after_description' );
        if ( !SharedFilesPublicHelpers::limitActive( $file_id ) ) {
            $wait_page_active = 0;
            if ( !$wait_page_active ) {
                $download_attr = 'download';
                if ( isset( $s['disable_download_attr'] ) ) {
                    $download_attr = '';
                }
                if ( isset( $s['show_download_button'] ) && ($password || $file_access_logged_in_only) ) {
                } elseif ( isset( $s['show_download_button'] ) && SharedFilesPublicHelpers::getFileType( $file_id ) != 'youtube' ) {
                    $html .= '<div class="shared-files-download-button-container"><a href="' . esc_url_raw( SharedFilesPublicHelpers::getFileURL( $file_id, 1 ) ) . '" class="shared-files-download-button" ' . $nofollow . ' ' . $download_attr . '>' . sanitize_text_field( __( 'Download', 'shared-files' ) ) . '</a></div>';
                }
            }
        }
        $html .= '<div class="shared-files-edit-actions">';
        if ( is_user_logged_in() && isset( $s['file_upload_show_delete_button'] ) && !isset( $atts['edit'] ) && !$favorites ) {
            $user = wp_get_current_user();
            $bare_url = './?_sf_delete_file=' . $file_id;
            if ( isset( $c['_sf_user_id'] ) && $c['_sf_user_id'][0] && $c['_sf_user_id'][0] == $user->ID ) {
                $html .= '<a href="' . wp_nonce_url( $bare_url, 'sf_delete_file_' . intval( $user->ID ), 'sc' ) . '" id="shared-files-public-delete-file" class="shared-files-public-delete-file" onclick="return confirm(\'' . esc_js( __( 'Are you sure?', 'shared-files' ) ) . '\')">' . sanitize_text_field( __( 'Delete', 'shared-files' ) ) . '</a>';
            }
        }
        $html .= '</div>';
        $html .= '</div>';
        if ( (!isset( $s['card_featured_image_align'] ) || $s['card_featured_image_align'] == '') && isset( $s['card_featured_image_as_extra'] ) && (!$password || isset( $s['show_featured_image_for_password_protected_files'] )) && (!$file_access_logged_in_only || isset( $s['file_access_logged_in_only_show_featured_image'] )) && !SharedFilesPublicHelpers::limitActive( $file_id ) && ($featured_img_url = esc_url_raw( get_the_post_thumbnail_url( $file_id, 'thumbnail' ) )) ) {
            $img_size = 'thumbnail';
            $html .= '<div class="shared-files-main-elements-featured-image">' . get_the_post_thumbnail( $file_id, $img_size ) . '</div>';
        }
        $html .= '</div>';
        $html .= '</li>';
        return $html;
    }

}
