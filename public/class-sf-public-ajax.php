<?php

class SharedFilesPublicAjax {
    public function search_log() {
        $s = get_option( 'shared_files_settings' );
        if ( isset( $s['enable_search_log'] ) ) {
            $search_term = '';
            $user_ip = '';
            $post_id = 0;
            $permalink = '';
            $user_agent = '';
            $referer_url = '';
            $min_chars = 3;
            if ( isset( $s['esl_search_term_min_chars'] ) && $s['esl_search_term_min_chars'] ) {
                $min_chars = intval( $s['esl_search_term_min_chars'] );
            }
            if ( isset( $s['esl_search_term'] ) ) {
                if ( isset( $_POST['search'] ) && $_POST['search'] ) {
                    $search_term = sanitize_text_field( $_POST['search'] );
                }
            }
            if ( strlen( $search_term ) >= $min_chars ) {
                if ( isset( $s['esl_user_agent'] ) ) {
                    if ( isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
                        $user_agent = sanitize_text_field( $_SERVER['HTTP_USER_AGENT'] );
                    }
                }
                $user_country = '';
                $user_city = '';
                global $wpdb;
                $wpdb->insert( $wpdb->prefix . 'shared_files_search_log', array(
                    'user_ip'      => $user_ip,
                    'user_country' => $user_country,
                    'user_city'    => $user_city,
                    'post_id'      => $post_id,
                    'permalink'    => $permalink,
                    'search'       => $search_term,
                    'user_agent'   => $user_agent,
                    'referer_url'  => $referer_url,
                ) );
                $inserted_id = $wpdb->insert_id;
            }
        }
        echo '';
    }

    public function sf_get_files() {
        $html = '';
        $tag_slug = '';
        $term_slug = '';
        $atts = [];
        $restricted = 0;
        if ( isset( $_POST['restricted'] ) ) {
            $restricted = intval( $_POST['restricted'] );
        }
        if ( isset( $_POST['sf_tag'] ) && $_POST['sf_tag'] ) {
            $tag_slug = sanitize_title( $_POST['sf_tag'] );
        }
        if ( isset( $_POST['sf_category'] ) && $_POST['sf_category'] ) {
            $term_slug = sanitize_title( $_POST['sf_category'] );
        } elseif ( isset( $atts['category'] ) && $atts['category'] ) {
            $term_slug = sanitize_title( $atts['category'] );
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
        $tax_query = [
            'relation' => 'AND',
        ];
        if ( $tag_slug ) {
            $tax_query[] = array(
                'taxonomy' => SHARED_FILES_TAG_SLUG,
                'field'    => 'slug',
                'terms'    => $tag_slug,
            );
        }
        if ( $term_slug ) {
            $tax_query[] = array(
                'taxonomy'         => 'shared-file-category',
                'field'            => 'slug',
                'terms'            => $term_slug,
                'include_children' => true,
            );
            $wp_query = new WP_Query(array(
                'post_type'      => 'shared_file',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'tax_query'      => $tax_query,
                'orderby'        => SharedFilesHelpers::getOrderBy( $atts ),
                'order'          => SharedFilesHelpers::getOrder( $atts ),
                'meta_key'       => SharedFilesHelpers::getMetaKey( $atts ),
                'meta_query'     => $meta_query_full,
            ));
        } else {
            $wp_query = new WP_Query(array(
                'post_type'      => 'shared_file',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'tax_query'      => $tax_query,
                'orderby'        => SharedFilesHelpers::getOrderBy( $atts ),
                'order'          => SharedFilesHelpers::getOrder( $atts ),
                'meta_key'       => SharedFilesHelpers::getMetaKey( $atts ),
                'meta_query'     => $meta_query_full,
            ));
        }
        $hide_description = ( isset( $_POST['hide_description'] ) && $_POST['hide_description'] ? 1 : '' );
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
        echo wp_kses( $html, $html_allowed_tags );
    }

}
