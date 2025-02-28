<?php

class SharedFilesSettingsTabAdminList {

  public function init() {

    $tabs = new SharedFilesSettingsTabs();
    $field_render = new SharedFilesSettingsFieldRender();

    $only_pro = '_FREE_';

    $s = get_option('shared_files_settings');

    add_settings_section(
      'shared-files_section_admin_list',
      '',
      array($tabs, 'shared_files_settings_admin_list_section_callback'),
      'shared-files'
    );

    add_settings_field(
      'shared-files-hide_limit_downloads',
      sanitize_text_field( __('Hide "Limit downloads"-column', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_section_admin_list',
      array('label_for' => 'shared-files-hide_limit_downloads', 'field_name' => 'hide_limit_downloads')
    );

    add_settings_field(
      'shared-files-hide_file_added',
      sanitize_text_field( __('Hide "File added"-column', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_section_admin_list',
      array('label_for' => 'shared-files-hide_file_added', 'field_name' => 'hide_file_added')
    );

    add_settings_field(
      'shared-files-hide_last_access',
      sanitize_text_field( __('Hide "Last access"-column', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_section_admin_list',
      array('label_for' => 'shared-files-hide_last_access', 'field_name' => 'hide_last_access')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'hide_bandwidth_usage',
      sanitize_text_field( __('Hide "Bandwidth usage"-column', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_section_admin_list',
      array('label_for' => 'shared-files-' . $only_pro . 'hide_bandwidth_usage', 'field_name' => $only_pro . 'hide_bandwidth_usage')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'hide_expiration_date',
      sanitize_text_field( __('Hide "Expiration date"-column', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_section_admin_list',
      array('label_for' => 'shared-files-' . $only_pro . 'hide_expiration_date', 'field_name' => $only_pro . 'hide_expiration_date')
    );

  }

}