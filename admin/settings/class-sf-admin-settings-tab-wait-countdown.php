<?php

class SharedFilesSettingsTabWaitCountdown {

  public function init() {

    $tabs = new SharedFilesSettingsTabs();
    $field_render = new SharedFilesSettingsFieldRender();

    $only_pro = '_FREE_';

    $s = get_option('shared_files_settings');

    $tab = 12;

    add_settings_section(
      'shared-files_tab_' . $tab,
      '',
      array($tabs, 'shared_files_settings_tab_' . $tab . '_callback'),
      'shared-files'
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'activate_wait_page',
      sanitize_text_field( __('Activate wait countdown page for all download links', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'activate_wait_page', 'field_name' => $only_pro . 'activate_wait_page')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'wait_page',
      sanitize_text_field( __('Wait countdown page', 'shared-files') ),
      array($field_render, 'wait_page_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'wait_page', 'field_name' => $only_pro . 'wait_page')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'wait_page_text_before_seconds',
      sanitize_text_field( __('Text before seconds', 'shared-files') ),
      array($field_render, 'input_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'wait_page_text_before_seconds', 'field_name' => $only_pro . 'wait_page_text_before_seconds', 'placeholder' => sanitize_text_field( __('Your download will start automatically in', 'shared-files') ) )
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'wait_page_countdown_seconds',
      sanitize_text_field( __('Countdown length in seconds', 'shared-files') ),
      array($field_render, 'input_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'wait_page_countdown_seconds', 'field_name' => $only_pro . 'wait_page_countdown_seconds', 'placeholder' => 5 )
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'wait_page_text_after_seconds',
      sanitize_text_field( __('Text after seconds', 'shared-files') ),
      array($field_render, 'input_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'wait_page_text_after_seconds', 'field_name' => $only_pro . 'wait_page_text_after_seconds', 'placeholder' => sanitize_text_field( __('seconds...', 'shared-files') ) )
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'wait_page_download_button_text',
      sanitize_text_field( __('Download button text', 'shared-files') ),
      array($field_render, 'input_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'wait_page_download_button_text', 'field_name' => $only_pro . 'wait_page_download_button_text', 'placeholder' => sanitize_text_field( __('Download', 'shared-files') ) )
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'wait_page_hide_download_button',
      sanitize_text_field( __('Hide download button', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'wait_page_hide_download_button', 'field_name' => $only_pro . 'wait_page_hide_download_button')
    );

  }

}