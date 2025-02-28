<?php

class SharedFilesSettingsTabCustomIcons {

  public function init() {

    $tabs = new SharedFilesSettingsTabs();
    $field_render = new SharedFilesSettingsFieldRender();

    $only_pro = '_FREE_';

    $s = get_option('shared_files_settings');

    $tab = 7;

    add_settings_section(
      'shared-files_tab_' . $tab,
      '',
      array($tabs, 'shared_files_settings_tab_' . $tab . '_callback'),
      'shared-files'
    );

    $num = [1];

    foreach ($num as $n) {

      $field_title = __('Custom file type', 'shared-files') . ' ' . $n . ': ' . __('extension', 'shared-files');

      add_settings_field(
        'shared-files-custom_' . $n .'_ext',
        esc_html( $field_title ),
        array($field_render, 'input_render'),
        'shared-files',
        'shared-files_tab_' . $tab,
        array('label_for' => 'shared-files-custom_' . $n .'_ext', 'field_name' => 'custom_' . $n . '_ext', 'placeholder' => '', 'ext' => 1)
      );

      $field_title = __('Custom file type', 'shared-files') . ' ' . $n . ': ' . __('icon file', 'shared-files');

      add_settings_field(
        'shared-files-custom_' . $n .'_icon',
        esc_html( $field_title ),
        array($field_render, 'input_render'),
        'shared-files',
        'shared-files_tab_' . $tab,
        array('label_for' => 'shared-files-custom_' . $n .'_icon', 'field_name' => 'custom_' . $n . '_icon', 'placeholder' => '', 'wide' => 1)
      );

    }

    $num = [2, 3, 4, 5, 6];

    foreach ($num as $n) {

      $field_title = __('Custom file type', 'shared-files') . ' ' . $n . ': ' . __('extension', 'shared-files');

      add_settings_field(
        'shared-files-' . $only_pro . 'custom_' . $n .'_ext',
        esc_html( $field_title ),
        array($field_render, 'input_render'),
        'shared-files',
        'shared-files_tab_' . $tab,
        array('label_for' => 'shared-files-' . $only_pro . 'custom_' . $n .'_ext', 'field_name' => $only_pro . 'custom_' . $n . '_ext', 'placeholder' => '', 'ext' => 1)
      );

      $field_title = __('Custom file type', 'shared-files') . ' ' . $n . ': ' . __('icon file', 'shared-files');

      add_settings_field(
        'shared-files-' . $only_pro . 'custom_' . $n .'_icon',
        esc_html( $field_title ),
        array($field_render, 'input_render'),
        'shared-files',
        'shared-files_tab_' . $tab,
        array('label_for' => 'shared-files-' . $only_pro . 'custom_' . $n .'_icon', 'field_name' => $only_pro . 'custom_' . $n . '_icon', 'placeholder' => '', 'wide' => 1)
      );

    }

  }

}