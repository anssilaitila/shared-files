<?php
  
class ShortcodeSharedFilesInfo {

  /**
   * Info view embeddable via shortcode.
   *
   * @since    1.0.0
   */
  public static function shared_files_info($atts = [], $content = null, $tag = '') {

    $html = '';

    if (isset($_GET) && isset($_GET['shared-files-update'])) {
      $html .= '<div class="shared-files-upload-complete">' . esc_html__('File successfully updated.', 'shared-files') . '</div>';
    } elseif (isset($_GET) && isset($_GET['_sf_delete_editable_file']) && isset($_GET['sc'])) {
      $html .= '<div class="shared-files-file-deleted">' . esc_html__('File successfully deleted.', 'shared-files') . '</div>';      
    }

    return $html;
  }

}
