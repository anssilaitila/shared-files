<?php

class ShortcodeSharedFilesSimple
{
    public static function view( $atts )
    {
        // normalize attribute keys, lowercase
        $atts = array_change_key_case( (array) $atts, CASE_LOWER );
        $s = get_option( 'shared_files_settings' );
        $html = '';
        $html .= '<div class="shared-files-simple-container" />';
        $html .= '<div class="shared-files-simple-text-contact" style="display: none;">' . __( 'contact', 'shared-files' ) . '</div>';
        $html .= '<div class="shared-files-simple-text-contacts" style="display: none;">' . __( 'contacts', 'shared-files' ) . '</div>';
        $html .= '<div class="shared-files-simple-text-found" style="display: none;">' . __( 'found', 'shared-files' ) . '</div>';
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
        $wp_query = new WP_Query( array(
            'post_type'   => 'shared_file',
            'post_status' => 'publish',
            'orderby'     => SharedFilesHelpers::getOrderBy( $atts ),
            'order'       => SharedFilesHelpers::getOrder( $atts ),
            'meta_key'    => SharedFilesHelpers::getMetaKey( $atts ),
            'meta_query'  => $meta_query_hide_not_public,
        ) );
        if ( !isset( $atts['hide_search'] ) ) {
            $html .= '<input type="text" class="shared-files-simple-search" placeholder="' . (( isset( $s['search_contacts'] ) && $s['search_contacts'] ? $s['search_contacts'] : __( 'Search files...', 'shared-files' ) )) . '">';
        }
        $html .= '<div id="shared-files-files-found"></div>';
        $html .= '<span id="shared-files-one-file-found">' . __( 'file found.', 'shared-files' ) . '</span><span id="shared-files-more-than-one-file-found">' . __( 'files found.', 'shared-files' ) . '</span>';
        $html .= '<div class="shared-files-simple-nothing-found">';
        $html .= __( 'No files found.', 'shared-files' );
        $html .= '</div>';
        
        if ( $wp_query->have_posts() ) {
            $html .= '<div class="shared-files-simple-ajax-results">';
            $html .= SharedFilesPublicHelpers::SharedFilesSimpleMarkup( $wp_query );
            $html .= '</div>';
        }
        
        if ( $wp_query->found_posts == 0 ) {
            $html .= '<p>' . __( 'No files found.', 'shared-files' ) . '</p>';
        }
        $html .= '</div>';
        wp_reset_postdata();
        return $html;
    }

}