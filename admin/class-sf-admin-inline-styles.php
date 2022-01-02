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

    if ($current_screen_id !== 'shared_file_page_shared-files-sync-files' && $current_screen_id !== 'shared_file_page_shared-files-sync-media-library') {
    
      $css .= '#adminmenu a[href="edit.php?post_type=shared_file&page=shared-files-sync-media-library"] { display: none; visibility: hidden; }';
      
    } 
    
    if ($current_screen_id !== 'shared_file_page_shared-files-support' && $current_screen_id !== 'shared_file_page_shared-files-restrict-access') {
    
      $css .= '#adminmenu a[href="edit.php?post_type=shared_file&page=shared-files-restrict-access"] { display: none; visibility: hidden; }';
      
    }
    
    if (SharedFilesHelpers::isPremium() == 0) {
      $css .= '.wp-list-table tr[data-slug="shared-files"] .upgrade a { color: #3db634; }';
    }

    return $css;
    
  }

}
