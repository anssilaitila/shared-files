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

    if (isset($s['card_small_font_size']) && $s['card_small_font_size']) {
      $out .= '.shared-files-main-elements p { font-size: 15px; }';
    }

    if (shared_files_fs()->is__premium_only()) {
      if (shared_files_fs()->can_use_premium_code()) {

        if (isset($s['folder_icon_uri']) && $s['folder_icon_uri']) {
          $out .= '.shared-files-categories ul.shared-files-categories-list li { background-image: url(' . esc_url_raw( $s['folder_icon_uri'] ) . '); }';
        }

      }
    }

    if (isset($s['card_font']) && $s['card_font']) {

      if ($s['card_font'] == 'roboto') {
        $out .= '.shared-files-main-elements * { font-family: "Roboto", sans-serif; }';
      } elseif ($s['card_font'] == 'ubuntu') {
        $out .= '.shared-files-main-elements * { font-family: "Ubuntu", sans-serif; }';
      }

    }

    if (isset($s['card_background']) && $s['card_background']) {

      $out .= '.shared-files-container .shared-files-main-file-list li { margin-bottom: 16px; } ';

      if ($s['card_background'] == 'custom_color' && isset($s['card_background_custom_color']) && $s['card_background_custom_color']) {
        $custom_color = '#' . esc_attr( $s['card_background_custom_color'] );

        if ($custom_color && preg_match('/^#([0-9A-F]{3}){1,2}$/i', $custom_color)) {
          $out .= '.shared-files-main-elements { background: ' . esc_attr( $custom_color ) . '; padding: 20px 10px; border-radius: 10px; margin-bottom: 20px; } ';
        } else {
          $out .= '.shared-files-main-elements { background: #f7f7f7; padding: 20px 10px; border-radius: 10px; margin-bottom: 20px; } ';
        }

      } elseif ($s['card_background'] == 'white') {
        $out .= '.shared-files-main-elements { background: #fff; padding: 20px 10px; border-radius: 10px; } ';
      } elseif ($s['card_background'] == 'light_gray') {
        $out .= '.shared-files-main-elements { background: #f7f7f7; padding: 20px 10px; border-radius: 10px; } ';
      }
    }

    if (isset($s['card_height']) && $s['card_height']) {
      $out .= '.shared-files-main-file-list li { min-height: ' . intval( $s['card_height'] ) . 'px; } ';
      $out .= '.shared-files-2-cards-on-the-same-row .shared-files-main-file-list li { min-height: ' . intval( $s['card_height'] ) . 'px; } ';
      $out .= '.shared-files-3-cards-on-the-same-row .shared-files-main-file-list li { min-height: ' . intval( $s['card_height'] ) . 'px; } ';
      $out .= '.shared-files-4-cards-on-the-same-row .shared-files-main-file-list li { min-height: ' . intval( $s['card_height'] ) . 'px; } ';
      $out .= ' @media (max-width: 500px) { .shared-files-main-file-list li { min-height: 0; } } ';
      $out .= ' @media (max-width: 500px) { .shared-files-2-cards-on-the-same-row .shared-files-main-file-list li { min-height: 0; } } ';
      $out .= ' @media (max-width: 500px) { .shared-files-3-cards-on-the-same-row .shared-files-main-file-list li { min-height: 0; } } ';
      $out .= ' @media (max-width: 500px) { .shared-files-4-cards-on-the-same-row .shared-files-main-file-list li { min-height: 0; } } ';
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
