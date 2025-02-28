<?php

class SharedFilesPublicContacts {

  public static function askForEmail($embed_id, $atts) {

    $html = '';

    $html = SharedFilesPublicContacts::askForEmailMarkup($embed_id, $atts);

    return $html;

  }

  public static function askForEmailInfo() {

    $html = '<div class="shared-files-ask-for-contact-info-for-admin">' . sanitize_text_field( __('Every non-admin will be asked for contact info before showing the file(s).', 'shared-files') ) . '</div>';

    return $html;

  }

  public static function askForEmailMarkup($embed_id, $atts) {

    $s = get_option('shared_files_settings');

    $html = '';

    $file_id = 0;

    if ( isset($atts['file_id']) && $atts['file_id'] ) {
      $file_id = intval( $atts['file_id'] );
    }

    $file_list_id = '';

    if ( isset($atts['file_list_id']) && $atts['file_list_id'] ) {
      $file_list_id = sanitize_text_field( $atts['file_list_id'] );
    } elseif ( isset($atts['ask_for_email_id']) && $atts['ask_for_email_id'] ) {
      $file_list_id = sanitize_text_field( $atts['ask_for_email_id'] );
    }

    $ask_for_email_form_field = '_sf_email_' . $embed_id;

    $name_field = '_sf_email_' . $embed_id;

    $lead_form_title = sanitize_text_field( __('Please enter the following information to see the file(s):', 'shared-files') );
    $lead_form_description = '';
    $lead_name_title = sanitize_text_field( __('Name', 'shared-files') );
    $lead_email_title = sanitize_text_field( __('Email', 'shared-files') );
    $lead_phone_title = sanitize_text_field( __('Phone', 'shared-files') );
    $lead_description_title = sanitize_text_field( __('Description', 'shared-files') );

    if ( isset($s['lead_form_title']) && $s['lead_form_title'] ) {
      $lead_form_title = sanitize_text_field( $s['lead_form_title'] );
    }

    if ( isset($s['lead_form_description']) && $s['lead_form_description'] ) {
      $lead_form_description = sanitize_textarea_field( $s['lead_form_description'] );
    }

    if ( isset($s['lead_name_title']) && $s['lead_name_title'] ) {
      $lead_name_title = sanitize_text_field( $s['lead_name_title'] );
    }

    if ( isset($s['lead_email_title']) && $s['lead_email_title'] ) {
      $lead_email_title = sanitize_text_field( $s['lead_email_title'] );
    }

    if ( isset($s['lead_phone_title']) && $s['lead_phone_title'] ) {
      $lead_phone_title = sanitize_text_field( $s['lead_phone_title'] );
    }

    if ( isset($s['lead_description_title']) && $s['lead_description_title'] ) {
      $lead_description_title = sanitize_text_field( $s['lead_description_title'] );
    }

    $html .= '<div class="shared-files-ask-for-contact-info-container">';
    $html .= '<div class="shared-files-ask-for-contact-info">';

    $html .= '<form method="POST" action="">';

    $html .= '<input name="shared-files-add-contact" value="1" type="hidden" />';

    $html .= '<h2>' . esc_html( $lead_form_title ) . '</h2>';

    if ( $lead_form_description ) {
      $html .= '<p>' . wp_kses_post( nl2br( $lead_form_description ) ) . '</p>';
    }

    $html .= wp_nonce_field('_SF_ASK_FOR_EMAIL', '_wpnonce', true, false);

    if ( isset($s['lead_show_name']) ) {
      $html .= '<div class="shared-files-form-field">';
      $html .=   '<div class="shared-files-form-field-left"><label for="name">' . esc_html( $lead_name_title ) . '</label></div>';
      $html .=   '<div class="shared-files-form-field-right"><input name="_sf_name" value="" required /></div>';
      $html .= '</div>';
    }

    if ( !isset($s['lead_hide_email']) ) {
      $html .= '<div class="shared-files-form-field">';
      $html .=   '<div class="shared-files-form-field-left"><label for="' . esc_attr( $ask_for_email_form_field ) . '">' . esc_html( $lead_email_title ) . '</label></div>';
      $html .=   '<div class="shared-files-form-field-right"><input name="' . esc_attr( $ask_for_email_form_field ) . '" type="email" value="" required /></div>';
      $html .= '</div>';
    }

    if ( isset($s['lead_show_phone']) ) {
      $html .= '<div class="shared-files-form-field">';
      $html .=   '<div class="shared-files-form-field-left"><label for="phone">' . esc_html( $lead_phone_title ) . '</label></div>';
      $html .=   '<div class="shared-files-form-field-right"><input name="_sf_phone" value="" required /></div>';
      $html .= '</div>';
    }

    if ( isset($s['lead_show_description']) ) {
      $html .= '<div class="shared-files-form-field">';
      $html .=   '<div class="shared-files-form-field-left"><label for="descr">' . esc_html( $lead_description_title ) . '</label></div>';
      $html .=   '<div class="shared-files-form-field-right"><textarea name="_sf_descr"></textarea></div>';
      $html .= '</div>';
    }

    $html .= '<input type="hidden" name="ask_for_email_id" value="' . esc_attr( $file_list_id ) . '" />';

    if ( isset( $_POST[$ask_for_email_form_field] ) && !is_email( $_POST[$ask_for_email_form_field] ) ) {
      $html .= '<div class="shared-files-invalid-email">' . esc_html__('Invalid email', 'shared-files') . '</div>';
    }

    $html .= '<input type="submit" class="shared-files-form-submit" value="' . esc_html__('Submit', 'shared-files') . '" />';

    $html .= '</form>';

    $html .= '</div>';
    $html .= '</div>';

    return $html;

  }

