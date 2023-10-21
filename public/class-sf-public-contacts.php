<?php

class SharedFilesPublicContacts {

  public static function askForEmail($embed_id, $atts) {

    $html = '';

    $html = SharedFilesPublicContacts::askForEmailMarkup($embed_id, $atts);

    return $html;
    
  }
  
  public static function askForEmailInfo() {

    $html = '<div class="shared-files-ask-for-email-info">' . sanitize_text_field( __('Every non-admin will be asked for an email address before showing the file(s).', 'shared-files') ) . '</div>';
    
    return $html;

  }

  public static function askForEmailMarkup($embed_id, $atts) {
  
    $html = '';
    
    $file_id = 0;
    
    if ( isset($atts['file_id']) && $atts['file_id'] ) {
      $file_id = intval( $atts['file_id'] );
    }

    $ask_for_email_id = '';
    
    if ( isset($atts['ask_for_email_id']) && $atts['ask_for_email_id'] ) {
      $ask_for_email_id = sanitize_text_field( $atts['ask_for_email_id'] );
    }
    
    $ask_for_email_form_field = '_sf_email_' . $embed_id;

    $html .= '<div class="shared-files-ask-for-email-container">';
    $html .= '<div class="shared-files-ask-for-email">';
  
    $html .= '<form method="POST" action="">';
    
    $html .= '<h2>' . esc_html__('Please enter an email address to see the file(s)', 'shared-files') . '</h2>';
  
    $html .= wp_nonce_field('_SF_ASK_FOR_EMAIL', '_wpnonce', true, false);
  
    $html .= '<div class="shared-files-form-field">';
    $html .=   '<div class="shared-files-form-field-left"><label for="password">' . esc_html__('Email', 'shared-files') . '</label></div>';
    $html .=   '<div class="shared-files-form-field-right"><input name="' . esc_attr( $ask_for_email_form_field ) . '" type="email" value="" required /></div>';
    $html .= '</div>';

    $html .= '<input type="hidden" name="ask_for_email_id" value="' . esc_attr( $ask_for_email_id ) . '" />';
  
    if ( isset( $_POST[$ask_for_email_form_field] ) && !is_email( $_POST[$ask_for_email_form_field] ) ) {
      $html .= '<div class="shared-files-invalid-email">' . esc_html__('Invalid email', 'shared-files') . '</div>';
    }
    
    $html .= '<input type="submit" class="shared-files-form-submit" value="' . esc_html__('Submit', 'shared-files') . '" />';
    
    $html .= '</form>';

    $html .= '</div>';
    $html .= '</div>';
    
    return $html;
    
  }
  
  public static function saveEmail($embed_id, $email, $atts) {

    if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], '_SF_ASK_FOR_EMAIL')) {
      wp_die('Error in processing form data.');
    }

    $referer_url = '';

    if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
      $referer_url = sanitize_text_field( $_SERVER['HTTP_REFERER'] );
    }

    $file_id = 0;
    
    if ( isset($atts['file_id']) && $atts['file_id'] ) {
    
      $file_id = intval( $atts['file_id'] );
      
    }
    
    $file_title = '';

    if ( $file_id ) {
      $file_title = sanitize_text_field( get_the_title( $file_id ) );
    }
    
    $ask_for_email_id = '';

    if ( isset($atts['ask_for_email_id']) && $atts['ask_for_email_id'] ) {
    
      $ask_for_email_id = sanitize_text_field( $atts['ask_for_email_id'] );
      
    }

    global $wpdb;
    
    $wpdb->insert($wpdb->prefix . 'shared_files_contacts', array(
      'file_id'           => $file_id,
      'file_title'        => $file_title,
      'email'             => $email,
      'embed_id'          => $embed_id,
      'ask_for_email_id'  => $ask_for_email_id,
      'referer_url'       => $referer_url
    ));
    
  }

}
