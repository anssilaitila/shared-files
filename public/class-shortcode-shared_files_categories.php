<?php
  
class ShortcodeSharedFilesCategories {

  public static function shared_files_categories($atts = [], $content = null, $tag = '') {

    if (SharedFilesHelpers::isPremium() == 0) {
      $html = SharedFilesAdminHelpers::sfProFeatureMarkup();
      return $html;
    }

    // normalize attribute keys, lowercase
    $atts = array_change_key_case( (array) $atts, CASE_LOWER);
    $s = get_option('shared_files_settings');

    $order_by_category_list = 'description';

    if (isset($s['order_by_category_list']) && $s['order_by_category_list']) {
      $order_by_category_list = $s['order_by_category_list'];
    }

    $layout = '';
    
    if (isset($atts['layout'])) {
      $layout = $atts['layout'];
    } elseif (isset($s['layout']) && $s['layout']) {
      $layout = $s['layout'];
    }
  
    $html = '';

    $category_slug = isset($_GET['cat']) ? $_GET['cat'] : '';

    if (isset($atts['category']) && !$category_slug) {
      $category_slug = sanitize_title($atts['category']);
    }

    if (isset($_GET['cat'])):

      $cat = $_GET['cat'];

      $parent_cat = get_term_by('slug', $cat, 'shared-file-category');
  
      $subcategories = get_terms(array(
        'taxonomy'   => 'shared-file-category',
        'hide_empty' => true,
        'parent' => $parent_cat->term_id,

        'orderby' => $order_by_category_list,
        'order' => 'ASC'

      ));

      $html .='<a href="javascript:history.back()">' . (isset($s['back_link_title']) && $s['back_link_title'] ? $s['back_link_title'] : __('<< Back', 'shared-files')) . '</a>';
      
      if (sizeof($subcategories) > 0):
        $html .= SharedFilesPublicHelpers::listCategories($subcategories);
      else:
  
        $category = get_term_by('slug', $category_slug, 'shared-file-category');
  
        if ($category):
          $html .='<h3 class="shared-files-group-title">' . $category->name . '</h3>';
        endif;
  
        $html .= SharedFilesHelpers::initLayout($s);
      
        $html .= '<div class="shared-files-container shared-files-categories-container ' . ($layout ? 'shared-files-' . $layout : '') . '">';  
        $html .= '<div id="shared-files-search">';
        
        $term_slug = sanitize_title($cat);
  
        $wpb_all_query = new WP_Query(array(
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
          
          'orderby' => SharedFilesHelpers::getOrderBy($atts),
          'order' => SharedFilesHelpers::getOrder($atts),
          'meta_key' => SharedFilesHelpers::getMetaKey($atts),
          
        ));
    
        $filetypes = SharedFilesHelpers::getFiletypes();
        $external_filetypes = SharedFilesHelpers::getExternalFiletypes();
      
        if ($wpb_all_query->have_posts()):
    
          $html .= '<ul id="myList">';
  
          while ($wpb_all_query->have_posts()): $wpb_all_query->the_post();
    
            $id = get_the_id();
            $c = get_post_custom($id);
    
            $external_url = isset($c['_sf_external_url']) ? $c['_sf_external_url'][0] : '';
            $filetype = '';
            $hide_description = isset($atts['hide_description']) ? $atts['hide_description'] : '';
    
            $imagefile = SharedFilesHelpers::getImageFile($id, $external_url);                        
            $html .= SharedFilesPublicHelpers::fileListItem($c, $imagefile, $hide_description);
    
          endwhile;
    
          $html .= '</ul>';
  
        else:
        
          $html .= '<p>' . __('No files in this category.', 'shared-files') . '</p>';
  
        endif;
      
        $html .= '</div></div><hr class="clear" />';

      endif;

    else:
          
      $category = get_term_by('slug', $category_slug, 'shared-file-category');
              
      $terms = '';
  
      if (isset($atts['category'])) {
        $terms = sanitize_title($atts['category']);
      }
  
      $categories = get_terms(array(
        'taxonomy'   => 'shared-file-category',
        'hide_empty' => true,
        'parent' => isset($category->term_id) ? $category->term_id : 0,
        'terms' => $terms,      

        'orderby' => $order_by_category_list,
        'order' => 'ASC'
    
      ));
    
      if (sizeof($categories) > 0):
        $html .= SharedFilesPublicHelpers::listCategories($categories);
      endif;
      
    endif;

    wp_reset_postdata();

    return $html;
  }

}
