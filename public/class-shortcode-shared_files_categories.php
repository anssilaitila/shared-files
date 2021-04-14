<?php

class ShortcodeSharedFilesCategories
{
    public static function shared_files_categories( $atts = array(), $content = null, $tag = '' )
    {
        
        if ( SharedFilesHelpers::isPremium() == 0 ) {
            $html = SharedFilesAdminHelpers::sfProFeatureMarkup();
            return $html;
        }
    
    }

}