<?php

class ShortcodeSharedFilesExactSearch {
    public static function shared_files_exact_search( $atts = [], $content = null, $tag = '' ) {
        if ( SharedFilesHelpers::isPremium() == 0 ) {
            $html = SharedFilesPublicHelpers::proFeaturePublicMarkup();
            return $html;
        } elseif ( !SharedFilesHelpers::isMin2Pr() ) {
            $html = '';
            return $html;
        }
    }

}
