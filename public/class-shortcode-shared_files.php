<?php

class ShortcodeSharedFiles
{
    /**
     * Search view embeddable via shortcode.
     *
     * @since    1.0.0
     */
    public static function shared_files( $atts = array(), $content = null, $tag = '' )
    {
        // normalize attribute keys, lowercase
        $atts = array_change_key_case( (array) $atts, CASE_LOWER );
        $s = get_option( 'shared_files_settings' );
        
        if ( isset( $atts['file_id'] ) ) {
            $file_id = (int) $atts['file_id'];
            $html = '';
            $html .= SharedFilesHelpers::initLayout( $s );
            $wpb_all_query = new WP_Query( array(
                'post_type'      => 'shared_file',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'p'              => $file_id,
            ) );
            $filetypes = SharedFilesHelpers::getFiletypes();
            $external_filetypes = SharedFilesHelpers::getExternalFiletypes();
            $html .= '<div id="shared-files-search">';
            $html .= '<ul id="myList">';
            
            if ( $wpb_all_query->have_posts() ) {
                while ( $wpb_all_query->have_posts() ) {
                    $wpb_all_query->the_post();
                    $id = get_the_id();
                    $c = get_post_custom( $id );
                    $external_url = ( isset( $c['_sf_external_url'] ) ? $c['_sf_external_url'][0] : '' );
                    $filetype = '';
                    $imagefile = SharedFilesHelpers::getImageFile( $id, $external_url );
                    $html .= SharedFilesPublicViews::fileListItem( $c, $imagefile, $atts['hide_description'] );
                }
            } else {
                $html .= '<div class="sf_error">' . __( 'File not found', 'shared-files' ) . '</div>';
            }
            
            $html .= '</ul>';
            $html .= '</div>';
            return $html;
        } else {
            $layout = '';
            
            if ( isset( $atts['layout'] ) ) {
                $layout = $atts['layout'];
            } elseif ( isset( $s['layout'] ) && $s['layout'] ) {
                $layout = $s['layout'];
            }
            
            $html = '';
            $html .= SharedFilesHelpers::initLayout( $s );
            $html .= '<div class="shared-files-container ' . (( $layout ? 'shared-files-' . $layout : '' )) . '">';
            $html .= '<div id="shared-files-search">';
            
            if ( isset( $atts['category'] ) ) {
                $html = SharedFilesPublicViews::sfProFeaturePublicMarkup();
                return $html;
            } else {
                
                if ( isset( $_GET['c'] ) && $_GET['c'] != 'all_files' ) {
                    $term_slug = sanitize_title( $_GET['c'] );
                    $wpb_all_query = new WP_Query( array(
                        'post_type'      => 'shared_file',
                        'post_status'    => 'publish',
                        'posts_per_page' => -1,
                        'tax_query'      => array( array(
                        'taxonomy'         => 'shared-file-category',
                        'field'            => 'slug',
                        'terms'            => $term_slug,
                        'include_children' => true,
                    ) ),
                    ) );
                    $wpb_all_query_all_files = new WP_Query( array(
                        'post_type'      => 'shared_file',
                        'post_status'    => 'publish',
                        'posts_per_page' => -1,
                        'tax_query'      => array( array(
                        'taxonomy'         => 'shared-file-category',
                        'field'            => 'slug',
                        'terms'            => $term_slug,
                        'include_children' => true,
                    ) ),
                    ) );
                } else {
                    $paged = ( get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1 );
                    $wpb_all_query = new WP_Query( array(
                        'post_type'      => 'shared_file',
                        'post_status'    => 'publish',
                        'posts_per_page' => 20,
                        'paged'          => $paged,
                    ) );
                    $wpb_all_query_all_files = new WP_Query( array(
                        'post_type'      => 'shared_file',
                        'post_status'    => 'publish',
                        'posts_per_page' => -1,
                    ) );
                }
            
            }
            
            $filetypes = SharedFilesHelpers::getFiletypes();
            $external_filetypes = SharedFilesHelpers::getExternalFiletypes();
            $html .= '<div id="shared-files-files-found"></div>';
            $html .= '<span id="shared-files-one-file-found">' . __( 'file found.', 'shared-files' ) . '</span><span id="shared-files-more-than-one-file-found">' . __( 'files found.', 'shared-files' ) . '</span>';
            $html .= '<ul id="myList">';
            if ( $wpb_all_query->have_posts() ) {
                while ( $wpb_all_query->have_posts() ) {
                    $wpb_all_query->the_post();
                    $id = get_the_id();
                    $c = get_post_custom( $id );
                    $external_url = ( isset( $c['_sf_external_url'] ) ? $c['_sf_external_url'][0] : '' );
                    $filetype = '';
                    $imagefile = SharedFilesHelpers::getImageFile( $id, $external_url );
                    $html .= SharedFilesPublicViews::fileListItem( $c, $imagefile, $atts['hide_description'] );
                }
            }
            $html .= '</ul>';
            $pagination_args = array(
                'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                'total'        => $wpb_all_query->max_num_pages,
                'current'      => max( 1, get_query_var( 'paged' ) ),
                'format'       => '?paged=%#%',
                'show_all'     => true,
                'type'         => 'plain',
                'prev_next'    => false,
                'add_args'     => false,
                'add_fragment' => '',
            );
            $html .= '<div id="shared-files-pagination" class="shared-files-pagination">';
            if ( paginate_links( $pagination_args ) ) {
                $html .= '<span class="shared-files-more-files">' . __( 'Browse more files:', 'shared-files' ) . '</span>' . paginate_links( $pagination_args );
            }
            $html .= '</div>';
            $html .= '<div id="shared-files-nothing-found">';
            $html .= __( 'No files found.', 'shared-files' );
            $html .= '</div>';
            $html .= '</div></div><hr class="clear" />';
            wp_reset_postdata();
            return $html;
        }
    
    }

}