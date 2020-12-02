<?php

class SharedFilesAdminSyncFiles {

  public function register_page() {
    add_submenu_page(
      'edit.php?post_type=shared_file',
      __('Sync Files', 'shared-files'),
      __('Sync Files', 'shared-files'),
      'manage_options',
      'shared-files-sync-files',
      [$this, 'register_page_callback'],
      4
    );
  }

  public function register_page_callback() {
    ?>
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    <div class="shared-files-sync-files">
      <h1><?= __('Sync Files', 'shared-files'); ?></h1>

      <?php
      if (SharedFilesHelpers::isPremium() == 0) {  
        echo SharedFilesAdminHelpers::sfProFeatureMarkup();
      }
      ?>

      <?php $path = SharedFilesFileHandling::getBaseDir(); ?>

      <p>
        <?= __('You may transfer many files at once using FTP to the folder mentioned below, and then sync the files here so they will be usable by the plugin.', 'shared-files') ?>
      </p>

      <p>
        <?= __('If a file is inactive, it means that it exists on the server, but has not yet been activated for the plugin.', 'shared-files') ?>
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

          <input type="hidden" name="shared-files-op" value="sync-files" />
          <input type="hidden" name="add_file" value="all_files" />
  
          <input type="submit" class="shared-files-activate <?= (SharedFilesHelpers::isPremium() == 0 ? 'shared-files-pro-required' : '') ?>" value="<?= __('Activate all inactive files', 'shared-files') ?>" />
        
        </form>
      </p>

      <p>
        <?= __('Files found on the server at', 'shared-files') ?>
        <span class="shared-files-path"><?= $path ?></span>:
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

      $files = array_diff(scandir($path), array('.', '..'));

      foreach ($files as $file) {

        $item = SharedFilesFileHandling::getBaseDir() . $file;
        
        if ($file == 'index.php' || is_dir($item)) {
          continue;
        }

        echo '<tr>';
        echo '<td>' . $file . '</td>';
        echo '<td>' . SharedFilesFileHandling::human_filesize(filesize($item)) . '</td>';
        echo '<td>' . date ("Y-m-d", filemtime($item)) . '</td>';
        echo '<td>';

        $meta_query = array('relation' => 'AND');
    
        $meta_query[] = array(
    			'key'		  => '_sf_filename',
    			'compare'	=> '=',
    			'value'   => $file
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
            <input type="hidden" name="add_file" value="<?= sanitize_file_name($file) ?>" />
            <input type="hidden" name="shared-file-category" class="shared-files-single-file-category" value="" />
            <input type="submit" class="shared-files-activate <?= (SharedFilesHelpers::isPremium() == 0 ? 'shared-files-pro-required' : '') ?>" value="<?= __('Activate', 'shared-files') ?>" />
          </form>

        <?php
        endif;

        echo '</td>';
        echo '</tr>';
      }

      echo '</table>';

      ?>

    </div>
    <?php
  }

}
