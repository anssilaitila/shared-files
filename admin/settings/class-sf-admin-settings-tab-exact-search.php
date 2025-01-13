<?php

class SharedFilesSettingsTabExactSearch {
    public function init( $slug ) {
        $tabs = new SharedFilesSettingsTabs();
        $field_render = new SharedFilesSettingsFieldRender();
        $only_pro = '_FREE_';
        $s = get_option( 'shared_files_settings' );
        $tab = $slug;
        $tab_underscore = str_replace( '-', '_', $slug );
        add_settings_section(
            'shared-files_tab_' . $tab,
            '',
            array($tabs, 'shared_files_settings_tab_' . $tab_underscore . '_callback'),
            'shared-files'
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'exact_search_min_chars',
            sanitize_text_field( __( 'Min. characters for search', 'shared-files' ) ),
            array($field_render, 'input_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'   => 'shared-files-' . $only_pro . 'exact_search_min_chars',
                'field_name'  => $only_pro . 'exact_search_min_chars',
                'placeholder' => 3,
            )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'exact_search_whole_words_only',
            sanitize_text_field( __( 'Search whole words only (default targets also partial text)', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'  => 'shared-files-' . $only_pro . 'exact_search_whole_words_only',
                'field_name' => $only_pro . 'exact_search_whole_words_only',
            )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'exact_search_ignore_file_extension',
            sanitize_text_field( __( 'Ignore file extension', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'  => 'shared-files-' . $only_pro . 'exact_search_ignore_file_extension',
                'field_name' => $only_pro . 'exact_search_ignore_file_extension',
            )
        );
        $tab = $slug . '_more';
        add_settings_section(
            'shared-files_tab_' . $tab,
            '',
            array($tabs, 'shared_files_settings_tab_' . $tab_underscore . '_more_callback'),
            'shared-files'
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'exact_search_more_fields',
            sanitize_text_field( __( 'Activate search for more fields (defined below)', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'  => 'shared-files-' . $only_pro . 'exact_search_more_fields',
                'field_name' => $only_pro . 'exact_search_more_fields',
            )
        );
        $custom_fields_cnt = 3 + 1;
        for ($n = 1; $n < $custom_fields_cnt; $n++) {
            add_settings_field(
                'shared-files-' . $only_pro . 'exact_search_custom_field_' . $n,
                sanitize_text_field( __( 'Custom field', 'shared-files' ) ) . ' ' . $n,
                array($field_render, 'checkbox_render'),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                    'label_for'  => 'shared-files-' . $only_pro . 'exact_search_custom_field_' . $n,
                    'field_name' => $only_pro . 'exact_search_custom_field_' . $n,
                )
            );
        }
    }

}
