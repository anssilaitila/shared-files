<?php

class ShortcodeSharedFilesAccordion
{
    public static function shared_files_accordion( $atts = array(), $content = null, $tag = '' )
    {
        
        if ( SharedFilesHelpers::isPremium() == 0 ) {
            $html = SharedFilesPublicHelpers::proFeaturePublicMarkup();
            return $html;
        }
    
    }

}