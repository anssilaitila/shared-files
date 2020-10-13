<?php

class SharedFilesAdminMultipleFilesUpload
{
    public function file_upload( $request )
    {
        return $request;
    }
    
    public function add_multiple_files_view()
    {
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