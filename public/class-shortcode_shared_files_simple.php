<?php

class ShortcodeSharedFilesSimple {

  public static function view($atts) {

    $html = '';

    // normalize attribute keys, lowercase
    $atts = array_change_key_case( (array) $atts, CASE_LOWER);
    $s = get_option('shared_files_settings');

    $current_url = esc_url_raw( get_permalink() );

    $elem_class = SharedFilesHelpers::createElemClass();

    $meta_query = [];
    $meta_query_full = [];
    $custom_fields_active = 0;

    $embed_id = isset($atts['embed_id']) ? sanitize_title($atts['embed_id']) : 'default';

    $limit_posts = 0;

    if ( ( isset($atts['ask_for_email']) && $atts['ask_for_email'] == 1 ) || ( isset($atts['ask_for_contact_info']) && $atts['ask_for_contact_info'] == 1 ) ) {

      if ( is_super_admin() ) {

        $html .= SharedFilesPublicContacts::askForEmailInfo();

      } else {

        if ( isset($_POST['shared-files-add-contact']) ) {

          SharedFilesPublicContacts::saveEmail($embed_id, $atts);

        } else {

          $html = SharedFilesPublicContacts::askForEmail($embed_id, $atts);
          return $html;

        }

      }

    }

    $tag_slug = '';

    if (isset($_GET['sf_tag']) && $_GET['sf_tag'] != '0') {
      $tag_slug = sanitize_title( $_GET['sf_tag'] );
    }

    $meta_query_hide_not_public = array('relation' => 'OR');

    $meta_query_hide_not_public[] = array(
      'key'		  => '_sf_not_public',
      'compare'	=> '=',
      'value'   => ''
    );

    $meta_query_hide_not_public[] = array(
      'key'		  => '_sf_not_public',
      'compare'	=> 'NOT EXISTS',
    );

    $html .= '<div class="' . $elem_class . ' shared-files-simple-container" data-search-type="' . sanitize_title( SharedFilesHelpers::searchType() ) . '" data-post-id="' . intval( get_the_ID() ) . '">';

    $html .= '<div class="shared-files-simple-text-contact" style="display: none;">' . sanitize_text_field( __('contact', 'shared-files') ) . '</div>';
    $html .= '<div class="shared-files-simple-text-contacts" style="display: none;">' . sanitize_text_field( __('contacts', 'shared-files') ) . '</div>';
    $html .= '<div class="shared-files-simple-text-found" style="display: none;">' . sanitize_text_field( __('found', 'shared-files') ) . '</div>';


    /* START NEW */

    if (!isset($s['hide_search_form']) && !isset($atts['hide_search'])) {

      $html .= '<div class="shared-files-search-form-container"><form class="shared-files-ajax-form" onsubmit="return false;" data-elem-class="' . $elem_class . '">';

      if (!isset($atts['hide_search_for_all_files'])) {

        $extra_class = '';

        $html .= '<div class="shared-files-search-input-container">';

        $html .= '<input type="text" class="shared-files-simple-search' . $extra_class . '" placeholder="' . (isset($s['search_contacts']) && $s['search_contacts'] ? esc_attr( $s['search_contacts'] ) : esc_attr__('Search files...', 'shared-files')) . '" data-elem-class="' . $elem_class . '">';


        $html .= '</div>';

      }

      // .shared-files-ajax-form
      $html .= '</form>';

      // .shared-files-search-form-container
      $html .= '</div>';

    }


    if ($custom_fields_active) {

      $meta_query_full = array('relation' => 'AND');

      $meta_query_full []= $meta_query_hide_not_public;
      $meta_query_full []= $meta_query;


    } else {

      $meta_query_full = $meta_query_hide_not_public;

    }

    /* END NEW */


    $tax_query = ['relation' => 'AND'];

    if ($tag_slug) {

      $tax_query []= array(
        'taxonomy'          => SHARED_FILES_TAG_SLUG,
        'field'             => 'slug',
        'terms'             => $tag_slug,
      );

    }

    if (isset($_GET['sf_category']) && $_GET['sf_category'] != '0') {

      $term_slug = sanitize_title($_GET['sf_category']);

      if ($term_slug) {

        $taxonomy_query []= array(
          'taxonomy'          => 'shared-file-category',
          'field'             => 'slug',
          'terms'             => $term_slug,
          'include_children'  => true
        );

      }

      $wp_query = new WP_Query(array(
        'post_type'       => 'shared_file',
        'post_status'     => 'publish',
        'posts_per_page'  => -1,

        'tax_query'       => $tax_query,

        'orderby'     => SharedFilesHelpers::getOrderBy($atts),
        'order'       => SharedFilesHelpers::getOrder($atts),
        'meta_key'    => SharedFilesHelpers::getMetaKey($atts),

        'meta_query'  => $meta_query_full,
      ));

      $wp_query_all_files = new WP_Query(array(
        'post_type'       => 'shared_file',
        'post_status'     => 'publish',
        'posts_per_page'  => -1,

        'tax_query' => array(
          array(
            'taxonomy'          => 'shared-file-category',
            'field'             => 'slug',
            'terms'             => $term_slug,
            'include_children'  => true
          )
        ),

        'orderby'     => SharedFilesHelpers::getOrderBy($atts),
        'order'       => SharedFilesHelpers::getOrder($atts),
        'meta_key'    => SharedFilesHelpers::getMetaKey($atts),

        'meta_query'  => $meta_query_hide_not_public,
      ));

    } else if (isset($_GET['c']) && $_GET['c'] != 'all_files') {

      $term_slug = sanitize_title($_GET['c']);

      if ($term_slug) {

        $taxonomy_query []= array(
          'taxonomy'          => 'shared-file-category',
          'field'             => 'slug',
          'terms'             => $term_slug,
          'include_children'  => true
        );

      }

      $wp_query = new WP_Query(array(
        'post_type'       => 'shared_file',
        'post_status'     => 'publish',
        'posts_per_page'  => -1,

        'tax_query'       => $tax_query,

        'orderby'     => SharedFilesHelpers::getOrderBy($atts),
        'order'       => SharedFilesHelpers::getOrder($atts),
        'meta_key'    => SharedFilesHelpers::getMetaKey($atts),

        'meta_query'  => $meta_query_full,
      ));

      $wp_query_all_files = new WP_Query(array(
        'post_type'       => 'shared_file',
        'post_status'     => 'publish',
        'posts_per_page'  => -1,

        'tax_query' => array(
          array(
            'taxonomy'          => 'shared-file-category',
            'field'             => 'slug',
            'terms'             => $term_slug,
            'include_children'  => true
          )
        ),

        'orderby'     => SharedFilesHelpers::getOrderBy($atts),
        'order'       => SharedFilesHelpers::getOrder($atts),
        'meta_key'    => SharedFilesHelpers::getMetaKey($atts),

        'meta_query'  => $meta_query_hide_not_public,
      ));

    } else {

      $posts_per_page = isset($s['pagination']) && $s['pagination'] ? (int) $s['pagination'] : 20;

      $pagination_active = 1;
      $paged = 1;

      if ($pagination_active) {

        if (isset($_GET['_page']) && $_GET['_page']) {
          $paged = (int) $_GET['_page'];
        } elseif (get_query_var('paged')) {
          $paged = absint( get_query_var('paged') );
        }

      }

      if ($limit_posts) {
        $posts_per_page = $limit_posts;
      }

      $wp_query = new WP_Query(array(
        'post_type'       => 'shared_file',
        'post_status'     => 'publish',

        'paged'           => $paged,
        'posts_per_page'  => $posts_per_page,

        'orderby'         => SharedFilesHelpers::getOrderBy($atts),
        'order'           => SharedFilesHelpers::getOrder($atts),
        'meta_key'        => SharedFilesHelpers::getMetaKey($atts),

        'meta_query'      => $meta_query_full,

        'tax_query'       => $tax_query,
      ));

      $wp_query_all_files = new WP_Query(array(
        'post_type'       => 'shared_file',
        'post_status'     => 'publish',
        'posts_per_page'  => -1,

        'orderby'         => SharedFilesHelpers::getOrderBy($atts),
        'order'           => SharedFilesHelpers::getOrder($atts),
        'meta_key'        => SharedFilesHelpers::getMetaKey($atts),

        'meta_query'      => $meta_query_hide_not_public,

        'tax_query'       => $tax_query
      ));

    }

    $html .= '<div class="shared-files-files-found"></div>';
    $html .= '<span class="shared-files-one-file-found">' . sanitize_text_field( __('file found.', 'shared-files') ) . '</span><span class="shared-files-more-than-one-file-found">' . sanitize_text_field( __('files found.', 'shared-files') ) . '</span>';

    $html .= '<div class="shared-files-simple-nothing-found">';
    $html .= sanitize_text_field( __('No files found.', 'shared-files') );
    $html .= '</div>';

    if ($wp_query->have_posts()) {

      $html .= '<div class="shared-files-simple-ajax-results">';
      $html .= SharedFilesPublicHelpers::SharedFilesSimpleMarkup($wp_query, 0, $atts);
      $html .= '</div>';

    }

    if ($wp_query_all_files->have_posts()) {

      if (!isset($s['hide_search_form']) && !isset($atts['hide_search'])) {

        $html .= '<div class="shared-files-simple-search-all-files">';
        $html .= SharedFilesPublicHelpers::SharedFilesSimpleMarkup($wp_query_all_files, 0, $atts);
        $html .= '</div>';

      }

    }

    if (!$limit_posts) {
      $html .= SharedFilesPublicPagination::getPagination($pagination_active, $wp_query, 'default');
    }

    if ($wp_query->found_posts == 0) {
      $html .= '<p>' . sanitize_text_field( __('No files found.', 'shared-files') ) . '</p>';
    }

    $html .= '</div>';

    wp_reset_postdata();

    return $html;

  }

}