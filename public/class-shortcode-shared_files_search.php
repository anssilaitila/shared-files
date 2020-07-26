<?php

class ShortcodeSharedFilesSearch
{
    public static function shared_files_search( $atts = array(), $content = null, $tag = '' )
    {
        $html = SharedFilesPublicHelpers::sfProFeaturePublicMarkup();
        return $html;
    }

}