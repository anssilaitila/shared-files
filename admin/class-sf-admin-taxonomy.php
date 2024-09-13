<?php

class SharedFilesAdminTaxonomy {
    public function create_shared_files_custom_taxonomy() {
        if ( SHARED_FILES_TAG_SLUG != 'post_tag' ) {
            $labels_tag = array(
                'name'              => sanitize_text_field( __( 'Tag', 'shared-files' ) ),
                'singular_name'     => sanitize_text_field( __( 'Tag', 'shared-files' ) ),
                'search_items'      => sanitize_text_field( __( 'Search Tags', 'shared-files' ) ),
                'all_items'         => sanitize_text_field( __( 'All Tags', 'shared-files' ) ),
                'parent_item'       => sanitize_text_field( __( 'Parent Tag', 'shared-files' ) ),
                'parent_item_colon' => sanitize_text_field( __( 'Parent Tag:', 'shared-files' ) ),
                'edit_item'         => sanitize_text_field( __( 'Edit Tag', 'shared-files' ) ),
                'update_item'       => sanitize_text_field( __( 'Update Tag', 'shared-files' ) ),
                'add_new_item'      => sanitize_text_field( __( 'Add New Tag', 'shared-files' ) ),
                'new_item_name'     => sanitize_text_field( __( 'New Type Name', 'shared-files' ) ),
                'menu_name'         => sanitize_text_field( __( 'Tags', 'shared-files' ) ),
            );
            register_taxonomy( SHARED_FILES_TAG_SLUG, array('shared_file'), array(
                'hierarchical'       => false,
                'labels'             => $labels_tag,
                'show_ui'            => true,
                'show_admin_column'  => true,
                'query_var'          => true,
                'rewrite'            => array(
                    'slug' => 'tag',
                ),
                'publicly_queryable' => false,
            ) );
        }
        $labels_category = array(
            'name'              => sanitize_text_field( __( 'Category', 'shared-files' ) ),
            'singular_name'     => sanitize_text_field( __( 'Category', 'shared-files' ) ),
            'search_items'      => sanitize_text_field( __( 'Search Categories', 'shared-files' ) ),
            'all_items'         => sanitize_text_field( __( 'All Categories', 'shared-files' ) ),
            'parent_item'       => sanitize_text_field( __( 'Parent Category', 'shared-files' ) ),
            'parent_item_colon' => sanitize_text_field( __( 'Parent Category:', 'shared-files' ) ),
            'edit_item'         => sanitize_text_field( __( 'Edit Category', 'shared-files' ) ),
            'update_item'       => sanitize_text_field( __( 'Update Category', 'shared-files' ) ),
            'add_new_item'      => sanitize_text_field( __( 'Add New Category', 'shared-files' ) ),
            'new_item_name'     => sanitize_text_field( __( 'New Type Name', 'shared-files' ) ),
            'menu_name'         => sanitize_text_field( __( 'Categories', 'shared-files' ) ),
        );
    }

    public function register_categories_info_page() {
        add_submenu_page(
            'edit.php?post_type=shared_file',
            sanitize_text_field( __( 'Categories', 'shared-files' ) ),
            sanitize_text_field( __( 'Categories', 'shared-files' ) ),
            'manage_options',
            'shared-files-categories-info',
            [$this, 'register_categories_info_page_callback'],
            3
        );
    }

    public function register_categories_info_page_callback() {
        ?>

    <div class="wrap shared-files-admin-page">
      <h1><?php 
        echo esc_html__( 'Categories', 'shared-files' );
        ?></h1>

      <?php 
        echo SharedFilesAdminHelpers::sfProFeatureMarkup();
        ?>

      <h2 style="margin-top: 24px;"><?php 
        echo esc_html__( 'Category password protection and file sync in Pro:' );
        ?></h2>

      <img src="<?php 
        echo esc_url_raw( SHARED_FILES_URI );
        ?>img/category-password-protection.png" style="max-width: 770px; height: auto; border: 1px solid #bbb;" />

    </div>
    <?php 
    }

    function taxonomy_custom_fields( $term ) {
        ?>

    <tr class="form-field">
      <th scope="row" valign="top">
      </th>
      <td>
        <div class="shared-files-category-description-info"><b><?php 
        echo esc_html__( 'The description field above can be used to alter the order of the categories in [shared_files_categories]-shortcode.', 'shared-files' );
        ?></b><br /><br /><?php 
        echo esc_html__( 'If a value is entered, the categories are sorted by that.', 'shared-files' );
        ?></div>
      </td>
    </tr>

    <?php 
        ?>

  <?php 
    }

    public function theme_columns( $theme_columns ) {
        $new_columns = [];
        $columns_set = 0;
        if ( !$columns_set ) {
            $new_columns = array(
                'cb'          => '<input type="checkbox" />',
                'name'        => sanitize_text_field( __( 'Name' ) ),
                'description' => sanitize_text_field( __( 'Description' ) ),
                'shortcode'   => sanitize_text_field( __( 'Shortcode', 'shared-files' ) ),
                'slug'        => sanitize_text_field( __( 'Slug' ) ),
                'posts'       => sanitize_text_field( __( 'Posts' ) ),
            );
        }
        return $new_columns;
    }

    function save_term_fields( $term_id ) {
    }

    public function add_shared_file_category_column_content( $content, $column_name, $term_id ) {
        $term = get_term( $term_id, 'shared-file-category' );
        switch ( $column_name ) {
            case 'restriction':
                break;
            case 'shortcode':
                $content = '<span class="shared-files-shortcode-admin-list shared-files-shortcode-' . sanitize_title( $term->slug ) . '" title="[shared_files category=' . sanitize_title( $term->slug ) . ']">[shared_files category=' . sanitize_title( $term->slug ) . ']</span>' . '<button class="shared-files-copy shared-files-copy-admin-list" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-' . sanitize_title( $term->slug ) . '">' . sanitize_text_field( __( 'Copy', 'shared-files' ) ) . '</button>';
                break;
            default:
                break;
        }
        return $content;
    }

}