  public static function saveEmail($embed_id, $atts) {

    if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], '_SF_ASK_FOR_EMAIL')) {
      wp_die('Error in processing form data.');
    }

    $name = '';
    $email = '';
    $phone = '';
    $descr = '';

    if ( isset($_POST['_sf_name']) && $_POST['_sf_name'] ) {
      $name = sanitize_text_field( $_POST['_sf_name'] );
    }

    $ask_for_email_form_field = '_sf_email_' . $embed_id;

    if ( isset($_POST[$ask_for_email_form_field]) && is_email($_POST[$ask_for_email_form_field]) ) {
      $email = sanitize_email( $_POST[$ask_for_email_form_field] );
    }

    if ( isset($_POST['_sf_phone']) && $_POST['_sf_phone'] ) {
      $phone = sanitize_text_field( $_POST['_sf_phone'] );
    }

    if ( isset($_POST['_sf_descr']) && $_POST['_sf_descr'] ) {
      $descr = sanitize_textarea_field( $_POST['_sf_descr'] );
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

    $file_list_id = '';

    if ( isset($atts['file_list_id']) && $atts['file_list_id'] ) {

      $file_list_id = sanitize_text_field( $atts['file_list_id'] );

    } elseif ( isset($atts['ask_for_email_id']) && $atts['ask_for_email_id'] ) {

      $file_list_id = sanitize_text_field( $atts['ask_for_email_id'] );

    }

    global $wpdb;

    $wpdb->insert($wpdb->prefix . 'shared_files_contacts', array(
      'file_id'           => $file_id,
      'file_title'        => $file_title,
      'name'              => $name,
      'email'             => $email,
      'phone'             => $phone,
      'descr'             => $descr,
      'embed_id'          => $embed_id,
      'ask_for_email_id'  => $file_list_id,
      'referer_url'       => $referer_url
    ));

    $args = [
      'file_id'           => $file_id,
      'file_title'        => $file_title,
      'name'              => $name,
      'email'             => $email,
      'phone'             => $phone,
      'descr'             => $descr,
      'embed_id'          => $embed_id,
      'ask_for_email_id'  => $file_list_id,
      'referer_url'       => $referer_url
    ];

    do_action( 'shared_files_add_lead', $args );

  }

}