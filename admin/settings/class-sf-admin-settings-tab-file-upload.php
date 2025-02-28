<?php

class SharedFilesSettingsTab5Content {

  public function init() {

    $tabs = new SharedFilesSettingsTabs();
    $field_render = new SharedFilesSettingsFieldRender();

    $only_pro = '_FREE_';

    $s = get_option('shared_files_settings');

    $tab = 5;

    add_settings_section(
      'shared-files_tab_' . $tab,
      '',
      array($tabs, 'shared_files_settings_tab_' . $tab . '_callback'),
      'shared-files'
    );

    add_settings_field(
      'shared-files-file_upload_disable_progress_bar',
      sanitize_text_field( __('Disable progress bar / ajax upload', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-file_upload_disable_progress_bar', 'field_name' => 'file_upload_disable_progress_bar')
    );

    add_settings_field(
      'shared-files-only_logged_in_users_can_add_files',
      sanitize_text_field( __('Only logged in users can add files', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-only_logged_in_users_can_add_files', 'field_name' => 'only_logged_in_users_can_add_files')
    );

    add_settings_field(
      'shared-files-file_upload_show_delete_button',
      sanitize_text_field( __("Show Delete button for logged in user's own files", 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-file_upload_show_delete_button', 'field_name' => 'file_upload_show_delete_button')
    );

    add_settings_field(
      'shared-files-file_upload_set_to_pending',
      sanitize_text_field( __('Set the status of uploaded files to "Pending Review"', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-file_upload_set_to_pending', 'field_name' =>  'file_upload_set_to_pending')
    );

    add_settings_field(
      'shared-files-hide_file_uploader_info',
      sanitize_text_field( __('Hide file uploader info', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-hide_file_uploader_info', 'field_name' => 'hide_file_uploader_info')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'uncheck_hide_from_other_pages',
      sanitize_text_field( __('Uncheck "Hide from other pages" for uploaded files', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-uncheck_hide_from_other_pages', 'field_name' => 'uncheck_hide_from_other_pages')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'file_upload_restrict_file_types',
      sanitize_text_field( __('Restrict accepted file types', 'shared-files') ),
      array($field_render, 'restrict_file_types_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'file_upload_restrict_file_types', 'field_name' => $only_pro . 'file_upload_restrict_file_types', 'placeholder' => '')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'file_upload_restrict_file_extensions',
      sanitize_text_field( __('Restrict accepted file extensions', 'shared-files') ),
      array($field_render, 'input_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'file_upload_restrict_file_extensions', 'field_name' => $only_pro . 'file_upload_restrict_file_extensions', 'placeholder' => '.gif, .jpg, .png, .doc', 'class' => 'shared-files-padding-bottom')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'file_upload_file_not_required',
      sanitize_text_field( __('File field optional', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'file_upload_file_not_required', 'field_name' => $only_pro . 'file_upload_file_not_required', 'placeholder' => '', 'class' => 'shared-files-border-top')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'file_upload_allow_featured_image',
      sanitize_text_field( __('Enable featured image (a separate file can be added)', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'file_upload_allow_featured_image', 'field_name' => $only_pro . 'file_upload_allow_featured_image')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'file_upload_show_external_url',
      sanitize_text_field( __('Show External URL', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'file_upload_show_external_url', 'field_name' => $only_pro . 'file_upload_show_external_url')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'file_upload_external_url_title',
      sanitize_text_field( __('Text for External URL', 'shared-files') ),
      array($field_render, 'input_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'file_upload_external_url_title', 'field_name' => $only_pro . 'file_upload_external_url_title', 'placeholder' => sanitize_text_field( __('Or enter a YouTube URL:', 'shared-files') ) )
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'file_upload_enable_restrict_access_for_users',
      sanitize_text_field( __('Restrict access for users (logged in users only)', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'file_upload_enable_restrict_access_for_users', 'field_name' => $only_pro . 'file_upload_enable_restrict_access_for_users')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'file_upload_enable_restrict_access_for_roles',
      sanitize_text_field( __('Restrict access for roles (logged in users only)', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'file_upload_enable_restrict_access_for_roles', 'field_name' => $only_pro . 'file_upload_enable_restrict_access_for_roles')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'file_upload_category_required',
      sanitize_text_field( __('Category selection required', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'file_upload_category_required', 'field_name' => $only_pro . 'file_upload_category_required')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'show_category_checkboxes_on_file_upload',
      sanitize_text_field( __('Show category checkboxes instead of a dropdown', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'show_category_checkboxes_on_file_upload', 'field_name' => $only_pro . 'show_category_checkboxes_on_file_upload')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'file_upload_new_category',
      sanitize_text_field( __('Allow the uploader to create a single new category', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'file_upload_new_category', 'field_name' => $only_pro . 'file_upload_new_category')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'file_upload_multiple_new_categories',
      sanitize_text_field( __('Allow the uploader to create multiple new categories', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'file_upload_multiple_new_categories', 'field_name' => $only_pro . 'file_upload_multiple_new_categories')
    );

    add_settings_field(
      'shared-files-show_tag_dropdown_on_file_upload',
      sanitize_text_field( __('Show tag dropdown', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-show_tag_dropdown_on_file_upload', 'field_name' => 'show_tag_dropdown_on_file_upload')
    );

    add_settings_field(
      'shared-files-show_tag_checkboxes_on_file_upload',
      sanitize_text_field( __('Show tag checkboxes', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-show_tag_checkboxes_on_file_upload', 'field_name' => 'show_tag_checkboxes_on_file_upload')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'file_upload_multiple_new_tags',
      sanitize_text_field( __('Allow the uploader to create multiple new tags', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'file_upload_multiple_new_tags', 'field_name' => $only_pro . 'file_upload_multiple_new_tags')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'show_file_upload_checkboxes_on_multiple_columns',
      sanitize_text_field( __('Show category and tag checkboxes on multiple columns', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'show_file_upload_checkboxes_on_multiple_columns', 'field_name' => $only_pro . 'show_file_upload_checkboxes_on_multiple_columns')
    );

    add_settings_field(
      'shared-files-file_upload_title_required',
      sanitize_text_field( __('File title required', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-file_upload_title_required', 'field_name' => 'file_upload_title_required')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'file_upload_password',
      sanitize_text_field( __('Allow the uploader to define a password for the file', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'file_upload_password', 'field_name' => $only_pro . 'file_upload_password', 'placeholder' => '')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'file_upload_show_expiration_date',
      sanitize_text_field( __('Show Expiration date', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'file_upload_show_expiration_date', 'field_name' => $only_pro . 'file_upload_show_expiration_date')
    );

    add_settings_field(
      'shared-files-file_upload_description_required',
      sanitize_text_field( __('Description required', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-file_upload_description_required', 'field_name' => 'file_upload_description_required')
    );

    add_settings_field(
      'shared-files-file_upload_hide_description',
      sanitize_text_field( __('Hide description', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-file_upload_hide_description', 'field_name' => 'file_upload_hide_description', 'class' => 'shared-files-padding-bottom')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'file_upload_send_email',
      sanitize_text_field( __('Send an email notify when a file is uploaded and / or send an email to all users having one of the roles below:', 'shared-files') ),
      array($field_render, 'input_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'file_upload_send_email', 'field_name' => $only_pro . 'file_upload_send_email', 'placeholder' => '', 'class' => 'shared-files-border-top')
    );

    global $wp_roles;

    $roles = $wp_roles->get_names();

    foreach ($roles as $key => $value) {

      if ($key && $value) {
        add_settings_field(
          'shared-files-' . $only_pro . 'notify_on_file_upload_' . $key,
          $value,
          array($field_render, 'checkbox_render'),
          'shared-files',
          'shared-files_tab_' . $tab,
          array('label_for' => 'shared-files-' . $only_pro . 'notify_on_file_upload_' . $key, 'field_name' => $only_pro . 'notify_on_file_upload_' . $key, 'placeholder' => '')
        );
      }

    }

  }

}