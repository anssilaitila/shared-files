<?php

class SharedFilesSettingsTabFavorites {
    public function init() {
        $tabs = new SharedFilesSettingsTabs();
        $field_render = new SharedFilesSettingsFieldRender();
        $only_pro = '_FREE_';
        $s = get_option( 'shared_files_settings' );
        $tab = 11;
        add_settings_section(
            'shared-files_tab_' . $tab,
            '',
            array($tabs, 'shared_files_settings_tab_' . $tab . '_callback'),
            'shared-files'
        );
        add_settings_field(
            'shared-files-' . $only_pro . 'activate_favorite_files_for_logged_in',
            sanitize_text_field( __( 'Activate favorite files for logged in users', 'shared-files' ) ),
            array($field_render, 'checkbox_render'),
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
            array($field_render, 'checkbox_render'),
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
            array($field_render, 'input_render'),
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
            array($field_render, 'input_render'),
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
            array($field_render, 'input_render'),
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
            array($field_render, 'input_render'),
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
            array($field_render, 'checkbox_render'),
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
            array($field_render, 'input_render'),
            'shared-files',
            'shared-files_tab_' . $tab,
            array(
                'label_for'   => 'shared-files-' . $only_pro . 'favorite_files_title_text',
                'field_name'  => $only_pro . 'favorite_files_title_text',
                'placeholder' => 'Favorite files',
            )
        );
    }

}
