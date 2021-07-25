<?php

class ShortcodeSharedFilesSimple
{
    public static function view( $atts )
    {
        // normalize attribute keys, lowercase
        $atts = array_change_key_case( (array) $atts, CASE_LOWER );
        $s = get_option( 'shared_files_settings' );
        $limit_posts = 0;
        $html = '';
        $html .= '<div class="shared-files-simple-container" />';
        $html .= '<div class="shared-files-simple-text-contact" style="display: none;">' . esc_html__( 'contact', 'shared-files' ) . '</div>';
        $html .= '<div class="shared-files-simple-text-contacts" style="display: none;">' . esc_html__( 'contacts', 'shared-files' ) . '</div>';
        $html .= '<div class="shared-files-simple-text-found" style="display: none;">' . esc_html__( 'found', 'shared-files' ) . '</div>';
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
        ) );
        if ( !isset( $atts['hide_search'] ) ) {
            $html .= '<input type="text" class="shared-files-simple-search" placeholder="' . (( isset( $s['search_contacts'] ) && $s['search_contacts'] ? $s['search_contacts'] : esc_html__( 'Search files...', 'shared-files' ) )) . '">';
        }
        $html .= '<div id="shared-files-files-found"></div>';
        $html .= '<span id="shared-files-one-file-found">' . esc_html__( 'file found.', 'shared-files' ) . '</span><span id="shared-files-more-than-one-file-found">' . esc_html__( 'files found.', 'shared-files' ) . '</span>';
        $html .= '<div class="shared-files-simple-nothing-found">';
        $html .= esc_html__( 'No files found.', 'shared-files' );
        $html .= '</div>';
        
        if ( $wp_query->have_posts() ) {
            $html .= '<div class="shared-files-simple-ajax-results">';
            $html .= SharedFilesPublicHelpers::SharedFilesSimpleMarkup( $wp_query );
            $html .= '</div>';
        }
        
        if ( !$limit_posts ) {
            $html .= SharedFilesPublicPagination::getPagination( $pagination_active, $wp_query, 'default' );
        }
        /*
            $pagination_args = array(
              'base'         => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
              'total'        => $wp_query->max_num_pages,
              'current'      => max(1, get_query_var('paged')),
              'format'       => '?paged=%#%',
              'show_all'     => true,
              'type'         => 'plain',
              'prev_next'    => false,
              'add_args'     => false,
              'add_fragment' => '',
            );
            
            if (!$limit_posts) {
            
              $html .= '<div id="shared-files-pagination" class="shared-files-pagination">';
              
              if (paginate_links($pagination_args)) {
                $html .= '<span class="shared-files-more-files">' . esc_html__('Browse more files:', 'shared-files') . '</span>' .
                paginate_links($pagination_args);
              }
              
              $html .= '</div>';
            
            }
        */
        if ( $wp_query->found_posts == 0 ) {
            $html .= '<p>' . esc_html__( 'No files found.', 'shared-files' ) . '</p>';
        }
        $html .= '</div>';
        wp_reset_postdata();
        return $html;
    }

}