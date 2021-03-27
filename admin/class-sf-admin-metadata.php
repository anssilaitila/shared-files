<?php

class SharedFilesAdminMetadata
{
    /**
     * Custom meta box for file edit view.
     *
     * @since    1.0.0
     */
    public function adding_custom_meta_boxes( $post )
    {
        add_meta_box(
            'my-meta-box',
            __( 'File info' ),
            array( $this, 'custom_metadata' ),
            'shared_file',
            'normal',
            'default'
        );
    }
    
    public function custom_metadata()
    {
        echo  SharedFilesAdminHelpSupport::permalinks_alert() ;
        $s = get_option( 'shared_files_settings' );
        wp_nonce_field( 'shared-files-nonce-' . get_current_user_id(), '_sf_file_nonce' );
        $post_id = get_the_ID();
        $c = get_post_custom( $post_id );
        $file = get_post_meta( $post_id, '_sf_file', true );
        $filename = get_post_meta( $post_id, '_sf_filename', true );
        $description = get_post_meta( $post_id, '_sf_description', true );
        $external_url = get_post_meta( $post_id, '_sf_external_url', true );
        $limit_downloads = get_post_meta( $post_id, '_sf_limit_downloads', true );
        $expiration_date = get_post_meta( $post_id, '_sf_expiration_date', true );
        $expiration_date_formatted = '';
        $main_date = get_post_meta( $post_id, '_sf_main_date', true );
        $main_date_formatted = '';
        $notify_email = get_post_meta( $post_id, '_sf_notify_email', true );
        $embed_post_id = get_post_meta( $post_id, '_sf_embed_post_id', true );
        $embed_post_title = get_post_meta( $post_id, '_sf_embed_post_title', true );
        $not_public = get_post_meta( $post_id, '_sf_not_public', true );
        $media_library_post_id = get_post_meta( $post_id, '_sf_media_library_post_id', true );
        if ( $expiration_date instanceof DateTime ) {
            $expiration_date_formatted = $expiration_date->format( 'Y-m-d' );
        }
        if ( $main_date instanceof DateTime ) {
            $main_date_formatted = $main_date->format( 'Y-m-d' );
        }
        $password = get_post_meta( get_the_ID(), '_sf_password', true );
        $html = '';
        
        if ( $media_library_post_id ) {
            $permalink = get_permalink( $media_library_post_id );
            $html .= '<div style="padding: 18px; margin: 10px 0 10px 0; background: rgb(252, 252, 252); border: 1px solid rgb(240, 240, 240);">';
            $html .= '<span style="font-size: 14px;">';
            $media_library_href = admin_url() . 'upload.php?item=' . $media_library_post_id;
            $file_with_url = wp_get_attachment_url( $media_library_post_id );
            $url_local = explode( site_url(), $file_with_url )[1];
            //output local path
            $html .= esc_html__( 'This file is activated from the media library', 'shared-files' ) . ':<br /><a href="' . $media_library_href . '" style="font-weight: bold; color: #333; text-decoration: none;" target="_blank">' . $url_local . '</a>';
            $html .= '</span>';
            $html .= '</div>';
        } elseif ( $embed_post_id ) {
            $permalink = get_permalink( $embed_post_id );
            $html .= '<div style="padding: 18px; margin: 10px 0; background: rgb(252, 252, 252); border: 1px solid rgb(240, 240, 240);">';
            $html .= '<span style="font-size: 14px;">';
            $uploader_html = esc_html__( 'by a visitor', 'shared-files' );
            
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
                    $uploader_html = esc_html__( 'by', 'shared-files' ) . ' ' . '<a href="' . get_admin_url( null, 'user-edit.php?user_id=' . $c['_sf_user_id'][0] ) . '" target="_blank">' . $user_fullname . '</a>';
                } else {
                    $uploader_html = esc_html__( 'by', 'shared-files' ) . ' ' . $user_fullname;
                }
            
            }
            
            
            if ( $permalink ) {
                $html .= esc_html__( 'This file was uploaded on page', 'shared-files' ) . ' <a href="' . $permalink . '" style="font-weight: bold;" target="_blank">' . get_the_title( $embed_post_id ) . '</a> ' . $uploader_html . '.';
            } else {
                $html .= esc_html__( 'This file was uploaded on a page that has been deleted since', 'shared-files' ) . ' (' . $embed_post_title . ', ' . $uploader_html . ').';
            }
            
