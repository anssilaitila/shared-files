<?php

class SharedFilesAdminCPT {
    /**
     * Create custom post type.
     *
     * @since    1.0.0
     */
    public function create_custom_post_type() {
        $s = get_option( 'shared_files_settings' );
        $cpt_supports = array('title', 'thumbnail');
        $publicly_queryable = false;
        $exclude_from_search = true;
        $show_description_in_rest_api = false;
        register_post_type( 'shared_file', [
            'labels'              => [
                'name'          => 'Shared Files',
                'singular_name' => sanitize_text_field( __( 'File', 'shared-files' ) ),
                'add_new_item'  => sanitize_text_field( __( 'Add New File', 'shared-files' ) ),
                'edit_item'     => sanitize_text_field( __( 'Edit File', 'shared-files' ) ),
                'not_found'     => sanitize_text_field( __( 'No files found.', 'shared-files' ) ),
                'all_items'     => sanitize_text_field( __( 'File Manager', 'shared-files' ) ),
                'add_new'       => sanitize_text_field( __( 'Add New File', 'shared-files' ) ),
                'search_items'  => sanitize_text_field( __( 'Search Files', 'shared-files' ) ),
            ],
            'supports'            => $cpt_supports,
            'public'              => $publicly_queryable,
            'show_ui'             => true,
            'has_archive'         => false,
            'publicly_queryable'  => $publicly_queryable,
            'menu_icon'           => 'dashicons-index-card',
            'taxonomies'          => array(SHARED_FILES_TAG_SLUG),
            'exclude_from_search' => $exclude_from_search,
            'show_in_rest'        => true,
        ] );
        remove_post_type_support( 'shared_file', 'editor' );
    }

}
