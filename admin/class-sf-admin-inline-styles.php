<?php

class SharedFilesAdminInlineStyles {

  public static function generateInlineStyles() {

    $current_screen = get_current_screen();
    $current_screen_id = '';

    if (isset($current_screen->id)) {
      $current_screen_id = $current_screen->id;
    }

    $s = get_option('shared_files_settings');

    $css = '';

    $css .= '#menu-posts-shared_file > ul > li:nth-of-type(7) {';
    $css .= 'border-bottom: 1px solid rgb(110, 110, 110);';
    $css .= '}';

    $css .= '#menu-posts-shared_file > ul > li:nth-of-type(8) {';
    $css .= 'border-bottom: 1px solid rgb(110, 110, 110);';
    $css .= '}';

    if ($current_screen_id !== 'shared_file_page_shared-files-sync-files' && $current_screen_id !== 'shared_file_page_shared-files-sync-media-library') {

      $css .= '#adminmenu a[href="edit.php?post_type=shared_file&page=shared-files-sync-media-library"] { display: none; visibility: hidden; }';

    }

    if ($current_screen_id !== 'shared_file_page_shared-files-shortcodes' && $current_screen_id !== 'shared_file_page_shared-files-restrict-access') {

      $css .= '#adminmenu a[href="edit.php?post_type=shared_file&page=shared-files-restrict-access"] { display: none; visibility: hidden; }';

    }

    if ($current_screen_id !== 'shared_file_page_shared-files-support' && $current_screen_id !== 'shared_file_page_shared-files-debug-info') {

      $css .= '#adminmenu a[href="edit.php?post_type=shared_file&page=shared-files-debug-info"] { display: none; visibility: hidden; }';

    }

    if (SharedFilesHelpers::isPremium() == 0) {
      $css .= '.wp-list-table tr[data-slug="shared-files"] .upgrade a { color: #3db634; }';
    }

    return $css;

  }

}