            $html .= '</span>';
            $html .= '<br /><br /><label><input type="checkbox" name="_sf_not_public"' . (( $not_public ? 'checked="checked"' : '' )) . ' /> ' . esc_html__( 'Hide from other pages', 'shared-files' ) . '</label>';
            $html .= '</div>';
        }
        
        
        if ( $file ) {
            $file_url = SharedFilesAdminHelpers::sf_root() . '/shared-files/' . get_the_ID() . '/' . SharedFilesHelpers::wp_engine() . $filename;
            $html .= esc_html__( 'Current file:', 'shared-files' ) . ' <a href="' . $file_url . '" target="_blank">' . $file_url . '</a>';
            $html .= '<br /><br /><b>' . esc_html__( 'Replace with a new file', 'shared-files' ) . ':</b><br />';
            $html .= '<input type="file" id="sf_file" name="_sf_file" value="" size="25" /><br />';
        } else {
            $html .= '<input type="file" id="sf_file" name="_sf_file" value="" size="25" /><br />';
        }
        
        $html .= '<p style="margin-bottom: 3px;">' . esc_html__( 'Maximum size of uploaded file:', 'shared-files' ) . ' <strong>' . SharedFilesHelpers::maxUploadSize() . '</strong></p>';
        $html .= '<p style="margin-top: 3px; margin-bottom: 20px;"><a href="https://www.sharedfilespro.com/how-to-increase-maximum-media-library-file-upload-size-in-wordpress-3-different-ways/" target="_blank">' . esc_html__( 'How to increase the maximum file size', 'shared-files' ) . '&raquo;</a></p>';
        $html .= '<div id="shared-file-main-date-title"><strong>' . esc_html__( 'File date', 'shared-files' ) . '</strong><br /><i>' . esc_html__( 'This date is displayed in the file list instead of the publish date. If empty, the publish date will be displayed. Both can be hidden from the settings.', 'shared-files' ) . '</i></div><input id="shared-file-main-date" name="_sf_main_date" type="date" value="' . $main_date_formatted . '" />';
        if ( SharedFilesHelpers::isPremium() == 0 ) {
            $html .= SharedFilesAdminHelpers::sfProMoreFeaturesMarkup();
        }
        $html .= '<div id="shared-file-description-title">' . esc_html__( 'Description', 'shared-files' ) . '</div>';
        echo  $html ;
        
        if ( isset( $s['textarea_for_file_description'] ) && $s['textarea_for_file_description'] ) {
            echo  '<textarea name="_sf_description" class="shared-files-admin-field-file-description">' . $description . '</textarea>' ;
        } else {
            $settings = array(
                'media_buttons' => false,
                'teeny'         => true,
                'wpautop'       => false,
                'textarea_rows' => 16,
            );
            wp_editor( $description, '_sf_description', $settings );
        }
        
        $html = '';
        $html .= "\n    <script>\n      jQuery(document).ready(function(\$) {\n        \$('form#post').attr('enctype', 'multipart/form-data');\n      });\n    </script>\n    ";
        $file_check = 0;
        if ( !$file_check ) {
            if ( !$file ) {
                $html .= "\n        <script>\n          jQuery(document).ready(function(\$) {\n            \$('#post').submit(function() {\n              if (\$('#sf_file').prop('files').length == 0) {\n                alert('" . esc_js( __( 'Please insert the file first.', 'shared-files' ) ) . "');\n                return false;\n              }\n            });\n          });\n        </script>\n        ";
            }
        }
        echo  $html ;
    }
    
    /**
     * Save the user submitted file itself and it's metadata.
     *
     * @since    1.0.0
     */
    public function save_custom_meta_data( $id )
    {
        
        if ( isset( $_FILES['_sf_file']['name'] ) ) {
            $s = get_option( 'shared_files_settings' );
            /* --- security verification --- */
            
            if ( isset( $_POST['post_type'] ) && $_POST['post_type'] != 'shared_file' ) {
                return $id;
            } elseif ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return $id;
            } elseif ( !current_user_can( 'edit_page', $id ) ) {
                return $id;
            } elseif ( !isset( $_POST['_sf_file_nonce'] ) || !wp_verify_nonce( $_POST['_sf_file_nonce'], 'shared-files-nonce-' . get_current_user_id() ) ) {
                return $id;
            }
            
            /* - end security verification - */
            $limit_downloads = '';
            
            if ( isset( $_POST['_sf_limit_downloads'] ) ) {
                $limit_downloads = (int) $_POST['_sf_limit_downloads'];
                if ( $limit_downloads == 0 ) {
                    $limit_downloads = '';
                }
            }
            
            $expiration_date = '';
            
            if ( isset( $_POST['_sf_expiration_date'] ) ) {
                $dt = DateTime::createFromFormat( "Y-m-d", $_POST['_sf_expiration_date'] );
                if ( $dt !== false && !array_sum( $dt::getLastErrors() ) ) {
                    $expiration_date = $dt;
                }
            }
            
            $main_date = '';
            
            if ( isset( $_POST['_sf_main_date'] ) ) {
                $dt = DateTime::createFromFormat( "Y-m-d", $_POST['_sf_main_date'] );
                if ( $dt !== false && !array_sum( $dt::getLastErrors() ) ) {
                    $main_date = $dt;
                }
            }
            
            $not_public = '';
            if ( isset( $_POST['_sf_not_public'] ) ) {
                $not_public = (int) $_POST['_sf_not_public'];
            }
            update_post_meta( $id, '_sf_not_public', $not_public );
            update_post_meta( $id, '_sf_limit_downloads', $limit_downloads );
            update_post_meta( $id, '_sf_expiration_date', $expiration_date );
            update_post_meta( $id, '_sf_main_date', $main_date );
            //      update_post_meta($id, '_sf_expiration_date', isset($_POST['_sf_expiration_date']) ? (int) $_POST['_sf_expiration_date'] : '');
            update_post_meta( $id, '_sf_password', ( isset( $_POST['_sf_password'] ) ? $_POST['_sf_password'] : '' ) );
            
            if ( isset( $_POST['_sf_description'] ) && $_POST['_sf_description'] ) {
                
                if ( isset( $s['textarea_for_file_description'] ) && $s['textarea_for_file_description'] ) {
                    $description = strip_tags( $_POST['_sf_description'] );
                    update_post_meta( $id, '_sf_description', $description );
                } else {
                    $description = balanceTags( wp_kses_post( $_POST['_sf_description'] ), 1 );
                    update_post_meta( $id, '_sf_description', $description );
                }
            
            } else {
                update_post_meta( $id, '_sf_description', '' );
            }
            
            
            if ( isset( $_POST['_sf_external_url'] ) && $_POST['_sf_external_url'] ) {
                $external_url = esc_url_raw( $_POST['_sf_external_url'] );
                update_post_meta( $id, '_sf_external_url', $external_url );
                $filename = basename( $external_url );
                update_post_meta( $id, '_sf_filename', $filename );
                update_post_meta( $id, '_sf_load_cnt', 0 );
                update_post_meta( $id, '_sf_bandwidth_usage', 0 );
                update_post_meta( $id, '_sf_file_added', current_time( 'Y-m-d H:i:s' ) );
            } elseif ( isset( $_FILES['_sf_file']['name'] ) && isset( $_FILES['_sf_file']['tmp_name'] ) && $_FILES['_sf_file']['tmp_name'] ) {
                // Get the file type of the upload
                $arr_file_type = wp_check_filetype( basename( $_FILES['_sf_file']['name'] ) );
                $uploaded_type = $arr_file_type['type'];
                add_filter( 'upload_dir', [ $this, 'set_upload_dir' ] );
                // Use the WordPress API to upload the file
                $upload = wp_upload_bits( $_FILES['_sf_file']['name'], null, file_get_contents( $_FILES['_sf_file']['tmp_name'] ) );
                if ( $upload['error'] ) {
                    wp_die( $upload['error'] );
                }
                remove_filter( 'upload_dir', [ $this, 'set_upload_dir' ] );
                
                if ( isset( $upload['error'] ) && $upload['error'] != 0 ) {
                    wp_die( 'There was an error uploading your file. The error is: ' . $upload['error'] );
                } else {
                    add_post_meta( $id, '_sf_file', $upload );
                    update_post_meta( $id, '_sf_file', $upload );
                    $filename = substr( strrchr( $upload['file'], "/" ), 1 );
                    update_post_meta( $id, '_sf_filename', $filename );
                    
                    if ( isset( $_FILES['_sf_file']['size'] ) ) {
                        update_post_meta( $id, '_sf_filesize', $_FILES['_sf_file']['size'] );
                    } else {
                        update_post_meta( $id, '_sf_filesize', 0 );
                    }
                    
                    update_post_meta( $id, '_sf_load_cnt', 0 );
                    update_post_meta( $id, '_sf_bandwidth_usage', 0 );
                    update_post_meta( $id, '_sf_file_added', current_time( 'Y-m-d H:i:s' ) );
                    SharedFilesHelpers::addFeaturedImage(
                        $id,
                        $upload,
                        $uploaded_type,
                        $filename
                    );
                    $post_title = '';
                    if ( isset( $_POST['post_title'] ) ) {
                        $post_title = $_POST['post_title'];
                    }
                    
                    if ( !$post_title ) {
                        $my_post = array(
                            'ID'         => $id,
                            'post_title' => $filename,
                        );
                        remove_action( 'save_post', [ $this, 'save_custom_meta_data' ] );
                        wp_update_post( $my_post );
                        add_action( 'save_post', [ $this, 'save_custom_meta_data' ] );
                    } else {
                        $my_post = array(
                            'ID'        => $id,
                            'post_name' => $id,
                        );
                        remove_action( 'save_post', [ $this, 'save_custom_meta_data' ] );
                        wp_update_post( $my_post );
                        add_action( 'save_post', [ $this, 'save_custom_meta_data' ] );
                    }
                
                }
            
            }
        
        }
    
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