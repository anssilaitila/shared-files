<?php

class ShortcodeSharedFilesSearch {

  public static function shared_files_search($atts = [], $content = null, $tag = '') {

    $html = SharedFilesPublicHelpers::proFeaturePublicMarkup();
    return $html;

  }

}