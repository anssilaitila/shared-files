<?php

class SharedFilesSettingsTabCustomPostType {
    public function init() {
        $tabs = new SharedFilesSettingsTabs();
        $field_render = new SharedFilesSettingsFieldRender();
        $only_pro = '_FREE_';
        $s = get_option( 'shared_files_settings' );
        $tab = 14;
        add_settings_section(
            'shared-files_tab_' . $tab,
            '',
            array($tabs, 'shared_files_settings_tab_' . $tab . '_callback'),
            'shared-files'
        );
        if ( SharedFilesHelpers::isMin2() ) {
            add_settings_field(
                'shared-files-' . $only_pro . 'enable_single_contact_page',
                sanitize_text_field( __( 'Enable single file page', 'shared-files' ) ),
                array($field_render, 'checkbox_render'),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                    'label_for'  => 'shared-files-' . $only_pro . 'enable_single_file_page',
                    'field_name' => $only_pro . 'enable_single_file_page',
                )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'show_files_in_site_search_results',
                sanitize_text_field( __( 'Show files in site search results', 'shared-files' ) ),
                array($field_render, 'checkbox_render'),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                    'label_for'  => 'shared-files-' . $only_pro . 'show_files_in_site_search_results',
                    'field_name' => $only_pro . 'show_files_in_site_search_results',
                )
            );
        }
        add_settings_field(
            'shared-files-tag_slug',
            sanitize_text_field( __( 'Tag taxonomy', 'shared-files' ) ),
            array($field_render, 'tag_slug_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'  => 'shared-files-tag_slug',
                'field_name' => 'tag_slug',
            )
        );
    }

}
