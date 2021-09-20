<?php

class SharedFilesPublicAjax
{
    public function sf_get_files()
    {
        $html = '';
        $tag_slug = '';
        $term_slug = '';
        $atts = [];
        if ( isset( $_POST['sf_tag'] ) && $_POST['sf_tag'] ) {
            $tag_slug = sanitize_title( $_POST['sf_tag'] );
        }
        if ( isset( $_POST['sf_category'] ) && $_POST['sf_category'] ) {
            $term_slug = sanitize_title( $_POST['sf_category'] );
        }
        $cf_active = 0;
        $meta_query = [];
        if ( isset( $atts['hide_files_first'] ) && !$term_slug && !$tag_slug && !$cf_active ) {
            die;
        }
        /* CATEGORY PASSWORD END */
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
        $meta_query_full = array(
            'relation' => 'AND',
        );
        $meta_query_full[] = $meta_query_hide_not_public;
        $meta_query_full[] = $meta_query;
        
        if ( $term_slug ) {
            $wp_query = new WP_Query( array(
                'post_type'      => 'shared_file',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'tag'            => $tag_slug,
                'tax_query'      => array( array(
                'taxonomy'         => 'shared-file-category',
                'field'            => 'slug',
                'terms'            => $term_slug,
                'include_children' => true,
            ) ),
                'orderby'        => SharedFilesHelpers::getOrderBy( $atts ),
                'order'          => SharedFilesHelpers::getOrder( $atts ),
                'meta_key'       => SharedFilesHelpers::getMetaKey( $atts ),
                'meta_query'     => $meta_query_full,
            ) );
        } else {
            $wp_query = new WP_Query( array(
                'post_type'      => 'shared_file',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'tag'            => $tag_slug,
                'orderby'        => SharedFilesHelpers::getOrderBy( $atts ),
                'order'          => SharedFilesHelpers::getOrder( $atts ),
                'meta_key'       => SharedFilesHelpers::getMetaKey( $atts ),
                'meta_query'     => $meta_query_full,
            ) );
        }
        
        $hide_description = ( isset( $_POST['hide_description'] ) && $_POST['hide_description'] ? 1 : '' );
        if ( $tag_slug ) {
            $html .= SharedFilesHelpers::tagTitleMarkup( $tag_slug, '', $hide_description );
        }
        if ( $wp_query->have_posts() ) {
            while ( $wp_query->have_posts() ) {
                $wp_query->the_post();
                $id = intval( get_the_id() );
                $c = get_post_custom( $id );
                $external_url = ( isset( $c['_sf_external_url'] ) ? esc_url_raw( $c['_sf_external_url'][0] ) : '' );
                $filetype = '';
                $imagefile = SharedFilesHelpers::getImageFile( $id, $external_url );
                $html .= SharedFilesPublicFileCardDefault::fileListItem(
                    $c,
                    $imagefile,
                    $hide_description,
                    1,
                    $atts
                );
            }
        }
        if ( $wp_query->found_posts == 0 ) {
            $html .= '<p>' . sanitize_text_field( __( 'No files found.', 'shared-files' ) ) . '</p>';
        }
        $html_allowed_tags = [
            'li'   => [],
            'div'  => [
            'class' => [],
            'style' => [],
        ],
            'a'    => [
            'href'                  => [],
            'target'                => [],
            'data-file-url'         => [],
            'data-external-url'     => [],
            'data-image-url'        => [],
            'data-file-type'        => [],
            'data-tag-slug'         => [],
            'data-hide-description' => [],
            'data-file-id'          => [],
            'class'                 => [],
            'id'                    => [],
            'download'              => [],
            'onclick'               => [],
        ],
            'span' => [
            'class' => [],
        ],
            'img'  => [
            'src' => [],
        ],
            'b'    => [],
            'p'    => [],
        ];
        echo  wp_kses( $html, $html_allowed_tags ) ;
    }

}