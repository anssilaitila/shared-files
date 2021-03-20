<?php

class SharedFilesFileUpload
{
    public static function fileUploadMarkup( $atts )
    {
        $html = '';
        $s = get_option( 'shared_files_settings' );
        if ( !function_exists( 'wp_terms_checklist' ) ) {
            include ABSPATH . 'wp-admin/includes/template.php';
        }
        $post_id = get_the_id();
        $post_title = get_the_title();
        
        if ( isset( $_GET ) && isset( $_GET['shared-files-upload'] ) ) {
            $html .= '<div class="shared-files-upload-complete">' . __( 'File successfully uploaded.', 'shared-files' ) . '</div>';
        } elseif ( isset( $_GET ) && isset( $_GET['_sf_delete_file'] ) && isset( $_GET['sc'] ) ) {
            $html .= '<div class="shared-files-file-deleted">' . __( 'File successfully deleted.', 'shared-files' ) . '</div>';
        }
        
        $html .= '<div class="sf-public-file-upload-container">';
        $html .= '<form method="post" enctype="multipart/form-data">';
        $html .= wp_nonce_field(
            'sf_insert_file',
            'secret_code',
            true,
            false
        );
        $html .= '<input name="shared-files-upload" value="1" type="hidden" />';
        $html .= '<input name="_sf_embed_post_id" value="' . esc_attr( $post_id ) . '" type="hidden" />';
        $html .= '<input name="_sf_embed_post_title" value="' . esc_attr( $post_title ) . '" type="hidden" />';
        $accept = '';
        $html .= '<input type="file" id="sf_file" accept="' . esc_attr( $accept ) . '" name="_sf_file" value="" size="25" /><hr class="clear" />';
        $html .= '<p style="margin-top: 5px; margin-bottom: 8px;">' . __( 'Maximum file size:', 'shared-files' ) . ' <strong>' . esc_html( SharedFilesHelpers::maxUploadSize() ) . '</strong></p>';
        
        if ( isset( $s['file_upload_show_external_url'] ) ) {
            $html .= '<div class="shared-files-file-upload-youtube-container">';
            $external_url_title = __( 'Or enter a YouTube URL:', 'shared-files' );
            if ( isset( $s['file_upload_external_url_title'] ) && $s['file_upload_external_url_title'] ) {
                $external_url_title = $s['file_upload_external_url_title'];
            }
            $html .= '<span>' . esc_html( $external_url_title ) . '</span>';
            $html .= '<input type="text" name="_sf_external_url" class="shared-files-external-url" value="" />';
            $html .= '</div>';
        }
        
        
        if ( isset( $atts['tag_checkboxes'] ) || isset( $s['show_tag_checkboxes_on_file_upload'] ) ) {
            $taglist_args = [
                'taxonomy' => 'post_tag',
                'echo'     => 0,
            ];
            $html .= '<span class="sf-taglist-title">' . __( 'Tags', 'shared-files' ) . '</span><ul class="sf-taglist">' . wp_terms_checklist( 0, $taglist_args ) . '</ul>';
        }
        
        $html .= '<span>' . __( 'Title', 'shared-files' ) . '</span>';
        $html .= '<input type="text" name="_sf_title" class="shared-files-title" value="" />';
        $html .= '<span>' . __( 'Description', 'shared-files' ) . '</span>';
        $html .= '<textarea name="_sf_description" class="shared-files-description"></textarea>';
        $html .= '<hr class="clear" /><input type="submit" value="Submit" class="sf-public-file-upload-submit" />';
        $html .= '</form>';
        $html .= '</div>';
        return $html;
    }
    
