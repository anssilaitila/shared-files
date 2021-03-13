<?php

class SharedFilesAdminSyncMediaLibrary {

  public function register_page() {

    $menu_pos = 4;

    if (SharedFilesHelpers::isPremium() == 1) {
      $menu_pos = 5;
    }
    
    add_submenu_page(
      'edit.php?post_type=shared_file',
      __('Sync Media Library', 'shared-files'),
      '<span style="font-size: 15px; margin: 0 2px 0 5px;">&#8627;</span> ' . __('Media Library', 'shared-files'),
      'manage_options',
      'shared-files-sync-media-library',
      [$this, 'register_page_callback'],
      $menu_pos
    );

  }

  public function register_page_callback() {
    ?>
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    <div class="shared-files-sync-files">
      <h1><?= __('Sync Media Library Files', 'shared-files'); ?></h1>

      <?php
      if (SharedFilesHelpers::isPremium() == 0) {  
        echo SharedFilesAdminHelpers::sfProFeatureMarkup();
      }
      ?>

      <?php $path = SharedFilesFileHandling::getBaseDir(); ?>

      <p>
        <?= __('You may activate files found in the media library to be used by the plugin, without having to add the files again.', 'shared-files') ?>
      </p>

      <p>
        <?= __('If a file is inactive, it means that it exists in the media library, but has not yet been activated for the plugin.', 'shared-files') ?>
      </p>

      <p>

        <form method="post">
          
          <?php $taxonomy_slug = 'shared-file-category'; ?>
        
          <?php if (get_taxonomy($taxonomy_slug)): ?>
  
            <span class="shared-files-category-for-new-files"><?= __('Category for new files:', 'shared-files') ?></span>
  
            <?= wp_dropdown_categories([
              'show_option_all' => ' ',
              'hide_empty' => 0,
              'hierarchical' => 1,
              'show_count' => 1,
              'orderby' => 'name',
              'name' => $taxonomy_slug,
              'value_field' => 'slug',
              'taxonomy' => $taxonomy_slug,
              'echo' => 0,
              'class' => 'select_v2',
              'show_option_all' => __('Choose category', 'shared-files')
            ]) ?><br />
            
          <?php endif; ?>
  
          <?php wp_nonce_field('sf-sync-files', 'sf-sync-files-nonce'); ?>
        
        </form>
      </p>

      <p>
        <?= __('Files found in the media library', 'shared-files') ?>:
      </p>

      <?php

      if (isset($_GET['files']) && $_GET['files'] == 'error') {
  
        echo '<p class="shared-files-error">' . __('Error processing file(s).', 'shared-files') . '</p>';
  
      } elseif (isset($_GET['files'])) {
        
        $num = (int) $_GET['files'];
        
        if ($num == 1) {
          echo '<p class="shared-files-files-activated">' . $num . ' ' . __('file activated.', 'shared-files') . '</p>';
        } else {
          echo '<p class="shared-files-files-activated">' . $num . ' ' . __('files activated.', 'shared-files') . '</p>';
         }

      }

      echo '<table>';

      echo '<tr><th>' . __('Filename', 'shared-files') . '</th><th>' . __('File size', 'shared-files') . '</th><th>' . __('Last modified', 'shared-files') . '</th><th>' . __('Status', 'shared-files') . '</th></tr>';

      $args = array(
        'post_type'      => 'attachment',
        'post_status'    => 'inherit',
        'posts_per_page' => - 1,
      ); 
      
      $wp_query = new WP_Query($args);

      if (isset($wp_query) && $wp_query->have_posts()) {

        foreach ( $wp_query->posts as $post ) {

  //        the_attachment_link($post->ID, false);
      
          $file_with_url = wp_get_attachment_url($post->ID);
          $file_with_path = get_attached_file($post->ID);
          $filename = basename($file_with_path);

          // $item
          if (strpos($file_with_url, '/wp-content/uploads/shared-files/') !== false || !file_exists($file_with_path)) {
            continue;
          }
          
          echo '<tr>';
          echo '<td><a href="' . $file_with_url . '" target="_blank">' . $filename . '</a>';
//          echo $post->post_title;
//          echo $file_with_path;
          echo '</td>';
          
          echo '<td>' . SharedFilesFileHandling::human_filesize(filesize($file_with_path)) . '</td>';

          echo '<td>' . $post->post_modified . '</td>';
          echo '<td>';
  
          $meta_query = array('relation' => 'AND');
      
          $meta_query[] = array(
      			'key'		  => '_sf_media_library_post_id',
      			'compare'	=> '=',
      			'value'   => $post->ID
      		);
  
          $wp_query = new WP_Query(array(
            'post_type' => 'shared_file',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'meta_query' => $meta_query,
          ));
  
          if ($wp_query->have_posts()):
            while ($wp_query->have_posts()): $wp_query->the_post();
      
              $id = get_the_id();
              $c = get_post_custom($id);
              echo '<span class="shared-files-active">' . __('Active', 'shared-files') . '</span>';
      
            endwhile;
            
            wp_reset_postdata();
            
          else:
            echo '<span class="shared-files-inactive">' . __('Inactive', 'shared-files') . '</span><br />';
          ?>
  
            <form method="post">
              <?php wp_nonce_field('sf-sync-files', 'sf-sync-files-nonce'); ?>
              <input type="hidden" name="shared-files-op" value="sync-files" />
              <input type="hidden" name="_sf_media_library_post_id" value="<?= $post->ID ?>" />
              <input type="hidden" name="add_file" value="<?= sanitize_file_name($filename) ?>" />
              <input type="hidden" name="shared-file-category" class="shared-files-single-file-category" value="" />
              <input type="submit" class="shared-files-activate <?= (SharedFilesHelpers::isPremium() == 0 ? 'shared-files-pro-required' : '') ?>" value="<?= __('Activate', 'shared-files') ?>" />
            </form>
  
          <?php
          endif;
  
          echo '</td>';
          echo '</tr>';
        }
        
      }

      echo '</table>';

      ?>

    </div>
    <?php
  }

}
