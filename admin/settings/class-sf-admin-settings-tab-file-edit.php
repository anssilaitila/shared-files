<?php

class SharedFilesSettingsTabFileEdit {
    public function init() {
        $tabs = new SharedFilesSettingsTabs();
        $field_render = new SharedFilesSettingsFieldRender();
        $only_pro = '_FREE_';
        $s = get_option( 'shared_files_settings' );
        $tab = 10;
        add_settings_section(
            'shared-files_tab_' . $tab,
            '',
            array($tabs, 'shared_files_settings_tab_' . $tab . '_callback'),
            'shared-files'
        );
        global $wp_roles;
        $roles = $wp_roles->get_names();
        foreach ( $roles as $key => $value ) {
            if ( $key && $value ) {
                add_settings_field(
                    'shared-files-' . $only_pro . 'can_edit_files_' . $key,
                    $value,
                    array($field_render, 'checkbox_render'),
                    'shared-files',
                    'shared-files_tab_' . $tab,
                    array(
                        'label_for'   => 'shared-files-' . $only_pro . 'can_edit_files_' . $key,
                        'field_name'  => $only_pro . 'can_edit_files_' . $key,
                        'placeholder' => '',
                    )
                );
            }
        }
        if ( SharedFilesHelpers::isMin2() ) {
            add_settings_section(
                'shared-files_tab_10_2',
                '',
                array($tabs, 'shared_files_settings_tab_10_2_callback'),
                'shared-files'
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'file_edit_hide_external_url',
                sanitize_text_field( __( 'Hide external URL', 'shared-files' ) ),
                array($field_render, 'checkbox_render'),
                'shared-files',
                'shared-files_tab_10_2',
                array(
                    'label_for'  => 'shared-files-' . $only_pro . 'file_edit_hide_external_url',
                    'field_name' => $only_pro . 'file_edit_hide_external_url',
                )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'file_edit_hide_category_checkboxes',
                sanitize_text_field( __( 'Hide category checkboxes', 'shared-files' ) ),
                array($field_render, 'checkbox_render'),
                'shared-files',
                'shared-files_tab_10_2',
                array(
                    'label_for'  => 'shared-files-' . $only_pro . 'file_edit_hide_category_checkboxes',
                    'field_name' => $only_pro . 'file_edit_hide_category_checkboxes',
                )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'file_edit_hide_new_categories',
                sanitize_text_field( __( 'Hide new category input', 'shared-files' ) ),
                array($field_render, 'checkbox_render'),
                'shared-files',
                'shared-files_tab_10_2',
                array(
                    'label_for'  => 'shared-files-' . $only_pro . 'file_edit_hide_new_categories',
                    'field_name' => $only_pro . 'file_edit_hide_new_categories',
                )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'file_edit_hide_tag_checkboxes',
                sanitize_text_field( __( 'Hide tag checkboxes', 'shared-files' ) ),
                array($field_render, 'checkbox_render'),
                'shared-files',
                'shared-files_tab_10_2',
                array(
                    'label_for'  => 'shared-files-' . $only_pro . 'file_edit_hide_tag_checkboxes',
                    'field_name' => $only_pro . 'file_edit_hide_tag_checkboxes',
                )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'file_edit_hide_new_tags',
                sanitize_text_field( __( 'Hide new tag input', 'shared-files' ) ),
                array($field_render, 'checkbox_render'),
                'shared-files',
                'shared-files_tab_10_2',
                array(
                    'label_for'  => 'shared-files-' . $only_pro . 'file_edit_hide_new_tags',
                    'field_name' => $only_pro . 'file_edit_hide_new_tags',
                )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'file_edit_hide_description',
                sanitize_text_field( __( 'Hide description', 'shared-files' ) ),
                array($field_render, 'checkbox_render'),
                'shared-files',
                'shared-files_tab_10_2',
                array(
                    'label_for'  => 'shared-files-' . $only_pro . 'file_edit_hide_description',
                    'field_name' => $only_pro . 'file_edit_hide_description',
                )
            );
        }
    }

}
