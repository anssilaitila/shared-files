<?php

class ShortcodeSharedFilesFavorites {

  /**
   * Search view embeddable via shortcode.
   *
   * @since    1.0.0
   */
  public static function shared_files_favorites($atts = [], $content = null, $tag = '') {

    $html = SharedFilesPublicHelpers::proFeaturePublicMarkup();
    return $html;

  }

}