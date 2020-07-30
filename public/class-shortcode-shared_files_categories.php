<?php

class ShortcodeSharedFilesCategories
{
    public static function shared_files_categories( $atts = array(), $content = null, $tag = '' )
    {
        $html = SharedFilesAdminHelpers::sfProFeatureMarkup();
        return $html;
        // normalize attribute keys, lowercase
        $atts = array_change_key_case( (array) $atts, CASE_LOWER );
        $s = get_option( 'shared_files_settings' );
        $layout = '';
        
        if ( isset( $atts['layout'] ) ) {
            $layout = $atts['layout'];
        } elseif ( isset( $s['layout'] ) && $s['layout'] ) {
            $layout = $s['layout'];
        }
        
        $html = '';
        $category_slug = ( isset( $_GET['cat'] ) ? $_GET['cat'] : '' );
        if ( isset( $atts['category'] ) && !$category_slug ) {
            $category_slug = sanitize_title( $atts['category'] );
        }
        
        if ( isset( $_GET['cat'] ) ) {
            $cat = $_GET['cat'];
            $parent_cat = get_term_by( 'slug', $cat, 'shared-file-category' );
            $subcategories = get_terms( array(
                'taxonomy'   => 'shared-file-category',
                'hide_empty' => true,
                'parent'     => $parent_cat->term_id,
            ) );
            $html .= '<a href="javascript:history.back()">' . (( isset( $s['back_link_title'] ) && $s['back_link_title'] ? $s['back_link_title'] : __( '<< Back', 'shared-files' ) )) . '</a>';
            
            if ( sizeof( $subcategories ) > 0 ) {
                $html .= SharedFilesPublicHelpers::listCategories( $subcategories );
            } else {
                $category = get_term_by( 'slug', $category_slug, 'shared-file-category' );
                if ( $category ) {
                    $html .= '<h3 class="contact-list-group-title">' . $category->name . '</h3>';
                }
                $html .= SharedFilesHelpers::initLayout( $s );
                $html .= '<div class="shared-files-container ' . (( $layout ? 'shared-files-' . $layout : '' )) . '">';
                $html .= '<div id="shared-files-search">';
                $term_slug = sanitize_title( $cat );
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
                $filetypes = SharedFilesHelpers::getFiletypes();
                $external_filetypes = SharedFilesHelpers::getExternalFiletypes();
                
                if ( $wpb_all_query->have_posts() ) {
                    $html .= '<ul id="myList">';
                    while ( $wpb_all_query->have_posts() ) {
                        $wpb_all_query->the_post();
                        $id = get_the_id();
                        $c = get_post_custom( $id );
                        $external_url = ( isset( $c['_sf_external_url'] ) ? $c['_sf_external_url'][0] : '' );
                        $filetype = '';
                        $hide_description = ( isset( $atts['hide_description'] ) ? $atts['hide_description'] : '' );
                        $imagefile = SharedFilesHelpers::getImageFile( $id, $external_url );
                        $html .= SharedFilesPublicHelpers::fileListItem( $c, $imagefile, $hide_description );
                    }
                    $html .= '</ul>';
                } else {
                    $html .= '<p>' . __( 'No files in this category.', 'shared-files' ) . '</p>';
                }
                
                $html .= '</div></div><hr class="clear" />';
            }
        
        } else {
            $category = get_term_by( 'slug', $category_slug, 'shared-file-category' );
            $terms = '';
            if ( isset( $atts['category'] ) ) {
                $terms = sanitize_title( $atts['category'] );
            }
            $categories = get_terms( array(
                'taxonomy'   => 'shared-file-category',
                'hide_empty' => true,
                'parent'     => ( isset( $category->term_id ) ? $category->term_id : 0 ),
                'terms'      => $terms,
            ) );
            if ( sizeof( $categories ) > 0 ) {
                $html .= SharedFilesPublicHelpers::listCategories( $categories );
            }
        }
        
        wp_reset_postdata();
        return $html;
    }

}