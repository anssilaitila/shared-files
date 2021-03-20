<?php

class SharedFilesPublicLoad {
  
  public function public_inline_styles() {
  
    $styles = $this->get_inline_styles();
    wp_add_inline_style( 'shared-files', $styles );
    
  }
  
  public function get_inline_styles() {
  
    $s = get_option('shared_files_settings');

    $out = '';
    
    if (isset($s['show_file_upload_checkboxes_on_multiple_columns'])) {

      $out .= '
        ul.sf-termlist,
        .sf-taglist {
          columns: 240px 5;
        }';
      
    }
  
    return $out;
  
  }

}

