<?php

class SharedFilesFileUpload
{
    public static function fileUploadMarkup()
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
        return array(
            'path'   => $dir['basedir'] . '/shared-files',
            'url'    => $dir['baseurl'] . '/shared-files',
            'subdir' => '/shared-files',
        ) + $dir;
    }

}