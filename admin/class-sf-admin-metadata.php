<?php

class SharedFilesAdminMetadata {

  /**
   * Custom meta box for file edit view.
   *
   * @since    1.0.0
   */
  public function adding_custom_meta_boxes($post) {

    add_meta_box(
      'my-meta-box',
      sanitize_text_field( __('File info') ),
      array($this, 'custom_metadata'),
      'shared_file',
      'normal',
      'default'
    );

  }

  public function custom_metadata() {

    echo SharedFilesAdminHelpSupport::permalinks_alert();

    $s = get_option('shared_files_settings');

    wp_nonce_field('shared-files-nonce-' . intval( get_current_user_id() ), '_sf_file_nonce');

    $post_id = intval( get_the_ID() );

    $c = get_post_custom($post_id);

    $file = get_post_meta($post_id, '_sf_file', true);
    $filename = sanitize_text_field( get_post_meta($post_id, '_sf_filename', true) );
    $description = wp_kses_post( get_post_meta($post_id, '_sf_description', true) );
    $external_url = esc_url_raw( get_post_meta($post_id, '_sf_external_url', true) );
    $limit_downloads = intval( get_post_meta($post_id, '_sf_limit_downloads', true) );
    $expiration_date = get_post_meta($post_id, '_sf_expiration_date', true);
    $expiration_date_formatted = '';
    $main_date = get_post_meta($post_id, '_sf_main_date', true);
    $main_date_formatted = '';
    $notify_email = sanitize_email( get_post_meta($post_id, '_sf_notify_email', true) );
    $subdir = sanitize_file_name( get_post_meta($post_id, '_sf_subdir', true) );

    if ( $subdir == '/' ) {
      $subdir = '';
    }

    $embed_post_id = intval( get_post_meta($post_id, '_sf_embed_post_id', true) );
    $embed_post_title = sanitize_text_field( get_post_meta($post_id, '_sf_embed_post_title', true) );
    $not_public = sanitize_text_field( get_post_meta($post_id, '_sf_not_public', true) );

    $upload_id = sanitize_text_field( get_post_meta($post_id, '_sf_upload_id', true) );

    $media_library_post_id = intval( get_post_meta($post_id, '_sf_media_library_post_id', true) );

    if ($expiration_date instanceof DateTime) {
      $expiration_date_formatted = $expiration_date->format('Y-m-d');
    }

    if ($main_date instanceof DateTime) {
      $main_date_formatted = $main_date->format('Y-m-d');
    }

    $password = sanitize_text_field( get_post_meta($post_id, '_sf_password', true) );

    if ($media_library_post_id) {

      $permalink = esc_url_raw( get_permalink($media_library_post_id) );

      echo '<div style="padding: 18px; margin: 10px 0 10px 0; background: rgb(252, 252, 252); border: 1px solid rgb(240, 240, 240);">';

      echo '<span style="font-size: 14px;">';

      $media_library_href = esc_url_raw( admin_url() . 'upload.php?item=' . $media_library_post_id );

      $file_with_url = esc_url_raw( wp_get_attachment_url($media_library_post_id) );
      $url_local = explode(site_url(), $file_with_url)[1]; //output local path

      echo esc_html__('This file is activated from the media library', 'shared-files') . ':<br /><a href="' . esc_url( $media_library_href ) . '" style="font-weight: bold; color: #333; text-decoration: none;" target="_blank">' . esc_html( $url_local ) . '</a>';

      echo '</span>';

      echo '</div>';

    } elseif ($embed_post_id) {

      $permalink = esc_url_raw( get_permalink($embed_post_id) );

      echo '<div style="padding: 18px; margin: 10px 0; background: rgb(252, 252, 252); border: 1px solid rgb(240, 240, 240);">';

      echo '<span style="font-size: 14px;">';

      $uploader_html = sanitize_text_field( __('by a visitor', 'shared-files') );

      if (isset($c['_sf_user_id'][0]) && $c['_sf_user_id'][0]) {

        $user = get_user_by('id', intval($c['_sf_user_id'][0]) );
        $user_fullname = $user->user_login;

        if ($user->first_name && $user->last_name) {
          $user_fullname = $user->first_name . ' ' . $user->last_name;
        } elseif ($user->last_name) {
          $user_fullname = $user->last_name;
        } elseif ($user->first_name) {
          $user_fullname = $user->first_name;
        }

        if (is_super_admin()) {
          $uploader_html = sanitize_text_field( __('by', 'shared-files') ) . ' ' . '<a href="' . esc_url_raw( get_admin_url(null, 'user-edit.php?user_id=' . intval( $c['_sf_user_id'][0] ) ) ) . '" target="_blank">' . sanitize_text_field( $user_fullname ) . '</a>';
        } else {
          $uploader_html = sanitize_text_field( __('by', 'shared-files') ) . ' ' . sanitize_text_field( $user_fullname );
        }

      }

      $html_allowed_tags = [

        'a' => [
          'href' => [],
          'target' => [],
        ],

      ];

      if ($permalink) {
        echo esc_html__('This file was uploaded on page', 'shared-files') . ' <a href="' . esc_url( $permalink ) . '" style="font-weight: bold;" target="_blank">' . esc_html( get_the_title($embed_post_id) ) . '</a> ' . wp_kses($uploader_html, $html_allowed_tags) . '.';
      } else {
        echo esc_html__('This file was uploaded on a page that has been deleted since', 'shared-files') . ' (' .  esc_html( $embed_post_title ) . ', ' . wp_kses($uploader_html, $html_allowed_tags) . ').';
      }

      echo '</span>';

      echo '<br /><br /><label><input type="checkbox" name="_sf_not_public"' . ($not_public ? 'checked="checked"' : '') . ' /> ' . esc_html__('Hide from other pages', 'shared-files') . '</label>';

      echo '</div>';

    }

    if ( $file ) {

      $file_url = SharedFilesPublicHelpers::getFileURL( intval( get_the_ID() ) );

      echo esc_html__('Current file:', 'shared-files') . ' <a href="' . esc_url( $file_url ) . '" target="_blank">' . esc_html( $file_url ) . '</a>';

      if ($subdir) {
        echo '<div class="shared-files-admin-folder-name-container">' . esc_html__('Server folder:', 'shared-files') . ' <div class="shared-files-admin-folder-name">shared-files/' . esc_attr( $subdir ) . '/</div></div>';
      } else {
        echo '<br /><br />';
      }

      echo '<b>' . esc_html__('Replace with a new file', 'shared-files') . ':</b><br />';
      echo '<input type="file" id="sf_file" name="_sf_file" value="" size="25" /><br />';

    } elseif ( $filename_fallback = get_post_meta($post_id, '_sf_filename', true) ) {

      $file_url = SharedFilesPublicHelpers::getFileURL( intval( get_the_ID() ) );

      echo esc_html__('Current file:', 'shared-files') . ' <a href="' . esc_url( $file_url ) . '" target="_blank">' . esc_html( $file_url ) . '</a>';

      if ($subdir) {
        echo '<div class="shared-files-admin-folder-name-container">' . esc_html__('Server folder:', 'shared-files') . ' <div class="shared-files-admin-folder-name">shared-files/' . esc_attr( $subdir ) . '/</div></div>';
      } else {
        echo '<br /><br />';
      }

      echo '<b>' . esc_html__('Replace with a new file', 'shared-files') . ':</b><br />';
      echo '<input type="file" id="sf_file" name="_sf_file" value="" size="25" /><br />';

    } else {

      echo '<input type="file" id="sf_file" name="_sf_file" value="" size="25" /><br />';

    }

    echo '<p style="margin-bottom: 3px;">' . esc_html__('Maximum size of uploaded file:', 'shared-files') . ' <strong>' . esc_html( SharedFilesHelpers::maxUploadSize() ) . '</strong></p>';

    echo '<p style="margin-top: 3px; margin-bottom: 20px;"><a href="https://www.sharedfilespro.com/how-to-increase-maximum-media-library-file-upload-size-in-wordpress-3-different-ways/" target="_blank">' . esc_html__('How to increase the maximum file size', 'shared-files') . '&raquo;</a></p>';


    // SUPPORT BOX START

    $url = 'https://wordpress.org/support/plugin/shared-files/';

    echo '<div class="shared-files-admin-support-box">';

    echo sprintf(
      wp_kses(
        /* translators: %s: link to the support forum */
        __('If you have any questions in mind, please contact the author at <a href="%s" target="_blank">the support forum</a>. The forum is actively monitored and any kind of feedback is welcome.', 'shared-files'),
        array('a' => array('href' => array(), 'target' => array()))
      ),
      esc_url($url)
    );

    echo '</div>';

    // SUPPORT BOX END


    if ( $upload_id ) {
      echo '<div class="shared-files-admin-upload-id-container">' . esc_html__('Upload ID:', 'shared-files') . ' <div class="shared-files-admin-upload-id">' . esc_html( $upload_id ) . '</div></div>';
    }

    $pro_field_active = 0;
    $field_in_pro_class = 'shared-files-field-in-pro-greyed-out';
    $field_in_pro_more_features_class = 'shared-files-admin-free-more-features';

    $field_in_all_plans_markup = '<div class="shared-files-field-in-pro-container">';
    $field_in_all_plans_markup .= '<a href="' . esc_url_raw( get_admin_url() ) . 'options-general.php?page=shared-files-pricing">';
    $field_in_all_plans_markup .= '<div class="shared-files-settings-pro-feature-overlay"><span>All Plans</span></div>';
    $field_in_all_plans_markup .= '</a>';
    $field_in_all_plans_markup .= '</div>';

    $field_in_pro_markup = '<div class="shared-files-field-in-pro-container">';
    $field_in_pro_markup .= '<a href="' . esc_url_raw( get_admin_url() ) . 'options-general.php?page=shared-files-pricing">';
    $field_in_pro_markup .= '<div class="shared-files-settings-pro-feature-overlay"><span>Pro</span></div>';
    $field_in_pro_markup .= '</a>';
    $field_in_pro_markup .= '</div>';

    $field_in_business_markup = '<div class="shared-files-field-in-pro-container">';
    $field_in_business_markup .= '<a href="' . esc_url_raw( get_admin_url() ) . 'options-general.php?page=shared-files-pricing">';
    $field_in_business_markup .= '<div class="shared-files-settings-pro-feature-overlay"><span>Max</span></div>';
    $field_in_business_markup .= '</a>';
    $field_in_business_markup .= '</div>';

    $field_in_pro_markup_allowed_tags = [

      'div' => [
        'class' => [],
        'style' => []
      ],

      'a' => [
        'href' => [],
      ],

      'span' => [
      ],

    ];

    echo '<div class="shared-files-admin-small-fields">';

    /* Filename START */

    echo '<div class="shared-files-admin-small-field-container">';

    echo '<div class="shared-files-admin-small-field-title ' . esc_attr( $field_in_pro_class ) . '">';
    echo '<h4>' . esc_html__('Filename', 'shared-files') . '</h4>';
    echo '<i>' . esc_html__('The filename in the url changes based on this value.', 'shared-files') . '</i>';
    echo '</div>';

    if ( $file ) {
      echo '<input id="shared-file-filename" class="shared-files-admin-field-full-width" name="_sf_filename" type="text" value="' . esc_attr( $filename ) . '" />';
    } else {
      echo '<div class="shared-files-admin-filename-info">' . esc_html__('You can change the filename after publishing a file.', 'shared-files') . '</div>';
    }

    echo '</div>';

    /* Filename END */


    /* File date START */

    echo '<div class="shared-files-admin-small-field-container">';

    echo '<div id="shared-file-main-date-title" class="shared-files-admin-small-field-title">';
    echo '<h4>' . esc_html__('File date', 'shared-files') . '</h4>';
    echo '<i>' . esc_html__('This date is displayed in the file list instead of the publish date. If empty, the publish date will be displayed. Both can be hidden from the settings.', 'shared-files') . '</i>';
    echo '</div>';

    echo '<input id="shared-file-main-date" name="_sf_main_date" type="date" value="' . esc_attr( $main_date_formatted ) . '" />';

    echo '</div>';

    /* File date END */


    /* External URL START */

    echo '<div class="shared-files-admin-small-field-container">';

    echo '<div id="shared-file-external-url-title" class="shared-files-admin-small-field-title ' . esc_attr( $field_in_pro_class ) . '">';
    echo '<h4>' . esc_html__('External URL', 'shared-files') . '</h4>';
    echo '<i>' . esc_html__('Instead of adding a local file, you may provide an external URL to a file located elsewhere.', 'shared-files') . '<br />' . esc_html__('Note: if the external URL is defined, the local file will not be saved.', 'shared-files') . '</i>';
    echo '</div>';

    $pro_field_active = 0;

    if (!$pro_field_active) {
      echo wp_kses($field_in_all_plans_markup, $field_in_pro_markup_allowed_tags);
    }

    echo '</div>';

    /* External URL END */


    /* Expiration date START */

    echo '<div class="shared-files-admin-small-field-container">';

    echo '<div id="shared-file-expiration-date-title" class="shared-files-admin-small-field-title ' . esc_attr( $field_in_pro_class ) . '">';
    echo '<h4>' . esc_html__('Expiration date', 'shared-files') . '</h4>';
    echo '<i>' . esc_html__("When this date is the current date, an email notify is sent to the administrator and the file is highlighted in the admin list.", 'shared-files') . '<br />' . esc_html__("It's also possible to delete these files automatically (see plugin settings).", 'shared-files') . '</i>';
    echo '</div>';

    $pro_field_active = 0;

    if (!$pro_field_active) {
      echo wp_kses($field_in_all_plans_markup, $field_in_pro_markup_allowed_tags);
    }

    echo '</div>';

    /* Expiration date END */

    /* Notification email START */

    echo '<div class="shared-files-admin-small-field-container">';
    echo '<div id="shared-file-notify-email-title" class="shared-files-admin-small-field-title ' . esc_attr( $field_in_pro_class ) . '">';
    echo '<h4>' . esc_html__('Notification email', 'shared-files') . '</h4>';
    echo '<i>' . esc_html__('This email address is used for notifications regarding this file. If this is not defined, the email defined in the settings will be used.', 'shared-files') . '</i>';
    echo '</div>';

    $pro_field_active = 0;

    if (!$pro_field_active) {
      echo wp_kses($field_in_all_plans_markup, $field_in_pro_markup_allowed_tags);
    }

    echo '</div>';

    /* Notification email END */

    echo '<div style="width: 100%; border-bottom: 1px solid #000; margin-bottom: 24px;"><h2 style="font-weight: 700; font-size: 20px; padding-left: 0;">' . esc_html__('Restrict access', 'shared-files') . '</h2></div>';

    /* User START */

    echo '<div class="shared-files-admin-small-field-container">';

    echo '<div id="shared-file-user-title" class="shared-files-admin-small-field-title ' . esc_attr( $field_in_pro_class ) . '">';
    echo '<h4>' . esc_html__('Restrict access for users', 'shared-files') . '</h4>';
    echo '<i>' . esc_html__('Only these users will see the file listed on shortcode [shared_files_restricted] and [shared_files_accordion restricted=1].', 'shared-files') . '</i>';
    echo '</div>';

    $pro_field_active = 0;

    if (!$pro_field_active) {
      echo wp_kses($field_in_pro_markup, $field_in_pro_markup_allowed_tags);
    }

    echo '</div>';

    /* User END */

    /* Password protection START */

    echo '<div class="shared-files-admin-small-field-container">';

    echo '<div id="shared-file-password-title" class="shared-files-admin-small-field-title ' . esc_attr( $field_in_pro_class ) . '">';
    echo '<h4>' . esc_html__('Password protection', 'shared-files') . '</h4>';
    echo '<i>' . esc_html__('Define a password here to enable password protection.', 'shared-files') . '</i>';
    echo '</div>';

    $pro_field_active = 0;

    if (!$pro_field_active) {
      echo wp_kses($field_in_all_plans_markup, $field_in_pro_markup_allowed_tags);
    }

    if ($pro_field_active) {
      $url = esc_url_raw( get_admin_url() . 'edit.php?post_type=shared_file&page=shared-files-restrict-access' );
      echo '<div style="margin-top: 12px;">' .  sprintf(
        wp_kses(
          /* translators: %s: link to the information page about access restriction */
          __('<a href="%s">Important information regarding file permissions &raquo;</a>', 'shared-files'),
          array('a' => array('href' => array(), 'target' => array()))
        ),
        esc_url($url)
      ) . '</div>';
    }

    echo '</div>';

    /* Password protection END */

    /* Role START */

    echo '<div class="shared-files-admin-small-field-container">';

    echo '<div id="shared-file-user-title" class="shared-files-admin-small-field-title ' . esc_attr( $field_in_pro_class ) . '">';
    echo '<h4>' . esc_html__('Restrict access for roles', 'shared-files') . '</h4>';
    echo '<i>' . esc_html__('Only the users having these roles will see the file listed on the restricted file lists.', 'shared-files') . '</i>';
    echo '</div>';

    $pro_field_active = 0;

    if (!$pro_field_active) {
      echo wp_kses($field_in_pro_markup, $field_in_pro_markup_allowed_tags);
    }

    echo '</div>';

    /* Role END */

    /* Limit downloads START */

    echo '<div class="shared-files-admin-small-field-container">';

    echo '<div id="shared-file-limit-downloads-title" class="shared-files-admin-small-field-title ' . esc_attr( $field_in_pro_class ) . '">';
    echo '<h4>' . esc_html__('Limit downloads', 'shared-files') . '</h4>';
    echo '<i>' . esc_html__('When this number is reached, the file can\'t be downloaded anymore and an email notify is sent to the administrator.', 'shared-files') . '</i>';
    echo '</div>';

    $pro_field_active = 0;

    if (!$pro_field_active) {
      echo wp_kses($field_in_all_plans_markup, $field_in_pro_markup_allowed_tags);
    }

    echo '</div>';

    /* Limit downloads END */

    /* Custom fields START */

    echo '<div style="width: 100%; border-bottom: 1px solid #000; margin-bottom: 8px;"><h2 style="font-weight: 700; font-size: 20px; padding-left: 0;">' . esc_html__('Custom fields', 'shared-files') . '</h2>';

    echo '</div>';


    echo '<div style="width: 100%; margin-bottom: 16px;">';

    $url = esc_url_raw( get_admin_url() . 'options-general.php?page=shared-files#shared-files-settings-tab-4' );
    echo sprintf(
      wp_kses(
        /* translators: %s: link to plugin settings */
        __('<a href="%s" target="_blank">Settings for custom fields &raquo;</a>', 'shared-files'),
        array('a' => array('href' => array(), 'target' => array()))
      ),
      esc_url($url)
    );

    echo '</div>';

    $pro_field_active = 0;

    if (!$pro_field_active) {

      $file_upload_cf = sanitize_text_field( get_post_meta($post_id, '_sf_file_upload_cf_1', true) );

      echo '<div class="shared-files-admin-small-field-container">';

      $cf_title = sanitize_text_field( __('Custom field 1', 'shared-files') );

      if (isset($s['file_upload_custom_field_1']) && $s['file_upload_custom_field_1']) {
        $cf_title = sanitize_text_field( $s['file_upload_custom_field_1'] );
      }

      echo '<div class="shared-files-admin-custom-field-title ' . esc_attr( $field_in_pro_class ) . '">';
      echo '<h4>' . esc_html( $cf_title ) . '</h4>';
      echo '</div>';

      echo '<input class="shared-files-admin-custom-field" type="text" name="_sf_file_upload_cf_1" value="' . esc_attr( $file_upload_cf ) . '" autocomplete="off" />';

      echo '</div>';

      echo '<div class="shared-files-admin-small-field-container">';

      echo '<div class="shared-files-admin-custom-field-title ' . esc_attr( $field_in_pro_class ) . '">';
      echo '<h4>' . esc_html__('Custom field 2') . '</h4>';
      echo '</div>';

      echo wp_kses($field_in_all_plans_markup, $field_in_pro_markup_allowed_tags);

      echo '</div>';

      echo '<div class="shared-files-admin-small-field-container">';

      echo '<div class="shared-files-admin-custom-field-title ' . esc_attr( $field_in_pro_class ) . '">';
      echo '<h4>' . esc_html__('Custom field 3') . '</h4>';
      echo '</div>';

      echo wp_kses($field_in_all_plans_markup, $field_in_pro_markup_allowed_tags);

      echo '</div>';

      echo '<div class="shared-files-admin-small-field-container">';

      echo '<div class="shared-files-admin-custom-field-title ' . esc_attr( $field_in_pro_class ) . '">';
      echo '<h4>' . esc_html__('Custom field 4') . '</h4>';
      echo '</div>';

      echo wp_kses($field_in_all_plans_markup, $field_in_pro_markup_allowed_tags);

      echo '</div>';

      echo '<div class="shared-files-admin-small-field-container">';

      echo '<div class="shared-files-admin-custom-field-title ' . esc_attr( $field_in_pro_class ) . '">';
      echo '<h4>' . esc_html__('Custom field 5') . '</h4>';
      echo '</div>';

      echo wp_kses($field_in_all_plans_markup, $field_in_pro_markup_allowed_tags);

      echo '</div>';


      echo '<div class="shared-files-admin-small-field-container">';

      echo '<div class="shared-files-admin-custom-field-title ' . esc_attr( $field_in_pro_class ) . '">';
      echo '<h4>' . esc_html__('Unlimited custom fields') . '</h4>';
      echo '</div>';

      echo wp_kses($field_in_all_plans_markup, $field_in_pro_markup_allowed_tags);

      echo '</div>';

    }

    /* Custom fields END */

    echo '</div>';

    /* Description START */

    echo '<div style="width: 100%; border-bottom: 1px solid #000; margin-bottom: 12px; margin-top: 0;"><h2 style="font-weight: 700; font-size: 20px; padding-left: 0;">' . esc_html__('Description', 'shared-files') . '</h2></div>';

    if (isset($s['textarea_for_file_description']) && $s['textarea_for_file_description']) {

      echo '<textarea name="_sf_description" class="shared-files-admin-field-file-description">' . esc_html( $description ) . '</textarea>';

    } else {

      $settings = array('media_buttons' => false, 'teeny' => true, 'wpautop' => false, 'textarea_rows' => 16);

      wp_editor($description, '_sf_description', $settings);

    }

    /* Description END */

  }

