<?php

class SharedFilesSettingsTabFileTypes {
    public function init() {
        $tabs = new SharedFilesSettingsTabs();
        $field_render = new SharedFilesSettingsFieldRender();
        $only_pro = '_FREE_';
        $s = get_option( 'shared_files_settings' );
        // settings.scss
        $tab = 51;
        add_settings_section(
            'shared-files_tab_' . $tab,
            '',
            array($tabs, 'shared_files_settings_tab_' . $tab . '_callback'),
            'shared-files'
        );
        $file_exts = [
            'webp',
            'avif',
            'svg',
            'json',
            'csv',
            'ttf',
            'woff',
            'woff2'
        ];
        foreach ( $file_exts as $ext ) {
            add_settings_field(
                'shared-files-allow_file_type_' . $ext,
                '.' . $ext,
                array($field_render, 'checkbox_render'),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                    'label_for'  => 'shared-files-allow_file_type_' . $ext,
                    'field_name' => 'allow_file_type_' . $ext,
                )
            );
        }
        $custom_file_types_cnt = 2;
        if ( isset( $s['custom_file_types_cnt'] ) ) {
            $custom_file_types_cnt = intval( $s['custom_file_types_cnt'] ) + 1;
        }
        for ($n = 1; $n < $custom_file_types_cnt; $n++) {
            add_settings_field(
                'shared-files-cft_' . $n . '_active',
                sanitize_text_field( __( 'Custom file type', 'shared-files' ) . ' ' . $n . ' ' . __( 'active', 'shared-files' ) ),
                array($field_render, 'checkbox_render'),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                    'label_for'  => 'shared-files-cft_' . $n . '_active',
                    'field_name' => 'cft_' . $n . '_active',
                )
            );
            add_settings_field(
                'shared-files-cft_' . $n . '_extension',
                sanitize_text_field( __( 'File extension', 'shared-files' ) ),
                array($field_render, 'input_render'),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                    'label_for'   => 'shared-files-cft_' . $n . '_extension',
                    'field_name'  => 'cft_' . $n . '_extension',
                    'placeholder' => '.ext',
                )
            );
            add_settings_field(
                'shared-files-cft_' . $n . '_mime_type',
                sanitize_text_field( __( 'Mime type', 'shared-files' ) ),
                array($field_render, 'input_render'),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                    'label_for'  => 'shared-files-cft_' . $n . '_mime_type',
                    'field_name' => 'cft_' . $n . '_mime_type',
                )
            );
        }
        add_settings_field(
            'shared-files-custom_file_types_cnt',
            sanitize_text_field( __( 'Number of custom file types', 'shared-files' ) ),
            array($field_render, 'custom_file_types_cnt_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'   => 'shared-files-custom_file_types_cnt',
                'field_name'  => 'custom_file_types_cnt',
                'placeholder' => '',
            )
        );
        $tab = 6;
        add_settings_section(
            'shared-files_tab_' . $tab,
            '',
            array($tabs, 'shared_files_settings_tab_' . $tab . '_callback'),
            'shared-files'
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'folder_icon_uri',
            sanitize_text_field( __( 'Folder icon', 'shared-files' ) ),
            array($field_render, 'input_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'  => 'shared-files-' . $only_pro . 'folder_icon_uri',
                'field_name' => $only_pro . 'folder_icon_uri',
            )
        );
        add_settings_field(
            'shared-files-icon_image',
            sanitize_text_field( __( 'File type: Image', 'shared-files' ) ),
            array($field_render, 'input_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'   => 'shared-files-icon_for_image',
                'field_name'  => 'icon_for_image',
                'placeholder' => '',
                'wide'        => 1,
            )
        );
        add_settings_field(
            'shared-files-icon_pdf',
            sanitize_text_field( __( 'File type: PDF', 'shared-files' ) ),
            array($field_render, 'input_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'   => 'shared-files-icon_for_pdf',
                'field_name'  => 'icon_for_pdf',
                'placeholder' => '',
                'wide'        => 1,
            )
        );
        add_settings_field(
            'shared-files-icon_ai',
            sanitize_text_field( __( 'File type: AI', 'shared-files' ) ),
            array($field_render, 'input_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'   => 'shared-files-icon_for_ai',
                'field_name'  => 'icon_for_ai',
                'placeholder' => '',
                'wide'        => 1,
            )
        );
        add_settings_field(
            'shared-files-icon_doc',
            sanitize_text_field( __( 'File type: Doc', 'shared-files' ) ),
            array($field_render, 'input_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'   => 'shared-files-icon_for_doc',
                'field_name'  => 'icon_for_doc',
                'placeholder' => '',
                'wide'        => 1,
            )
        );
        add_settings_field(
            'shared-files-icon_font',
            sanitize_text_field( __( 'File type: Font', 'shared-files' ) ),
            array($field_render, 'input_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'   => 'shared-files-icon_for_font',
                'field_name'  => 'icon_for_font',
                'placeholder' => '',
                'wide'        => 1,
            )
        );
        add_settings_field(
            'shared-files-icon_html',
            sanitize_text_field( __( 'File type: HTML', 'shared-files' ) ),
            array($field_render, 'input_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'   => 'shared-files-icon_for_html',
                'field_name'  => 'icon_for_html',
                'placeholder' => '',
                'wide'        => 1,
            )
        );
        add_settings_field(
            'shared-files-icon_mp3',
            sanitize_text_field( __( 'File type: MP3', 'shared-files' ) ),
            array($field_render, 'input_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'   => 'shared-files-icon_for_mp3',
                'field_name'  => 'icon_for_mp3',
                'placeholder' => '',
                'wide'        => 1,
            )
        );
        add_settings_field(
            'shared-files-icon_video',
            sanitize_text_field( __( 'File type: Video', 'shared-files' ) ),
            array($field_render, 'input_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'   => 'shared-files-icon_for_video',
                'field_name'  => 'icon_for_video',
                'placeholder' => '',
                'wide'        => 1,
            )
        );
        add_settings_field(
            'shared-files-icon_xlsx',
            sanitize_text_field( __( 'File type: XLSX', 'shared-files' ) ),
            array($field_render, 'input_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'   => 'shared-files-icon_for_xlsx',
                'field_name'  => 'icon_for_xlsx',
                'placeholder' => '',
                'wide'        => 1,
            )
        );
        add_settings_field(
            'shared-files-icon_pptx',
            sanitize_text_field( __( 'File type: PPT(X)', 'shared-files' ) ),
            array($field_render, 'input_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'   => 'shared-files-icon_for_pptx',
                'field_name'  => 'icon_for_pptx',
                'placeholder' => '',
                'wide'        => 1,
            )
        );
        add_settings_field(
            'shared-files-icon_zip',
            sanitize_text_field( __( 'File type: ZIP', 'shared-files' ) ),
            array($field_render, 'input_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'   => 'shared-files-icon_for_zip',
                'field_name'  => 'icon_for_zip',
                'placeholder' => '',
                'wide'        => 1,
            )
        );
        add_settings_field(
            'shared-files-icon_indd',
            sanitize_text_field( __( 'File type: INDD', 'shared-files' ) ),
            array($field_render, 'input_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'   => 'shared-files-icon_for_indd',
                'field_name'  => 'icon_for_indd',
                'placeholder' => '',
                'wide'        => 1,
            )
        );
        add_settings_field(
            'shared-files-icon_psd',
            sanitize_text_field( __( 'File type: PSD', 'shared-files' ) ),
            array($field_render, 'input_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'   => 'shared-files-icon_for_psd',
                'field_name'  => 'icon_for_psd',
                'placeholder' => '',
                'wide'        => 1,
            )
        );
        add_settings_field(
            'shared-files-icon_svg',
            sanitize_text_field( __( 'File type: SVG', 'shared-files' ) ),
            array($field_render, 'input_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'   => 'shared-files-icon_for_svg',
                'field_name'  => 'icon_for_svg',
                'placeholder' => '',
                'wide'        => 1,
            )
        );
        add_settings_field(
            'shared-files-icon_other',
            sanitize_text_field( __( 'File type: Other files', 'shared-files' ) ),
            array($field_render, 'input_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'   => 'shared-files-icon_for_other',
                'field_name'  => 'icon_for_other',
                'placeholder' => '',
                'wide'        => 1,
            )
        );
        add_settings_field(
            'shared-files-icon_youtube',
            sanitize_text_field( __( 'YouTube-link (External URL)', 'shared-files' ) ),
            array($field_render, 'input_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'   => 'shared-files-icon_for_youtube',
                'field_name'  => 'icon_for_youtube',
                'placeholder' => '',
                'wide'        => 1,
            )
        );
    }

}
