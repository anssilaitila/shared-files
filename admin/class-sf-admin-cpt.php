<?php

class SharedFilesAdminCPT {

  /**
   * Create custom post type.
   *
   * @since    1.0.0
   */
  public function create_custom_post_type()  {

    register_post_type('shared_file',
                       [
                          'labels'      => [
                            'name'             => 'Shared Files',
                            'singular_name'    => __('File', 'shared-files'),
                            'add_new_item'     => __('Add New File', 'shared-files'),
                            'edit_item'        => __('Edit File', 'shared-files'),
                            'not_found'        => __('No files found.', 'shared-files'),
                            'all_items'        => __('File Management', 'shared-files'),
                            'add_new'          => __('Add New', 'shared-files')
                          ],
                          'public'             => false,
                          'show_ui'            => true,
                          'has_archive'        => false,
                          'publicly_queryable' => false,
                          'menu_icon'          => 'dashicons-index-card'                          
                       ]
    );

    remove_post_type_support('shared_file', 'editor');

  }

}