  /**
   * Save the user submitted file itself and it's metadata.
   *
   * @since    1.0.0
   */
  public function save_custom_meta_data($id) {

    if (isset($_FILES['_sf_file']['name'])) {

      $s = get_option('shared_files_settings');

      $sf_nonce = '';

      if ( isset( $_POST['_sf_file_nonce'] ) ) {
        $sf_nonce = sanitize_text_field( $_POST['_sf_file_nonce'] );
      }

      /* --- security verification --- */
      if (isset($_POST['post_type']) && $_POST['post_type'] != 'shared_file') {
        return $id;
      } elseif (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $id;
      } elseif (!current_user_can('edit_page', $id)) {
        return $id;
      } elseif (!isset($sf_nonce) || !wp_verify_nonce($sf_nonce, 'shared-files-nonce-' . intval( get_current_user_id() ) )) {
        return $id;
      }
      /* - end security verification - */

      $limit_downloads = '';

      if (isset($_POST['_sf_limit_downloads'])) {
        $limit_downloads = (int) $_POST['_sf_limit_downloads'];

        if ($limit_downloads == 0) {
          $limit_downloads = '';
        }
      }

      $expiration_date = '';

      if (isset($_POST['_sf_expiration_date']) && $_POST['_sf_expiration_date']) {
        $dt = DateTime::createFromFormat("Y-m-d", sanitize_text_field( $_POST['_sf_expiration_date'] ));

        $errors = $dt::getLastErrors();

        if ($dt !== false && !array_sum( (array) $errors )) {
          $expiration_date = $dt;
        }
      }

      $main_date = '';

      if (isset($_POST['_sf_main_date']) && $_POST['_sf_main_date']) {
        $dt = DateTime::createFromFormat("Y-m-d", sanitize_text_field($_POST['_sf_main_date']));

        $errors = $dt::getLastErrors();

        if ($dt !== false && !array_sum( (array) $errors )) {
          $main_date = $dt;
        }
      }

      $not_public = '';

      if ( isset($_POST['_sf_not_public']) && $_POST['_sf_not_public'] ) {
        $not_public = 1;
      }

      update_post_meta($id, '_sf_not_public', $not_public);

      update_post_meta($id, '_sf_limit_downloads', $limit_downloads);
      update_post_meta($id, '_sf_expiration_date', $expiration_date);
      update_post_meta($id, '_sf_main_date', $main_date);



      $custom_fields_free = 1;

      if ( $custom_fields_free ) {

        if (isset($_POST['_sf_file_upload_cf_1']) && $_POST['_sf_file_upload_cf_1']) {
          update_post_meta($id, '_sf_file_upload_cf_1', sanitize_text_field( $_POST['_sf_file_upload_cf_1'] ));
        }

      }

      if (isset($_POST['_sf_description']) && $_POST['_sf_description']) {

        if (isset($s['textarea_for_file_description']) && $s['textarea_for_file_description']) {
          $description = strip_tags($_POST['_sf_description']);
          update_post_meta($id, '_sf_description', $description);
        } else {
          $description = balanceTags(wp_kses_post($_POST['_sf_description']), 1);
          update_post_meta($id, '_sf_description', $description);
        }

      } else {
        update_post_meta($id, '_sf_description', '');
      }

      $custom_filename = '';

      if ( isset($_POST['_sf_filename']) && $_POST['_sf_filename'] ) {
        $custom_filename = sanitize_text_field( $_POST['_sf_filename'] );
        update_post_meta($id, '_sf_filename', $custom_filename );
      }

      if (isset($_POST['_sf_external_url']) && $_POST['_sf_external_url']) {

        $external_url = esc_url_raw($_POST['_sf_external_url']);
        update_post_meta($id, '_sf_external_url', $external_url);

        $filename = basename($external_url);
        update_post_meta($id, '_sf_filename', sanitize_text_field( $filename ));
        update_post_meta($id, '_sf_load_cnt', 0);
        update_post_meta($id, '_sf_bandwidth_usage', 0);
        update_post_meta($id, '_sf_file_added', current_time('Y-m-d H:i:s'));

      } elseif (isset($_FILES['_sf_file']['name']) && isset($_FILES['_sf_file']['tmp_name']) && $tmp_name = $_FILES['_sf_file']['tmp_name']) {

        $basename = sanitize_file_name( basename( $_FILES['_sf_file']['name'] ) );
        $checked_mime_type = SharedFilesAdminAllowMoreFileTypes::allowed_mime_types( $tmp_name, $basename );

        if ( !$checked_mime_type[0] ) {
          $error_msg = sanitize_text_field( __('Error: file mime type is not allowed', 'shared-files') );
          $error_msg .= '<br /><br />';
          $error_msg .= sanitize_text_field( __('Detected mime type:', 'shared-files') . ' ' . $checked_mime_type[1] );
          wp_die( wp_kses_post( $error_msg ) );
        }

        // Get the file type of the upload
        $arr_file_type = wp_check_filetype(basename($_FILES['_sf_file']['name']));
        $uploaded_type = $arr_file_type['type'];
        $filename_for_custom_field = basename( $_FILES['_sf_file']['name'] );

        $file_contents_sanitized = SharedFilesAdminAllowMoreFileTypes::sanitize_file( $tmp_name );

        add_filter('upload_dir', [ $this, 'set_upload_dir' ]);
        add_filter('upload_mimes', [ 'SharedFilesAdminAllowMoreFileTypes', 'add_file_types' ] );

        // Use the WordPress API to upload the file
        $upload = wp_upload_bits($_FILES['_sf_file']['name'], null, $file_contents_sanitized);

        remove_filter('upload_mimes', [ 'SharedFilesAdminAllowMoreFileTypes', 'add_file_types' ] );
        remove_filter('upload_dir', [ $this, 'set_upload_dir' ]);

        if ($upload['error']) {
          wp_die( esc_html( $upload['error'] ) );
        }

        if (isset($upload['error']) && $upload['error'] != 0) {

          wp_die('There was an error uploading your file. The error is: ' . esc_html( $upload['error'] ) );

        } else {

          add_post_meta($id, '_sf_file', $upload);
          update_post_meta($id, '_sf_file', $upload);

          $filename = $filename_for_custom_field;

          update_post_meta($id, '_sf_filename', sanitize_text_field( $filename ));

          $sf_file_size = 0;
          $upload_file = '';

          if ( isset($_FILES['_sf_file']['size']) && $_FILES['_sf_file']['size'] ) {
            $sf_file_size = sanitize_text_field( $_FILES['_sf_file']['size'] );
          }

          if ( isset($upload['file']) && $upload['file'] ) {
            $upload_file = sanitize_text_field( $upload['file'] );
          }

          SharedFilesFileUpdate::uFilesize($id, $sf_file_size, $upload_file);

          update_post_meta($id, '_sf_load_cnt', 0);
          update_post_meta($id, '_sf_bandwidth_usage', 0);
          update_post_meta($id, '_sf_file_added', current_time('Y-m-d H:i:s'));

          if (isset($s['folder_for_new_files']) && $s['folder_for_new_files']) {

            $folder_for_new_files = sanitize_file_name( $s['folder_for_new_files'] );

            if ($folder_for_new_files) {
              update_post_meta($id, '_sf_subdir', rtrim( $folder_for_new_files, '/' ));
            }

          }

          SharedFilesHelpers::addFeaturedImage($id, $upload, $uploaded_type, $filename, 1);

          $post_title = '';

          if (isset($_POST['post_title'])) {
            $post_title = sanitize_text_field( $_POST['post_title'] );
          }

          if (!$post_title) {

            $my_post = array(
              'ID'           => intval( $id ),
              'post_title'   => sanitize_text_field( $filename ),
            );

            remove_action('save_post', [ $this, 'save_custom_meta_data' ]);
            wp_update_post($my_post);
            add_action('save_post', [ $this, 'save_custom_meta_data' ]);

          } else {

            $my_post = array(
              'ID'           => intval( $id ),
              'post_name'    => intval( $id ),
            );

            remove_action('save_post', [ $this, 'save_custom_meta_data' ]);
            wp_update_post($my_post);
            add_action('save_post', [ $this, 'save_custom_meta_data' ]);

          }
        }
      }
    }
  }

  /**
   * Set the custom upload directory.
   *
   * @since    1.0.0
   */
  public function set_upload_dir($dir) {

    $s = get_option('shared_files_settings');

    $full_path_default = realpath( $dir['basedir'] ) . '/shared-files';

    $folder_for_new_files = '';

    if (isset($s['folder_for_new_files']) && $s['folder_for_new_files']) {

      $folder_for_new_files = '/' . sanitize_file_name($s['folder_for_new_files']);

      $full_path_new = realpath( $dir['basedir'] ) . '/shared-files' . $folder_for_new_files;

      if ( !file_exists( $full_path_new ) ) {
        mkdir( $full_path_new );
      }

    } elseif ( !file_exists( $full_path_default ) ) {

      mkdir( $full_path_default );

    }

    return array(
      'path'   => realpath( $dir['basedir'] ) . '/shared-files' . $folder_for_new_files,
      'url'    => $dir['baseurl'] . '/shared-files' . $folder_for_new_files,
      'subdir' => '/shared-files' . $folder_for_new_files,
    ) + $dir;

  }

}