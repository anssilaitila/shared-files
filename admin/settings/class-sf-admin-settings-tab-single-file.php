<?php

class SharedFilesSettingsTabSingleFile {
    public function init( $slug ) {
        $tabs = new SharedFilesSettingsTabs();
        $field_render = new SharedFilesSettingsFieldRender();
        $only_pro = '_FREE_';
        $s = get_option( 'shared_files_settings' );
        $tab = 16;
        $tab = $slug;
        $tab_underscore = str_replace( '-', '_', $slug );
        add_settings_section(
            'shared-files_tab_' . $tab,
            '',
            array($tabs, 'shared_files_settings_tab_' . $tab_underscore . '_callback'),
            'shared-files'
        );
        $single_file_free = 1;
        if ( $single_file_free ) {
            add_settings_field(
                'shared-files-' . $only_pro . 'single_file_show_custom_fields',
                sanitize_text_field( __( 'Show custom fields', 'shared-files' ) ),
                array($field_render, 'checkbox_render'),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                    'label_for'  => 'shared-files-' . $only_pro . 'single_file_show_custom_fields',
                    'field_name' => $only_pro . 'single_file_show_custom_fields',
                )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'single_file_show_description',
                sanitize_text_field( __( 'Show description', 'shared-files' ) ),
                array($field_render, 'checkbox_render'),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                    'label_for'  => 'shared-files-' . $only_pro . 'single_file_show_description',
                    'field_name' => $only_pro . 'single_file_show_description',
                )
            );
        }
    }

}
