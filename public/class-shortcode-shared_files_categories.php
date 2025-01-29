<?php

class ShortcodeSharedFilesCategories {
    public static function shared_files_categories( $atts = [], $content = null, $tag = '' ) {

        $html = SharedFilesAdminHelpers::sfProFeatureMarkup();
        return $html;

    }

}
