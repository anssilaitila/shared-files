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

  /**
   * Set cookies.
   *
   * @since    1.0.0
   */
  public function set_cookies() {

    if (isset($_POST['_sf_cat_password']) && $_POST['_sf_cat_password'] && !is_admin()) {
      setcookie('_sf_cat_password', sanitize_text_field( $_POST['_sf_cat_password'] ), strtotime('+30 minutes'), '/');
    }

  }

}

