<?php

class SharedFilesShortcodeFilters {

  public static function getFilters( $className, $atts ) {

    if ( !class_exists($className) || !method_exists($className, 'setMetaQuery') || !method_exists($className, 'addToMetaQuery') ) {
      wp_die( 'Error in ' . $className );
    }

    $s = get_option('shared_files_settings');

    $custom_fields_active = 0;

    $meta_query_hide_not_public = [];

    $html = '';

    if (isset($s['show_tag_dropdown']) || isset($atts['show_tag_dropdown'])) {

      $tag_selected = isset($_GET['sf_tag']) ? sanitize_title( $_GET['sf_tag'] ) : '';

      $tags_orderby = '';
      $tags_order = 'ASC';

      if (isset($s['sort_tags_by']) && $s['sort_tags_by']) {
        $tags_orderby = sanitize_title( $s['sort_tags_by'] );
      }

      $tag_args = array(
                'taxonomy'          => SHARED_FILES_TAG_SLUG,
                'name'              => 'sf_tag',
                'show_option_none'   => esc_attr__('Choose tag', 'shared-files'),
                'hierarchical'      => true,
                'class'             => 'shared-files-tag-select select_v2',
                'echo'              => false,
                'value_field'       => 'slug',
                'selected'          => $tag_selected,
                'option_none_value' => '',

                'orderby'           => $tags_orderby,
                'order'             => $tags_order,

              );

      $html .= '<div class="shared-files-tag-select-container">';
      $html .= wp_dropdown_categories($tag_args);
      $html .= '</div>';

    }

    if ($custom_fields_active) {

      $className::setMetaQuery( array('relation' => 'AND') );
      $className::addToMetaQuery( $meta_query_hide_not_public );
      $className::addToMetaQuery( $meta_query );

    } else {

      $className::setMetaQuery( $meta_query_hide_not_public );

    }

    return $html;

  }

}