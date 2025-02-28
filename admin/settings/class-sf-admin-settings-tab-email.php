<?php

class SharedFilesSettingsTabEmail {

  public function init() {

    $tabs = new SharedFilesSettingsTabs();
    $field_render = new SharedFilesSettingsFieldRender();

    $only_pro = '_FREE_';

    $s = get_option('shared_files_settings');

    $tab = 8;

    add_settings_section(
      'shared-files_tab_' . $tab,
      '',
      array($tabs, 'shared_files_settings_tab_' . $tab . '_callback'),
      'shared-files'
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'send_email',
      sanitize_text_field( __('Send an email notify when a file is downloaded', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'send_email', 'field_name' => $only_pro . 'send_email')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'send_file_uploaded_email_to_users',
      sanitize_text_field( __('Send an email notify to users when a file is uploaded (files with restricted permissions)', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'send_file_uploaded_email_to_users', 'field_name' => $only_pro . 'send_file_uploaded_email_to_users')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'trigger_download_email',
      sanitize_text_field( __('Trigger file downloaded email on', 'shared-files') ),
      array($field_render, 'trigger_download_email_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'trigger_download_email', 'field_name' => $only_pro . 'trigger_download_email')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'add_ip_to_file_downloaded_email',
      sanitize_text_field( __("Add the downloader's IP address to the email", 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'add_ip_to_file_downloaded_email', 'field_name' => $only_pro . 'add_ip_to_file_downloaded_email')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'send_email_on_file_activation',
      sanitize_text_field( __('Send an email notify when a file is automatically activated for a category', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'send_email_on_file_activation', 'field_name' => $only_pro . 'send_email_on_file_activation')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'recipient_email',
      sanitize_text_field( __('Notification recipient email', 'shared-files') ),
      array($field_render, 'input_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'recipient_email', 'field_name' => $only_pro . 'recipient_email', 'placeholder' => '')
    );


  }

}