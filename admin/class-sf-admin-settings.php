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
        register_setting( 'shared-files', 'shared_files_settings' );
        add_settings_field(
            'shared-files-icon_set',
            esc_html__( 'Icon set', 'shared-files' ),
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
            esc_html__( 'General settings', 'shared-files' ),
            array( $this, 'shared_files_settings_general_section_callback' ),
            'shared-files'
        );
        add_settings_field(
            'shared-files-hide_search_form',
            esc_html__( 'Hide search form', 'shared-files' ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_section_general',
            array(
            'label_for'  => 'shared-files-hide_search_form',
            'field_name' => 'hide_search_form',
        )
        );
        add_settings_field(
            'shared-files-show_tag_dropdown',
            esc_html__( 'Show tag dropdown', 'shared-files' ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_section_general',
            array(
            'label_for'  => 'shared-files-show_tag_dropdown',
            'field_name' => 'show_tag_dropdown',
        )
        );
        add_settings_field(
            'shared-files-hide_date_from_card',
            esc_html__( 'Hide file date / publish date from card', 'shared-files' ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_section_general',
            array(
            'label_for'  => 'shared-files-hide_date_from_card',
            'field_name' => 'hide_date_from_card',
        )
        );
        add_settings_field(
            'shared-files-hide_file_size_from_card',
            esc_html__( 'Hide file size from card', 'shared-files' ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_section_general',
            array(
            'label_for'  => 'shared-files-hide_file_size_from_card',
            'field_name' => 'hide_file_size_from_card',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'delete_expired_files',
            esc_html__( 'Delete expired files (files will be moved to trash when the expiration date is reached)', 'shared-files' ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_section_general',
            array(
            'label_for'  => 'shared-files-' . $only_pro . 'delete_expired_files',
            'field_name' => $only_pro . 'delete_expired_files',
        )
        );
        add_settings_field(
            'shared-files-preview_service',
            esc_html__( 'Preview service', 'shared-files' ),
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
            esc_html__( 'Always show preview button for PDF files', 'shared-files' ),
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
            esc_html__( 'Bypass the preview service when previewing PDF files. The file is opened in the browser directly.', 'shared-files' ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_section_general',
            array(
            'label_for'  => 'shared-files-bypass_preview_pdf',
            'field_name' => 'bypass_preview_pdf',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'enable_preview_for_password_protected_files',
            esc_html__( 'Enable the use of the preview service for password protected files', 'shared-files' ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_section_general',
            array(
            'label_for'  => 'shared-files-' . $only_pro . 'enable_preview_for_password_protected_files',
            'field_name' => $only_pro . 'enable_preview_for_password_protected_files',
        )
        );
        add_settings_field(
            'shared-files-hide_preview_button',
            esc_html__( 'Hide preview button', 'shared-files' ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_section_general',
            array(
            'label_for'  => 'shared-files-hide_preview_button',
            'field_name' => 'hide_preview_button',
        )
        );
        add_settings_field(
            'shared-files-hide_file_type_icon_from_card',
            esc_html__( 'Hide file type icon from card', 'shared-files' ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_section_general',
            array(
            'label_for'  => 'shared-files-hide_file_type_icon_from_card',
            'field_name' => 'hide_file_type_icon_from_card',
        )
        );
        add_settings_field(
            'shared-files-show_download_button',
            esc_html__( 'Show download button on card', 'shared-files' ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_section_general',
            array(
            'label_for'  => 'shared-files-show_download_button',
            'field_name' => 'show_download_button',
        )
        );
        add_settings_field(
            'shared-files-textarea_for_file_description',
            esc_html__( 'Use textarea for file description (instead of rich text editor)', 'shared-files' ),
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
            esc_html__( 'Order by', 'shared-files' ),
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
            esc_html__( 'Order', 'shared-files' ),
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
            esc_html__( 'Order by (category list)', 'shared-files' ),
            array( $this, 'order_by_category_list_render' ),
            'shared-files',
            'shared-files_section_general',
            array(
            'label_for'  => 'shared-files-' . $only_pro . 'order_by_category_list',
            'field_name' => $only_pro . 'order_by_category_list',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'hide_category_name_from_card',
            esc_html__( 'Hide category name(s) from card', 'shared-files' ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_section_general',
            array(
            'label_for'  => 'shared-files-' . $only_pro . 'hide_category_name_from_card',
            'field_name' => $only_pro . 'hide_category_name_from_card',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'pagination',
            esc_html__( 'Pagination (number of files on one page)', 'shared-files' ),
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
            'shared-files-pagination_type',
            esc_html__( 'Pagination type', 'shared-files' ),
            array( $this, 'pagination_type_render' ),
            'shared-files',
            'shared-files_section_general',
            array(
            'label_for'  => 'shared-files-pagination_type',
            'field_name' => 'pagination_type',
        )
        );
        add_settings_field(
            'shared-files-maximum_size_text',
            esc_html__( 'Maximum size of uploaded file', 'shared-files' ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_section_general',
            array(
            'label_for'   => 'shared-files-maximum_size_text',
            'field_name'  => 'maximum_size_text',
            'placeholder' => SharedFilesHelpers::maxUploadSize(),
        )
        );
        add_settings_field(
            'shared-files-file_open_method',
            esc_html__( 'File opening method', 'shared-files' ),
            array( $this, 'file_open_method_render' ),
            'shared-files',
            'shared-files_section_general',
            array(
            'label_for'  => 'shared-files-file_open_method',
            'field_name' => 'file_open_method',
        )
        );
        add_settings_field(
            'shared-files-wp_engine_compatibility_mode',
            esc_html__( 'Compatibility mode', 'shared-files' ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_section_general',
            array(
            'label_for'  => 'shared-files-wp_engine_compatibility_mode',
            'field_name' => 'wp_engine_compatibility_mode',
        )
        );
        add_settings_field(
            'shared-files-wp_location',
            esc_html__( 'WordPress location', 'shared-files' ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_section_general',
            array(
            'label_for'   => 'shared-files-wp_location',
            'field_name'  => 'wp_location',
            'placeholder' => '/some-dir/',
        )
        );
        add_settings_field(
            'shared-files-folder_for_new_files',
            esc_html__( 'Folder for new files', 'shared-files' ),
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
            'shared-files-' . $only_pro . 'download_limit_msg',
            esc_html__( 'Message for download limit reached', 'shared-files' ),
            array( $this, 'textarea_render' ),
            'shared-files',
            'shared-files_section_general',
            array(
            'label_for'   => 'shared-files-' . $only_pro . 'download_limit_msg',
            'field_name'  => $only_pro . 'download_limit_msg',
            'placeholder' => 'This file is no longer available for download.',
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
            'shared-files-layout',
            esc_html__( 'Layout', 'shared-files' ),
            array( $this, 'layout_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-layout',
            'field_name' => 'layout',
        )
        );
        add_settings_field(
            'shared-files-card_font',
            esc_html__( 'Card font', 'shared-files' ),
            array( $this, 'card_font_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-card_font',
            'field_name' => 'card_font',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'card_align_elements_vertically',
            esc_html__( 'Align elements vertically and centered (inside card)', 'shared-files' ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-' . $only_pro . 'card_align_elements_vertically',
            'field_name' => $only_pro . 'card_align_elements_vertically',
        )
        );
        add_settings_field(
            'shared-files-card_small_font_size',
            esc_html__( 'Small font size on card', 'shared-files' ),
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
            esc_html__( 'Hide tags from the file card', 'shared-files' ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-' . $only_pro . 'hide_tags',
            'field_name' => $only_pro . 'hide_tags',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'show_tags_on_search_results',
            esc_html__( 'Show tags on search results cards', 'shared-files' ),
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
            esc_html__( 'Show featured image in addition to file type icon', 'shared-files' ) . '<div style="font-weight: 400; font-style: italic; font-size: 12px; margin-top: 3px;">' . esc_html__( 'Featured image will be displayed next to file description.', 'shared-files' ) . '<br />' . esc_html__( 'Normally it is displayed instead of file type icon.', 'shared-files' ) . '</div>',
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
            esc_html__( 'Use a larger, non-cropped version of the featured image', 'shared-files' ) . '<div style="font-weight: 400; font-style: italic; font-size: 12px; margin-top: 3px;">' . esc_html__( '"Show featured image in addition to file type icon" must also be checked.', 'shared-files' ) . '</div>',
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
            esc_html__( 'Featured image container width (px)', 'shared-files' ),
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
            esc_html__( 'Featured image container height (px)', 'shared-files' ),
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
            esc_html__( 'Show featured image for password protected files', 'shared-files' ),
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
            esc_html__( 'Align featured image', 'shared-files' ),
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
            esc_html__( 'Card height in pixels', 'shared-files' ),
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
            esc_html__( 'Card background', 'shared-files' ),
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
            esc_html__( 'Card background, custom color (HEX code)', 'shared-files' ) . '<div style="font-weight: 400; font-style: italic; font-size: 12px; margin-top: 3px;">' . esc_html__( 'See', 'shared-files' ) . ' <a href="https://htmlcolorcodes.com/" target="_blank">htmlcolorcodes.com</a></div>',
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'   => 'shared-files-card_background_custom_color',
            'field_name'  => 'card_background_custom_color',
            'placeholder' => '',
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
            'shared-files-icon_image',
            esc_html__( 'File type: Image', 'shared-files' ),
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
            esc_html__( 'File type: PDF', 'shared-files' ),
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
            esc_html__( 'File type: AI', 'shared-files' ),
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
            esc_html__( 'File type: Doc', 'shared-files' ),
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
            esc_html__( 'File type: Font', 'shared-files' ),
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
            esc_html__( 'File type: HTML', 'shared-files' ),
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
            esc_html__( 'File type: MP3', 'shared-files' ),
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
            esc_html__( 'File type: Video', 'shared-files' ),
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
            esc_html__( 'File type: XLSX', 'shared-files' ),
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
            esc_html__( 'File type: PPT(X)', 'shared-files' ),
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
            esc_html__( 'File type: ZIP', 'shared-files' ),
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
            esc_html__( 'File type: INDD', 'shared-files' ),
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
            esc_html__( 'File type: PSD', 'shared-files' ),
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
            esc_html__( 'File type: SVG', 'shared-files' ),
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
            esc_html__( 'File type: Other files', 'shared-files' ),
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
            esc_html__( 'YouTube-link (External URL)', 'shared-files' ),
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
        $tab = 4;
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
        $tab = 5;
        add_settings_section(
            'shared-files_tab_' . $tab,
            '',
            array( $this, 'shared_files_settings_tab_' . $tab . '_callback' ),
            'shared-files'
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'send_email',
            esc_html__( 'Send an email notify when a file is downloaded', 'shared-files' ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-' . $only_pro . 'send_email',
            'field_name' => $only_pro . 'send_email',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'add_ip_to_file_downloaded_email',
            __( "Add the downloader's IP address to the email", 'shared-files' ),
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
            esc_html__( 'Send an email notify when a file is automatically activated for a category', 'shared-files' ),
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
            esc_html__( 'Notification recipient email', 'shared-files' ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'   => 'shared-files-' . $only_pro . 'recipient_email',
            'field_name'  => $only_pro . 'recipient_email',
            'placeholder' => '',
        )
        );
        //    $tab = 6;
        add_settings_section(
            'shared-files_section_admin_list',
            '',
            array( $this, 'shared_files_settings_admin_list_section_callback' ),
            'shared-files'
        );
        add_settings_field(
            'shared-files-hide_limit_downloads',
            esc_html__( 'Hide "Limit downloads"-column', 'shared-files' ),
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
            esc_html__( 'Hide "File added"-column', 'shared-files' ),
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
            esc_html__( 'Hide "Last access"-column', 'shared-files' ),
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
            esc_html__( 'Hide "Bandwidth usage"-column', 'shared-files' ),
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
            esc_html__( 'Hide "Expiration date"-column', 'shared-files' ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_section_admin_list',
            array(
            'label_for'  => 'shared-files-' . $only_pro . 'hide_expiration_date',
            'field_name' => $only_pro . 'hide_expiration_date',
        )
        );
        $tab = 7;
        add_settings_section(
            'shared-files_tab_' . $tab,
            '',
            array( $this, 'shared_files_settings_tab_' . $tab . '_callback' ),
            'shared-files'
        );
        add_settings_field(
            'shared-files-only_logged_in_users_can_add_files',
            esc_html__( 'Only logged in users can add files using the front-end file uploader', 'shared-files' ),
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
            esc_html__( 'Hide file uploader info', 'shared-files' ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-hide_file_uploader_info',
            'field_name' => 'hide_file_uploader_info',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'file_upload_allow_featured_image',
            esc_html__( 'Enable featured image (a separate file can be added)', 'shared-files' ),
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
            esc_html__( 'Show category checkboxes for front-end file uploader (instead of dropdown)', 'shared-files' ),
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
            esc_html__( 'Show category and tag checkboxes on multiple columns', 'shared-files' ),
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
            esc_html__( 'Allow the uploader to create a new category', 'shared-files' ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-' . $only_pro . 'file_upload_new_category',
            'field_name' => $only_pro . 'file_upload_new_category',
        )
        );
        add_settings_field(
            'shared-files-show_tag_dropdown_on_file_upload',
            esc_html__( 'Show tag dropdown for front-end file uploader', 'shared-files' ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-show_tag_dropdown_on_file_upload',
            'field_name' => 'show_tag_dropdown_on_file_upload',
        )
        );
        add_settings_field(
            'shared-files-show_tag_checkboxes_on_file_upload',
            esc_html__( 'Show tag checkboxes for front-end file uploader', 'shared-files' ),
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
            esc_html__( 'Uncheck "Hide from other pages" for uploaded files', 'shared-files' ),
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
            esc_html__( 'Show External Url on file upload form', 'shared-files' ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'  => 'shared-files-file_upload_show_external_url',
            'field_name' => 'file_upload_show_external_url',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'file_upload_external_url_title',
            esc_html__( 'Text for External URL', 'shared-files' ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'   => 'shared-files-' . $only_pro . 'file_upload_external_url_title',
            'field_name'  => $only_pro . 'file_upload_external_url_title',
            'placeholder' => 'Or enter a YouTube URL:',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'file_upload_restrict_file_types',
            esc_html__( 'Restrict accepted file types', 'shared-files' ),
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
            esc_html__( 'Restrict accepted file extensions', 'shared-files' ),
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
            'shared-files-' . $only_pro . 'file_upload_custom_field_1',
            esc_html__( 'Custom field 1', 'shared-files' ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'   => 'shared-files-' . $only_pro . 'file_upload_custom_field_1',
            'field_name'  => $only_pro . 'file_upload_custom_field_1',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'file_upload_custom_field_2',
            esc_html__( 'Custom field 2', 'shared-files' ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'   => 'shared-files-' . $only_pro . 'file_upload_custom_field_2',
            'field_name'  => $only_pro . 'file_upload_custom_field_2',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'file_upload_custom_field_3',
            esc_html__( 'Custom field 3', 'shared-files' ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'   => 'shared-files-' . $only_pro . 'file_upload_custom_field_3',
            'field_name'  => $only_pro . 'file_upload_custom_field_3',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'file_upload_password',
            esc_html__( 'Allow the uploader to define a password for the file', 'shared-files' ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
            'label_for'   => 'shared-files-' . $only_pro . 'password',
            'field_name'  => $only_pro . 'file_upload_password',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'file_upload_send_email',
            esc_html__( 'Send and email notify when a file is uploaded and / or send an email to all users having one of the roles below:', 'shared-files' ),
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
        $tab = 8;
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
            echo  $free_class ;
            ?>">

        <?php 
            
            if ( $free ) {
                ?>
 
          <a href="<?php 
                echo  get_admin_url() ;
                ?>options-general.php?page=shared-files-pricing">
            <div class="shared-files-settings-pro-feature-overlay"><span>Pro</span></div>
          </a>
 
        <?php 
            } else {
                ?>
  
          <div class="shared-files-setting">
            <input type="checkbox" id="shared-files-<?php 
                echo  $field_name ;
                ?>" name="shared_files_settings[<?php 
                echo  $field_name ;
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
                $val = $options[$args['field_name']];
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
            echo  $free_class ;
            ?>">
      
        <?php 
            
            if ( $free ) {
                ?>
        
        <a href="<?php 
                echo  get_admin_url() ;
                ?>options-general.php?page=shared-files-pricing">
          <div class="shared-files-settings-pro-feature-overlay"><span>Pro</span></div>
        </a>
        
        <?php 
            } else {
                ?>
        
        <div class="shared-files-setting">
        
          <select name="shared_files_settings[<?php 
                echo  $args['field_name'] ;
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
            echo  $free_class ;
            ?>">

        <?php 
            
            if ( $free ) {
                ?>
 
          <a href="<?php 
                echo  get_admin_url() ;
                ?>options-general.php?page=shared-files-pricing">
            <div class="shared-files-settings-pro-feature-overlay"><span>Pro</span></div>
          </a>
 
        <?php 
            } else {
                ?>
  
          <div class="shared-files-setting">

              <textarea class="textarea-field" id="shared-files-<?php 
                echo  $field_name ;
                ?>" name="shared_files_settings[<?php 
                echo  $field_name ;
                ?>]" placeholder="<?php 
                echo  ( $args['placeholder'] ? $args['placeholder'] : '' ) ;
                ?>"><?php 
                echo  ( isset( $options[$field_name] ) ? $options[$field_name] : '' ) ;
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
            echo  $free_class ;
            ?>">

        <?php 
            
            if ( $free ) {
                ?>
 
          <a href="<?php 
                echo  get_admin_url() ;
                ?>options-general.php?page=shared-files-pricing">
            <div class="shared-files-settings-pro-feature-overlay"><span>Pro</span></div>
          </a>
 
        <?php 
            } else {
                ?>
  
          <div class="shared-files-setting">

            <?php 
                
                if ( $field_name == 'card_background_custom_color' ) {
                    ?>
              # <input type="text" style="width: 100px;" class="input-field <?php 
                    echo  ( isset( $args['wide'] ) ? 'input-field-wide' : '' ) ;
                    ?>" id="shared-files-<?php 
                    echo  $field_name ;
                    ?>" name="shared_files_settings[<?php 
                    echo  $field_name ;
                    ?>]" value="<?php 
                    echo  ( isset( $options[$field_name] ) ? $options[$field_name] : '' ) ;
                    ?>" placeholder="<?php 
                    echo  ( isset( $args['placeholder'] ) ? $args['placeholder'] : '' ) ;
                    ?>">
            <?php 
                } elseif ( isset( $args['ext'] ) ) {
                    ?>
              filename.<input type="text" class="input-field <?php 
                    echo  ( isset( $args['wide'] ) ? 'input-field-wide' : '' ) ;
                    ?>" id="shared-files-<?php 
                    echo  $field_name ;
                    ?>" name="shared_files_settings[<?php 
                    echo  $field_name ;
                    ?>]" value="<?php 
                    echo  ( isset( $options[$field_name] ) ? $options[$field_name] : '' ) ;
                    ?>" placeholder="<?php 
                    echo  ( isset( $args['placeholder'] ) ? $args['placeholder'] : '' ) ;
                    ?>" style="width: 80px;">
            <?php 
                } else {
                    ?>
              <input type="text" class="input-field <?php 
                    echo  ( isset( $args['wide'] ) ? 'input-field-wide' : '' ) ;
                    ?>" id="shared-files-<?php 
                    echo  $field_name ;
                    ?>" name="shared_files_settings[<?php 
                    echo  $field_name ;
                    ?>]" value="<?php 
                    echo  ( isset( $options[$field_name] ) ? $options[$field_name] : '' ) ;
                    ?>" placeholder="<?php 
                    echo  ( isset( $args['placeholder'] ) ? $args['placeholder'] : '' ) ;
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
                echo  esc_html__( 'If you\'re getting 404 from file URLs, it may be necessary to set this to the same directory that your WordPress is installed to. If this is set, the file URLs are formatted like so:<br /><b>/some-dir/shared-files/123/this-is-a-file.pdf</b>', 'shared-files' ) ;
                ?><br /><br />
          <?php 
                echo  esc_html__( 'You should only set this to be the first part of the url, like /some-dir/. This setting may be necessary, if you have installed WordPress in a subdirectory.', 'shared-files' ) ;
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
            } elseif ( $field_name == 'icon_for_image' || $field_name == 'custom_1_icon' ) {
                ?>
        <p><?php 
                echo  esc_html__( 'e.g. /wp-content/uploads/2019/12/some-fancy-icon.png', 'shared-files' ) ;
                ?></p>
      <?php 
            } elseif ( $field_name == 'file_upload_send_email' ) {
                ?>
        <div class="email-info">
          <?php 
                echo  esc_html__( 'Enter an email address to receive the notify.', 'shared-files' ) ;
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
        $url = get_admin_url() . 'edit.php?post_type=shared_file';
        $text = sprintf( wp_kses(
            /* translators: %s: link to file management */
            __( 'Insert files from the <a href="%s" target="_blank">file management</a>.', 'shared-files' ),
            array(
                'a' => array(
                'href'   => array(),
                'target' => array(),
            ),
            )
        ), esc_url( $url ) );
        echo  $text ;
        echo  '</span></li>' ;
        echo  '<li><span>' ;
        $text = wp_kses( __( 'Insert the shortcode <span class="shared-files-mini-shortcode">[shared_files]</span>, <span class="shared-files-mini-shortcode">[shared_files_simple]</span> or <span class="shared-files-mini-shortcode">[shared_files file_upload=1]</span> to the content editor of any page or post.', 'shared-files' ), array(
            'span' => array(
            'class' => array(),
        ),
        ) );
        echo  $text ;
        echo  '</span></li>' ;
        echo  '</ol>' ;
        echo  '</div>' ;
    }
    
    public function shared_files_settings_tab_2_callback()
    {
        echo  '</div>' ;
        echo  '<div class="shared-files-settings-tab-2">' ;
        echo  '<h2>' . esc_html__( 'Layout settings', 'shared-files' ) . '</h2>' ;
    }
    
    public function shared_files_settings_tab_3_callback()
    {
        echo  '</div>' ;
        echo  '<div class="shared-files-settings-tab-3">' ;
        echo  '<h2>' . esc_html__( 'Change default file icons', 'shared-files' ) . '</h2>' ;
    }
    
    public function shared_files_settings_tab_4_callback()
    {
        echo  '</div>' ;
        echo  '<div class="shared-files-settings-tab-4">' ;
        echo  '<h2>' . esc_html__( 'Custom file types', 'shared-files' ) . '</h2>' ;
        echo  '<p>' . esc_html__( 'Define extensions and icons for custom file types here. You may add the files to the media library and then copy the URL to the appropriate field below.', 'shared-files' ) . '</p>' ;
    }
    
    public function shared_files_settings_tab_5_callback()
    {
        echo  '</div>' ;
        echo  '<div class="shared-files-settings-tab-5">' ;
        echo  '<h2>' . esc_html__( 'Email settings', 'shared-files' ) . '</h2>' ;
    }
    
    public function shared_files_settings_admin_list_section_callback()
    {
        echo  '</div>' ;
        echo  '<div class="shared-files-settings-tab-6">' ;
        echo  '<h2>' . esc_html__( 'Admin list', 'shared-files' ) . '</h2>' ;
    }
    
    public function shared_files_settings_tab_7_callback()
    {
        echo  '</div>' ;
        echo  '<div class="shared-files-settings-tab-7">' ;
        echo  '<h2>' . esc_html__( 'Front-end file uploader settings', 'shared-files' ) . '</h2>' ;
    }
    
    public function shared_files_settings_tab_8_callback()
    {
        echo  '</div>' ;
        echo  '<div class="shared-files-settings-tab-8">' ;
        echo  '<h2>' . esc_html__( 'File edit settings', 'shared-files' ) . '</h2>' ;
        echo  '<p>' . esc_html__( 'These settings are valid for shortcodes [shared_files edit=1] and [shared_files_categories edit=1].', 'shared-files' ) . '</p>' ;
        echo  '<p>' . esc_html__( 'The following user roles have the permissions to edit any file:', 'shared-files' ) . '</p>' ;
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
        echo  esc_html__( 'Layout', 'shared-files' ) ;
        ?></span></li>
          <li class="shared-files-settings-tab-3-title" data-settings-container="shared-files-settings-tab-3"><span><?php 
        echo  esc_html__( 'File type icons', 'shared-files' ) ;
        ?></span></li>
          <li class="shared-files-settings-tab-4-title" data-settings-container="shared-files-settings-tab-4"><span><?php 
        echo  esc_html__( 'Custom file types', 'shared-files' ) ;
        ?></span></li>
          <li class="shared-files-settings-tab-5-title" data-settings-container="shared-files-settings-tab-5"><span><?php 
        echo  esc_html__( 'Email', 'shared-files' ) ;
        ?></span></li>
          <li class="shared-files-settings-tab-6-title" data-settings-container="shared-files-settings-tab-6"><span><?php 
        echo  esc_html__( 'Admin list & columns', 'shared-files' ) ;
        ?></span></li>
          <li class="shared-files-settings-tab-7-title" data-settings-container="shared-files-settings-tab-7"><span><?php 
        echo  esc_html__( 'File upload', 'shared-files' ) ;
        ?></span></li>
          <li class="shared-files-settings-tab-8-title" data-settings-container="shared-files-settings-tab-8"><span><?php 
        echo  esc_html__( 'File edit', 'shared-files' ) ;
        ?></span></li>
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
                $layout = $options[$args['field_name']];
            }
            ?>    
      <select name="shared_files_settings[<?php 
            echo  $args['field_name'] ;
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
    
    public function icon_set_render( $args )
    {
        
        if ( $args['field_name'] ) {
            $options = get_option( 'shared_files_settings' );
            $val = '';
            if ( isset( $options[$args['field_name']] ) ) {
                $val = $options[$args['field_name']];
            }
            ?>    
      <select name="shared_files_settings[<?php 
            echo  $args['field_name'] ;
            ?>]">
          <option value="2020" <?php 
            echo  ( $val == '2020' || $val == '' ? 'selected' : '' ) ;
            ?>>2020</option>
          <option value="2019" <?php 
            echo  ( $val == '2019' ? 'selected' : '' ) ;
            ?>>2019</option>
      </select>
      <?php 
        }
    
    }
    
    public function file_open_method_render( $args )
    {
        
        if ( $args['field_name'] ) {
            $options = get_option( 'shared_files_settings' );
            $val = '';
            if ( isset( $options[$args['field_name']] ) ) {
                $val = $options[$args['field_name']];
            }
            ?>    
      <select name="shared_files_settings[<?php 
            echo  $args['field_name'] ;
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
                $val = $options[$args['field_name']];
            }
            ?>    
      <select name="shared_files_settings[<?php 
            echo  $args['field_name'] ;
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
                $val = $options[$args['field_name']];
            }
            ?>    
      <select name="shared_files_settings[<?php 
            echo  $args['field_name'] ;
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
                $order_by = $options[$args['field_name']];
            }
            ?>    
      <select name="shared_files_settings[<?php 
            echo  $args['field_name'] ;
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
                $order_by = $options[$args['field_name']];
            }
            ?>    
      <select name="shared_files_settings[<?php 
            echo  $args['field_name'] ;
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
                $order = $options[$args['field_name']];
            }
            ?>
      <select name="shared_files_settings[<?php 
            echo  $args['field_name'] ;
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
                $card_background = $options[$args['field_name']];
            }
            ?>    
      <select name="shared_files_settings[<?php 
            echo  $args['field_name'] ;
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
                $card_font = $options[$args['field_name']];
            }
            ?>    
      <select name="shared_files_settings[<?php 
            echo  $args['field_name'] ;
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
                $val = $options[$args['field_name']];
            }
            ?>    
      <select name="shared_files_settings[<?php 
            echo  $args['field_name'] ;
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