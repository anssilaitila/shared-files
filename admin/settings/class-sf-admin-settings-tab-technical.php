<?php

class SharedFilesSettingsTab2Content {

  public function init() {

    $tabs = new SharedFilesSettingsTabs();
    $field_render = new SharedFilesSettingsFieldRender();

    $only_pro = '_FREE_';

    $s = get_option('shared_files_settings');

    $tab = 2;

    add_settings_section(
      'shared-files_tab_' . $tab,
      '',
      array($tabs, 'shared_files_settings_tab_' . $tab . '_callback'),
      'shared-files'
    );

    add_settings_field(
      'shared-files-file_open_method',
      sanitize_text_field( __('File opening method', 'shared-files') ),
      array($field_render, 'file_open_method_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-file_open_method', 'field_name' => 'file_open_method')
    );

    add_settings_field(
      'shared-files-wp_engine_compatibility_mode',
      sanitize_text_field( __('Compatibility mode', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-wp_engine_compatibility_mode', 'field_name' => 'wp_engine_compatibility_mode')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'obfuscate_file_urls',
      sanitize_text_field( __('Obfuscate file urls', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'obfuscate_file_urls', 'field_name' => $only_pro . 'obfuscate_file_urls')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'file_sync_interval',
      sanitize_text_field( __('File & category sync interval', 'shared-files') ),
      array($field_render, 'file_sync_interval_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'file_sync_interval', 'field_name' => $only_pro . 'file_sync_interval')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'remove_obsolete_file_metadata_automatically',
      sanitize_text_field( __('Remove obsolete file metadata automatically', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'remove_obsolete_file_metadata_automatically', 'field_name' => $only_pro . 'remove_obsolete_file_metadata_automatically')
    );

    add_settings_field(
      'shared-files-bypass_file_exists_check',
      sanitize_text_field( __('Bypass the file exists check on frontend file list', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-bypass_file_exists_check', 'field_name' => 'bypass_file_exists_check')
    );

    add_settings_field(
      'shared-files-prevent_search_engines_from_indexing_uploaded_file_urls',
      sanitize_text_field( __('Prevent search engines from indexing files uploaded using front end uploader', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-prevent_search_engines_from_indexing_uploaded_file_urls', 'field_name' => 'prevent_search_engines_from_indexing_uploaded_file_urls')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'prevent_search_engines_from_indexing_file_urls',
      sanitize_text_field( __('Prevent search engines from indexing all file urls', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'prevent_search_engines_from_indexing_file_urls', 'field_name' => $only_pro . 'prevent_search_engines_from_indexing_file_urls')
    );

    add_settings_field(
      'shared-files-wp_location',
      sanitize_text_field( __('WordPress location', 'shared-files') ),
      array($field_render, 'input_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-wp_location', 'field_name' => 'wp_location', 'placeholder' => '/wp-folder/')
    );

    add_settings_field(
      'shared-files-pagination_type',
      sanitize_text_field( __('Pagination type', 'shared-files') ),
      array($field_render, 'pagination_type_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-pagination_type', 'field_name' => 'pagination_type')
    );

  }

}