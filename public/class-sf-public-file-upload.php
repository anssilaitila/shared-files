<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
class SharedFilesFileUpload {
    public function file_upload_plup( $request ) {
        $s = get_option( 'shared_files_settings' );
        if ( isset( $_GET ) && isset( $_GET['_sf_delete_file'] ) ) {
            $user = wp_get_current_user();
            $sc = '';
            if ( isset( $_GET['sc'] ) ) {
                $sc = sanitize_text_field( wp_unslash( $_GET['sc'] ) );
            }
            if ( !$sc || !wp_verify_nonce( $sc, 'sf_delete_file_' . intval( $user->ID ) ) ) {
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
        if ( isset( $_POST ) && isset( $_POST['shared-files-upload'] ) ) {
            $secret_code = '';
            if ( isset( $_POST['secret_code'] ) ) {
                $secret_code = sanitize_text_field( wp_unslash( $_POST['secret_code'] ) );
            }
            if ( !$secret_code || !wp_verify_nonce( $secret_code, 'sf_insert_file' ) ) {
                wp_die( 'Error in processing form data.' );
            }
            // NEW START
            if ( isset( $_POST ) && isset( $_POST['_sf_insert_multiple_files_frontend'] ) ) {
                $goto_url = '';
                SharedFilesHelpers::writeLog( 'Start processing files from frontend uploader:' );
                /*
                // Good idea to make sure things are set before using them
                $tags = isset( $_POST['tags'] ) ? (array) $_POST['tags'] : array();
                
                // Any of the WordPress data sanitization functions can be used here
                $tags = array_map( 'esc_attr', $tags );
                */
                if ( isset( $_POST['_sf_file_uploaded_file'] ) && is_array( $_POST['_sf_file_uploaded_file'] ) ) {
                    foreach ( $_POST['_sf_file_uploaded_file'] as $file_id => $data ) {
                        $file_path = sanitize_text_field( wp_unslash( $data['file'] ) );
                        $file_type = sanitize_text_field( wp_unslash( $data['type'] ) );
                        $file_url = esc_url_raw( wp_unslash( $data['url'] ) );
                        SharedFilesHelpers::writeLog( $file_path );
                        SharedFilesHelpers::writeLog( $file_type );
                        SharedFilesHelpers::writeLog( $file_url );
                    }
                }
                if ( isset( $s['file_upload_file_not_required'] ) || isset( $_POST['_sf_file_uploaded_file'] ) && is_array( $_POST['_sf_file_uploaded_file'] ) ) {
                    $uploaded_files = 0;
                    if ( isset( $_POST['_sf_file_uploaded_file'] ) && is_array( $_POST['_sf_file_uploaded_file'] ) ) {
                        $uploaded_files = $_POST['_sf_file_uploaded_file'];
                    } elseif ( isset( $s['file_upload_file_not_required'] ) ) {
                        $bogus_array[0] = [
                            'file' => '',
                            'type' => '',
                            'url'  => '',
                        ];
                        $uploaded_files = $bogus_array;
                    }
                    foreach ( $uploaded_files as $file_id => $data ) {
                        $file_path = sanitize_text_field( wp_unslash( $data['file'] ) );
                        $file_type = sanitize_text_field( wp_unslash( $data['type'] ) );
                        $file_url = esc_url_raw( wp_unslash( $data['url'] ) );
                        // SINGLE -> MULTIPLE START
                        $post_status = ( isset( $s['file_upload_set_to_pending'] ) && $s['file_upload_set_to_pending'] ? 'pending' : 'publish' );
                        $new_post = array(
                            'post_type'    => 'shared_file',
                            'post_status'  => $post_status,
                            'post_title'   => '',
                            'post_content' => '',
                        );
                        $id = wp_insert_post( $new_post );
                        update_post_meta( $id, '_sf_frontend_uploader', 1 );
                        if ( isset( $_POST['_sf_embed_post_id'] ) ) {
                            update_post_meta( $id, '_sf_embed_post_id', intval( $_POST['_sf_embed_post_id'] ) );
                        }
                        if ( isset( $_POST['_sf_embed_post_title'] ) ) {
                            update_post_meta( $id, '_sf_embed_post_title', sanitize_text_field( wp_unslash( $_POST['_sf_embed_post_title'] ) ) );
                        }
                        if ( !empty( $_POST['_sf_upload_id'] ) ) {
                            update_post_meta( $id, '_sf_upload_id', sanitize_text_field( wp_unslash( $_POST['_sf_upload_id'] ) ) );
                            update_post_meta( $id, '_sf_not_public', 1 );
                        } elseif ( !isset( $s['uncheck_hide_from_other_pages'] ) ) {
                            update_post_meta( $id, '_sf_not_public', 1 );
                        } else {
                            update_post_meta( $id, '_sf_not_public', '' );
                        }
                        if ( isset( $_POST[SHARED_FILES_TAG_SLUG] ) ) {
                            $cat_slug = sanitize_title( wp_unslash( $_POST[SHARED_FILES_TAG_SLUG] ) );
                            $cat = get_term_by( 'slug', sanitize_title( $cat_slug ), SHARED_FILES_TAG_SLUG );
                            if ( $cat ) {
                                wp_set_object_terms( $id, intval( $cat->term_id ), SHARED_FILES_TAG_SLUG );
                            }
                        }
                        if ( isset( $_POST['tax_input'][SHARED_FILES_TAG_SLUG] ) ) {
                            $tags = wp_unslash( $_POST['tax_input'][SHARED_FILES_TAG_SLUG] );
                            if ( is_array( $tags ) ) {
                                $tags_int = array_map( function ( $value ) {
                                    return (int) $value;
                                }, $tags );
                                wp_set_post_terms( $id, $tags_int, SHARED_FILES_TAG_SLUG );
                            }
                        }
                        if ( is_user_logged_in() ) {
                            $user = wp_get_current_user();
                            update_post_meta( $id, '_sf_user_id', intval( $user->ID ) );
                        }
                        if ( isset( $_POST['_sf_description'] ) ) {
                            $description = wp_strip_all_tags( balanceTags( wp_kses_post( wp_unslash( $_POST['_sf_description'] ) ), 1 ) );
                            if ( !isset( $s['textarea_for_file_description'] ) ) {
                                $description = nl2br( $description );
                            }
                            update_post_meta( $id, '_sf_description', $description );
                        } else {
                            update_post_meta( $id, '_sf_description', '' );
                        }
                        //            $filename = $_FILES['_sf_files']['name'][$i];
                        $filename = '';
                        $at_least_one_file_uploaded = 0;
                        // File added using the uploader
                        if ( $file_path ) {
                            $tmp_name = $file_path;
                            $basename = sanitize_file_name( basename( $file_path ) );
                            $sf_file_uploaded_file = $file_path;
                            $sf_file_uploaded_type = $file_type;
                            $sf_file_uploaded_url = $file_url;
                            $upload = [
                                'file' => $sf_file_uploaded_file,
                                'type' => $sf_file_uploaded_type,
                                'url'  => $sf_file_uploaded_url,
                            ];
                            add_post_meta( $id, '_sf_file', $upload );
                            update_post_meta( $id, '_sf_file', $upload );
                            $at_least_one_file_uploaded = 1;
                            $filename = substr( strrchr( $upload['file'], "/" ), 1 );
                            update_post_meta( $id, '_sf_filename', sanitize_text_field( $filename ) );
                            $sf_file_size = 0;
                            $upload_file = '';
                            if ( isset( $upload['file'] ) && $upload['file'] ) {
                                $upload_file = sanitize_text_field( $upload['file'] );
                            }
                            SharedFilesFileUpdate::uFilesize( $id, $sf_file_size, $upload_file );
                            $featured_image_already_added = 0;
                            if ( !$featured_image_already_added ) {
                                if ( !isset( $s['file_upload_disable_featured_image'] ) ) {
                                    SharedFilesHelpers::addFeaturedImage(
                                        $id,
                                        $upload,
                                        $sf_file_uploaded_type,
                                        $filename,
                                        1
                                    );
                                }
                            }
                        } elseif ( !isset( $s['file_upload_file_not_required'] ) ) {
                            $error_msg = sanitize_text_field( __( 'File was not successfully uploaded. Please note the maximum file size.', 'shared-files' ) );
                            wp_die( esc_html( $error_msg ) );
                        }
                        update_post_meta( $id, '_sf_load_cnt', 0 );
                        update_post_meta( $id, '_sf_bandwidth_usage', 0 );
                        update_post_meta( $id, '_sf_file_added', current_time( 'Y-m-d H:i:s' ) );
                        update_post_meta( $id, '_sf_main_date', '' );
                        $post_title = $filename;
                        if ( !empty( $_POST['_sf_title'] ) ) {
                            $post_title = sanitize_text_field( wp_unslash( $_POST['_sf_title'] ) );
                        } elseif ( !$at_least_one_file_uploaded && !empty( $_POST['_sf_external_url'] ) ) {
                            $post_title = sanitize_text_field( __( 'External URL', 'shared-files' ) );
                        }
                        if ( !$at_least_one_file_uploaded && !empty( $_POST['_sf_external_url'] ) ) {
                            $external_url = esc_url_raw( wp_unslash( $_POST['_sf_external_url'] ) );
                            update_post_meta( $id, '_sf_external_url', $external_url );
                            $filename = basename( $external_url );
                            update_post_meta( $id, '_sf_filename', sanitize_text_field( $filename ) );
                        }
                        $my_post = array(
                            'ID'         => $id,
                            'post_title' => sanitize_text_field( $post_title ),
                        );
                        wp_update_post( $my_post );
                        do_action( 'shared_files_frontend_file_uploaded', $id );
                        $goto_url = esc_url_raw( get_site_url() );
                        if ( !empty( $_POST['_SF_GOTO'] ) ) {
                            $goto_url = esc_url_raw( wp_unslash( $_POST['_SF_GOTO'] ) );
                        }
                        $container_url = $goto_url;
                        // SINGLE -> MULTIPLE END
                    }
                } elseif ( !empty( $_POST['_sf_external_url'] ) ) {
                    $post_status = ( isset( $s['file_upload_set_to_pending'] ) && $s['file_upload_set_to_pending'] ? 'pending' : 'publish' );
                    $new_post = array(
                        'post_type'    => 'shared_file',
                        'post_status'  => $post_status,
                        'post_title'   => '',
                        'post_content' => '',
                    );
                    $id = wp_insert_post( $new_post );
                    update_post_meta( $id, '_sf_frontend_uploader', 1 );
                    update_post_meta( $id, '_sf_embed_post_id', intval( $_POST['_sf_embed_post_id'] ) );
                    update_post_meta( $id, '_sf_embed_post_title', sanitize_text_field( wp_unslash( $_POST['_sf_embed_post_title'] ) ) );
                    if ( !empty( $_POST['_sf_upload_id'] ) ) {
                        update_post_meta( $id, '_sf_upload_id', sanitize_text_field( wp_unslash( $_POST['_sf_upload_id'] ) ) );
                        update_post_meta( $id, '_sf_not_public', 1 );
                    } elseif ( !isset( $s['uncheck_hide_from_other_pages'] ) ) {
                        update_post_meta( $id, '_sf_not_public', 1 );
                    } else {
                        update_post_meta( $id, '_sf_not_public', '' );
                    }
                    if ( isset( $_POST[SHARED_FILES_TAG_SLUG] ) ) {
                        $cat_slug = sanitize_title( wp_unslash( $_POST[SHARED_FILES_TAG_SLUG] ) );
                        $cat = get_term_by( 'slug', sanitize_title( $cat_slug ), SHARED_FILES_TAG_SLUG );
                        if ( $cat ) {
                            wp_set_object_terms( $id, intval( $cat->term_id ), SHARED_FILES_TAG_SLUG );
                        }
                    }
                    if ( isset( $_POST['tax_input'][SHARED_FILES_TAG_SLUG] ) ) {
                        $tags = wp_unslash( $_POST['tax_input'][SHARED_FILES_TAG_SLUG] );
                        if ( is_array( $tags ) ) {
                            $tags_int = array_map( function ( $value ) {
                                return (int) $value;
                            }, $tags );
                            wp_set_post_terms( $id, $tags_int, SHARED_FILES_TAG_SLUG );
                        }
                    }
                    if ( is_user_logged_in() ) {
                        $user = wp_get_current_user();
                        update_post_meta( $id, '_sf_user_id', intval( $user->ID ) );
                    }
                    if ( isset( $_POST['_sf_description'] ) ) {
                        $description = wp_strip_all_tags( balanceTags( wp_kses_post( wp_unslash( $_POST['_sf_description'] ) ), 1 ) );
                        if ( !isset( $s['textarea_for_file_description'] ) ) {
                            $description = nl2br( $description );
                        }
                        update_post_meta( $id, '_sf_description', $description );
                    } else {
                        update_post_meta( $id, '_sf_description', '' );
                    }
                    $external_url = esc_url_raw( wp_unslash( $_POST['_sf_external_url'] ) );
                    update_post_meta( $id, '_sf_external_url', $external_url );
                    $filename = basename( $external_url );
                    update_post_meta( $id, '_sf_filename', sanitize_text_field( $filename ) );
                    update_post_meta( $id, '_sf_load_cnt', 0 );
                    update_post_meta( $id, '_sf_bandwidth_usage', 0 );
                    update_post_meta( $id, '_sf_file_added', current_time( 'Y-m-d H:i:s' ) );
                    update_post_meta( $id, '_sf_main_date', '' );
                    $post_title = $filename;
                    if ( !empty( $_POST['_sf_title'] ) ) {
                        $post_title = sanitize_text_field( wp_unslash( $_POST['_sf_title'] ) );
                    } elseif ( !empty( $_POST['_sf_external_url'] ) ) {
                        $post_title = sanitize_text_field( __( 'External URL', 'shared-files' ) );
                    }
                    $my_post = array(
                        'ID'         => $id,
                        'post_title' => sanitize_text_field( $post_title ),
                    );
                    wp_update_post( $my_post );
                    do_action( 'shared_files_frontend_file_uploaded', $id );
                    $goto_url = esc_url_raw( get_site_url() );
                    if ( !empty( $_POST['_SF_GOTO'] ) ) {
                        $goto_url = esc_url_raw( wp_unslash( $_POST['_SF_GOTO'] ) );
                    }
                    $container_url = $goto_url;
                }
                wp_safe_redirect( $goto_url . '?shared-files-upload=1' );
                exit;
            }
        }
        return $request;
    }

    /**
     * Set the custom upload directory.
     *
     * @since    1.0.0
     */
    public function set_upload_dir( $dir ) {
        $s = get_option( 'shared_files_settings' );
        $folder_for_new_files = '';
        if ( isset( $s['folder_for_new_files'] ) && $s['folder_for_new_files'] ) {
            $folder_for_new_files = '/' . sanitize_file_name( $s['folder_for_new_files'] );
            $full_path_new = realpath( $dir['basedir'] ) . '/shared-files' . $folder_for_new_files;
            if ( !file_exists( $full_path_new ) ) {
                SharedFilesHelpers::createDir( $full_path_new );
            }
        }
        return array(
            'path'   => realpath( $dir['basedir'] ) . '/shared-files' . $folder_for_new_files,
            'url'    => $dir['baseurl'] . '/shared-files' . $folder_for_new_files,
            'subdir' => '/shared-files' . $folder_for_new_files,
        ) + $dir;
    }

}
