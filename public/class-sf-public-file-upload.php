<?php

class SharedFilesFileUpload
{
    public static function fileUploadMarkup( $atts )
    {
        $html = '';
        return $html;
    }
    
    public function file_upload( $request )
    {
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