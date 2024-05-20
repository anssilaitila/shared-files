<?php

class SharedFilesSettingsTab1Content {
    public function init() {
        $tabs = new SharedFilesSettingsTabs();
        $field_render = new SharedFilesSettingsFieldRender();
        $only_pro = '_FREE_';
        $s = get_option( 'shared_files_settings' );
        add_settings_field(
            'shared-files-show_download_counter',
            sanitize_text_field( __( 'Show download counter', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'  => 'shared-files-show_download_counter',
                'field_name' => 'show_download_counter',
            )
        );
        add_settings_field(
            'shared-files-download_counter_text',
            sanitize_text_field( __( 'Download counter text', 'shared-files' ) ),
            array($field_render, 'input_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'   => 'shared-files-download_counter_text',
                'field_name'  => 'download_counter_text',
                'placeholder' => sanitize_text_field( __( 'Downloads:', 'shared-files' ) ),
            )
        );
        add_settings_field(
            'shared-files-hide_search_form',
            sanitize_text_field( __( 'Hide search form', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'   => 'shared-files-hide_search_form',
                'field_name'  => 'hide_search_form',
                'placeholder' => sanitize_text_field( __( 'The search form is automatically visible unless hidden by this setting or by a shortcode parameter.', 'shared-files' ) ),
            )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'search_input_targets_active_files',
            sanitize_text_field( __( 'Search input field targets filtered files rather than all files', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'  => 'shared-files-' . $only_pro . 'search_input_targets_active_files',
                'field_name' => $only_pro . 'search_input_targets_active_files',
                'class'      => 'shared-files-padding-bottom',
            )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'file_access_logged_in_only',
            sanitize_text_field( __( 'Only logged in users can open files', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'  => 'shared-files-' . $only_pro . 'file_access_logged_in_only',
                'field_name' => $only_pro . 'file_access_logged_in_only',
                'class'      => 'shared-files-border-top',
            )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'file_access_logged_in_only_show_featured_image',
            sanitize_text_field( __( 'Show featured image for non logged in users', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'  => 'shared-files-' . $only_pro . 'file_access_logged_in_only_show_featured_image',
                'field_name' => $only_pro . 'file_access_logged_in_only_show_featured_image',
            )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'file_access_logged_in_only_enable_preview',
            sanitize_text_field( __( 'Enable the use of the preview service for non logged in users', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'  => 'shared-files-' . $only_pro . 'file_access_logged_in_only_enable_preview',
                'field_name' => $only_pro . 'file_access_logged_in_only_enable_preview',
                'class'      => 'shared-files-border-bottom',
            )
        );
        add_settings_field(
            'shared-files-log_enable_user_data',
            sanitize_text_field( __( 'Log downloader user data', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'  => 'shared-files-log_enable_user_data',
                'field_name' => 'log_enable_user_data',
                'class'      => 'shared-files-padding-top',
            )
        );
        add_settings_field(
            'shared-files-log_enable_ip',
            sanitize_text_field( __( 'Log downloader IP', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'  => 'shared-files-log_enable_ip',
                'field_name' => 'log_enable_ip',
            )
        );
        add_settings_field(
            'shared-files-log_enable_user_agent',
            sanitize_text_field( __( 'Log downloader user agent', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'  => 'shared-files-log_enable_user_agent',
                'field_name' => 'log_enable_user_agent',
            )
        );
        add_settings_field(
            'shared-files-log_enable_referer_url',
            sanitize_text_field( __( 'Log referer url', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'  => 'shared-files-log_enable_referer_url',
                'field_name' => 'log_enable_referer_url',
            )
        );
        add_settings_field(
            'shared-files-show_tag_dropdown',
            sanitize_text_field( __( 'Show tag filter', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'  => 'shared-files-show_tag_dropdown',
                'field_name' => 'show_tag_dropdown',
            )
        );
        if ( SharedFilesHelpers::isPremium() == 0 ) {
            add_settings_field(
                'shared-files-' . $only_pro . 'sort_tags_by',
                sanitize_text_field( __( 'Sort tags by', 'shared-files' ) ),
                array($field_render, 'sort_tags_by_render'),
                'shared-files',
                'shared-files_section_general',
                array(
                    'label_for'  => 'shared-files-' . $only_pro . 'sort_tags_by',
                    'field_name' => $only_pro . 'sort_tags_by',
                )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'show_category_dropdown',
                sanitize_text_field( __( 'Show category filter', 'shared-files' ) ),
                array($field_render, 'checkbox_render'),
                'shared-files',
                'shared-files_section_general',
                array(
                    'label_for'  => 'shared-files-' . $only_pro . 'show_category_dropdown',
                    'field_name' => $only_pro . 'show_category_dropdown',
                )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'sort_categories_by',
                sanitize_text_field( __( 'Sort categories by', 'shared-files' ) ),
                array($field_render, 'sort_categories_by_render'),
                'shared-files',
                'shared-files_section_general',
                array(
                    'label_for'  => 'shared-files-' . $only_pro . 'sort_categories_by',
                    'field_name' => $only_pro . 'sort_categories_by',
                )
            );
        } else {
            add_settings_field(
                'shared-files-' . $only_pro . 'sort_tags_by',
                sanitize_text_field( __( 'Sort tags by', 'shared-files' ) ),
                array($field_render, 'sort_tags_by_render'),
                'shared-files',
                'shared-files_section_general',
                array(
                    'label_for'  => 'shared-files-' . $only_pro . 'sort_tags_by',
                    'field_name' => $only_pro . 'sort_tags_by',
                )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'hide_category_dropdown',
                sanitize_text_field( __( 'Hide category filter', 'shared-files' ) ),
                array($field_render, 'checkbox_render'),
                'shared-files',
                'shared-files_section_general',
                array(
                    'label_for'  => 'shared-files-' . $only_pro . 'hide_category_dropdown',
                    'field_name' => $only_pro . 'hide_category_dropdown',
                )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'sort_categories_by',
                sanitize_text_field( __( 'Sort categories by', 'shared-files' ) ),
                array($field_render, 'sort_categories_by_render'),
                'shared-files',
                'shared-files_section_general',
                array(
                    'label_for'  => 'shared-files-' . $only_pro . 'sort_categories_by',
                    'field_name' => $only_pro . 'sort_categories_by',
                )
            );
        }
        add_settings_field(
            'shared-files-' . $only_pro . 'pagination',
            sanitize_text_field( __( 'Pagination (number of files on one page)', 'shared-files' ) ),
            array($field_render, 'input_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'   => 'shared-files-' . $only_pro . 'pagination',
                'field_name'  => $only_pro . 'pagination',
                'placeholder' => '20',
            )
        );
        add_settings_field(
            'shared-files-icon_set',
            sanitize_text_field( __( 'Icon set', 'shared-files' ) ),
            array($field_render, 'icon_set_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'  => 'shared-files-icon_set',
                'field_name' => 'icon_set',
            )
        );
        add_settings_section(
            'shared-files_section_general',
            sanitize_text_field( __( 'General settings', 'shared-files' ) ),
            array($tabs, 'shared_files_settings_general_section_callback'),
            'shared-files'
        );
        add_settings_field(
            'shared-files-preview_service',
            sanitize_text_field( __( 'Preview service', 'shared-files' ) ),
            array($field_render, 'preview_service_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'  => 'shared-files-preview_service',
                'field_name' => 'preview_service',
            )
        );
        add_settings_field(
            'shared-files-always_preview_pdf',
            sanitize_text_field( __( 'Always show preview button for PDF files', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'  => 'shared-files-always_preview_pdf',
                'field_name' => 'always_preview_pdf',
            )
        );
        add_settings_field(
            'shared-files-bypass_preview_pdf',
            sanitize_text_field( __( 'Bypass the preview service when previewing PDF files. The file is opened in the browser directly.', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'  => 'shared-files-bypass_preview_pdf',
                'field_name' => 'bypass_preview_pdf',
            )
        );
        add_settings_field(
            'shared-files-folder_for_new_files',
            sanitize_text_field( __( 'Folder for new files', 'shared-files' ) ),
            array($field_render, 'input_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'   => 'shared-files-folder_for_new_files',
                'field_name'  => 'folder_for_new_files',
                'placeholder' => 'folder-name',
            )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'enable_preview_for_password_protected_files',
            sanitize_text_field( __( 'Enable the use of the preview service for password protected files', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'  => 'shared-files-' . $only_pro . 'enable_preview_for_password_protected_files',
                'field_name' => $only_pro . 'enable_preview_for_password_protected_files',
            )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'delete_expired_files',
            sanitize_text_field( __( 'Delete expired files (files will be moved to trash when the expiration date is reached)', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'  => 'shared-files-' . $only_pro . 'delete_expired_files',
                'field_name' => $only_pro . 'delete_expired_files',
            )
        );
        add_settings_field(
            'shared-files-textarea_for_file_description',
            sanitize_text_field( __( 'Use textarea for file description (instead of rich text editor)', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'  => 'shared-files-textarea_for_file_description',
                'field_name' => 'textarea_for_file_description',
            )
        );
        add_settings_field(
            'shared-files-order_by',
            sanitize_text_field( __( 'File list: order by', 'shared-files' ) ),
            array($field_render, 'order_by_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'  => 'shared-files-order_by',
                'field_name' => 'order_by',
            )
        );
        add_settings_field(
            'shared-files-order',
            sanitize_text_field( __( 'File list: order', 'shared-files' ) ),
            array($field_render, 'order_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'  => 'shared-files-order',
                'field_name' => 'order',
            )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'order_by_category_list',
            sanitize_text_field( __( 'Category list: order by', 'shared-files' ) ),
            array($field_render, 'order_by_category_list_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'  => 'shared-files-' . $only_pro . 'order_by_category_list',
                'field_name' => $only_pro . 'order_by_category_list',
            )
        );
        add_settings_field(
            'shared-files-maximum_size_text',
            sanitize_text_field( __( 'Maximum size of uploaded file', 'shared-files' ) ),
            array($field_render, 'input_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'   => 'shared-files-maximum_size_text',
                'field_name'  => 'maximum_size_text',
                'placeholder' => sanitize_text_field( SharedFilesHelpers::maxUploadSize() ),
            )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'show_limit_message_on_file_card',
            sanitize_text_field( __( 'Show message for download limit reached on file card', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'  => 'shared-files-' . $only_pro . 'show_limit_message_on_file_card',
                'field_name' => $only_pro . 'show_limit_message_on_file_card',
            )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'download_limit_msg',
            sanitize_text_field( __( 'Message for download limit reached', 'shared-files' ) ),
            array($field_render, 'textarea_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'   => 'shared-files-' . $only_pro . 'download_limit_msg',
                'field_name'  => $only_pro . 'download_limit_msg',
                'placeholder' => sanitize_text_field( __( 'This file is no longer available for download.', 'shared-files' ) ),
            )
        );
        add_settings_field(
            'shared-files-disable_download_log',
            sanitize_text_field( __( 'Disable download log', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'  => 'shared-files-disable_download_log',
                'field_name' => 'disable_download_log',
            )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'and_or_include_children',
            sanitize_text_field( __( 'Include subcategories / subtags when using shortcode parameters ending __and + __or', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'  => 'shared-files-' . $only_pro . 'and_or_include_children',
                'field_name' => $only_pro . 'and_or_include_children',
            )
        );
        add_settings_field(
            'shared-files-disable_download_attr',
            sanitize_text_field( __( 'Remove the "download" attribute from download links', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
            'shared-files',
            'shared-files_section_general',
            array(
                'label_for'  => 'shared-files-disable_download_attr',
                'field_name' => 'disable_download_attr',
            )
        );
    }

}
