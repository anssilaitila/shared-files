<?php

class SharedFilesSettingsTabLeadGeneration {

  public function init() {

    $tabs = new SharedFilesSettingsTabs();
    $field_render = new SharedFilesSettingsFieldRender();

    $only_pro = '_FREE_';

    $s = get_option('shared_files_settings');

    $tab = 15;

    add_settings_section(
      'shared-files_tab_' . $tab,
      '',
      array($tabs, 'shared_files_settings_tab_' . $tab . '_callback'),
      'shared-files'
    );

    add_settings_field(
      'shared-files-lead_form_title',
      sanitize_text_field( __('Title above the form', 'shared-files') ),
      array($field_render, 'input_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-lead_form_title', 'field_name' => 'lead_form_title', 'placeholder' => sanitize_text_field( __('Please enter the following information to see the file(s):', 'shared-files') ))
    );

    add_settings_field(
      'shared-files-lead_form_description',
      sanitize_text_field( __('Description after the title', 'shared-files') ),
      array($field_render, 'textarea_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-lead_form_description', 'field_name' => 'lead_form_description', 'placeholder' => '')
    );

    add_settings_field(
      'shared-files-lead_show_name',
      sanitize_text_field( __('Show name', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-lead_show_name', 'field_name' => 'lead_show_name')
    );

    add_settings_field(
      'shared-files-lead_name_title',
      sanitize_text_field( __('Title for name', 'shared-files') ),
      array($field_render, 'input_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-lead_name_title', 'field_name' => 'lead_name_title', 'placeholder' => sanitize_text_field( __('Name', 'shared-files') ))
    );

    add_settings_field(
      'shared-files-lead_hide_email',
      sanitize_text_field( __('Hide email', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-lead_hide_email', 'field_name' => 'lead_hide_email')
    );

    add_settings_field(
      'shared-files-lead_email_title',
      sanitize_text_field( __('Title for email', 'shared-files') ),
      array($field_render, 'input_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-lead_email_title', 'field_name' => 'lead_email_title', 'placeholder' => sanitize_text_field( __('Email', 'shared-files') ))
    );

    add_settings_field(
      'shared-files-lead_show_phone',
      sanitize_text_field( __('Show phone', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-lead_show_phone', 'field_name' => 'lead_show_phone')
    );

    add_settings_field(
      'shared-files-lead_phone_title',
      sanitize_text_field( __('Title for phone', 'shared-files') ),
      array($field_render, 'input_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-lead_phone_title', 'field_name' => 'lead_phone_title', 'placeholder' => sanitize_text_field( __('Phone', 'shared-files') ))
    );

    add_settings_field(
      'shared-files-lead_show_description',
      sanitize_text_field( __('Show description', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-lead_show_description', 'field_name' => 'lead_show_description')
    );

    add_settings_field(
      'shared-files-lead_description_title',
      sanitize_text_field( __('Title for description', 'shared-files') ),
      array($field_render, 'input_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-lead_description_title', 'field_name' => 'lead_description_title', 'placeholder' => sanitize_text_field( __('Description', 'shared-files') ))
    );

  }

}