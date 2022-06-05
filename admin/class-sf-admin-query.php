<?php

class SharedFilesAdminQuery
{
    /**
     * Serve the file itself and update necessary metadata.
     *
     * @since    1.0.0
     */
    public function alter_the_query( $request )
    {
        global  $wp ;
        $s = get_option( 'shared_files_settings' );
        $url = esc_url_raw( home_url( $wp->request ) );
        $url_parts = parse_url( $url );
        $sf_query = 0;
        if ( isset( $url_parts['path'] ) ) {
            $path_parts = explode( '/', $url_parts['path'] );
        }
        
        if ( is_super_admin() && isset( $_GET['DEBUG_URL_PARTS'] ) ) {
            echo  '<pre>1</pre>' ;
            echo  '<pre>' . esc_html( var_dump( $url_parts ) ) . '</pre>' ;
            echo  '<pre>2</pre>' ;
            echo  '<pre>' . esc_html( var_dump( $path_parts ) ) . '</pre>' ;
            
            if ( sizeof( $path_parts ) > 1 ) {
                echo  '<pre>3</pre>' ;
                echo  '<pre>' . var_dump( esc_html( $path_parts[count( $path_parts ) - 2] ) ) . '</pre>' ;
            }
            
            echo  '<pre>4</pre>' ;
            echo  '<pre>' . var_dump( esc_html( end( $path_parts ) ) ) . '</pre>' ;
        }
        
        $sf_base = '';
        $sf_base_alt = '';
        $sf_file_id = 0;
        $sf_query_filename = '';
        $file_id = 0;
        $sc_part = '';
        $sf_sc = '';
        
        if ( isset( $path_parts ) && is_array( $path_parts ) && isset( $path_parts[count( $path_parts ) - 3] ) ) {
            $sf_base = $path_parts[count( $path_parts ) - 3];
            $sf_base_alt = $path_parts[count( $path_parts ) - 2];
            
            if ( $sf_base == 'shared-files' ) {
                
                if ( isset( $s['obfuscate_file_urls'] ) ) {
                    $sc_part = sanitize_text_field( $path_parts[count( $path_parts ) - 2] );
                    $sc_parts = explode( '-', $sc_part );
                    
                    if ( isset( $sc_parts[0] ) && $sc_parts[0] && isset( $sc_parts[1] ) && $sc_parts[1] ) {
                        $file_id = $sc_parts[0];
                        $sf_sc = $sc_parts[1];
                        $sf_query = 1;
                        $sf_query_filename = end( $path_parts );
                    }
                
                } else {
                    $file_id = (int) $path_parts[count( $path_parts ) - 2];
                    
                    if ( $file_id > 0 ) {
                        $sf_query = 1;
                        $sf_query_filename = end( $path_parts );
                    }
                
                }
            
            } elseif ( $sf_base_alt == 'shared-files' ) {
                
                if ( isset( $s['obfuscate_file_urls'] ) ) {
                    $sc_part = sanitize_text_field( end( $path_parts ) );
                    $sc_parts = explode( '-', $sc_part );
                    
                    if ( isset( $sc_parts[0] ) && $sc_parts[0] && isset( $sc_parts[1] ) && $sc_parts[1] ) {
                        $file_id = $sc_parts[0];
                        $sf_sc = $sc_parts[1];
                        $sf_query = 1;
                        $sf_query_filename = end( $path_parts );
                    }
                
                } else {
                    $file_id = (int) end( $path_parts );
                    
                    if ( $file_id > 0 ) {
                        $sf_query = 1;
                        $sf_query_filename = '';
                    }
                
                }
            
            }
        
        }
        
        
        if ( is_super_admin() && isset( $_GET['DEBUG_URL_PARTS'] ) ) {
            echo  '<pre>sf_base</pre>' ;
            echo  '<pre>' . var_dump( esc_html( $path_parts[count( $path_parts ) - 3] ) ) . '</pre>' ;
            echo  '<pre>sf_base</pre>' ;
            echo  '<pre>' . var_dump( esc_html( $sf_base ) ) . '</pre>' ;
            echo  '<pre>sf_base_alt</pre>' ;
            echo  '<pre>' . var_dump( esc_html( $sf_base_alt ) ) . '</pre>' ;
            echo  '<pre>sf_query</pre>' ;
            echo  '<pre>' . var_dump( esc_html( $sf_query ) ) . '</pre>' ;
            echo  '<pre>file_id</pre>' ;
            echo  '<pre>' . var_dump( esc_html( $file_id ) ) . '</pre>' ;
            echo  '<pre>sf_query_filename</pre>' ;
            echo  '<pre>' . var_dump( esc_html( $sf_query_filename ) ) . '</pre>' ;
            wp_die();
        }
        
        $file_id = intval( $file_id );
        if ( $sf_query && $file_id ) {
            
            if ( $file_id ) {
                $filesize = 0;
                if ( get_post_meta( $file_id, '_sf_filesize', true ) ) {
                    $filesize = intval( get_post_meta( $file_id, '_sf_filesize', true ) );
                }
                $external_url = esc_url_raw( get_post_meta( $file_id, '_sf_external_url', true ) );
                $file = get_post_meta( $file_id, '_sf_file', true );
                $filename_fallback = get_post_meta( $file_id, '_sf_filename', true );
                
                if ( $external_url ) {
                    if ( !isset( $_POST['youtube'] ) && !isset( $_POST['only_meta'] ) ) {
                        header( 'Location: ' . esc_url_raw( $external_url ) );
                    }
                    die;
                } elseif ( $file || $filename_fallback ) {
                    $redirect = 0;
                    if ( isset( $s['file_open_method'] ) && $s['file_open_method'] == 'redirect' ) {
                        $redirect = 1;
                    }
                    $filename = '';
                    
                    if ( isset( $file['file'] ) ) {
                        $filename = SharedFilesFileOpen::getUpdatedPathAndFilename( sanitize_text_field( $file['file'] ) );
                    } elseif ( $filename_fallback ) {
                        // metadata not found (field _sf_file)
                        $filename_with_path_fallback = 'shared-files/';
                        if ( $subdir_fallback = get_post_meta( $file_id, '_sf_subdir', true ) ) {
                            $filename_with_path_fallback .= $subdir_fallback . '/';
                        }
                        $filename_with_path_fallback .= $filename_fallback;
                        $filename = SharedFilesFileOpen::getUpdatedPathAndFilename( sanitize_text_field( $filename_with_path_fallback ) );
                    }
                    
                    
                    if ( is_super_admin() && isset( $_GET['DEBUG_FILE'] ) ) {
                        echo  '<pre>' . var_dump( esc_html( $file['file'] ) ) . '</pre>' ;
                        echo  '<pre>' . var_dump( esc_html( $filename ) ) . '</pre>' ;
                        echo  '<pre>' . var_dump( esc_html( $filename_fallback ) ) . '</pre>' ;
                        wp_die();
                    }
                    
                    if ( !$redirect && (!isset( $filename ) || !file_exists( $filename )) ) {
                        wp_die( esc_html__( 'File not found:', 'shared-files' ) . '<br />' . $filename );
                    }
                    $file_mime = '';
                    
                    if ( function_exists( 'mime_content_type' ) ) {
                        $file_mime = mime_content_type( $filename );
                    } elseif ( function_exists( 'finfo_open' ) && function_exists( 'finfo_file' ) ) {
                        $finfo = finfo_open( FILEINFO_MIME_TYPE );
                        $file_mime = finfo_file( $finfo, $filename );
                        finfo_close( $finfo );
                    }
                    
                    if ( !$file_mime ) {
                        $file_mime = SharedFilesAdminHelpers::get_mime_type( $filename );
                    }
                    // Update load counter (1/2)
                    $load_cnt = (int) get_post_meta( $file_id, '_sf_load_cnt', true );
                    // Update load counter (2/2)
                    update_post_meta( $file_id, '_sf_load_cnt', intval( $load_cnt ) + 1 );
                    
                    if ( isset( $s['file_open_method'] ) && $s['file_open_method'] == 'redirect' ) {
                        $file = get_post_meta( $file_id, '_sf_file', true );
                        $file_url = esc_url_raw( $file['url'] );
                        $redirect_url_parts = parse_url( $file_url );
                        $file_uri = $redirect_url_parts['path'];
                        wp_redirect( esc_url_raw( $file_uri ) );
                        exit;
                    }
                    
                    $path = pathinfo( $filename );
                    $header_filename = $path['filename'];
                    $header_extension = $path['extension'];
                    $header_filename_ext = '';
                    if ( $header_filename && $header_extension ) {
                        $header_filename_ext = $header_filename . '.' . $header_extension;
                    }
                    
                    if ( isset( $_GET['download'] ) ) {
                        header( 'Pragma: public' );
                        header( 'Expires: 0' );
                        header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
                        header( 'Content-Type: application/force-download' );
                        header( 'Content-Type: application/octet-stream' );
                        header( 'Content-Type: application/download' );
                        if ( $header_filename_ext ) {
                            header( 'Content-Disposition: attachment;filename=' . $header_filename_ext );
                        }
                        header( 'Content-Transfer-Encoding: binary' );
                    } else {
                        // Set headers
                        header( 'Content-Type: ' . $file_mime );
                        if ( $header_filename_ext ) {
                            header( 'Content-Disposition: inline; filename="' . $header_filename_ext . '"' );
                        }
                        header( 'Cache-Control: no-cache, must-revalidate' );
                        header( 'X-Accel-Buffering: no' );
                        header( 'Content-Length: ' . filesize( $filename ) );
                    }
                    
                    if ( function_exists( 'ob_clean' ) ) {
                        ob_clean();
                    }
                    if ( function_exists( 'ob_end_flush' ) ) {
                        ob_end_flush();
                    }
                    
                    if ( isset( $s['file_open_method'] ) && $s['file_open_method'] == 'alt' ) {
                        set_time_limit( 0 );
                        $file_alt = @fopen( $filename, 'rb' );
                        while ( !feof( $file_alt ) ) {
                            print @fread( $file_alt, 1024 * 8 );
                            ob_flush();
                            flush();
                        }
                    } else {
                        readfile( $filename );
                    }
                    
                    exit;
                }
            
            }
        
        }
        return $request;
    }

}