<?php

class ShortcodeSharedFilesSimple
{
    public static function view( $atts )
    {
        // normalize attribute keys, lowercase
        $atts = array_change_key_case( (array) $atts, CASE_LOWER );
        $s = get_option( 'shared_files_settings' );
        $elem_class = SharedFilesHelpers::createElemClass();
        $limit_posts = 0;
        $html = '';
        $html .= '<div class="' . $elem_class . ' shared-files-simple-container" />';
        $html .= '<div class="shared-files-simple-text-contact" style="display: none;">' . sanitize_text_field( __( 'contact', 'shared-files' ) ) . '</div>';
        $html .= '<div class="shared-files-simple-text-contacts" style="display: none;">' . sanitize_text_field( __( 'contacts', 'shared-files' ) ) . '</div>';
        $html .= '<div class="shared-files-simple-text-found" style="display: none;">' . sanitize_text_field( __( 'found', 'shared-files' ) ) . '</div>';
        $limit_posts = 0;
        $tax_query = [];
        $meta_query_hide_not_public = array(
            'relation' => 'OR',
        );
        $meta_query_hide_not_public[] = array(
            'key'     => '_sf_not_public',
            'compare' => '=',
            'value'   => '',
        );
        $meta_query_hide_not_public[] = array(
            'key'     => '_sf_not_public',
            'compare' => 'NOT EXISTS',
        );
        $posts_per_page = ( isset( $s['pagination'] ) && $s['pagination'] ? (int) $s['pagination'] : 20 );
        $pagination_active = 1;
        $paged = 1;
        if ( $pagination_active ) {
            
            if ( isset( $_GET['_page'] ) && $_GET['_page'] ) {
                $paged = (int) $_GET['_page'];
            } elseif ( get_query_var( 'paged' ) ) {
                $paged = absint( get_query_var( 'paged' ) );
            }
        
        }
        if ( $limit_posts ) {
            $posts_per_page = $limit_posts;
        }
        $wp_query = new WP_Query( array(
            'post_type'      => 'shared_file',
            'post_status'    => 'publish',
            'paged'          => $paged,
            'posts_per_page' => $posts_per_page,
            'orderby'        => SharedFilesHelpers::getOrderBy( $atts ),
            'order'          => SharedFilesHelpers::getOrder( $atts ),
            'meta_key'       => SharedFilesHelpers::getMetaKey( $atts ),
            'meta_query'     => $meta_query_hide_not_public,
            'tax_query'      => $tax_query,
        ) );
        $wp_query_all_files = new WP_Query( array(
            'post_type'      => 'shared_file',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => SharedFilesHelpers::getOrderBy( $atts ),
            'order'          => SharedFilesHelpers::getOrder( $atts ),
            'meta_key'       => SharedFilesHelpers::getMetaKey( $atts ),
            'meta_query'     => $meta_query_hide_not_public,
            'tax_query'      => $tax_query,
        ) );
        if ( !isset( $s['hide_search_form'] ) && !isset( $atts['hide_search'] ) ) {
            $html .= '<input type="text" class="shared-files-simple-search" placeholder="' . (( isset( $s['search_contacts'] ) && $s['search_contacts'] ? esc_attr( $s['search_contacts'] ) : esc_attr__( 'Search files...', 'shared-files' ) )) . '" data-elem-class="' . $elem_class . '">';
        }
        $html .= '<div class="shared-files-files-found"></div>';
        $html .= '<span class="shared-files-one-file-found">' . sanitize_text_field( __( 'file found.', 'shared-files' ) ) . '</span><span class="shared-files-more-than-one-file-found">' . sanitize_text_field( __( 'files found.', 'shared-files' ) ) . '</span>';
        $html .= '<div class="shared-files-simple-nothing-found">';
        $html .= sanitize_text_field( __( 'No files found.', 'shared-files' ) );
        $html .= '</div>';
        
        if ( $wp_query->have_posts() ) {
            $html .= '<div class="shared-files-simple-ajax-results">';
            $html .= SharedFilesPublicHelpers::SharedFilesSimpleMarkup( $wp_query, 0, $atts );
            $html .= '</div>';
        }
        
        if ( $wp_query_all_files->have_posts() ) {
            
            if ( !isset( $s['hide_search_form'] ) && !isset( $atts['hide_search'] ) ) {
                $html .= '<div class="shared-files-simple-search-all-files">';
                $html .= SharedFilesPublicHelpers::SharedFilesSimpleMarkup( $wp_query_all_files, 0, $atts );
                $html .= '</div>';
            }
        
        }
        if ( !$limit_posts ) {
            $html .= SharedFilesPublicPagination::getPagination( $pagination_active, $wp_query, 'default' );
        }
        if ( $wp_query->found_posts == 0 ) {
            $html .= '<p>' . sanitize_text_field( __( 'No files found.', 'shared-files' ) ) . '</p>';
        }
        $html .= '</div>';
        wp_reset_postdata();
        return $html;
    }

}