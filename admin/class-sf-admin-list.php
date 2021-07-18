<?php

class SharedFilesAdminList
{
    /**
     * Custom columns for shared file.
     *
     * @since    1.0.0
     */
    public function shared_file_custom_columns( $defaults )
    {
        $s = get_option( 'shared_files_settings' );
        $defaults['file_url'] = __( 'Shortcode', 'shared-files' );
        $defaults['filesize'] = __( 'File size', 'shared-files' );
        $defaults['load_cnt'] = __( 'File loads', 'shared-files' );
        if ( !isset( $s['hide_limit_downloads'] ) ) {
            $defaults['limit_downloads'] = __( 'Limit', 'shared-files' );
        }
        if ( !isset( $s['hide_file_added'] ) ) {
            $defaults['file_added'] = __( 'File added', 'shared-files' );
        }
        if ( !isset( $s['hide_last_access'] ) ) {
            $defaults['last_access'] = __( 'Last access', 'shared-files' );
        }
        if ( !isset( $s['hide_bandwidth_usage'] ) ) {
            $defaults['bandwidth_usage'] = __( 'Bandwidth usage (estimate)', 'shared-files' );
        }
        if ( !isset( $s['hide_expiration_date'] ) ) {
            $defaults['expiration_date'] = __( 'Expires', 'shared-files' );
        }
        return $defaults;
    }
    
    public function set_custom_shared_files_sortable_columns( $columns )
    {
        $columns['taxonomy-shared-file-category'] = 'shared-file-category';
        $columns['expiration_date'] = '_sf_expiration_date';
        $columns['file_added'] = '_sf_file_added';
        $columns['last_access'] = '_sf_last_access';
        $columns['load_cnt'] = '_sf_load_cnt';
        $columns['limit_downloads'] = '_sf_limit_downloads';
        $columns['filesize'] = '_sf_filesize';
        return $columns;
    }
    
    public function sort_posts_by_meta_value( $query )
    {
        if ( !is_admin() || !$query->is_main_query() ) {
            return;
        }
        global  $pagenow ;
        if ( is_admin() && $pagenow == 'edit.php' && isset( $_GET['post_type'] ) && $_GET['post_type'] == 'shared_file' && isset( $_GET['orderby'] ) && $_GET['orderby'] != 'None' ) {
            
            if ( $_GET['orderby'] == '_sf_expiration_date' ) {
                $query->query_vars['orderby'] = 'meta_value';
                $query->query_vars['meta_key'] = $_GET['orderby'];
            } elseif ( $_GET['orderby'] == '_sf_file_added' ) {
                $query->query_vars['orderby'] = 'meta_value';
                $query->query_vars['meta_key'] = $_GET['orderby'];
                $query->query_vars['meta_type'] = 'DATETIME';
            } elseif ( $_GET['orderby'] == '_sf_last_access' ) {
                $query->query_vars['orderby'] = 'meta_value';
                $query->query_vars['meta_key'] = $_GET['orderby'];
                $query->query_vars['meta_type'] = 'DATETIME';
            } elseif ( $_GET['orderby'] == '_sf_load_cnt' ) {
                $query->query_vars['orderby'] = 'meta_value';
                $query->query_vars['meta_key'] = $_GET['orderby'];
                $query->query_vars['meta_type'] = 'numeric';
            } elseif ( $_GET['orderby'] == '_sf_limit_downloads' ) {
                $query->query_vars['orderby'] = 'meta_value';
                $query->query_vars['meta_key'] = $_GET['orderby'];
                $query->query_vars['meta_type'] = 'numeric';
            } elseif ( $_GET['orderby'] == '_sf_filesize' ) {
                $query->query_vars['orderby'] = 'meta_value';
                $query->query_vars['meta_key'] = $_GET['orderby'];
                $query->query_vars['meta_type'] = 'numeric';
            }
        
        }
    }
    
