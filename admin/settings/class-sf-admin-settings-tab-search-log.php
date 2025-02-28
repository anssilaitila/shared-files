<?php

class SharedFilesSettingsTabSearchLog {

  public function init( $slug ) {

    $tabs = new SharedFilesSettingsTabs();
    $field_render = new SharedFilesSettingsFieldRender();

    $only_pro = '_FREE_';

    $s = get_option('shared_files_settings');

    $tab = $slug;
    $tab_underscore = str_replace( '-', '_', $slug );

    add_settings_section(
      'shared-files_tab_' . $tab,
      '',
      array($tabs, 'shared_files_settings_tab_' . $tab_underscore . '_callback'),
      'shared-files'
    );

    // START

    add_settings_field(
      'shared-files-enable_search_log',
      sanitize_text_field( __('Enable search log', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-enable_search_log', 'field_name' => 'enable_search_log')
    );

    add_settings_field(
      'shared-files-esl_search_term',
      sanitize_text_field( __('Log search term', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-esl_search_term', 'field_name' => 'esl_search_term')
    );

    add_settings_field(
      'shared-files-esl_search_term_min_chars',
      sanitize_text_field( __('Min. characters to log', 'shared-files') ),
      array($field_render, 'input_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-esl_search_term_min_chars', 'field_name' =>  'esl_search_term_min_chars', 'placeholder' => '3')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'esl_user_ip',
      sanitize_text_field( __('Log user IP address', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'esl_user_ip', 'field_name' => $only_pro . 'esl_user_ip')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'esl_user_country',
      sanitize_text_field( __('Log user country', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'esl_user_country', 'field_name' => $only_pro . 'esl_user_country', 'class' => 'shared-files-new-feature')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'esl_user_city',
      sanitize_text_field( __('Log user city', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'esl_user_city', 'field_name' => $only_pro . 'esl_user_city', 'class' => 'shared-files-new-feature')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'esl_search_container',
      sanitize_text_field( __('Log search container (page / post information)', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'esl_search_container', 'field_name' => $only_pro . 'esl_search_container')
    );

    add_settings_field(
      'shared-files-esl_user_agent',
      sanitize_text_field( __('Log user agent (browser)', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-esl_user_agent', 'field_name' => 'esl_user_agent')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'esl_referer_url',
      sanitize_text_field( __('Log referer URL (full URL when searching)', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'esl_referer_url', 'field_name' => $only_pro . 'esl_referer_url')
    );

    // END

  }

}