    public function file_upload( $request )
    {
        $s = get_option( 'shared_files_settings' );
        
        if ( isset( $_GET ) && isset( $_GET['_sf_delete_file'] ) ) {
            $user = wp_get_current_user();
            if ( !isset( $_GET['sc'] ) || !wp_verify_nonce( $_GET['sc'], 'sf_delete_file_' . $user->ID ) ) {
                wp_die( 'Error in processing form data.' );
            }
            $file_id = (int) $_GET['_sf_delete_file'];
            $file = get_post( $file_id );
            $post_type = get_post_type( $file_id );
            $c = get_post_custom( $file_id );
            if ( $file && $user->ID == $c['_sf_user_id'][0] && $post_type == 'shared_file' ) {
                wp_trash_post( $file_id );
            }
        }
        
        
        if ( isset( $_POST ) && isset( $_POST['shared-files-upload'] ) && (isset( $_FILES ) && isset( $_FILES['_sf_file']['name'] ) || isset( $_POST['_sf_external_url'] ) && $_POST['_sf_external_url']) ) {
            if ( !isset( $_POST['secret_code'] ) || !wp_verify_nonce( $_POST['secret_code'], 'sf_insert_file' ) ) {
                wp_die( 'Error in processing form data.' );
            }
            $new_post = array(
                'post_type'    => 'shared_file',
                'post_status'  => 'publish',
                'post_title'   => '',
                'post_content' => '',
            );
            $id = wp_insert_post( $new_post );
            update_post_meta( $id, '_sf_frontend_uploader', 1 );
            if ( !isset( $s['uncheck_hide_from_other_pages'] ) ) {
                update_post_meta( $id, '_sf_not_public', 1 );
            }
            update_post_meta( $id, '_sf_embed_post_id', intval( $_POST['_sf_embed_post_id'] ) );
            update_post_meta( $id, '_sf_embed_post_title', sanitize_text_field( $_POST['_sf_embed_post_title'] ) );
            
            if ( isset( $_POST['tax_input']['post_tag'] ) && ($tags = $_POST['tax_input']['post_tag']) ) {
                $tags_int = array_map( function ( $value ) {
                    return (int) $value;
                }, $tags );
                wp_set_post_terms( $id, $tags_int, 'post_tag' );
            }
            
            
            if ( is_user_logged_in() ) {
                $user = wp_get_current_user();
                update_post_meta( $id, '_sf_user_id', intval( $user->ID ) );
            }
            
            
            if ( isset( $_POST['_sf_description'] ) && $_POST['_sf_description'] ) {
                $description = wp_strip_all_tags( balanceTags( wp_kses_post( $_POST['_sf_description'] ), 1 ) );
                update_post_meta( $id, '_sf_description', $description );
            } else {
                update_post_meta( $id, '_sf_description', '' );
            }
            
            
            if ( isset( $_FILES['_sf_file']['tmp_name'] ) && $_FILES['_sf_file']['tmp_name'] ) {
                // Get the file type of the upload
                $arr_file_type = wp_check_filetype( basename( $_FILES['_sf_file']['name'] ) );
                $uploaded_type = $arr_file_type['type'];
                add_filter( 'upload_dir', [ $this, 'set_upload_dir' ] );
                // Use the WordPress API to upload the file
                $upload = wp_upload_bits( $_FILES['_sf_file']['name'], null, file_get_contents( $_FILES['_sf_file']['tmp_name'] ) );
                if ( isset( $upload['error'] ) && $upload['error'] ) {
                    wp_die( 'There was an error uploading your file. The error is: ' . $upload['error'] );
                }
                remove_filter( 'upload_dir', [ $this, 'set_upload_dir' ] );
                add_post_meta( $id, '_sf_file', $upload );
                update_post_meta( $id, '_sf_file', $upload );
                $filename = substr( strrchr( $upload['file'], "/" ), 1 );
                update_post_meta( $id, '_sf_filename', sanitize_text_field( $filename ) );
                update_post_meta( $id, '_sf_filesize', sanitize_text_field( $_FILES['_sf_file']['size'] ) );
                $featured_image_already_added = 0;
                if ( !$featured_image_already_added ) {
                    SharedFilesHelpers::addFeaturedImage(
                        $id,
                        $upload,
                        $uploaded_type,
                        $filename
                    );
                }
            } elseif ( isset( $_POST['_sf_external_url'] ) && $_POST['_sf_external_url'] ) {
                $external_url = esc_url_raw( $_POST['_sf_external_url'] );
                update_post_meta( $id, '_sf_external_url', $external_url );
                $filename = basename( $external_url );
                update_post_meta( $id, '_sf_filename', sanitize_text_field( $filename ) );
            } else {
                $error_msg = __( 'File was not successfully uploaded. Please note the maximum file size.', 'shared_files' );
                wp_die( $error_msg );
            }
            
            update_post_meta( $id, '_sf_load_cnt', 0 );
            update_post_meta( $id, '_sf_bandwidth_usage', 0 );
            update_post_meta( $id, '_sf_file_added', current_time( 'Y-m-d H:i:s' ) );
            update_post_meta( $id, '_sf_main_date', '' );
            $post_title = $filename;
            
            if ( isset( $_POST['_sf_title'] ) && $_POST['_sf_title'] ) {
                $post_title = $_POST['_sf_title'];
            } elseif ( isset( $_POST['_sf_external_url'] ) && $_POST['_sf_external_url'] ) {
                $post_title = __( 'External URL', 'shared-files' );
            }
            
            $my_post = array(
                'ID'         => $id,
                'post_title' => sanitize_text_field( $post_title ),
            );
            wp_update_post( $my_post );
            $goto_url = '/';
            if ( isset( $request['pagename'] ) && $request['pagename'] ) {
                $goto_url = '/' . $request['pagename'] . '/';
            }
            
            if ( isset( $s['file_upload_send_email'] ) && is_email( $s['file_upload_send_email'] ) ) {
                $container_url = get_site_url() . $goto_url;
                SharedFilesAdminSendMail::file_upload_send_email( $id, get_post( $id ), $container_url );
            }
            
            wp_redirect( $goto_url . '?shared-files-upload=1' );
            exit;
        }
        
        return $request;
    }
    
    /**
     * Set the custom upload directory.
     *
     * @since    1.0.0
     */
    public function set_upload_dir( $dir )
    {
        $s = get_option( 'shared_files_settings' );
        $folder_for_new_files = '';
        
        if ( isset( $s['folder_for_new_files'] ) && $s['folder_for_new_files'] ) {
            $folder_for_new_files = '/' . sanitize_file_name( $s['folder_for_new_files'] );
            $full_path_new = $dir['basedir'] . '/shared-files' . $folder_for_new_files;
            if ( !file_exists( $full_path_new ) ) {
                mkdir( $full_path_new );
            }
        }
        
        return array(
            'path'   => $dir['basedir'] . '/shared-files' . $folder_for_new_files,
            'url'    => $dir['baseurl'] . '/shared-files' . $folder_for_new_files,
            'subdir' => '/shared-files' . $folder_for_new_files,
        ) + $dir;
    }

}