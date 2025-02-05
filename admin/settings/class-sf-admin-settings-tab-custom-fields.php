<?php

class SharedFilesSettingsTab4Content {
    public function init() {
        $tabs = new SharedFilesSettingsTabs();
        $field_render = new SharedFilesSettingsFieldRender();
        $only_pro = '_FREE_';
        $s = get_option( 'shared_files_settings' );
        // settings.scss
        $tab = 4;
        add_settings_section(
            'shared-files_tab_' . $tab,
            '',
            array($tabs, 'shared_files_settings_tab_' . $tab . '_callback'),
            'shared-files'
        );
        $custom_fields_cnt = 3 + 1;
        for ($n = 1; $n < $custom_fields_cnt; $n++) {
            if ( $n == 1 ) {
                add_settings_field(
                    'shared-files-file_upload_custom_field_' . $n,
                    sanitize_text_field( __( 'Custom field', 'shared-files' ) ) . ' ' . $n,
                    array($field_render, 'input_render'),
                    'shared-files',
                    'shared-files_tab_' . $tab,
                    array(
                        'label_for'   => 'shared-files-file_upload_custom_field_' . $n,
                        'field_name'  => 'file_upload_custom_field_' . $n,
                        'placeholder' => '',
                    )
                );
            } else {
                add_settings_field(
                    'shared-files-' . $only_pro . 'file_upload_custom_field_' . $n,
                    sanitize_text_field( __( 'Custom field', 'shared-files' ) ) . ' ' . $n,
                    array($field_render, 'input_render'),
                    'shared-files',
                    'shared-files_tab_' . $tab,
                    array(
                        'label_for'   => 'shared-files-' . $only_pro . 'file_upload_custom_field_' . $n,
                        'field_name'  => $only_pro . 'file_upload_custom_field_' . $n,
                        'placeholder' => '',
                        'class'       => 'shared-files-border-top',
                    )
                );
            }
            if ( SharedFilesHelpers::isMin2Pr() ) {
                add_settings_field(
                    'shared-files-' . $only_pro . 'cf_' . $n . '_use_as_search_filter',
                    sanitize_text_field( __( 'Use as search filter', 'shared-files' ) ),
                    array($field_render, 'checkbox_render'),
                    'shared-files',
                    'shared-files_tab_' . $tab,
                    array(
                        'label_for'  => 'shared-files-' . $only_pro . 'cf_' . $n . '_use_as_search_filter',
                        'field_name' => $only_pro . 'cf_' . $n . '_use_as_search_filter',
                    )
                );
                add_settings_field(
                    'shared-files-' . $only_pro . 'cf_' . $n . '_select_title',
                    sanitize_text_field( __( 'Search filter title', 'shared-files' ) ),
                    array($field_render, 'input_render'),
                    'shared-files',
                    'shared-files_tab_' . $tab,
                    array(
                        'label_for'  => 'shared-files-' . $only_pro . 'cf_' . $n . '_select_title',
                        'field_name' => $only_pro . 'cf_' . $n . '_select_title',
                    )
                );
            }
            add_settings_field(
                'shared-files-' . $only_pro . 'cf_' . $n . '_hide_from_frontend_uploader',
                sanitize_text_field( __( 'Hide from front-end uploader', 'shared-files' ) ),
                array($field_render, 'checkbox_render'),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                    'label_for'  => 'shared-files-' . $only_pro . 'cf_' . $n . '_hide_from_frontend_uploader',
                    'field_name' => $only_pro . 'cf_' . $n . '_hide_from_frontend_uploader',
                )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'cf_' . $n . '_hide_from_admin_edit',
                sanitize_text_field( __( 'Hide from admin edit view', 'shared-files' ) ),
                array($field_render, 'checkbox_render'),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                    'label_for'  => 'shared-files-' . $only_pro . 'cf_' . $n . '_hide_from_admin_edit',
                    'field_name' => $only_pro . 'cf_' . $n . '_hide_from_admin_edit',
                    'class'      => 'shared-files-padding-bottom',
                )
            );
        }
        add_settings_field(
            'shared-files-' . $only_pro . 'custom_fields_cnt',
            sanitize_text_field( __( 'Number of custom fields', 'shared-files' ) ),
            array($field_render, 'custom_fields_cnt_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'   => 'shared-files-' . $only_pro . 'custom_fields_cnt',
                'field_name'  => $only_pro . 'custom_fields_cnt',
                'placeholder' => '',
                'class'       => 'shared-files-border-top',
            )
        );
    }

}