    /**
     * Custom column content for shared file.
     *
     * @since    1.0.0
     */
    public function shared_file_custom_columns_content( $column_name, $post_ID )
    {
        switch ( $column_name ) {
            case 'file_url':
                echo  '<span class="shared-files-shortcode-admin-list shared-files-shortcode-admin-list-file shared-files-shortcode-' . $post_ID . '" title="[shared_files file_id=' . $post_ID . ']">[shared_files file_id=' . $post_ID . ']</span>' ;
                echo  '<button class="shared-files-copy shared-files-copy-admin-list" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-' . $post_ID . '">' . __( 'Copy', 'shared-files' ) . '</button>' ;
                $folder_name = get_post_meta( get_the_ID(), '_sf_subdir', true );
                if ( $folder_name ) {
                    echo  '<hr class="clear" /><div class="shared-files-admin-folder-name">' . $folder_name . '/</div>' ;
                }
                $file = get_post_meta( get_the_ID(), '_sf_file', true );
                $file_url = SharedFilesAdminHelpers::sf_root() . '/shared-files/' . $post_ID . '/' . SharedFilesHelpers::wp_engine() . get_post_meta( $post_ID, '_sf_filename', true );
                echo  '<hr class="clear" /><a href="' . $file_url . '" class="shared-files-admin-file-url" target="_blank">' . $file_url . '</a>' ;
                break;
            case 'filesize':
                
                if ( get_post_meta( $post_ID, '_sf_external_url', true ) ) {
                    echo  'n/a' ;
                } else {
                    echo  SharedFilesAdminHelpers::human_filesize( get_post_meta( $post_ID, '_sf_filesize', true ) ) ;
                }
                
                break;
            case 'load_cnt':
                if ( SharedFilesHelpers::isPremium() == 0 ) {
                    echo  '<div class="shared-files-pro-only">' . __( 'Pro' ) . '</div>' ;
                }
                break;
            case 'limit_downloads':
                if ( SharedFilesHelpers::isPremium() == 0 ) {
                    echo  '<div class="shared-files-pro-only">' . __( 'Pro' ) . '</div>' ;
                }
                break;
            case 'file_added':
                echo  get_post_meta( $post_ID, '_sf_file_added', true ) ;
                break;
            case 'last_access':
                if ( SharedFilesHelpers::isPremium() == 0 ) {
                    echo  '<div class="shared-files-pro-only">' . __( 'Pro' ) . '</div>' ;
                }
                break;
            case 'bandwidth_usage':
                if ( SharedFilesHelpers::isPremium() == 0 ) {
                    echo  '<div class="shared-files-pro-only">' . __( 'Pro' ) . '</div>' ;
                }
                break;
            case 'expiration_date':
                if ( SharedFilesHelpers::isPremium() == 0 ) {
                    echo  '<div class="shared-files-pro-only">' . __( 'Pro' ) . '</div>' ;
                }
                break;
        }
    }
    
    function filter_files_by_taxonomies( $post_type, $which )
    {
        // Apply this only on a specific post type
        if ( $post_type !== 'shared_file' ) {
            return;
        }
        $taxonomy_slug = 'shared-file-category';
        $current_category_slug = ( isset( $_GET['shared-file-category'] ) ? $_GET['shared-file-category'] : '' );
        if ( get_taxonomy( $taxonomy_slug ) ) {
            wp_dropdown_categories( [
                'show_option_all' => get_taxonomy( $taxonomy_slug )->labels->all_items,
                'hide_empty'      => 1,
                'hierarchical'    => 1,
                'show_count'      => 1,
                'orderby'         => 'name',
                'name'            => $taxonomy_slug,
                'value_field'     => 'slug',
                'taxonomy'        => $taxonomy_slug,
                'selected'        => $current_category_slug,
            ] );
        }
    }
    
    public function sort_by_custom_taxonomy( $clauses, $wp_query )
    {
        global  $wpdb ;
        
        if ( isset( $wp_query->query['orderby'] ) && $wp_query->query['orderby'] == 'shared-file-category' ) {
            $clauses['join'] .= "\n        LEFT OUTER JOIN {$wpdb->term_relationships} ON {$wpdb->posts}.ID={$wpdb->term_relationships}.object_id\n        LEFT OUTER JOIN {$wpdb->term_taxonomy} USING (term_taxonomy_id)\n        LEFT OUTER JOIN {$wpdb->terms} USING (term_id)\n        ";
            $clauses['where'] .= " AND (taxonomy = 'shared-file-category' OR taxonomy IS NULL)";
            $clauses['groupby'] = "object_id";
            $clauses['orderby'] = "GROUP_CONCAT({$wpdb->terms}.name ORDER BY name ASC) ";
            $clauses['orderby'] .= ( 'ASC' == strtoupper( $wp_query->get( 'order' ) ) ? 'ASC' : 'DESC' );
        }
        
        return $clauses;
    }

}