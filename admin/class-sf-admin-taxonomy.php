<?php

class SharedFilesAdminTaxonomy
{
    public function create_shared_files_custom_taxonomy()
    {
        $labels = array(
            'name'              => __( 'Category', 'shared-files' ),
            'singular_name'     => __( 'Category', 'shared-files' ),
            'search_items'      => __( 'Search Categories', 'shared-files' ),
            'all_items'         => __( 'All Categories', 'shared-files' ),
            'parent_item'       => __( 'Parent Category', 'shared-files' ),
            'parent_item_colon' => __( 'Parent Category:', 'shared-files' ),
            'edit_item'         => __( 'Edit Category', 'shared-files' ),
            'update_item'       => __( 'Update Category', 'shared-files' ),
            'add_new_item'      => __( 'Add New Category', 'shared-files' ),
            'new_item_name'     => __( 'New Type Name', 'shared-files' ),
            'menu_name'         => __( 'Categories', 'shared-files' ),
        );
    }
    
    public function register_categories_info_page()
    {
        add_submenu_page(
            'edit.php?post_type=shared_file',
            __( 'Categories', 'shared-files' ),
            __( 'Categories', 'shared-files' ),
            'manage_options',
            'shared-files-categories-info',
            [ $this, 'register_categories_info_page_callback' ]
        );
    }
    
    public function register_categories_info_page_callback()
    {
        ?>

    <div class="wrap">
      <h1><?php 
        echo  __( 'Categories', 'shared-files' ) ;
        ?></h1>

      <?php 
        echo  SharedFilesAdminHelpers::sfProFeatureMarkup() ;
        ?>

    </div>
    <?php 
    }

}