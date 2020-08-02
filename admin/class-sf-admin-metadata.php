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
        wp_nonce_field( plugin_basename( __FILE__ ), '_sf_file_nonce' );
        $post_id = get_the_ID();
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
        if ( $expiration_date instanceof DateTime ) {
            $expiration_date_formatted = $expiration_date->format( 'Y-m-d' );
        }
        if ( $main_date instanceof DateTime ) {
            $main_date_formatted = $main_date->format( 'Y-m-d' );
        }
        $password = get_post_meta( get_the_ID(), '_sf_password', true );
        $html = '';
        
        if ( $embed_post_id ) {
            $permalink = get_permalink( $embed_post_id );
            $html .= '<div style="padding: 18px; margin: 10px 0; background: rgb(252, 252, 252); border: 1px solid rgb(240, 240, 240);">';
            $html .= '<span style="font-size: 14px;">';
            
            if ( $permalink ) {
                $html .= __( 'This file was uploaded on page', 'shared-files' ) . ' <a href="' . $permalink . '" style="font-weight: bold;" target="_blank">' . get_the_title( $embed_post_id ) . '</a>.';
            } else {
                $html .= __( 'This file was uploaded on a page that has been deleted since', 'shared-files' ) . ' (' . $embed_post_title . ').';
            }
            
            $html .= '</span>';
            $html .= '<br /><br /><label><input type="checkbox" name="_sf_not_public"' . (( $not_public ? 'checked="checked"' : '' )) . ' /> ' . __( 'Hide from other pages', 'shared-files' ) . '</label>';
            $html .= '</div>';
        }
        
        
        if ( $file ) {
            $file_url = SharedFilesAdminHelpers::sf_root() . '/shared-files/' . get_the_ID() . '/' . $filename;
            $html .= __( 'Current file:', 'shared-files' ) . ' <a href="' . $file_url . '" target="_blank">' . $file_url . '</a>';
            $html .= '<br /><br /><b>' . __( 'Replace with a new file', 'shared-files' ) . ':</b><br />';
            $html .= '<input type="file" id="sf_file" name="_sf_file" value="" size="25" /><br />';
        } else {
            $html .= '<input type="file" id="sf_file" name="_sf_file" value="" size="25" /><br />';
        }
        
        $html .= '<div id="shared-file-main-date-title"><strong>' . __( 'File date', 'shared-files' ) . '</strong><br /><i>' . __( 'This date is displayed in the file list instead of the publish date. If empty, the publish date will be displayed. Both can be hidden from the settings.', 'shared-files' ) . '</i></div><input id="shared-file-main-date" name="_sf_main_date" type="date" value="' . $main_date_formatted . '">';
        $html .= SharedFilesAdminHelpers::sfProMoreFeaturesMarkup();
        $html .= '<div id="shared-file-description-title">' . __( 'Description', 'shared-files' ) . '</div>';
        echo  $html ;
        $settings = array(
            'media_buttons' => false,
            'teeny'         => true,
            'wpautop'       => false,
            'textarea_rows' => 16,
        );
        wp_editor( $description, '_sf_description', $settings );
        $html = '';
        $html .= "\n    <script>\n      jQuery(document).ready(function(\$) {\n        \$('form#post').attr('enctype', 'multipart/form-data');\n      });\n    </script>\n    ";
        if ( !$file ) {
            $html .= "\n      <script>\n        jQuery(document).ready(function(\$) {\n          \$('#post').submit(function() {\n            if (\$('#shared-file-external-url').val().length == 0 && \$('#sf_file').prop('files').length == 0) {\n              alert('" . __( 'Please insert the file first or define an external URL.', 'shared-files' ) . "');\n              return false;\n            }\n          });\n        });\n      </script>\n      ";
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
        
        if ( !empty($_FILES) ) {
            /* --- security verification --- */
            if ( !isset( $_POST['_sf_file_nonce'] ) || !wp_verify_nonce( $_POST['_sf_file_nonce'], plugin_basename( __FILE__ ) ) ) {
                return $id;
            }
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return $id;
            }
            
            if ( $_POST['post_type'] == 'page' ) {
                if ( !current_user_can( 'edit_page', $id ) ) {
                    return $id;
                }
            } else {
                if ( !current_user_can( 'edit_page', $id ) ) {
                    return $id;
                }
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
                $not_public = $_POST['_sf_not_public'];
            }
            update_post_meta( $id, '_sf_not_public', $not_public );
            update_post_meta( $id, '_sf_limit_downloads', $limit_downloads );
            update_post_meta( $id, '_sf_expiration_date', $expiration_date );
            update_post_meta( $id, '_sf_main_date', $main_date );
            //      update_post_meta($id, '_sf_expiration_date', isset($_POST['_sf_expiration_date']) ? (int) $_POST['_sf_expiration_date'] : '');
            update_post_meta( $id, '_sf_password', ( isset( $_POST['_sf_password'] ) ? $_POST['_sf_password'] : '' ) );
            
            if ( isset( $_POST['_sf_description'] ) && $_POST['_sf_description'] ) {
                $description = balanceTags( wp_kses_post( $_POST['_sf_description'] ), 1 );
                update_post_meta( $id, '_sf_description', $description );
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
            } elseif ( !empty($_FILES['_sf_file']['name']) ) {
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
                    update_post_meta( $id, '_sf_filesize', $_FILES['_sf_file']['size'] );
                    update_post_meta( $id, '_sf_load_cnt', 0 );
                    update_post_meta( $id, '_sf_bandwidth_usage', 0 );
                    update_post_meta( $id, '_sf_file_added', current_time( 'Y-m-d H:i:s' ) );
                    $post_title = $_POST['post_title'];
                    
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
        return array(
            'path'   => $dir['basedir'] . '/shared-files',
            'url'    => $dir['baseurl'] . '/shared-files',
            'subdir' => '/shared-files',
        ) + $dir;
    }

}