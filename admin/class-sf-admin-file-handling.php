<?php

class SharedFilesFileHandling
{
    public static function add_file(
        $file,
        $cat_slug,
        $media_library_post_id = 0,
        $subdir = ''
    )
    {
        return 1;
    }
    
    public static function activate_file()
    {
        
        if ( current_user_can( 'administrator' ) && isset( $_POST['shared-files-op'] ) && $_POST['shared-files-op'] == 'sync-files' && isset( $_POST['add_file'] ) ) {
            if ( !isset( $_POST['sf-sync-files-nonce'] ) || !wp_verify_nonce( $_POST['sf-sync-files-nonce'], 'sf-sync-files' ) ) {
                wp_die( 'Error in processing form data.' );
            }
            $cat_slug = '';
            if ( isset( $_POST['shared-file-category'] ) ) {
                $cat_slug = sanitize_title_with_dashes( $_POST['shared-file-category'] );
            }
            
            if ( $_POST['add_file'] == 'all_files' ) {
                $path = self::getBaseDir();
                $files = array_diff( scandir( $path ), array( '.', '..' ) );
                $count = 0;
                foreach ( $files as $file ) {
                    $item = self::getBaseDir() . $file;
                    if ( $file == 'index.php' || is_dir( $item ) ) {
                        continue;
                    }
                    $meta_query = array(
                        'relation' => 'AND',
                    );
                    $meta_query[] = array(
                        'key'     => '_sf_filename',
                        'compare' => '=',
                        'value'   => $file,
                    );
                    $wp_query = new WP_Query( array(
                        'post_type'      => 'shared_file',
                        'post_status'    => 'publish',
                        'posts_per_page' => 1,
                        'meta_query'     => $meta_query,
                    ) );
                    $file_active = 0;
                    
                    if ( $wp_query->have_posts() ) {
                        while ( $wp_query->have_posts() ) {
                            $wp_query->the_post();
                            $file_active = 1;
                        }
                        wp_reset_postdata();
                    }
                    
                    if ( !$file_active ) {
                        if ( SharedFilesFileHandling::add_file( $file, $cat_slug ) ) {
                            $count++;
                        }
                    }
                }
                wp_redirect( admin_url( 'edit.php?post_type=shared_file&page=shared-files-sync-files&files=' . $count ) );
                exit;
            } else {
                $filename = sanitize_file_name( $_POST['add_file'] );
                $page = 'shared-files-sync-files';
                $media_library_post_id = 0;
                $subdir = '';
                
                if ( isset( $_POST['_sf_media_library_post_id'] ) ) {
                    $page = 'shared-files-sync-media-library';
                    $media_library_post_id = $_POST['_sf_media_library_post_id'];
                }
                
                if ( isset( $_POST['_SF_SUBDIR'] ) ) {
                    $subdir = sanitize_file_name( $_POST['_SF_SUBDIR'] );
                }
                
                if ( SharedFilesFileHandling::add_file(
                    $filename,
                    $cat_slug,
                    $media_library_post_id,
                    $subdir
                ) ) {
                    wp_redirect( admin_url( 'edit.php?post_type=shared_file&page=' . $page . '&files=1' ) );
                    exit;
                } else {
                    echo  '<p>' . __( 'Error processing file(s).', 'shared-files' ) . '</p>' ;
                    wp_redirect( admin_url( 'edit.php?post_type=shared_file&page=' . $page . '&files=error' ) );
                    exit;
                }
            
            }
        
        }
    
    }
    
    public static function getBaseDir()
    {
        $base_dir = wp_get_upload_dir()['basedir'] . '/shared-files/';
        return $base_dir;
    }
    
    public static function getFileUrl( $file_id )
    {
        $file_url = SharedFilesHelpers::sf_root() . '/shared-files/' . $file_id . '/' . SharedFilesHelpers::wp_engine() . $c['_sf_filename'][0];
        return $file_dir;
    }
    
    public static function getFileUrlByName( $filename, $subdir = '' )
    {
        $wp_upload_dir = parse_url( wp_upload_dir()['baseurl'] );
        $file_url = $wp_upload_dir['path'] . '/shared-files/' . $subdir . $filename;
        return $file_url;
    }
    
    public static function human_filesize( $bytes, $decimals = 2 )
    {
        $size = array(
            'bytes',
            'KB',
            'MB',
            'GB',
            'TB',
            'PB',
            'EB',
            'ZB',
            'YB'
        );
        $factor = floor( (strlen( $bytes ) - 1) / 3 );
        return ( $bytes ? sprintf( "%.{$decimals}f", $bytes / pow( 1024, $factor ) ) . ' ' . @$size[$factor] : 0 );
    }

}