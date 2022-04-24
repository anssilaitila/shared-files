<?php

class SharedFilesFileHandling
{
    public static function getBaseDir()
    {
        $base_dir = wp_get_upload_dir()['basedir'] . '/shared-files/';
        return $base_dir;
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