<?php

class Shared_Files_Settings
{
    public function shared_files_add_admin_menu()
    {
        add_options_page(
            'Shared Files Settings',
            'Shared Files',
            'manage_options',
            'shared-files',
            array( $this, 'settings_page' )
        );
    }
    
    public function shared_files_settings_init()
    {
        $only_pro = '_FREE_';
        $s = get_option( 'shared_files_settings' );
        register_setting( 'shared-files', 'shared_files_settings' );
        add_settings_field(
            'shared-files-show_download_counter',
            sanitize_text_field( __( 'Show download counter', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
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
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_section_general',
            array(
            'label_for'   => 'shared-files-download_counter_text',
            'field_name'  => 'download_counter_text',
            'placeholder' => sanitize_text_field( __( 'Downloads:', 'shared-files' ) ),
        )
        );
        
        if ( SharedFilesHelpers::isPremium() == 0 ) {
            add_settings_field(
                'shared-files-' . $only_pro . 'show_search_form',
                sanitize_text_field( __( 'Show search form', 'shared-files' ) ),
                array( $this, 'checkbox_render' ),
                'shared-files',
                'shared-files_section_general',
                array(
                'label_for'  => 'shared-files-' . $only_pro . 'show_search_form',
                'field_name' => $only_pro . 'show_search_form',
            )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'show_tag_dropdown',
                sanitize_text_field( __( 'Show tag filter', 'shared-files' ) ),
                array( $this, 'checkbox_render' ),
                'shared-files',
                'shared-files_section_general',
                array(
                'label_for'  => 'shared-files-' . $only_pro . 'show_tag_dropdown',
                'field_name' => $only_pro . 'show_tag_dropdown',
            )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'sort_tags_by',
                sanitize_text_field( __( 'Sort tags by', 'shared-files' ) ),
                array( $this, 'sort_tags_by_render' ),
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
                array( $this, 'checkbox_render' ),
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
                array( $this, 'sort_categories_by_render' ),
                'shared-files',
                'shared-files_section_general',
                array(
                'label_for'  => 'shared-files-' . $only_pro . 'sort_categories_by',
                'field_name' => $only_pro . 'sort_categories_by',
            )
            );
        } else {
            add_settings_field(
                'shared-files-' . $only_pro . 'hide_search_form',
                sanitize_text_field( __( 'Hide search form', 'shared-files' ) ),
                array( $this, 'checkbox_render' ),
                'shared-files',
                'shared-files_section_general',
                array(
                'label_for'   => 'shared-files-' . $only_pro . 'hide_search_form',
                'field_name'  => $only_pro . 'hide_search_form',
                'placeholder' => sanitize_text_field( __( 'The search form is automatically visible unless hidden by this setting or by a shortcode parameter.', 'shared-files' ) ),
            )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'show_tag_dropdown',
                sanitize_text_field( __( 'Show tag filter', 'shared-files' ) ),
                array( $this, 'checkbox_render' ),
                'shared-files',
                'shared-files_section_general',
                array(
                'label_for'  => 'shared-files-' . $only_pro . 'show_tag_dropdown',
                'field_name' => $only_pro . 'show_tag_dropdown',
            )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'sort_tags_by',
                sanitize_text_field( __( 'Sort tags by', 'shared-files' ) ),
                array( $this, 'sort_tags_by_render' ),
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
                array( $this, 'checkbox_render' ),
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
                array( $this, 'sort_categories_by_render' ),
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
            array( $this, 'input_render' ),
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
            array( $this, 'icon_set_render' ),
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
            array( $this, 'shared_files_settings_general_section_callback' ),
            'shared-files'
        );
        add_settings_field(
            'shared-files-preview_service',
            sanitize_text_field( __( 'Preview service', 'shared-files' ) ),
            array( $this, 'preview_service_render' ),
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
            array( $this, 'checkbox_render' ),
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
            array( $this, 'checkbox_render' ),
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
            array( $this, 'input_render' ),
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
            array( $this, 'checkbox_render' ),
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
            array( $this, 'checkbox_render' ),
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
            array( $this, 'checkbox_render' ),
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
            array( $this, 'order_by_render' ),
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
            array( $this, 'order_render' ),
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
            array( $this, 'order_by_category_list_render' ),
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
            array( $this, 'input_render' ),
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
            array( $this, 'checkbox_render' ),
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
            array( $this, 'textarea_render' ),
            'shared-files',
            'shared-files_section_general',
            array(
            'label_for'   => 'shared-files-' . $only_pro . 'download_limit_msg',
            'field_name'  => $only_pro . 'download_limit_msg',
            'placeholder' => sanitize_text_field( __( 'This file is no longer available for download.', 'shared-files' ) ),
        )
        );
        $tab = 2;
        add_settings_section(
            'shared-files_tab_' . $tab,
            '',
            array( $this, 'shared_files_settings_tab_' . $tab . '_callback' ),
            'shared-files'
        );
        add_settings_field(
            'shared-files-file_open_method',
            sanitize_text_field( __( 'File opening method', 'shared-files' ) ),
            array( $this, 'file_open_method_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-file_open_method',
            'field_name' => 'file_open_method',
        )
        );
        add_settings_field(
            'shared-files-wp_engine_compatibility_mode',
            sanitize_text_field( __( 'Compatibility mode', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-wp_engine_compatibility_mode',
            'field_name' => 'wp_engine_compatibility_mode',
        )
        );
        if ( shared_files_fs()->is_free_plan() || shared_files_fs()->is_plan_or_trial( 'business' ) ) {
            add_settings_field(
                'shared-files-' . $only_pro . 'obfuscate_file_urls',
                sanitize_text_field( __( 'Obfuscate file urls', 'shared-files' ) ),
                array( $this, 'checkbox_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'  => 'shared-files-' . $only_pro . 'obfuscate_file_urls',
                'field_name' => $only_pro . 'obfuscate_file_urls',
            )
            );
        }
        if ( shared_files_fs()->is_free_plan() || shared_files_fs()->is_plan_or_trial( 'pro' ) || shared_files_fs()->is_plan_or_trial( 'business' ) ) {
            add_settings_field(
                'shared-files-' . $only_pro . 'file_sync_interval',
                sanitize_text_field( __( 'File & category sync interval', 'shared-files' ) ),
                array( $this, 'file_sync_interval_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'  => 'shared-files-' . $only_pro . 'file_sync_interval',
                'field_name' => $only_pro . 'file_sync_interval',
            )
            );
        }
        add_settings_field(
            'shared-files-' . $only_pro . 'remove_obsolete_file_metadata_automatically',
            sanitize_text_field( __( 'Remove obsolete file metadata automatically', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-' . $only_pro . 'remove_obsolete_file_metadata_automatically',
            'field_name' => $only_pro . 'remove_obsolete_file_metadata_automatically',
        )
        );
        add_settings_field(
            'shared-files-bypass_file_exists_check',
            sanitize_text_field( __( 'Bypass the file exists check on frontend file list', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-bypass_file_exists_check',
            'field_name' => 'bypass_file_exists_check',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'prevent_search_engines_from_indexing_file_urls',
            sanitize_text_field( __( 'Prevent search engines from indexing file urls', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-' . $only_pro . 'prevent_search_engines_from_indexing_file_urls',
            'field_name' => $only_pro . 'prevent_search_engines_from_indexing_file_urls',
        )
        );
        add_settings_field(
            'shared-files-wp_location',
            sanitize_text_field( __( 'WordPress location', 'shared-files' ) ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'   => 'shared-files-wp_location',
            'field_name'  => 'wp_location',
            'placeholder' => '/some-folder/',
        )
        );
        
        if ( shared_files_fs()->is_free_plan() || shared_files_fs()->is_plan_or_trial( 'pro' ) || shared_files_fs()->is_plan_or_trial( 'business' ) ) {
            add_settings_field(
                'shared-files-' . $only_pro . 'exact_search_min_chars',
                sanitize_text_field( __( 'Min. characters for search in [shared_files_exact_search]', 'shared-files' ) ),
                array( $this, 'input_render' ),
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
                sanitize_text_field( __( 'Search whole words only in [shared_files_exact_search] (default targets also partial text)', 'shared-files' ) ),
                array( $this, 'checkbox_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'  => 'shared-files-' . $only_pro . 'exact_search_whole_words_only',
                'field_name' => $only_pro . 'exact_search_whole_words_only',
            )
            );
        }
        
        add_settings_field(
            'shared-files-pagination_type',
            sanitize_text_field( __( 'Pagination type', 'shared-files' ) ),
            array( $this, 'pagination_type_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-pagination_type',
            'field_name' => 'pagination_type',
        )
        );
        $tab = 3;
        add_settings_section(
            'shared-files_tab_' . $tab,
            '',
            array( $this, 'shared_files_settings_tab_' . $tab . '_callback' ),
            'shared-files'
        );
        add_settings_field(
            'shared-files-layout',
            sanitize_text_field( __( 'Layout', 'shared-files' ) ),
            array( $this, 'layout_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-layout',
            'field_name' => 'layout',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'card_align_elements_vertically',
            sanitize_text_field( __( 'Align elements vertically and centered (inside file card)', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-' . $only_pro . 'card_align_elements_vertically',
            'field_name' => $only_pro . 'card_align_elements_vertically',
        )
        );
        if ( shared_files_fs()->is_free_plan() || shared_files_fs()->is_plan_or_trial( 'pro' ) || shared_files_fs()->is_plan_or_trial( 'business' ) ) {
            add_settings_field(
                'shared-files-' . $only_pro . 'remove_link_from_file_title',
                sanitize_text_field( __( 'Remove link from file title', 'shared-files' ) ),
                array( $this, 'checkbox_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'  => 'shared-files-' . $only_pro . 'remove_link_from_file_title',
                'field_name' => $only_pro . 'remove_link_from_file_title',
            )
            );
        }
        add_settings_field(
            'shared-files-show_download_button',
            sanitize_text_field( __( 'Show download button', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-show_download_button',
            'field_name' => 'show_download_button',
        )
        );
        add_settings_field(
            'shared-files-hide_preview_button',
            sanitize_text_field( __( 'Hide preview button', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-hide_preview_button',
            'field_name' => 'hide_preview_button',
        )
        );
        add_settings_field(
            'shared-files-hide_date_from_card',
            sanitize_text_field( __( 'Hide file date / publish date from card', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-hide_date_from_card',
            'field_name' => 'hide_date_from_card',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'hide_category_name_from_card',
            sanitize_text_field( __( 'Hide category name(s) from file card', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-' . $only_pro . 'hide_category_name_from_card',
            'field_name' => $only_pro . 'hide_category_name_from_card',
        )
        );
        add_settings_field(
            'shared-files-card_font',
            sanitize_text_field( __( 'Card font', 'shared-files' ) ),
            array( $this, 'card_font_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-card_font',
            'field_name' => 'card_font',
        )
        );
        add_settings_field(
            'shared-files-card_small_font_size',
            sanitize_text_field( __( 'Small font size on card', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-card_small_font_size',
            'field_name' => 'card_small_font_size',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'hide_tags',
            sanitize_text_field( __( 'Hide tags from the file card', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-' . $only_pro . 'hide_tags',
            'field_name' => $only_pro . 'hide_tags',
        )
        );
        add_settings_field(
            'shared-files-hide_file_size_from_card',
            sanitize_text_field( __( 'Hide file size from card', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-hide_file_size_from_card',
            'field_name' => 'hide_file_size_from_card',
        )
        );
        add_settings_field(
            'shared-files-hide_file_type_icon_from_card',
            sanitize_text_field( __( 'Hide file type icon from card', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-hide_file_type_icon_from_card',
            'field_name' => 'hide_file_type_icon_from_card',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'show_tags_on_search_results',
            sanitize_text_field( __( 'Show tags on search results cards', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-' . $only_pro . 'show_tags_on_search_results',
            'field_name' => $only_pro . 'show_tags_on_search_results',
        )
        );
        add_settings_field(
            'shared-files-card_featured_image_as_extra',
            sanitize_text_field( __( 'Show featured image in addition to file type icon', 'shared-files' ) ) . '<div style="font-weight: 400; font-style: italic; font-size: 12px; margin-top: 3px;">' . sanitize_text_field( __( 'Featured image will be displayed next to file description.', 'shared-files' ) ) . '<br />' . sanitize_text_field( __( 'Normally it is displayed instead of file type icon.', 'shared-files' ) ) . '</div>',
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-card_featured_image_as_extra',
            'field_name' => 'card_featured_image_as_extra',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'larger_featured_image',
            sanitize_text_field( __( 'Use a larger, non-cropped version of the featured image', 'shared-files' ) ) . '<div style="font-weight: 400; font-style: italic; font-size: 12px; margin-top: 3px;">' . sanitize_text_field( __( '"Show featured image in addition to file type icon" must also be checked.', 'shared-files' ) ) . '</div>',
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-' . $only_pro . 'larger_featured_image',
            'field_name' => $only_pro . 'larger_featured_image',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'featured_image_container_width',
            sanitize_text_field( __( 'Featured image container width (px)', 'shared-files' ) ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'   => 'shared-files-' . $only_pro . 'featured_image_container_width',
            'field_name'  => $only_pro . 'featured_image_container_width',
            'placeholder' => '150',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'featured_image_container_height',
            sanitize_text_field( __( 'Featured image container height (px)', 'shared-files' ) ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'   => 'shared-files-' . $only_pro . 'featured_image_container_height',
            'field_name'  => $only_pro . 'featured_image_container_height',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'show_featured_image_for_password_protected_files',
            sanitize_text_field( __( 'Show featured image for password protected files', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-' . $only_pro . 'show_featured_image_for_password_protected_files',
            'field_name' => $only_pro . 'show_featured_image_for_password_protected_files',
        )
        );
        add_settings_field(
            'shared-files-card_featured_image_align',
            sanitize_text_field( __( 'Align featured image', 'shared-files' ) ),
            array( $this, 'card_featured_image_align' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-card_featured_image_align',
            'field_name' => 'card_featured_image_align',
        )
        );
        add_settings_field(
            'shared-files-card_height',
            sanitize_text_field( __( 'Card height in pixels', 'shared-files' ) ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'   => 'shared-files-card_height',
            'field_name'  => 'card_height',
            'placeholder' => '380',
        )
        );
        add_settings_field(
            'shared-files-card_background',
            sanitize_text_field( __( 'Card background', 'shared-files' ) ),
            array( $this, 'card_background_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-card_background',
            'field_name' => 'card_background',
        )
        );
        add_settings_field(
            'shared-files-card_background_custom_color',
            sanitize_text_field( __( 'Card background, custom color (HEX code)', 'shared-files' ) ) . '<div style="font-weight: 400; font-style: italic; font-size: 12px; margin-top: 3px;">' . sanitize_text_field( __( 'See', 'shared-files' ) ) . ' <a href="https://htmlcolorcodes.com/" target="_blank">htmlcolorcodes.com</a></div>',
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'   => 'shared-files-card_background_custom_color',
            'field_name'  => 'card_background_custom_color',
            'placeholder' => '',
        )
        );
        $tab = 4;
        add_settings_section(
            'shared-files_tab_' . $tab,
            '',
            array( $this, 'shared_files_settings_tab_' . $tab . '_callback' ),
            'shared-files'
        );
        $custom_fields_cnt = 3 + 1;
        for ( $n = 1 ;  $n < $custom_fields_cnt ;  $n++ ) {
            add_settings_field(
                'shared-files-' . $only_pro . 'file_upload_custom_field_' . $n,
                sanitize_text_field( __( 'Custom field', 'shared-files' ) ) . ' ' . $n,
                array( $this, 'input_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'   => 'shared-files-' . $only_pro . 'file_upload_custom_field_' . $n,
                'field_name'  => $only_pro . 'file_upload_custom_field_' . $n,
                'placeholder' => '',
            )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'cf_' . $n . '_hide_from_frontend_uploader',
                sanitize_text_field( __( 'Hide from front-end uploader', 'shared-files' ) ),
                array( $this, 'checkbox_render' ),
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
                array( $this, 'checkbox_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'  => 'shared-files-' . $only_pro . 'cf_' . $n . '_hide_from_admin_edit',
                'field_name' => $only_pro . 'cf_' . $n . '_hide_from_admin_edit',
            )
            );
            
            if ( shared_files_fs()->is_free_plan() || shared_files_fs()->is_plan_or_trial( 'pro' ) || shared_files_fs()->is_plan_or_trial( 'business' ) ) {
                add_settings_field(
                    'shared-files-' . $only_pro . 'cf_' . $n . '_use_as_search_filter',
                    sanitize_text_field( __( 'Use as search filter', 'shared-files' ) ),
                    array( $this, 'checkbox_render' ),
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
                    array( $this, 'input_render' ),
                    'shared-files',
                    'shared-files_tab_' . $tab,
                    array(
                    'label_for'  => 'shared-files-' . $only_pro . 'cf_' . $n . '_select_title',
                    'field_name' => $only_pro . 'cf_' . $n . '_select_title',
                )
                );
            }
        
        }
        if ( shared_files_fs()->is_free_plan() || shared_files_fs()->is_plan_or_trial( 'business' ) ) {
            add_settings_field(
                'shared-files-' . $only_pro . 'custom_fields_cnt',
                sanitize_text_field( __( 'Number of custom fields', 'shared-files' ) ),
                array( $this, 'custom_fields_cnt_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'   => 'shared-files-' . $only_pro . 'custom_fields_cnt',
                'field_name'  => $only_pro . 'custom_fields_cnt',
                'placeholder' => '',
            )
            );
        }
        $tab = 5;
        add_settings_section(
            'shared-files_tab_' . $tab,
            '',
            array( $this, 'shared_files_settings_tab_' . $tab . '_callback' ),
            'shared-files'
        );
        add_settings_field(
            'shared-files-file_upload_disable_progress_bar',
            sanitize_text_field( __( 'Disable progress bar / ajax upload', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-file_upload_disable_progress_bar',
            'field_name' => 'file_upload_disable_progress_bar',
        )
        );
        add_settings_field(
            'shared-files-only_logged_in_users_can_add_files',
            sanitize_text_field( __( 'Only logged in users can add files using the front-end file uploader', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-only_logged_in_users_can_add_files',
            'field_name' => 'only_logged_in_users_can_add_files',
        )
        );
        add_settings_field(
            'shared-files-hide_file_uploader_info',
            sanitize_text_field( __( 'Hide file uploader info', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-hide_file_uploader_info',
            'field_name' => 'hide_file_uploader_info',
        )
        );
        add_settings_field(
            'shared-files-file_upload_hide_description',
            sanitize_text_field( __( 'Hide description field', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-file_upload_hide_description',
            'field_name' => 'file_upload_hide_description',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'file_upload_allow_featured_image',
            sanitize_text_field( __( 'Enable featured image (a separate file can be added)', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-' . $only_pro . 'file_upload_allow_featured_image',
            'field_name' => $only_pro . 'file_upload_allow_featured_image',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'show_category_checkboxes_on_file_upload',
            sanitize_text_field( __( 'Show category checkboxes for front-end file uploader (instead of dropdown)', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-' . $only_pro . 'show_category_checkboxes_on_file_upload',
            'field_name' => $only_pro . 'show_category_checkboxes_on_file_upload',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'show_file_upload_checkboxes_on_multiple_columns',
            sanitize_text_field( __( 'Show category and tag checkboxes on multiple columns', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-' . $only_pro . 'show_file_upload_checkboxes_on_multiple_columns',
            'field_name' => $only_pro . 'show_file_upload_checkboxes_on_multiple_columns',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'file_upload_new_category',
            sanitize_text_field( __( 'Allow the uploader to create a single new category', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-' . $only_pro . 'file_upload_new_category',
            'field_name' => $only_pro . 'file_upload_new_category',
        )
        );
        
        if ( shared_files_fs()->is_free_plan() || shared_files_fs()->is_plan_or_trial( 'pro' ) || shared_files_fs()->is_plan_or_trial( 'business' ) ) {
            add_settings_field(
                'shared-files-' . $only_pro . 'file_upload_multiple_new_categories',
                sanitize_text_field( __( 'Allow the uploader to create multiple new categories', 'shared-files' ) ),
                array( $this, 'checkbox_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'  => 'shared-files-' . $only_pro . 'file_upload_multiple_new_categories',
                'field_name' => $only_pro . 'file_upload_multiple_new_categories',
            )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'file_upload_multiple_new_tags',
                sanitize_text_field( __( 'Allow the uploader to create multiple new tags', 'shared-files' ) ),
                array( $this, 'checkbox_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'  => 'shared-files-' . $only_pro . 'file_upload_multiple_new_tags',
                'field_name' => $only_pro . 'file_upload_multiple_new_tags',
            )
            );
        }
        
        add_settings_field(
            'shared-files-' . $only_pro . 'show_tag_dropdown_on_file_upload',
            sanitize_text_field( __( 'Show tag dropdown for front-end file uploader', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-' . $only_pro . 'show_tag_dropdown_on_file_upload',
            'field_name' => $only_pro . 'show_tag_dropdown_on_file_upload',
        )
        );
        add_settings_field(
            'shared-files-show_tag_checkboxes_on_file_upload',
            sanitize_text_field( __( 'Show tag checkboxes for front-end file uploader', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-show_tag_checkboxes_on_file_upload',
            'field_name' => 'show_tag_checkboxes_on_file_upload',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'uncheck_hide_from_other_pages',
            sanitize_text_field( __( 'Uncheck "Hide from other pages" for uploaded files', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-uncheck_hide_from_other_pages',
            'field_name' => 'uncheck_hide_from_other_pages',
        )
        );
        add_settings_field(
            'shared-files-file_upload_show_external_url',
            sanitize_text_field( __( 'Show External Url on file upload form', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-file_upload_show_external_url',
            'field_name' => 'file_upload_show_external_url',
        )
        );
        add_settings_field(
            'shared-files-file_upload_show_expiration_date',
            sanitize_text_field( __( 'Show Expiration date', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-file_upload_show_expiration_date',
            'field_name' => 'file_upload_show_expiration_date',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'file_upload_external_url_title',
            sanitize_text_field( __( 'Text for External URL', 'shared-files' ) ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'   => 'shared-files-' . $only_pro . 'file_upload_external_url_title',
            'field_name'  => $only_pro . 'file_upload_external_url_title',
            'placeholder' => sanitize_text_field( __( 'Or enter a YouTube URL:', 'shared-files' ) ),
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'file_upload_restrict_file_types',
            sanitize_text_field( __( 'Restrict accepted file types', 'shared-files' ) ),
            array( $this, 'restrict_file_types_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'   => 'shared-files-' . $only_pro . 'file_upload_restrict_file_types',
            'field_name'  => $only_pro . 'file_upload_restrict_file_types',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'file_upload_restrict_file_extensions',
            sanitize_text_field( __( 'Restrict accepted file extensions', 'shared-files' ) ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'   => 'shared-files-' . $only_pro . 'file_upload_restrict_file_extensions',
            'field_name'  => $only_pro . 'file_upload_restrict_file_extensions',
            'placeholder' => '.gif, .jpg, .png, .doc',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'file_upload_password',
            sanitize_text_field( __( 'Allow the uploader to define a password for the file', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'   => 'shared-files-' . $only_pro . 'file_upload_password',
            'field_name'  => $only_pro . 'file_upload_password',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'file_upload_file_not_required',
            sanitize_text_field( __( 'Make the file field optional', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'   => 'shared-files-' . $only_pro . 'file_upload_file_not_required',
            'field_name'  => $only_pro . 'file_upload_file_not_required',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'file_upload_send_email',
            sanitize_text_field( __( 'Send and email notify when a file is uploaded and / or send an email to all users having one of the roles below:', 'shared-files' ) ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'   => 'shared-files-' . $only_pro . 'file_upload_send_email',
            'field_name'  => $only_pro . 'file_upload_send_email',
            'placeholder' => '',
        )
        );
        global  $wp_roles ;
        $roles = $wp_roles->get_names();
        foreach ( $roles as $key => $value ) {
            if ( $key && $value ) {
                add_settings_field(
                    'shared-files-' . $only_pro . 'notify_on_file_upload_' . $key,
                    $value,
                    array( $this, 'checkbox_render' ),
                    'shared-files',
                    'shared-files_tab_' . $tab,
                    array(
                    'label_for'   => 'shared-files-' . $only_pro . 'notify_on_file_upload_' . $key,
                    'field_name'  => $only_pro . 'notify_on_file_upload_' . $key,
                    'placeholder' => '',
                )
                );
            }
        }
        $tab = 6;
        add_settings_section(
            'shared-files_tab_' . $tab,
            '',
            array( $this, 'shared_files_settings_tab_' . $tab . '_callback' ),
            'shared-files'
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'folder_icon_uri',
            sanitize_text_field( __( 'Folder icon', 'shared-files' ) ),
            array( $this, 'input_render' ),
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
            array( $this, 'input_render' ),
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
            array( $this, 'input_render' ),
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
            array( $this, 'input_render' ),
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
            array( $this, 'input_render' ),
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
            array( $this, 'input_render' ),
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
            array( $this, 'input_render' ),
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
            array( $this, 'input_render' ),
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
            array( $this, 'input_render' ),
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
            array( $this, 'input_render' ),
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
            array( $this, 'input_render' ),
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
            array( $this, 'input_render' ),
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
            array( $this, 'input_render' ),
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
            array( $this, 'input_render' ),
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
            array( $this, 'input_render' ),
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
            array( $this, 'input_render' ),
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
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'   => 'shared-files-icon_for_youtube',
            'field_name'  => 'icon_for_youtube',
            'placeholder' => '',
            'wide'        => 1,
        )
        );
        $tab = 7;
        add_settings_section(
            'shared-files_tab_' . $tab,
            '',
            array( $this, 'shared_files_settings_tab_' . $tab . '_callback' ),
            'shared-files'
        );
        $num = [ 1 ];
        foreach ( $num as $n ) {
            $field_title = __( 'Custom file type', 'shared-files' ) . ' ' . $n . ': ' . __( 'extension', 'shared-files' );
            add_settings_field(
                'shared-files-custom_' . $n . '_ext',
                esc_html( $field_title ),
                array( $this, 'input_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'   => 'shared-files-custom_' . $n . '_ext',
                'field_name'  => 'custom_' . $n . '_ext',
                'placeholder' => '',
                'ext'         => 1,
            )
            );
            $field_title = __( 'Custom file type', 'shared-files' ) . ' ' . $n . ': ' . __( 'icon file', 'shared-files' );
            add_settings_field(
                'shared-files-custom_' . $n . '_icon',
                esc_html( $field_title ),
                array( $this, 'input_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'   => 'shared-files-custom_' . $n . '_icon',
                'field_name'  => 'custom_' . $n . '_icon',
                'placeholder' => '',
                'wide'        => 1,
            )
            );
        }
        $num = [
            2,
            3,
            4,
            5,
            6
        ];
        foreach ( $num as $n ) {
            $field_title = __( 'Custom file type', 'shared-files' ) . ' ' . $n . ': ' . __( 'extension', 'shared-files' );
            add_settings_field(
                'shared-files-' . $only_pro . 'custom_' . $n . '_ext',
                esc_html( $field_title ),
                array( $this, 'input_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'   => 'shared-files-' . $only_pro . 'custom_' . $n . '_ext',
                'field_name'  => $only_pro . 'custom_' . $n . '_ext',
                'placeholder' => '',
                'ext'         => 1,
            )
            );
            $field_title = __( 'Custom file type', 'shared-files' ) . ' ' . $n . ': ' . __( 'icon file', 'shared-files' );
            add_settings_field(
                'shared-files-' . $only_pro . 'custom_' . $n . '_icon',
                esc_html( $field_title ),
                array( $this, 'input_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'   => 'shared-files-' . $only_pro . 'custom_' . $n . '_icon',
                'field_name'  => $only_pro . 'custom_' . $n . '_icon',
                'placeholder' => '',
                'wide'        => 1,
            )
            );
        }
        $tab = 8;
        add_settings_section(
            'shared-files_tab_' . $tab,
            '',
            array( $this, 'shared_files_settings_tab_' . $tab . '_callback' ),
            'shared-files'
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'send_email',
            sanitize_text_field( __( 'Send an email notify when a file is downloaded', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-' . $only_pro . 'send_email',
            'field_name' => $only_pro . 'send_email',
        )
        );
        if ( shared_files_fs()->is_free_plan() || shared_files_fs()->is_plan_or_trial( 'pro' ) || shared_files_fs()->is_plan_or_trial( 'business' ) ) {
            add_settings_field(
                'shared-files-' . $only_pro . 'trigger_download_email',
                sanitize_text_field( __( 'Trigger file downloaded email on', 'shared-files' ) ),
                array( $this, 'trigger_download_email_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'  => 'shared-files-' . $only_pro . 'trigger_download_email',
                'field_name' => $only_pro . 'trigger_download_email',
            )
            );
        }
        add_settings_field(
            'shared-files-' . $only_pro . 'add_ip_to_file_downloaded_email',
            sanitize_text_field( __( "Add the downloader's IP address to the email", 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-' . $only_pro . 'add_ip_to_file_downloaded_email',
            'field_name' => $only_pro . 'add_ip_to_file_downloaded_email',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'send_email_on_file_activation',
            sanitize_text_field( __( 'Send an email notify when a file is automatically activated for a category', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-' . $only_pro . 'send_email_on_file_activation',
            'field_name' => $only_pro . 'send_email_on_file_activation',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'recipient_email',
            sanitize_text_field( __( 'Notification recipient email', 'shared-files' ) ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'   => 'shared-files-' . $only_pro . 'recipient_email',
            'field_name'  => $only_pro . 'recipient_email',
            'placeholder' => '',
        )
        );
        //    $tab = 9;
        add_settings_section(
            'shared-files_section_admin_list',
            '',
            array( $this, 'shared_files_settings_admin_list_section_callback' ),
            'shared-files'
        );
        add_settings_field(
            'shared-files-hide_limit_downloads',
            sanitize_text_field( __( 'Hide "Limit downloads"-column', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_section_admin_list',
            array(
            'label_for'  => 'shared-files-hide_limit_downloads',
            'field_name' => 'hide_limit_downloads',
        )
        );
        add_settings_field(
            'shared-files-hide_file_added',
            sanitize_text_field( __( 'Hide "File added"-column', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_section_admin_list',
            array(
            'label_for'  => 'shared-files-hide_file_added',
            'field_name' => 'hide_file_added',
        )
        );
        add_settings_field(
            'shared-files-hide_last_access',
            sanitize_text_field( __( 'Hide "Last access"-column', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_section_admin_list',
            array(
            'label_for'  => 'shared-files-hide_last_access',
            'field_name' => 'hide_last_access',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'hide_bandwidth_usage',
            sanitize_text_field( __( 'Hide "Bandwidth usage"-column', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_section_admin_list',
            array(
            'label_for'  => 'shared-files-' . $only_pro . 'hide_bandwidth_usage',
            'field_name' => $only_pro . 'hide_bandwidth_usage',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'hide_expiration_date',
            sanitize_text_field( __( 'Hide "Expiration date"-column', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_section_admin_list',
            array(
            'label_for'  => 'shared-files-' . $only_pro . 'hide_expiration_date',
            'field_name' => $only_pro . 'hide_expiration_date',
        )
        );
        $tab = 10;
        add_settings_section(
            'shared-files_tab_' . $tab,
            '',
            array( $this, 'shared_files_settings_tab_' . $tab . '_callback' ),
            'shared-files'
        );
        global  $wp_roles ;
        $roles = $wp_roles->get_names();
        foreach ( $roles as $key => $value ) {
            if ( $key && $value ) {
                add_settings_field(
                    'shared-files-' . $only_pro . 'can_edit_files_' . $key,
                    $value,
                    array( $this, 'checkbox_render' ),
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
        
        if ( shared_files_fs()->is_free_plan() || shared_files_fs()->is_plan_or_trial( 'pro' ) || shared_files_fs()->is_plan_or_trial( 'business' ) ) {
            add_settings_section(
                'shared-files_tab_10_2',
                '',
                array( $this, 'shared_files_settings_tab_10_2_callback' ),
                'shared-files'
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'file_edit_hide_external_url',
                sanitize_text_field( __( 'Hide external URL', 'shared-files' ) ),
                array( $this, 'checkbox_render' ),
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
                array( $this, 'checkbox_render' ),
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
                array( $this, 'checkbox_render' ),
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
                array( $this, 'checkbox_render' ),
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
                array( $this, 'checkbox_render' ),
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
                array( $this, 'checkbox_render' ),
                'shared-files',
                'shared-files_tab_10_2',
                array(
                'label_for'  => 'shared-files-' . $only_pro . 'file_edit_hide_description',
                'field_name' => $only_pro . 'file_edit_hide_description',
            )
            );
        }
        
        
        if ( shared_files_fs()->is_free_plan() || shared_files_fs()->is_plan_or_trial( 'business' ) ) {
            $tab = 11;
            add_settings_section(
                'shared-files_tab_' . $tab,
                '',
                array( $this, 'shared_files_settings_tab_' . $tab . '_callback' ),
                'shared-files'
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'activate_favorite_files_for_logged_in',
                sanitize_text_field( __( 'Activate favorite files for logged in users', 'shared-files' ) ),
                array( $this, 'checkbox_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'  => 'shared-files-' . $only_pro . 'activate_favorite_files_for_logged_in',
                'field_name' => $only_pro . 'activate_favorite_files_for_logged_in',
            )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'activate_favorite_files_for_non_logged_in',
                sanitize_text_field( __( 'Activate for non-logged in users', 'shared-files' ) ),
                array( $this, 'checkbox_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'  => 'shared-files-' . $only_pro . 'activate_favorite_files_for_non_logged_in',
                'field_name' => $only_pro . 'activate_favorite_files_for_non_logged_in',
            )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'favorite_files_text_add_to_favorites',
                sanitize_text_field( __( 'Text for "Add to favorites"', 'shared-files' ) ),
                array( $this, 'input_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'   => 'shared-files-' . $only_pro . 'favorite_files_text_add_to_favorites',
                'field_name'  => $only_pro . 'favorite_files_text_add_to_favorites',
                'placeholder' => sanitize_text_field( __( 'Add to favorites', 'shared-files' ) ),
            )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'favorite_files_text_favorited',
                sanitize_text_field( __( 'Text for "Favorited"', 'shared-files' ) ),
                array( $this, 'input_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'   => 'shared-files-' . $only_pro . 'favorite_files_text_favorited',
                'field_name'  => $only_pro . 'favorite_files_text_favorited',
                'placeholder' => sanitize_text_field( __( 'Favorited', 'shared-files' ) ),
            )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'favorite_files_text_delete_from_favorites',
                sanitize_text_field( __( 'Text for "Remove from favorites"', 'shared-files' ) ),
                array( $this, 'input_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'   => 'shared-files-' . $only_pro . 'favorite_files_text_delete_from_favorites',
                'field_name'  => $only_pro . 'favorite_files_text_delete_from_favorites',
                'placeholder' => sanitize_text_field( __( 'Remove from favorites', 'shared-files' ) ),
            )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'favorite_files_text_deleted',
                sanitize_text_field( __( 'Text for "Removed"', 'shared-files' ) ),
                array( $this, 'input_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'   => 'shared-files-' . $only_pro . 'favorite_files_text_deleted',
                'field_name'  => $only_pro . 'favorite_files_text_deleted',
                'placeholder' => sanitize_text_field( __( 'Removed', 'shared-files' ) ),
            )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'show_title_above_favorite_files',
                sanitize_text_field( __( 'Show title in shortcode [shared_files_favorites]', 'shared-files' ) ),
                array( $this, 'checkbox_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'  => 'shared-files-' . $only_pro . 'show_title_above_favorite_files',
                'field_name' => $only_pro . 'show_title_above_favorite_files',
            )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'favorite_files_title_text',
                sanitize_text_field( __( 'Title text', 'shared-files' ) ),
                array( $this, 'input_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'   => 'shared-files-' . $only_pro . 'favorite_files_title_text',
                'field_name'  => $only_pro . 'favorite_files_title_text',
                'placeholder' => 'Favorite files',
            )
            );
            $tab = 12;
            add_settings_section(
                'shared-files_tab_' . $tab,
                '',
                array( $this, 'shared_files_settings_tab_' . $tab . '_callback' ),
                'shared-files'
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'activate_wait_page',
                sanitize_text_field( __( 'Activate wait countdown page for all download links', 'shared-files' ) ),
                array( $this, 'checkbox_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'  => 'shared-files-' . $only_pro . 'activate_wait_page',
                'field_name' => $only_pro . 'activate_wait_page',
            )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'wait_page',
                sanitize_text_field( __( 'Wait countdown page', 'shared-files' ) ),
                array( $this, 'wait_page_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'  => 'shared-files-' . $only_pro . 'wait_page',
                'field_name' => $only_pro . 'wait_page',
            )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'wait_page_text_before_seconds',
                sanitize_text_field( __( 'Text before seconds', 'shared-files' ) ),
                array( $this, 'input_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'   => 'shared-files-' . $only_pro . 'wait_page_text_before_seconds',
                'field_name'  => $only_pro . 'wait_page_text_before_seconds',
                'placeholder' => sanitize_text_field( __( 'Your download will start automatically in', 'shared-files' ) ),
            )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'wait_page_countdown_seconds',
                sanitize_text_field( __( 'Countdown length in seconds', 'shared-files' ) ),
                array( $this, 'input_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'   => 'shared-files-' . $only_pro . 'wait_page_countdown_seconds',
                'field_name'  => $only_pro . 'wait_page_countdown_seconds',
                'placeholder' => 5,
            )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'wait_page_text_after_seconds',
                sanitize_text_field( __( 'Text after seconds', 'shared-files' ) ),
                array( $this, 'input_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'   => 'shared-files-' . $only_pro . 'wait_page_text_after_seconds',
                'field_name'  => $only_pro . 'wait_page_text_after_seconds',
                'placeholder' => sanitize_text_field( __( 'seconds...', 'shared-files' ) ),
            )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'wait_page_download_button_text',
                sanitize_text_field( __( 'Download button text', 'shared-files' ) ),
                array( $this, 'input_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'   => 'shared-files-' . $only_pro . 'wait_page_download_button_text',
                'field_name'  => $only_pro . 'wait_page_download_button_text',
                'placeholder' => sanitize_text_field( __( 'Download', 'shared-files' ) ),
            )
            );
            add_settings_field(
                'shared-files-' . $only_pro . 'wait_page_hide_download_button',
                sanitize_text_field( __( 'Hide download button', 'shared-files' ) ),
                array( $this, 'checkbox_render' ),
                'shared-files',
                'shared-files_tab_' . $tab,
                array(
                'label_for'  => 'shared-files-' . $only_pro . 'wait_page_hide_download_button',
                'field_name' => $only_pro . 'wait_page_hide_download_button',
            )
            );
        }
        
        $tab = 13;
        add_settings_section(
            'shared-files_tab_' . $tab,
            '',
            array( $this, 'shared_files_settings_tab_' . $tab . '_callback' ),
            'shared-files'
        );
        add_settings_field(
            'shared-files-simple_list_show_titles_for_columns',
            sanitize_text_field( __( 'Show titles for columns', 'shared-files' ) ),
            array( $this, 'checkbox_render' ),
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
            array( $this, 'checkbox_render' ),
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
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-simple_list_title_file',
            'field_name' => 'simple_list_title_file',
        )
        );
        $custom_fields_cnt = 3 + 1;
        for ( $n = 1 ;  $n < $custom_fields_cnt ;  $n++ ) {
            add_settings_field(
                'shared-files-' . $only_pro . 'simple_list_show_custom_field_' . $n,
                sanitize_text_field( __( 'Show custom field', 'shared-files' ) . ' ' . $n ),
                array( $this, 'checkbox_render' ),
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
                array( $this, 'input_render' ),
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
            array( $this, 'checkbox_render' ),
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
            array( $this, 'input_render' ),
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
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-simple_list_show_tag',
            'field_name' => 'simple_list_show_tag',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'simple_list_title_tag',
            sanitize_text_field( __( 'Title for tag column', 'shared-files' ) ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-' . $only_pro . 'simple_list_title_tag',
            'field_name' => $only_pro . 'simple_list_title_tag',
        )
        );
    }
    
    public function checkbox_render( $args )
    {
        
        if ( $field_name = $args['field_name'] ) {
            $options = get_option( 'shared_files_settings' );
            ?>    

      <?php 
            $free = 0;
            ?>
      <?php 
            $free_class = '';
            ?>
      <?php 
            $plan_required = 'All Plans';
            ?>

      <?php 
            $show_info = 0;
            ?>
    
      <?php 
            
            if ( substr( $field_name, 0, strlen( '_FREE_' ) ) === '_FREE_' ) {
                ?>
        <?php 
                $free = 1;
                ?>
        <?php 
                $free_class = 'shared-files-setting-container-free';
                ?>

        <?php 
                
                if ( strpos( $field_name, '_use_as_search_filter' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Professional';
                    ?>
        <?php 
                } elseif ( strpos( $field_name, 'file_upload_multiple_new_categories' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Professional';
                    ?>
        <?php 
                } elseif ( strpos( $field_name, 'file_upload_multiple_new_tags' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Professional';
                    ?>

        <?php 
                } elseif ( strpos( $field_name, 'file_edit_hide_external_url' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Professional';
                    ?>
        <?php 
                } elseif ( strpos( $field_name, 'file_edit_hide_category_checkboxes' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Professional';
                    ?>
        <?php 
                } elseif ( strpos( $field_name, 'file_edit_hide_new_categories' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Professional';
                    ?>
        <?php 
                } elseif ( strpos( $field_name, 'file_edit_hide_tag_checkboxes' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Professional';
                    ?>
        <?php 
                } elseif ( strpos( $field_name, 'file_edit_hide_new_tags' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Professional';
                    ?>
        <?php 
                } elseif ( strpos( $field_name, 'file_edit_hide_description' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Professional';
                    ?>
        <?php 
                } elseif ( strpos( $field_name, 'remove_link_from_file_title' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Professional';
                    ?>
        <?php 
                } elseif ( strpos( $field_name, 'exact_search_whole_words_only' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Professional';
                    ?>
        <?php 
                } elseif ( strpos( $field_name, 'remove_obsolete_file_metadata_automatically' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Professional';
                    ?>

        <?php 
                } elseif ( strpos( $field_name, 'activate_favorite_files' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Business';
                    ?>
        <?php 
                } elseif ( strpos( $field_name, 'activate_favorite_files_non_logged_in' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Business';
                    ?>
        <?php 
                } elseif ( strpos( $field_name, 'show_title_above_favorite_files' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Business';
                    ?>

        <?php 
                } elseif ( strpos( $field_name, 'activate_wait_page' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Business';
                    ?>
        <?php 
                } elseif ( strpos( $field_name, 'wait_page_hide_download_button' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Business';
                    ?>
        <?php 
                } elseif ( strpos( $field_name, 'obfuscate_file_urls' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Business';
                    ?>
          <?php 
                    $show_info = 1;
                    ?>

        <?php 
                }
                
                ?>
        
      <?php 
            }
            
            ?>

      <div class="shared-files-setting-container <?php 
            echo  esc_attr( $free_class ) ;
            ?>">

        <?php 
            
            if ( $free ) {
                ?>
 
          <a href="<?php 
                echo  esc_url( get_admin_url() ) ;
                ?>options-general.php?page=shared-files-pricing">
            <div class="shared-files-settings-pro-feature-overlay"><div><?php 
                echo  esc_html( $plan_required ) ;
                ?></div></div>
          </a>
 
        <?php 
            } else {
                ?>
  
          <div class="shared-files-setting">
            <input type="checkbox" id="shared-files-<?php 
                echo  esc_attr( $field_name ) ;
                ?>" name="shared_files_settings[<?php 
                echo  esc_attr( $field_name ) ;
                ?>]" <?php 
                echo  ( isset( $options[$field_name] ) ? 'checked="checked"' : '' ) ;
                ?>>      
          </div>
          
        <?php 
            }
            
            ?>
      
      </div>

      <?php 
            
            if ( $args['field_name'] == 'wp_engine_compatibility_mode' ) {
                ?>
        <div class="email-info">
          <?php 
                echo  esc_html__( 'This should be checked if you\'re using WP Engine to host your site or if you\'re facing issues opening files.', 'shared-files' ) ;
                ?><br /><br />
          <?php 
                echo  esc_html__( 'When this option is checked, an extra "?" is automatically added to the URLs before the filename like so:', 'shared-files' ) ;
                ?><br /><b>/shared-files/123/?this-is-a-file.pdf</b><br /><br />
          <?php 
                echo  esc_html__( 'Can also be used with other hosting providers, may help solving 404 errors.', 'shared-files' ) ;
                ?>
        </div>
      <?php 
            } elseif ( $args['field_name'] == 'uncheck_hide_from_other_pages' ) {
                ?>
        <div class="email-info">
          <?php 
                echo  esc_html__( 'If checked, all uploaded files will be instantly listed on other shortcodes/pages also.', 'shared-files' ) ;
                ?><br />
        </div>
      <?php 
            } elseif ( $args['field_name'] == 'obfuscate_file_urls' || $show_info ) {
                ?>
        <div class="email-info">
          <?php 
                echo  esc_html__( 'Generate long random urls for files, like so:', 'shared-files' ) ;
                ?><br />
          <strong>/shared-files/5348-9f13c19ce03475aa0565010094d83678/this-is-a-file.pdf</strong><br /><br />
          <?php 
                echo  esc_html__( "Files can't be opened without knowing the exact long part before the filename.", 'shared-files' ) ;
                ?><br />
        </div>
      <?php 
            } elseif ( $args['field_name'] == 'remove_obsolete_file_metadata_automatically' ) {
                ?>
        <div class="email-info">
          <?php 
                echo  esc_html__( "If a file isn't readable or doesn't exist at all (you may have manually deleted the file from the server), you may want to delete the file metadata automatically, so there won't be an error message in the frontend file list.", 'shared-files' ) ;
                ?><br /><br />
          <?php 
                echo  esc_html__( "If this setting is checked, the related file metadata is automatically moved to trash.", 'shared-files' ) ;
                ?>
        </div>
      <?php 
            } elseif ( isset( $args['placeholder'] ) && $args['placeholder'] ) {
                ?>
        <div class="email-info">
          <?php 
                echo  esc_html( $args['placeholder'] ) ;
                ?><br />
        </div>
      <?php 
            }
            
            ?>

      <?php 
        }
    
    }
    
    public function restrict_file_types_render( $args )
    {
        
        if ( $field_name = $args['field_name'] ) {
            $options = get_option( 'shared_files_settings' );
            $val = '';
            if ( isset( $options[$args['field_name']] ) ) {
                $val = sanitize_text_field( $options[$args['field_name']] );
            }
            ?>

      <?php 
            $free = 0;
            ?>
      <?php 
            $free_class = '';
            ?>
      
      <?php 
            
            if ( substr( $field_name, 0, strlen( '_FREE_' ) ) === '_FREE_' ) {
                ?>
        <?php 
                $free = 1;
                ?>
        <?php 
                $free_class = 'shared-files-setting-container-free';
                ?>
      <?php 
            }
            
            ?>
      
      <div class="shared-files-setting-container <?php 
            echo  esc_attr( $free_class ) ;
            ?>">
      
        <?php 
            
            if ( $free ) {
                ?>
        
          <a href="<?php 
                echo  esc_url( get_admin_url() ) ;
                ?>options-general.php?page=shared-files-pricing">
            <div class="shared-files-settings-pro-feature-overlay"><div><?php 
                echo  esc_html__( 'All Plans', 'shared-files' ) ;
                ?></div></div>
          </a>
        
        <?php 
            } else {
                ?>
        
          <div class="shared-files-setting">
          
            <select name="shared_files_settings[<?php 
                echo  esc_attr( $args['field_name'] ) ;
                ?>]">
              <option value="" <?php 
                echo  ( $val == '' ? 'selected' : '' ) ;
                ?>></option>
              <option value="any_sound_file" <?php 
                echo  ( $val == 'any_sound_file' ? 'selected' : '' ) ;
                ?>><?php 
                echo  esc_html__( 'Any sound file', 'shared-files' ) ;
                ?></option>
              <option value="any_video_file" <?php 
                echo  ( $val == 'any_video_file' ? 'selected' : '' ) ;
                ?>><?php 
                echo  esc_html__( 'Any video file', 'shared-files' ) ;
                ?></option>
              <option value="any_image_file" <?php 
                echo  ( $val == 'any_image_file' ? 'selected' : '' ) ;
                ?>><?php 
                echo  esc_html__( 'Any image file', 'shared-files' ) ;
                ?></option>
            </select>
          
          </div>
        
        <?php 
            }
            
            ?>

      </div>
            
      <?php 
        }
    
    }
    
    public function custom_fields_cnt_render( $args )
    {
        
        if ( $field_name = $args['field_name'] ) {
            $options = get_option( 'shared_files_settings' );
            $val = '';
            if ( isset( $options[$args['field_name']] ) ) {
                $val = sanitize_text_field( $options[$args['field_name']] );
            }
            ?>
  
      <?php 
            $free = 0;
            ?>
      <?php 
            $free_class = '';
            ?>
      <?php 
            $plan_required = 'Business';
            ?>
      
      <?php 
            
            if ( substr( $field_name, 0, strlen( '_FREE_' ) ) === '_FREE_' ) {
                ?>
        <?php 
                $free = 1;
                ?>
        <?php 
                $free_class = 'shared-files-setting-container-free';
                ?>
      <?php 
            }
            
            ?>
      
      <div class="shared-files-setting-container <?php 
            echo  esc_attr( $free_class ) ;
            ?>">
      
        <?php 
            
            if ( $free ) {
                ?>
        
          <a href="<?php 
                echo  esc_url( get_admin_url() ) ;
                ?>options-general.php?page=shared-files-pricing">
            <div class="shared-files-settings-pro-feature-overlay"><div><?php 
                echo  esc_html( $plan_required ) ;
                ?></div></div>
          </a>
        
        <?php 
            } else {
                ?>
        
          <div class="shared-files-setting">
          
            <select name="shared_files_settings[<?php 
                echo  esc_attr( $args['field_name'] ) ;
                ?>]">
              <option value="" <?php 
                echo  ( $val == '' ? 'selected' : '' ) ;
                ?>></option>
              <option value="1" <?php 
                echo  ( $val == '1' ? 'selected' : '' ) ;
                ?>>1</option>
              <option value="2" <?php 
                echo  ( $val == '2' ? 'selected' : '' ) ;
                ?>>2</option>
              <option value="3" <?php 
                echo  ( $val == '3' ? 'selected' : '' ) ;
                ?>>3</option>
              <option value="4" <?php 
                echo  ( $val == '4' ? 'selected' : '' ) ;
                ?>>4</option>
              <option value="5" <?php 
                echo  ( $val == '5' ? 'selected' : '' ) ;
                ?>>5</option>
              <option value="6" <?php 
                echo  ( $val == '6' ? 'selected' : '' ) ;
                ?>>6</option>
              <option value="7" <?php 
                echo  ( $val == '7' ? 'selected' : '' ) ;
                ?>>7</option>
              <option value="8" <?php 
                echo  ( $val == '8' ? 'selected' : '' ) ;
                ?>>8</option>
              <option value="9" <?php 
                echo  ( $val == '9' ? 'selected' : '' ) ;
                ?>>9</option>
              <option value="10" <?php 
                echo  ( $val == '10' ? 'selected' : '' ) ;
                ?>>10</option>
              <option value="11" <?php 
                echo  ( $val == '11' ? 'selected' : '' ) ;
                ?>>11</option>
              <option value="12" <?php 
                echo  ( $val == '12' ? 'selected' : '' ) ;
                ?>>12</option>
              <option value="13" <?php 
                echo  ( $val == '13' ? 'selected' : '' ) ;
                ?>>13</option>
              <option value="14" <?php 
                echo  ( $val == '14' ? 'selected' : '' ) ;
                ?>>14</option>
              <option value="15" <?php 
                echo  ( $val == '15' ? 'selected' : '' ) ;
                ?>>15</option>
              <option value="16" <?php 
                echo  ( $val == '16' ? 'selected' : '' ) ;
                ?>>16</option>
              <option value="17" <?php 
                echo  ( $val == '17' ? 'selected' : '' ) ;
                ?>>17</option>
              <option value="18" <?php 
                echo  ( $val == '18' ? 'selected' : '' ) ;
                ?>>18</option>
              <option value="19" <?php 
                echo  ( $val == '19' ? 'selected' : '' ) ;
                ?>>19</option>
              <option value="20" <?php 
                echo  ( $val == '20' ? 'selected' : '' ) ;
                ?>>20</option>
            </select>

            <div class="email-info">
              <?php 
                echo  esc_html__( 'Choose a value and save the settings, and the new custom fields will be usable.', 'shared-files' ) ;
                ?>
            </div>
          
          </div>
        
        <?php 
            }
            
            ?>
  
      </div>
            
      <?php 
        }
    
    }
    
    public function textarea_render( $args )
    {
        
        if ( $field_name = $args['field_name'] ) {
            $options = get_option( 'shared_files_settings' );
            ?>    

      <?php 
            $free = 0;
            ?>
      <?php 
            $free_class = '';
            ?>
    
      <?php 
            
            if ( substr( $field_name, 0, strlen( '_FREE_' ) ) === '_FREE_' ) {
                ?>
        <?php 
                $free = 1;
                ?>
        <?php 
                $free_class = 'shared-files-setting-container-free';
                ?>
      <?php 
            }
            
            ?>

      <div class="shared-files-setting-container <?php 
            echo  esc_attr( $free_class ) ;
            ?>">

        <?php 
            
            if ( $free ) {
                ?>
 
          <a href="<?php 
                echo  esc_url( get_admin_url() ) ;
                ?>options-general.php?page=shared-files-pricing">
            <div class="shared-files-settings-pro-feature-overlay"><div><?php 
                echo  esc_html__( 'All Plans', 'shared-files' ) ;
                ?></div></div>
          </a>
 
        <?php 
            } else {
                ?>
  
          <div class="shared-files-setting">

              <?php 
                $val = '';
                ?>

              <?php 
                
                if ( isset( $options[$field_name] ) && $options[$field_name] ) {
                    ?>
                <?php 
                    $val = sanitize_textarea_field( $options[$field_name] );
                    ?>
              <?php 
                }
                
                ?>

              <textarea class="textarea-field" id="shared-files-<?php 
                echo  esc_attr( $field_name ) ;
                ?>" name="shared_files_settings[<?php 
                echo  esc_attr( $field_name ) ;
                ?>]" placeholder="<?php 
                echo  ( $args['placeholder'] ? esc_attr( $args['placeholder'] ) : '' ) ;
                ?>"><?php 
                echo  ( isset( $val ) ? esc_html( $val ) : '' ) ;
                ?></textarea>

          </div>
          
        <?php 
            }
            
            ?>
      
      </div>

      <?php 
        }
    
    }
    
    public function input_render( $args )
    {
        
        if ( $field_name = $args['field_name'] ) {
            $options = get_option( 'shared_files_settings' );
            ?>    

      <?php 
            $free = 0;
            ?>
      <?php 
            $free_class = '';
            ?>
      <?php 
            $plan_required = 'All Plans';
            ?>
    
      <?php 
            
            if ( substr( $field_name, 0, strlen( '_FREE_' ) ) === '_FREE_' ) {
                ?>
        <?php 
                $free = 1;
                ?>
        <?php 
                $free_class = 'shared-files-setting-container-free';
                ?>

        <?php 
                
                if ( strpos( $field_name, 'cf_' ) !== false && strpos( $field_name, '_select_title' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Professional';
                    ?>
        <?php 
                } elseif ( strpos( $field_name, 'exact_search_min_chars' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Professional';
                    ?>

        <?php 
                } elseif ( strpos( $field_name, 'favorite_files_text_add_to_favorites' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Business';
                    ?>
        <?php 
                } elseif ( strpos( $field_name, 'favorite_files_text_favorited' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Business';
                    ?>
        <?php 
                } elseif ( strpos( $field_name, 'favorite_files_title_text' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Business';
                    ?>
        <?php 
                } elseif ( strpos( $field_name, 'favorite_files_text_delete_from_favorites' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Business';
                    ?>
        <?php 
                } elseif ( strpos( $field_name, 'favorite_files_text_deleted' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Business';
                    ?>

        <?php 
                } elseif ( strpos( $field_name, 'wait_page_text_before_seconds' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Business';
                    ?>
        <?php 
                } elseif ( strpos( $field_name, 'wait_page_countdown_seconds' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Business';
                    ?>
        <?php 
                } elseif ( strpos( $field_name, 'wait_page_text_after_seconds' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Business';
                    ?>
        <?php 
                } elseif ( strpos( $field_name, 'wait_page_download_button_text' ) !== false ) {
                    ?>
          <?php 
                    $plan_required = 'Business';
                    ?>

        <?php 
                }
                
                ?>

      <?php 
            }
            
            ?>

      <div class="shared-files-setting-container <?php 
            echo  esc_attr( $free_class ) ;
            ?>">

        <?php 
            
            if ( $free ) {
                ?>
 
          <a href="<?php 
                echo  esc_url( get_admin_url() ) ;
                ?>options-general.php?page=shared-files-pricing">
            <div class="shared-files-settings-pro-feature-overlay"><div><?php 
                echo  esc_html( $plan_required ) ;
                ?></div></div>
          </a>
 
        <?php 
            } else {
                ?>
  
          <div class="shared-files-setting">

            <?php 
                $val = '';
                ?>
            
            <?php 
                
                if ( isset( $options[$field_name] ) ) {
                    ?>
              <?php 
                    $val = sanitize_text_field( $options[$field_name] );
                    ?>
            <?php 
                }
                
                ?>

            <?php 
                
                if ( $field_name == 'card_background_custom_color' ) {
                    ?>
              # <input type="text" style="width: 100px;" class="input-field <?php 
                    echo  ( isset( $args['wide'] ) ? 'input-field-wide' : '' ) ;
                    ?>" id="shared-files-<?php 
                    echo  esc_attr( $field_name ) ;
                    ?>" name="shared_files_settings[<?php 
                    echo  esc_attr( $field_name ) ;
                    ?>]" value="<?php 
                    echo  ( isset( $val ) ? esc_attr( $val ) : '' ) ;
                    ?>" placeholder="<?php 
                    echo  ( isset( $args['placeholder'] ) ? esc_attr( $args['placeholder'] ) : '' ) ;
                    ?>">
            <?php 
                } elseif ( isset( $args['ext'] ) ) {
                    ?>
              filename.<input type="text" class="input-field <?php 
                    echo  ( isset( $args['wide'] ) ? 'input-field-wide' : '' ) ;
                    ?>" id="shared-files-<?php 
                    echo  esc_attr( $field_name ) ;
                    ?>" name="shared_files_settings[<?php 
                    echo  esc_attr( $field_name ) ;
                    ?>]" value="<?php 
                    echo  ( isset( $val ) ? esc_attr( $val ) : '' ) ;
                    ?>" placeholder="<?php 
                    echo  ( isset( $args['placeholder'] ) ? esc_attr( $args['placeholder'] ) : '' ) ;
                    ?>" style="width: 80px;">
            <?php 
                } else {
                    ?>
              <input type="text" class="input-field <?php 
                    echo  ( isset( $args['wide'] ) ? 'input-field-wide' : '' ) ;
                    ?>" id="shared-files-<?php 
                    echo  esc_attr( $field_name ) ;
                    ?>" name="shared_files_settings[<?php 
                    echo  esc_attr( $field_name ) ;
                    ?>]" value="<?php 
                    echo  ( isset( $val ) ? esc_attr( $val ) : '' ) ;
                    ?>" placeholder="<?php 
                    echo  ( isset( $args['placeholder'] ) ? esc_attr( $args['placeholder'] ) : '' ) ;
                    ?>">
            <?php 
                }
                
                ?>

          </div>
          
        <?php 
            }
            
            ?>
      
      </div>

      <?php 
            
            if ( $field_name == 'wp_location' ) {
                ?>
        <div class="email-info">
          <?php 
                echo  esc_html__( 'If you\'re getting 404 from file URLs, it may be necessary to set this to the same folder that your WordPress is installed to. If this is set, the file URLs are formatted like so:', 'shared-files' ) ;
                ?><br /><b>/some-folder/shared-files/123/this-is-a-file.pdf</b><br /><br />
          <?php 
                echo  esc_html__( 'You should usually set this to be the first part of the url, like /some-folder/. This setting may be necessary, if you have installed WordPress in a subdirectory.', 'shared-files' ) ;
                ?><br /><br />
          <?php 
                echo  esc_html__( 'In some cases there is two extra parts before the /wp-content/... part starts, you should set this to whatever is before /wp-content/ in other url\'s used by your theme.', 'shared-files' ) ;
                ?>
        </div>
      <?php 
            } elseif ( $field_name == 'folder_for_new_files' ) {
                ?>
        <div class="email-info">
          <?php 
                echo  esc_html__( 'Normally the files are saved under wp-content/uploads/shared-files/.', 'shared-files' ) ;
                ?><br /><br />
          <?php 
                echo  esc_html__( 'If you wish the new files to be saved to a subfolder under wp-content/uploads/shared-files/, define the folder name here.', 'shared-files' ) ;
                ?><br /><br />
          <?php 
                echo  esc_html__( 'When this folder name is defined, new files will be saved under this path:', 'shared-files' ) ;
                ?><br/>
          <?php 
                echo  esc_html__( 'wp-content/uploads/shared-files/folder-name/', 'shared-files' ) ;
                ?>
        </div>
      <?php 
            } elseif ( $field_name == 'maximum_size_text' ) {
                ?>
        <div class="email-info">
          <?php 
                echo  esc_html__( 'This is for informational purposes only.' ) ;
                ?><br />
          <?php 
                echo  esc_html__( 'The text defined here replaces the default automatically detected maximum file size.', 'shared-files' ) ;
                ?>
        </div>
      <?php 
            } elseif ( $field_name == 'icon_for_image' || $field_name == 'custom_1_icon' || $field_name == 'folder_icon_uri' ) {
                ?>
        <p><?php 
                echo  esc_html__( 'e.g. /wp-content/uploads/2022/01/custom-icon.png', 'shared-files' ) ;
                ?></p>
      <?php 
            } elseif ( $field_name == 'file_upload_send_email' ) {
                ?>
        <div class="email-info">
          <?php 
                echo  esc_html__( 'Enter an email address to receive the notify, or multiple email addresses separated by a comma.', 'shared-files' ) ;
                ?>
        </div>
      <?php 
            } elseif ( $field_name == 'file_upload_custom_field_1' ) {
                ?>
        <div class="email-info">
          <?php 
                echo  esc_html__( 'Enter a title here and the custom field (an input field) is automatically activated for the uploader and the file edit view.', 'shared-files' ) ;
                ?>
        </div>
      <?php 
            } elseif ( $field_name == 'file_upload_restrict_file_extensions' ) {
                ?>
        <div class="email-info">
          <?php 
                echo  esc_html__( 'A comma separated list of accepted file extensions and/or file types, for example:', 'shared-files' ) ;
                ?>
          <ul style="list-style: inside; padding-left: 10px; margin-bottom: 0;">
            <li>.gif, .jpg, .png, .doc</li>
            <li>.doc, .docx, application/msword</li>
            <li><?php 
                echo  esc_html__( 'More information', 'shared-files' ) ;
                ?> <a href="https://developer.mozilla.org/en-US/docs/Web/HTML/Attributes/accept" target="_blank"><?php 
                echo  esc_html__( 'here', 'shared-files' ) ;
                ?></a></li>
          </ul>
        </div>
      <?php 
            }
            
            ?>

      <?php 
        }
    
    }
    
    public function shared_files_settings_general_section_callback()
    {
        echo  '<div class="shared-files-how-to-get-started">' ;
        echo  '<h2>' . esc_html__( 'How to get started', 'shared-files' ) . '</h2>' ;
        echo  '<ol>' ;
        echo  '<li><span>' ;
        $url = esc_url_raw( get_admin_url() . 'edit.php?post_type=shared_file' );
        echo  sprintf( wp_kses(
            /* translators: %s: link to file management */
            __( 'Insert files from the <a href="%s" target="_blank">file management</a>.', 'shared-files' ),
            array(
                'a' => array(
                'href'   => array(),
                'target' => array(),
            ),
            )
        ), esc_url( $url ) ) ;
        echo  '</span></li>' ;
        echo  '<li><span>' ;
        echo  wp_kses( __( 'Insert the shortcode <span class="shared-files-mini-shortcode">[shared_files]</span>, <span class="shared-files-mini-shortcode">[shared_files_simple]</span> or <span class="shared-files-mini-shortcode">[shared_files file_upload=1]</span> to the content editor of any page or post.', 'shared-files' ), array(
            'span' => array(
            'class' => array(),
        ),
        ) ) ;
        echo  '</span></li>' ;
        echo  '</ol>' ;
        echo  '</div>' ;
    }
    
    public function shared_files_settings_tab_2_callback()
    {
        echo  '</div>' ;
        echo  '<div class="shared-files-settings-tab-2">' ;
        echo  '<h2>' . esc_html__( 'Technical settings', 'shared-files' ) . '</h2>' ;
        //    echo '<p>' . esc_html__('Use these settings to...', 'shared-files') . '</p>';
    }
    
    public function shared_files_settings_tab_3_callback()
    {
        echo  '</div>' ;
        echo  '<div class="shared-files-settings-tab-3">' ;
        echo  '<h2>' . esc_html__( 'Layout settings', 'shared-files' ) . '</h2>' ;
    }
    
    public function shared_files_settings_tab_4_callback()
    {
        echo  '</div>' ;
        echo  '<div class="shared-files-settings-tab-4">' ;
        echo  '<h2>' . esc_html__( 'Custom fields', 'shared-files' ) . '</h2>' ;
    }
    
    public function shared_files_settings_tab_5_callback()
    {
        echo  '</div>' ;
        echo  '<div class="shared-files-settings-tab-5">' ;
        echo  '<h2>' . esc_html__( 'Front-end file uploader settings', 'shared-files' ) . '</h2>' ;
    }
    
    public function shared_files_settings_tab_6_callback()
    {
        echo  '</div>' ;
        echo  '<div class="shared-files-settings-tab-6">' ;
        echo  '<h2>' . esc_html__( 'Change default icons', 'shared-files' ) . '</h2>' ;
    }
    
    public function shared_files_settings_tab_7_callback()
    {
        echo  '</div>' ;
        echo  '<div class="shared-files-settings-tab-7">' ;
        echo  '<h2>' . esc_html__( 'Custom file types', 'shared-files' ) . '</h2>' ;
        echo  '<p>' . esc_html__( 'Define extensions and icons for custom file types here. You may add the files to the media library and then copy the URL to the appropriate field below.', 'shared-files' ) . '</p>' ;
    }
    
    public function shared_files_settings_tab_8_callback()
    {
        echo  '</div>' ;
        echo  '<div class="shared-files-settings-tab-8">' ;
        echo  '<h2>' . esc_html__( 'Email settings', 'shared-files' ) . '</h2>' ;
    }
    
    public function shared_files_settings_admin_list_section_callback()
    {
        echo  '</div>' ;
        echo  '<div class="shared-files-settings-tab-9">' ;
        echo  '<h2>' . esc_html__( 'Admin list', 'shared-files' ) . '</h2>' ;
    }
    
    public function shared_files_settings_tab_10_callback()
    {
        echo  '</div>' ;
        echo  '<div class="shared-files-settings-tab-10">' ;
        echo  '<h2>' . esc_html__( 'File edit settings', 'shared-files' ) . '</h2>' ;
        echo  '<p>' . esc_html__( 'These settings are valid for shortcodes [shared_files edit=1] and [shared_files_categories edit=1].', 'shared-files' ) . '</p>' ;
        echo  '<p>' . esc_html__( 'The following user roles have the permissions to edit any file:', 'shared-files' ) . '</p>' ;
    }
    
    public function shared_files_settings_tab_10_2_callback()
    {
        echo  '<p>' . esc_html__( 'More settings for file edit view:', 'shared-files' ) . '</p>' ;
    }
    
    public function shared_files_settings_tab_11_callback()
    {
        echo  '</div>' ;
        echo  '<div class="shared-files-settings-tab-11">' ;
        echo  '<h2>' . esc_html__( 'Favorites', 'shared-files' ) . '</h2>' ;
    }
    
    public function shared_files_settings_tab_12_callback()
    {
        echo  '</div>' ;
        echo  '<div class="shared-files-settings-tab-12">' ;
        echo  '<h2>' . esc_html__( 'Wait countdown page', 'shared-files' ) . '</h2>' ;
    }
    
    public function shared_files_settings_tab_13_callback()
    {
        echo  '</div>' ;
        echo  '<div class="shared-files-settings-tab-13">' ;
        echo  '<h2>' . esc_html__( 'Simple list', 'shared-files' ) . '</h2>' ;
    }
    
    public function settings_page()
    {
        ?>

    <?php 
        echo  SharedFilesAdminHelpSupport::permalinks_alert() ;
        ?>

    <form action="options.php" method="post" class="shared-files-settings-form">

      <h1><?php 
        echo  esc_html__( 'Shared Files Settings', 'shared-files' ) ;
        ?></h1>

      <div class="shared-files-settings-tabs-container">
        <ul class="shared-files-settings-tabs">
          <li class="shared-files-settings-tab-1-title" data-settings-container="shared-files-settings-tab-1"><span><?php 
        echo  esc_html__( 'General settings', 'shared-files' ) ;
        ?></span></li>
          <li class="shared-files-settings-tab-2-title" data-settings-container="shared-files-settings-tab-2"><span><?php 
        echo  esc_html__( 'Technical', 'shared-files' ) ;
        ?></span></li>
          <li class="shared-files-settings-tab-3-title" data-settings-container="shared-files-settings-tab-3"><span><?php 
        echo  esc_html__( 'Layout', 'shared-files' ) ;
        ?></span></li>
          <li class="shared-files-settings-tab-4-title" data-settings-container="shared-files-settings-tab-4"><span><?php 
        echo  esc_html__( 'Custom fields', 'shared-files' ) ;
        ?></span></li>
          <li class="shared-files-settings-tab-5-title" data-settings-container="shared-files-settings-tab-5"><span><?php 
        echo  esc_html__( 'File upload', 'shared-files' ) ;
        ?></span></li>
          <li class="shared-files-settings-tab-6-title" data-settings-container="shared-files-settings-tab-6"><span><?php 
        echo  esc_html__( 'Icons', 'shared-files' ) ;
        ?></span></li>
          <li class="shared-files-settings-tab-7-title" data-settings-container="shared-files-settings-tab-7"><span><?php 
        echo  esc_html__( 'Custom file types', 'shared-files' ) ;
        ?></span></li>
          <li class="shared-files-settings-tab-8-title" data-settings-container="shared-files-settings-tab-8"><span><?php 
        echo  esc_html__( 'Email', 'shared-files' ) ;
        ?></span></li>
          <li class="shared-files-settings-tab-9-title" data-settings-container="shared-files-settings-tab-9"><span><?php 
        echo  esc_html__( 'Admin list', 'shared-files' ) ;
        ?></span></li>
          <li class="shared-files-settings-tab-10-title" data-settings-container="shared-files-settings-tab-10"><span><?php 
        echo  esc_html__( 'File edit', 'shared-files' ) ;
        ?></span></li>

          <li class="shared-files-settings-tab-13-title" data-settings-container="shared-files-settings-tab-13"><span><?php 
        echo  esc_html__( 'Simple list', 'shared-files' ) ;
        ?></span></li>
          
          <?php 
        
        if ( shared_files_fs()->is_free_plan() || shared_files_fs()->is_plan_or_trial( 'business' ) ) {
            ?>
            <li class="shared-files-settings-tab-11-title" data-settings-container="shared-files-settings-tab-11"><span><?php 
            echo  esc_html__( 'Favorites', 'shared-files' ) ;
            ?></span></li>
            <li class="shared-files-settings-tab-12-title" data-settings-container="shared-files-settings-tab-12"><span><?php 
            echo  esc_html__( 'Wait countdown page', 'shared-files' ) ;
            ?></span></li>
          <?php 
        }
        
        ?>
          
          <hr class="clear" />
        </ul>
      </div>

      <div class="shared-files-settings-container">

        <div class="shared-files-settings-tab-1">
          <?php 
        settings_fields( 'shared-files' );
        ?>
          <?php 
        do_settings_sections( 'shared-files' );
        ?>  
        </div>
        
        <?php 
        submit_button();
        ?>
      
      </div>

    </form>
    <?php 
    }
    
    public function layout_render( $args )
    {
        
        if ( $args['field_name'] ) {
            $options = get_option( 'shared_files_settings' );
            $layout = '';
            if ( isset( $options[$args['field_name']] ) ) {
                $layout = sanitize_text_field( $options[$args['field_name']] );
            }
            ?>    
      <select name="shared_files_settings[<?php 
            echo  esc_attr( $args['field_name'] ) ;
            ?>]">
          <option value=""><?php 
            echo  esc_html__( 'Default list', 'shared-files' ) ;
            ?></option>
          <option value="2-cards-on-the-same-row" <?php 
            echo  ( $layout == '2-cards-on-the-same-row' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( '2 columns', 'shared-files' ) ;
            ?></option>
          <option value="3-cards-on-the-same-row" <?php 
            echo  ( $layout == '3-cards-on-the-same-row' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( '3 columns', 'shared-files' ) ;
            ?></option>
          <option value="4-cards-on-the-same-row" <?php 
            echo  ( $layout == '4-cards-on-the-same-row' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( '4 columns', 'shared-files' ) ;
            ?></option>
      </select>
      <?php 
        }
    
    }
    
    public function wait_page_render( $args )
    {
        
        if ( $field_name = $args['field_name'] ) {
            $options = get_option( 'shared_files_settings' );
            $val = '';
            if ( isset( $options[$field_name] ) ) {
                $val = sanitize_text_field( $options[$field_name] );
            }
            ?>

      <?php 
            $free = 0;
            ?>
      <?php 
            $free_class = '';
            ?>
      
      <?php 
            
            if ( substr( $field_name, 0, strlen( '_FREE_' ) ) === '_FREE_' ) {
                ?>
        <?php 
                $free = 1;
                ?>
        <?php 
                $free_class = 'shared-files-setting-container-free';
                ?>
      <?php 
            }
            
            ?>

      <div class="shared-files-setting-container <?php 
            echo  esc_attr( $free_class ) ;
            ?>">

        <?php 
            
            if ( $free ) {
                ?>
        
          <a href="<?php 
                echo  esc_url( get_admin_url() ) ;
                ?>options-general.php?page=shared-files-pricing">
            <div class="shared-files-settings-pro-feature-overlay"><div><?php 
                echo  esc_html__( 'Business', 'shared-files' ) ;
                ?></div></div>
          </a>
        
        <?php 
            } else {
                ?>
        
          <div class="shared-files-setting">
          
            <?php 
                $pages_args = [
                    'name'             => "shared_files_settings[" . esc_attr( $args['field_name'] ) . "]",
                    'selected'         => $val,
                    'show_option_none' => ' ',
                ];
                ?>    
            
            <?php 
                wp_dropdown_pages( $pages_args );
                ?>
            
            <div class="email-info">
              <?php 
                echo  esc_html__( "The countdown timer is displayed on the page selected above. It is hooked to the theme's function the_content(), and displayed just before the actual content.", "shared-files" ) ;
                ?>
            </div>
          
          </div>
        
        <?php 
            }
            
            ?>

      </div>

      <?php 
        }
    
    }
    
    public function icon_set_render( $args )
    {
        
        if ( $args['field_name'] ) {
            $options = get_option( 'shared_files_settings' );
            $val = '';
            if ( isset( $options[$args['field_name']] ) ) {
                $val = sanitize_text_field( $options[$args['field_name']] );
            }
            ?>    
      <select name="shared_files_settings[<?php 
            echo  esc_attr( $args['field_name'] ) ;
            ?>]">
        <option value="2020" <?php 
            echo  ( $val == '2020' || $val == '' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( 'Improved (SVG)', 'shared-files' ) ;
            ?></option>
        <option value="2019" <?php 
            echo  ( $val == '2019' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( 'First set', 'shared-files' ) ;
            ?></option>
      </select>
      <?php 
        }
    
    }
    
    public function sort_tags_by_render( $args )
    {
        
        if ( $field_name = $args['field_name'] ) {
            $options = get_option( 'shared_files_settings' );
            $val = '';
            if ( isset( $options[$args['field_name']] ) ) {
                $val = sanitize_text_field( $options[$args['field_name']] );
            }
            ?>    

      <?php 
            $free = 0;
            ?>
      <?php 
            $free_class = '';
            ?>
      <?php 
            $plan_required = 'All Plans';
            ?>
      
      <?php 
            
            if ( substr( $field_name, 0, strlen( '_FREE_' ) ) === '_FREE_' ) {
                ?>
        <?php 
                $free = 1;
                ?>
        <?php 
                $free_class = 'shared-files-setting-container-free';
                ?>
      <?php 
            }
            
            ?>

      <div class="shared-files-setting-container <?php 
            echo  esc_attr( $free_class ) ;
            ?>">
      
        <?php 
            
            if ( $free ) {
                ?>
        
          <a href="<?php 
                echo  esc_url( get_admin_url() ) ;
                ?>options-general.php?page=shared-files-pricing">
            <div class="shared-files-settings-pro-feature-overlay"><div><?php 
                echo  esc_html( $plan_required ) ;
                ?></div></div>
          </a>
        
        <?php 
            } else {
                ?>
        
          <div class="shared-files-setting">
      
            <select name="shared_files_settings[<?php 
                echo  esc_attr( $args['field_name'] ) ;
                ?>]">
                <option value="" <?php 
                echo  ( $val == '' ? 'selected' : '' ) ;
                ?>>ID</option>
                <option value="name" <?php 
                echo  ( $val == 'name' ? 'selected' : '' ) ;
                ?>><?php 
                echo  esc_html__( 'Name', 'shared-files' ) ;
                ?></option>
            </select>
            
          </div>
          
        <?php 
            }
            
            ?>
        
      </div>
      
      <?php 
        }
    
    }
    
    public function file_sync_interval_render( $args )
    {
        
        if ( $field_name = $args['field_name'] ) {
            $options = get_option( 'shared_files_settings' );
            $val = '';
            if ( isset( $options[$args['field_name']] ) ) {
                $val = sanitize_text_field( $options[$args['field_name']] );
            }
            ?>    

      <?php 
            $free = 0;
            ?>
      <?php 
            $free_class = '';
            ?>
      <?php 
            $plan_required = 'Professional';
            ?>
      
      <?php 
            
            if ( substr( $field_name, 0, strlen( '_FREE_' ) ) === '_FREE_' ) {
                ?>
        <?php 
                $free = 1;
                ?>
        <?php 
                $free_class = 'shared-files-setting-container-free';
                ?>
      <?php 
            }
            
            ?>

      <div class="shared-files-setting-container <?php 
            echo  esc_attr( $free_class ) ;
            ?>">
      
        <?php 
            
            if ( $free ) {
                ?>
        
          <a href="<?php 
                echo  esc_url( get_admin_url() ) ;
                ?>options-general.php?page=shared-files-pricing">
            <div class="shared-files-settings-pro-feature-overlay"><div><?php 
                echo  esc_html( $plan_required ) ;
                ?></div></div>
          </a>
        
        <?php 
            } else {
                ?>
        
          <div class="shared-files-setting">
      
            <select name="shared_files_settings[<?php 
                echo  esc_attr( $args['field_name'] ) ;
                ?>]">
              <option value="every_15_min" <?php 
                echo  ( $val == 'every_15_min' ? 'selected' : '' ) ;
                ?>><?php 
                echo  esc_html__( '15 minutes', 'shared-files' ) ;
                ?></option>
              <option value="shared_files_every_5_min" <?php 
                echo  ( $val == 'shared_files_every_5_min' ? 'selected' : '' ) ;
                ?>><?php 
                echo  esc_html__( '5 minutes', 'shared-files' ) ;
                ?></option>
              <option value="every_min" <?php 
                echo  ( $val == 'every_min' ? 'selected' : '' ) ;
                ?>><?php 
                echo  esc_html__( '1 minute', 'shared-files' ) ;
                ?></option>
            </select>
            
          </div>
          
        <?php 
            }
            
            ?>
        
      </div>
      
      <?php 
        }
    
    }
    
    public function trigger_download_email_render( $args )
    {
        
        if ( $field_name = $args['field_name'] ) {
            $options = get_option( 'shared_files_settings' );
            $val = '';
            if ( isset( $options[$args['field_name']] ) ) {
                $val = sanitize_text_field( $options[$args['field_name']] );
            }
            ?>    

      <?php 
            $free = 0;
            ?>
      <?php 
            $free_class = '';
            ?>
      <?php 
            $plan_required = 'Professional';
            ?>
      
      <?php 
            
            if ( substr( $field_name, 0, strlen( '_FREE_' ) ) === '_FREE_' ) {
                ?>
        <?php 
                $free = 1;
                ?>
        <?php 
                $free_class = 'shared-files-setting-container-free';
                ?>
      <?php 
            }
            
            ?>

      <div class="shared-files-setting-container <?php 
            echo  esc_attr( $free_class ) ;
            ?>">
      
        <?php 
            
            if ( $free ) {
                ?>
        
          <a href="<?php 
                echo  esc_url( get_admin_url() ) ;
                ?>options-general.php?page=shared-files-pricing">
            <div class="shared-files-settings-pro-feature-overlay"><div><?php 
                echo  esc_html( $plan_required ) ;
                ?></div></div>
          </a>
        
        <?php 
            } else {
                ?>
        
          <div class="shared-files-setting">
      
            <select name="shared_files_settings[<?php 
                echo  esc_attr( $args['field_name'] ) ;
                ?>]">
                <option value="" <?php 
                echo  ( $val == '' ? 'selected' : '' ) ;
                ?>><?php 
                echo  esc_html__( 'File title link, preview and download buttons', 'shared-files' ) ;
                ?></option>
                <option value="download_button_only" <?php 
                echo  ( $val == 'download_button_only' ? 'selected' : '' ) ;
                ?>><?php 
                echo  esc_html__( 'Download button only', 'shared-files' ) ;
                ?></option>
            </select>
            
          </div>
          
        <?php 
            }
            
            ?>
        
      </div>
      
      <?php 
        }
    
    }
    
    public function sort_categories_by_render( $args )
    {
        
        if ( $field_name = $args['field_name'] ) {
            $options = get_option( 'shared_files_settings' );
            $val = '';
            if ( isset( $options[$args['field_name']] ) ) {
                $val = sanitize_text_field( $options[$args['field_name']] );
            }
            ?>    
      
      <?php 
            $free = 0;
            ?>
      <?php 
            $free_class = '';
            ?>
      <?php 
            $plan_required = 'All Plans';
            ?>
      
      <?php 
            
            if ( substr( $field_name, 0, strlen( '_FREE_' ) ) === '_FREE_' ) {
                ?>
        <?php 
                $free = 1;
                ?>
        <?php 
                $free_class = 'shared-files-setting-container-free';
                ?>
      <?php 
            }
            
            ?>
      
      <div class="shared-files-setting-container <?php 
            echo  esc_attr( $free_class ) ;
            ?>">
      
        <?php 
            
            if ( $free ) {
                ?>
        
          <a href="<?php 
                echo  esc_url( get_admin_url() ) ;
                ?>options-general.php?page=shared-files-pricing">
            <div class="shared-files-settings-pro-feature-overlay"><div><?php 
                echo  esc_html( $plan_required ) ;
                ?></div></div>
          </a>
        
        <?php 
            } else {
                ?>
        
          <div class="shared-files-setting">
      
            <select name="shared_files_settings[<?php 
                echo  esc_attr( $args['field_name'] ) ;
                ?>]">
                <option value="" <?php 
                echo  ( $val == '' ? 'selected' : '' ) ;
                ?>>ID</option>
                <option value="name" <?php 
                echo  ( $val == 'name' ? 'selected' : '' ) ;
                ?>><?php 
                echo  esc_html__( 'Name', 'shared-files' ) ;
                ?></option>
            </select>
            
          </div>
            
        <?php 
            }
            
            ?>
        
      </div>

      <?php 
        }
    
    }
    
    public function file_open_method_render( $args )
    {
        
        if ( $args['field_name'] ) {
            $options = get_option( 'shared_files_settings' );
            $val = '';
            if ( isset( $options[$args['field_name']] ) ) {
                $val = sanitize_text_field( $options[$args['field_name']] );
            }
            ?>    
      <select name="shared_files_settings[<?php 
            echo  esc_attr( $args['field_name'] ) ;
            ?>]">
          <option value="" <?php 
            echo  ( $val == '' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( 'Default', 'shared-files' ) ;
            ?></option>
          <option value="redirect" <?php 
            echo  ( $val == 'redirect' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( 'Redirect', 'shared-files' ) ;
            ?></option>
      </select>

      <div class="email-info">
        <?php 
            echo  esc_html__( 'Default method means opening the files using the following url format:', 'shared-files' ) ;
            ?><br />
        <strong>/shared-files/123/this-is-a-file.pdf</strong><br /><br />
        <?php 
            echo  esc_html__( 'Redirect method means that while the file url is at first the same as it is using the default method, the user will be redirected to the actual location on server like so:', 'shared-files' ) ;
            ?><br />
        <strong>/wp-content/uploads/shared-files/this-is-a-file.pdf</strong>
      </div>

      <?php 
        }
    
    }
    
    public function pagination_type_render( $args )
    {
        
        if ( $args['field_name'] ) {
            $options = get_option( 'shared_files_settings' );
            $val = '';
            if ( isset( $options[$args['field_name']] ) ) {
                $val = sanitize_text_field( $options[$args['field_name']] );
            }
            ?>    
      <select name="shared_files_settings[<?php 
            echo  esc_attr( $args['field_name'] ) ;
            ?>]">
          <option value="" <?php 
            echo  ( $val == '' ? 'original' : '' ) ;
            ?>><?php 
            echo  esc_html__( 'Original', 'shared-files' ) ;
            ?></option>
          <option value="improved" <?php 
            echo  ( $val == 'improved' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( 'Improved', 'shared-files' ) ;
            ?></option>
      </select>
  
      <div class="email-info">
        <?php 
            echo  esc_html__( 'Original type means that the page links are in the following url format:', 'shared-files' ) ;
            ?><br />
        <strong>sample-page-name/page/1/, sample-page-name/page/2/, ...</strong><br /><br />
        <?php 
            echo  esc_html__( 'Improved type works via GET parameters:', 'shared-files' ) ;
            ?><br />
        <strong>sample-page-name/?_page=1, sample-page-name/?_page=2, ...</strong><br /><br />
        <?php 
            echo  esc_html__( 'Improved type must be used, if the shortcode is on the front page or various other types of pages of the site. If you are getting 404 from the page links, use the Improved type.', 'shared-files' ) ;
            ?><br />
      </div>
  
      <?php 
        }
    
    }
    
    public function preview_service_render( $args )
    {
        
        if ( $args['field_name'] ) {
            $options = get_option( 'shared_files_settings' );
            $val = '';
            if ( isset( $options[$args['field_name']] ) ) {
                $val = sanitize_text_field( $options[$args['field_name']] );
            }
            ?>    
      <select name="shared_files_settings[<?php 
            echo  esc_attr( $args['field_name'] ) ;
            ?>]">
          <option value="" <?php 
            echo  ( $val == '' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( 'Google', 'shared-files' ) ;
            ?></option>
          <option value="microsoft" <?php 
            echo  ( $val == 'microsoft' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( 'Microsoft', 'shared-files' ) ;
            ?></option>
      </select>
      <?php 
        }
    
    }
    
    public function order_by_render( $args )
    {
        
        if ( $args['field_name'] ) {
            $options = get_option( 'shared_files_settings' );
            $order_by = '';
            if ( isset( $options[$args['field_name']] ) ) {
                $order_by = sanitize_text_field( $options[$args['field_name']] );
            }
            ?>    
      <select name="shared_files_settings[<?php 
            echo  esc_attr( $args['field_name'] ) ;
            ?>]">
          <option value="post_date" <?php 
            echo  ( $order_by == 'post_date' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( 'File publish date (post date)', 'shared-files' ) ;
            ?></option>
          <option value="_sf_main_date" <?php 
            echo  ( $order_by == '_sf_main_date' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( 'File date', 'shared-files' ) ;
            ?></option>
          <option value="title" <?php 
            echo  ( $order_by == 'title' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( 'File title', 'shared-files' ) ;
            ?></option>
      </select>
      <?php 
        }
    
    }
    
    public function order_by_category_list_render( $args )
    {
        
        if ( $args['field_name'] ) {
            $options = get_option( 'shared_files_settings' );
            $order_by = '';
            if ( isset( $options[$args['field_name']] ) ) {
                $order_by = sanitize_text_field( $options[$args['field_name']] );
            }
            ?>    
      <select name="shared_files_settings[<?php 
            echo  esc_attr( $args['field_name'] ) ;
            ?>]">
          <option value=""><?php 
            echo  esc_html__( 'Description', 'shared-files' ) ;
            ?></option>
          <option value="name" <?php 
            echo  ( $order_by == 'name' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( 'Category name', 'shared-files' ) ;
            ?></option>
      </select>
      <?php 
        }
    
    }
    
    public function order_render( $args )
    {
        
        if ( $args['field_name'] ) {
            $options = get_option( 'shared_files_settings' );
            $order = '';
            if ( isset( $options[$args['field_name']] ) ) {
                $order = sanitize_text_field( $options[$args['field_name']] );
            }
            ?>
      <select name="shared_files_settings[<?php 
            echo  esc_attr( $args['field_name'] ) ;
            ?>]">
          <option value="DESC" <?php 
            echo  ( $order == 'DESC' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( 'Descending', 'shared-files' ) ;
            ?></option>
          <option value="ASC" <?php 
            echo  ( $order == 'ASC' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( 'Ascending', 'shared-files' ) ;
            ?></option>
      </select>
      <?php 
        }
    
    }
    
    public function card_background_render( $args )
    {
        
        if ( $args['field_name'] ) {
            $options = get_option( 'shared_files_settings' );
            $card_background = '';
            if ( isset( $options[$args['field_name']] ) ) {
                $card_background = sanitize_text_field( $options[$args['field_name']] );
            }
            ?>    
      <select name="shared_files_settings[<?php 
            echo  esc_attr( $args['field_name'] ) ;
            ?>]">
        <option value=""><?php 
            echo  esc_html__( 'Transparent', 'shared-files' ) ;
            ?></option>
        <option value="white" <?php 
            echo  ( $card_background == 'white' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( 'White', 'shared-files' ) ;
            ?></option>
        <option value="light_gray" <?php 
            echo  ( $card_background == 'light_gray' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( 'Light gray', 'shared-files' ) ;
            ?></option>
        <option value="custom_color" <?php 
            echo  ( $card_background == 'custom_color' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( 'Custom color', 'shared-files' ) ;
            ?></option>
      </select>
      <?php 
        }
    
    }
    
    public function card_font_render( $args )
    {
        
        if ( $args['field_name'] ) {
            $options = get_option( 'shared_files_settings' );
            $card_font = '';
            if ( isset( $options[$args['field_name']] ) ) {
                $card_font = sanitize_text_field( $options[$args['field_name']] );
            }
            ?>    
      <select name="shared_files_settings[<?php 
            echo  esc_attr( $args['field_name'] ) ;
            ?>]">
        <option value=""><?php 
            echo  esc_html__( 'Default', 'shared-files' ) ;
            ?></option>
        <option value="roboto" <?php 
            echo  ( $card_font == 'roboto' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( 'Roboto', 'shared-files' ) ;
            ?></option>
        <option value="ubuntu" <?php 
            echo  ( $card_font == 'ubuntu' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( 'Ubuntu', 'shared-files' ) ;
            ?></option>
      </select>
      <?php 
        }
    
    }
    
    public function card_featured_image_align( $args )
    {
        
        if ( $args['field_name'] ) {
            $options = get_option( 'shared_files_settings' );
            $val = '';
            if ( isset( $options[$args['field_name']] ) ) {
                $val = sanitize_text_field( $options[$args['field_name']] );
            }
            ?>    
      <select name="shared_files_settings[<?php 
            echo  esc_attr( $args['field_name'] ) ;
            ?>]">
        <option value=""><?php 
            echo  esc_html__( 'Right', 'shared-files' ) ;
            ?></option>
        <option value="left" <?php 
            echo  ( $val == 'left' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( 'Left', 'shared-files' ) ;
            ?></option>
      </select>
      <?php 
        }
    
    }

}