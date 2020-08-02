<?php

class SharedFilesPublicAjax {
  
  public function sf_get_files() {

    $html = '';

    $term_slug = '';

    if (isset($_POST['sf_category']) && $_POST['sf_category']) {
      $term_slug = sanitize_title($_POST['sf_category']);
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

    if ($term_slug) {

      $wp_query = new WP_Query(array(
        'post_type' => 'shared_file',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'tax_query' => array(
          array (
            'taxonomy' => 'shared-file-category',
            'field' => 'slug',
            'terms' => $term_slug,
            'include_children' => true
          )
        ),
        'meta_query' => $meta_query_hide_not_public,
      ));

    } else {

      $wp_query = new WP_Query(array(
        'post_type' => 'shared_file',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_query' => $meta_query_hide_not_public,
      ));

    }

    if ($wp_query->have_posts()):
      while ($wp_query->have_posts()): $wp_query->the_post();

        $id = get_the_id();
        $c = get_post_custom($id);

        $external_url = isset($c['_sf_external_url']) ? $c['_sf_external_url'][0] : '';
        $filetype = '';
        $hide_description = isset($atts['hide_description']) ? $atts['hide_description'] : '';

        $imagefile = SharedFilesHelpers::getImageFile($id, $external_url);

        $html .= SharedFilesPublicHelpers::fileListItem($c, $imagefile, $hide_description);

      endwhile;
    endif;

    if ($wp_query->found_posts == 0) {
      $html .= '<p>' . __('No files found.', 'shared-files') . '</p>';
    }

    echo $html;
  }

  public function my_ajax_without_file() { ?>
  
      <script type="text/javascript" >
      jQuery(document).ready(function($) {
        ajaxurl = "<?= admin_url('admin-ajax.php') ?>"; // get ajaxurl
      });
      </script> 
      <?php
  }

}
