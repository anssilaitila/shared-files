<?php

class ShortcodeSharedFilesSearch {
    public static function shared_files_search( $atts = [], $content = null, $tag = '' ) {
        if ( SharedFilesHelpers::isPremium() == 0 ) {
            $html = SharedFilesPublicHelpers::proFeaturePublicMarkup();
            return $html;
        }
    }

}
