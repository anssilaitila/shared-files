<?php

class ShortcodeSharedFilesAccordion {

  public static function shared_files_accordion($atts = [], $content = null, $tag = '') {

    $html = SharedFilesPublicHelpers::proFeaturePublicMarkup();
    return $html;

  }

}