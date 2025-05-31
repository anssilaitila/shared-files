<?php

class ShortcodeSharedFilesFavorites {
    /**
     * Search view embeddable via shortcode.
     *
     * @since    1.0.0
     */
    public static function shared_files_favorites( $atts = [], $content = null, $tag = '' ) {
        if ( SharedFilesHelpers::isPremium() == 0 ) {
            $html = SharedFilesPublicHelpers::proFeaturePublicMarkup();
            return $html;
        }
        $html = '';
        return $html;
    }

}
