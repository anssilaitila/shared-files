<?php

class Shared_Files_Settings {
    public function shared_files_add_admin_menu() {
        $tabs = new SharedFilesSettingsTabs();
        add_options_page(
            'Shared Files Settings',
            'Shared Files',
            'manage_options',
            'shared-files',
            array($tabs, 'settings_page')
        );
    }

    public function shared_files_settings_init() {
        $tabs = new SharedFilesSettingsTabs();
        $field_render = new SharedFilesSettingsFieldRender();
        $tab_1_content = new SharedFilesSettingsTab1Content();
        $tab_2_content = new SharedFilesSettingsTab2Content();
        $tab_3_content = new SharedFilesSettingsTab3Content();
        $tab_4_content = new SharedFilesSettingsTab4Content();
        $tab_5_content = new SharedFilesSettingsTab5Content();
        $tab_file_types_content = new SharedFilesSettingsTabFileTypes();
        $tab_content_custom_icons = new SharedFilesSettingsTabCustomIcons();
        $tab_content_email = new SharedFilesSettingsTabEmail();
        $tab_content_admin_list = new SharedFilesSettingsTabAdminList();
        $tab_content_file_edit = new SharedFilesSettingsTabFileEdit();
        $tab_content_favorites = new SharedFilesSettingsTabFavorites();
        $tab_content_wait_countdown = new SharedFilesSettingsTabWaitCountdown();
        $tab_content_simple_list = new SharedFilesSettingsTabSimpleList();
        $tab_content_custom_post_type = new SharedFilesSettingsTabCustomPostType();
        $tab_content_lead_generation = new SharedFilesSettingsTabLeadGeneration();
        $tab_content_single_file = new SharedFilesSettingsTabSingleFile();
        $tab_content_exact_search = new SharedFilesSettingsTabExactSearch();
        $tab_content_search_log = new SharedFilesSettingsTabSearchLog();
        $only_pro = '_FREE_';
        $s = get_option( 'shared_files_settings' );
        register_setting( 'shared-files', 'shared_files_settings' );
        // General settings
        $tab_1_content->init();
        // Technical
        $tab_2_content->init();
        // Layout
        $tab_3_content->init();
        // Custom fields
        $tab_4_content->init();
        // File upload
        $tab_5_content->init();
        // ...
        // Allow more file types
        $tab_file_types_content->init();
        // Custom icons
        $tab_content_custom_icons->init();
        // Email
        $tab_content_email->init();
        // Admin list ( POISTA )
        $tab_content_admin_list->init();
        // File edit
        $tab_content_file_edit->init();

        // Favorites
        $tab_content_favorites->init();
        // Wait countdown page
        $tab_content_wait_countdown->init();

        // Simple list
        $tab_content_simple_list->init();
        // Custom post type
        $tab_content_custom_post_type->init();
        // Lead generation
        $tab_content_lead_generation->init();
        // Single file
        $tab_content_single_file->init( 'single-file' );

        // Exact search
        $tab_content_exact_search->init( 'exact-search' );

        $tab_content_search_log->init( 'search-log' );
    }

}
