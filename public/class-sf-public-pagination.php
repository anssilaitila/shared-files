<?php

class SharedFilesPublicPagination {
  
  public static function getPagination($pagination_active, $wp_query, $embed_id) {

    $html = '';

    $s = get_option('shared_files_settings');

    if ( isset($s['pagination_type']) && $s['pagination_type'] == 'improved' ) {
    
      $paged_current = 1;
    
      if ($pagination_active && isset( $_GET['_page'] ) && $_GET['_page']) {
        $paged_current = (int) $_GET['_page'];
      }
      
      $pagination_args = array(
      
         'base'     => preg_replace('/\?.*/', '/', get_pagenum_link(1)) . '%_%',
      
         'total'    => $wp_query->max_num_pages,
         'current'  => max(1, $paged_current),
         'format'   => '?_page=%#%',
      
         'add_args' => array(
           '_paged' => $embed_id
         ));

      if (paginate_links($pagination_args)) {

        $html .= '<hr class="clear" /><div class="shared-files-pagination-improved">';
  
        $html .= '<div class="shared-files-pagination-improved-more-files">' . sanitize_text_field( __('Browse files:', 'shared-files') ) . '</div>';
        
        $html .= paginate_links($pagination_args);
  
        $html .= '</div>';
        
      }

    } else {
    
      $paged_current = $pagination_active ? get_query_var('paged') : 1;
    
      $pagination_args = array(
          'base'         => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
          'total'        => $wp_query->max_num_pages,
          'current'      => max(1, $paged_current),
          'format'       => '?paged_' . $embed_id . '=%#%',
          'show_all'     => true,
          'type'         => 'plain',
          'prev_next'    => false,
          'add_args'     => false,
          'add_fragment' => '',
          'add_args'     => array('_paged' => $embed_id)
        );
    
    
      $html .= '<hr class="clear" /><div class="shared-files-pagination">';
    
      if (paginate_links($pagination_args)) {
        $html .= '<span class="shared-files-more-files">' . sanitize_text_field( __('Browse more files:', 'shared-files') ) . '</span>' .
        paginate_links($pagination_args);
      }
    
      $html .= '</div>';
      
    }

    return $html;

  }

}
