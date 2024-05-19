<?php

class SharedFilesSettingsTabSimpleList {
    public function init() {
        $tabs = new SharedFilesSettingsTabs();
        $field_render = new SharedFilesSettingsFieldRender();
        $only_pro = '_FREE_';
        $s = get_option( 'shared_files_settings' );
        $tab = 13;
        add_settings_section(
            'shared-files_tab_' . $tab,
            '',
            array($tabs, 'shared_files_settings_tab_' . $tab . '_callback'),
            'shared-files'
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'simple_list_show_search_filters',
            sanitize_text_field( __( 'Show search filters', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'  => 'shared-files-' . $only_pro . 'simple_list_show_search_filters',
                'field_name' => $only_pro . 'simple_list_show_search_filters',
            )
        );
        add_settings_field(
            'shared-files-simple_list_show_titles_for_columns',
            sanitize_text_field( __( 'Show titles for columns', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'  => 'shared-files-simple_list_show_titles_for_columns',
                'field_name' => 'simple_list_show_titles_for_columns',
            )
        );
        add_settings_field(
            'shared-files-simple_list_hide_file_description',
            sanitize_text_field( __( 'Hide file description', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'  => 'shared-files-simple_list_hide_file_description',
                'field_name' => 'simple_list_hide_file_description',
            )
        );
        add_settings_field(
            'shared-files-simple_list_title_file',
            sanitize_text_field( __( 'Title for file column', 'shared-files' ) ),
            array($field_render, 'input_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'  => 'shared-files-simple_list_title_file',
                'field_name' => 'simple_list_title_file',
            )
        );
        add_settings_field(
            'shared-files-simple_list_show_download_counter',
            sanitize_text_field( __( 'Show download counter', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'  => 'shared-files-simple_list_show_download_counter',
                'field_name' => 'simple_list_show_download_counter',
            )
        );
        add_settings_field(
            'shared-files-simple_list_title_download_counter',
            sanitize_text_field( __( 'Title for download counter', 'shared-files' ) ),
            array($field_render, 'input_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'   => 'shared-files-simple_list_title_download_counter',
                'field_name'  => 'simple_list_title_download_counter',
                'placeholder' => sanitize_text_field( __( 'Downloads', 'shared-files' ) ),
            )
        );
        $custom_fields_cnt = 3 + 1;
        for ($n = 1; $n < $custom_fields_cnt; $n++) {
            add_settings_field(
                'shared-files-' . $only_pro . 'simple_list_show_custom_field_' . $n,
                sanitize_text_field( __( 'Show custom field', 'shared-files' ) . ' ' . $n ),
                array($field_render, 'checkbox_render'),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                    'label_for'  => 'shared-files-' . $only_pro . 'simple_list_show_custom_field_' . $n,
                    'field_name' => $only_pro . 'simple_list_show_custom_field_' . $n,
                )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'simple_list_title_custom_field_' . $n,
                sanitize_text_field( __( 'Title for custom field', 'shared-files' ) . ' ' . $n ),
                array($field_render, 'input_render'),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                    'label_for'  => 'shared-files-' . $only_pro . 'simple_list_title_custom_field_' . $n,
                    'field_name' => $only_pro . 'simple_list_title_custom_field_' . $n,
                )
            );
        }
        add_settings_field(
            'shared-files-' . $only_pro . 'simple_list_show_category',
            sanitize_text_field( __( 'Show category', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'  => 'shared-files-' . $only_pro . 'simple_list_show_category',
                'field_name' => $only_pro . 'simple_list_show_category',
            )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'simple_list_title_category',
            sanitize_text_field( __( 'Title for category column', 'shared-files' ) ),
            array($field_render, 'input_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'  => 'shared-files-' . $only_pro . 'simple_list_title_category',
                'field_name' => $only_pro . 'simple_list_title_category',
            )
        );
        add_settings_field(
            'shared-files-simple_list_show_tag',
            sanitize_text_field( __( 'Show tag', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'  => 'shared-files-simple_list_show_tag',
                'field_name' => 'simple_list_show_tag',
            )
        );
        add_settings_field(
            'shared-files-simple_list_title_tag',
            sanitize_text_field( __( 'Title for tag column', 'shared-files' ) ),
            array($field_render, 'input_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'   => 'shared-files-simple_list_title_tag',
                'field_name'  => 'simple_list_title_tag',
                'placeholder' => sanitize_text_field( __( 'Tag', 'shared-files' ) ),
            )
        );
    }

}
