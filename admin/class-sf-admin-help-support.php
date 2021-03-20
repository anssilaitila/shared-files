<?php

class SharedFilesAdminHelpSupport {

  public function register_support_page() {
    add_submenu_page(
      'edit.php?post_type=shared_file',
      __('How to use Shared Files', 'shared-files'),
      __('Help / Support', 'shared-files'),
      'manage_options',
      'shared-files-support',
      [$this, 'register_support_page_callback'],
      999
    );
  }

  public static function permalinks_alert() {
  
    $html = '';
  
    if (!get_option('permalink_structure')) {
    
      $html = '<div class="shared-files-permalinks-alert"><strong>' . __('Please note', 'shared-files') . '</strong>: ' . __('you have currently "Plain" selected in the permalink settings. You should change this to any other available setting to enable the Shared Files to operate normally. Thank you!', 'shared-files') . '</div>';
    
    }
    
    return $html;

  }

  public function register_support_page_callback() {
    ?>

    <?php $s = get_option('shared_files_settings') ?>
    
    <?= $this::permalinks_alert() ?>
    
    <?php $num = 0 ?>

    <link rel="stylesheet" href="<?= SHARED_FILES_URI ?>dist/tipso.min.css">
    <script src="<?= SHARED_FILES_URI ?>dist/tipso.min.js"></script>

    <div class="shared-files-help-support wrap">
      <h1><?= __('How to use Shared Files', 'shared-files'); ?></h1>
      <div class="shared-files-examples">
        <p><?= __('Some examples on how you can use different views available at', 'shared-files') ?> <a href="https://www.sharedfilespro.com/shared-files/" target="_blank"><?= __('sharedfilespro.com', 'shared-files') ?></a>.</p>
        <p><?= __('Any kind of feedback is welcome. You may contact the author at', 'shared-files') ?> <a href="https://www.sharedfilespro.com/support/" target="_blank">sharedfilespro.com/support/</a>.</p>
      </div>

      <div class="shared-files-admin-section">

        <h2><?= __('Instructions for basic usage', 'shared-files') ?></h2>
        <ol>
          <li>
  
            <?php
            $url = get_admin_url() . 'edit.php?post_type=shared_file';
            $text = sprintf(
              wp_kses(
                /* translators: %s: link to file management */
                __('Add the files from the <a href="%s" target="_blank">file management</a> page.', 'shared-files'),
                array('a' => array('href' => array(), 'target' => array()))
              ),
              esc_url($url) 
            );
            echo $text;
            ?>
          
          </li>
          <li>
            <?= __('Insert either one of these shortcodes to any page or post:', 'shared-files'); ?><br />
  
            <ul>
              <li><?= __('The default file list:', 'shared-files') ?><br /><?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-only shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= __('Copy', 'shared-files') ?></button></li>
              <li><?= __('A simpler list of files:', 'shared-files') ?><br /><?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-only shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files_simple]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= __('Copy', 'shared-files') ?></button></li>
              <li><?= __('Front-end file uploader:', 'shared-files') ?><br /><?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-only shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files file_upload=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= __('Copy', 'shared-files') ?></button></li>
            </ul>
  
            <strong>
            <?php
            $url = get_admin_url() . 'edit.php?post_type=shared_file&page=shared-files-shortcodes';
            $text = sprintf(
              wp_kses(
                /* translators: %s: link to the list of available shortcodes */
                __('A complete list of available shortcodes can be found <a href="%s">here</a>.', 'shared-files'),
                array('a' => array('href' => array(), 'target' => array()))
              ),
              esc_url($url) 
            );
            echo $text;
            ?>
            </strong>
            
          </li>
        </ol>
        
      </div>

      <div class="shared-files-admin-section">

        <h2><?= __('Help regarding finding the correct settings', 'shared-files') ?></h2>
  
        <p>
          
          <?php
          $url = get_admin_url() . 'options-general.php?page=shared-files';
          $text = sprintf(
            wp_kses(
              /* translators: %s: link to plugin settings */
              __('In case you are getting 404-errors from file URLs, you should change the following <a href="%s" target="_blank">settings</a> (either one or both)', 'shared-files'),
              array('a' => array('href' => array(), 'target' => array()))
            ),
            esc_url($url) 
          );
          echo $text . ':';
          ?>
        
        </p>
  
        <ul>
          <li>
            <?= __('Set the file opening method to "Redirect".', 'shared-files') ?>
          </li>
          <li>
            <?= __('Check the checkbox for "WP Engine compatibility mode".', 'shared-files') ?>
          </li>
          <li>
            <?= __('Define the "WordPress location" if you have WP installed under a subdirectory.', 'shared-files') ?>
          </li>
        </ul>
        
        <p><?= __('If the issue still persists, we are happy to help at', 'shared-files') ?> <a href="https://www.sharedfilespro.com/support/" target="_blank">sharedfilespro.com/support/</a>. <?= __('You can just send the debug info below and we will take a look at it.', 'shared-files') ?> <?= __('Thank you!', 'shared-files') ?></p>
        
      </div>

      <script>
        jQuery(function ($) {
          $('.shared-files-toggle-debug-info').on('click', function() {
            if ($('.shared-files-debug-info-container').is(':hidden')) {
              $('.shared-files-debug-info-container').show();
              $(this).text("<?= __('Close', 'shared-files') ?>");
            } else {
              $('.shared-files-debug-info-container').hide();
              $(this).text("<?= __('Open', 'shared-files') ?>");
            }
          });
        });
      </script>

      <div class="shared-files-admin-section">

        <h2><?= __('Debug Info', 'shared-files'); ?> <button class="shared-files-toggle-debug-info">Open</button></h2>
  
        <div class="shared-files-debug-info-container">
  
          <div class="shared-files-info-small">
            <p><?= __('This section contains some debug info, which may be useful when trying to solve abnormal behaviour of the plugin.', 'shared-files') ?></a></p>
          </div>
    
          <?php global $wp; ?>
    
          <h3><?= __('Variables', 'shared-files') ?></h3>
          site_url(): <?= site_url() ?><br />
          home_url(): <?= home_url() ?><br />
          wp_upload_dir()['path']: <?= wp_upload_dir()['path'] ?><br />
          wp_upload_dir()['url']: <?= wp_upload_dir()['url'] ?><br />
          wp_upload_dir()['subdir']: <?= wp_upload_dir()['subdir'] ?><br />
          wp_upload_dir()['basedir']: <?= wp_upload_dir()['basedir'] ?><br />
          wp_upload_dir()['baseurl']: <?= wp_upload_dir()['baseurl'] ?><br />
          wp_upload_dir()['error']: <?= wp_upload_dir()['error'] ?><br />
          sf_root: <?= SharedFilesHelpers::sf_root() ? SharedFilesHelpers::sf_root() : '(not set)' ?><br />
          get_template_directory(): <?php echo get_template_directory() ?><br />
          get_template_directory_uri(): <?= get_template_directory_uri() ?><br />
          permalinks: <?= get_option('permalink_structure') ?>
          <br />
    
          <?php
            $wp_query = new WP_Query(array(
              'post_type' => 'shared_file',
              'post_status' => 'publish',
              'posts_per_page' => 5,
              'orderby' => 'date',
              'order'   => 'DESC',
              ));
          ?>
    
          <h3><?= __('Sample file data (5 newest files)', 'shared-files') ?></h3>
          <?php
          if ($wp_query->have_posts()):
            while ($wp_query->have_posts()): $wp_query->the_post();
      
              $id = get_the_id();
              $c = get_post_custom($id);
              $file = (isset($c['_sf_filename']) ? SharedFilesHelpers::sf_root() . '/shared-files/' . get_the_id() . '/' . SharedFilesHelpers::wp_engine() . $c['_sf_filename'][0] : '');
              ?>
      
              <?= $file ?> | <?= get_the_date() ?><br />
    
            <?php
            endwhile;
          endif;
          ?>

          <?php
          $wp_query = new WP_Query(array(
            'post_type' => 'shared_file',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'orderby' => 'date',
            'order'   => 'DESC',
            ));
          ?>

          <h3><?= __('More detailed data on newest file', 'shared-files') ?></h3>

          <?php
          if ($wp_query->have_posts()):
            while ($wp_query->have_posts()): $wp_query->the_post();
          
              $id = get_the_id();
              $c = get_post_custom($id);
              $file = (isset($c['_sf_filename']) ? SharedFilesHelpers::sf_root() . '/shared-files/' . get_the_id() . '/' . SharedFilesHelpers::wp_engine() . $c['_sf_filename'][0] : '');
              ?>
          
              <div style="background: #fff; padding: 6px 8px; margin-bottom: 4px;">
                <?= $file ?> | <?= get_the_date() ?>
              </div>

              <?php $file = get_post_meta($id, '_sf_file', true) ?>
              
              <?php if (isset($file['file'])): ?>
                1: <?php echo $file['file'] ?><br />
                2: <?php echo $file['url'] ?><br />
                3: <?php echo $file['type'] ?><br />
                4: <?php echo $file['error'] ?><br />
                5: <?php echo '<pre>' . var_dump(pathinfo($file['file'])) . '</pre>' ?>
                6: <?php echo SharedFilesHelpers::getFilenameWithPathV2($file['file']) ?><br />
                7: <?php echo SharedFilesHelpers::getFilenameWithPathV3($file['file']) ?>
              <?php endif; ?>

            <?php
            endwhile;
          endif;
          ?>

          <?php
          $wp_query = new WP_Query(array(
            'post_type' => 'shared_file',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'orderby' => 'date',
            'order'   => 'ASC',
            ));
          ?>
          
          <h3><?php echo esc_html__('Oldest file', 'shared-files') ?></h3>
          
          <?php
          if ($wp_query->have_posts()):
            while ($wp_query->have_posts()): $wp_query->the_post();
          
              $id = get_the_id();
              $c = get_post_custom($id);
              $file = (isset($c['_sf_filename']) ? SharedFilesHelpers::sf_root() . '/shared-files/' . get_the_id() . '/' . SharedFilesHelpers::wp_engine() . $c['_sf_filename'][0] : '');
              ?>
          
              <div style="background: #fff; padding: 6px 8px; margin-bottom: 4px;">
                <?= $file ?> | <?= get_the_date() ?>
              </div>
          
              <?php $file = get_post_meta($id, '_sf_file', true) ?>
              
              <?php if (isset($file['file'])): ?>
                1: <?php echo $file['file'] ?><br />
                2: <?php echo $file['url'] ?><br />
                3: <?php echo $file['type'] ?><br />
                4: <?php echo $file['error'] ?><br />
                5: <?php echo '<pre>' . var_dump(pathinfo($file['file'])) . '</pre>' ?>
                6: <?php echo SharedFilesHelpers::getFilenameWithPathV2($file['file']) ?><br />
                7: <?php echo SharedFilesHelpers::getFilenameWithPathV3($file['file']) ?>
              <?php endif; ?>
          
            <?php
            endwhile;
          endif;
          ?>


        </div>
        
      </div>

      <script src="<?= SHARED_FILES_URI ?>dist/clipboard.min.js"></script>
  
      <script>
      var clipboard = new ClipboardJS('.shared-files-copy');
  
      clipboard.on('success', function(e) {

        e.clearSelection();

        let clipboardtarget = jQuery(e.trigger).data('clipboard-target');

        jQuery(clipboardtarget).tipso({
          content: "<?= __('Shortcode copied to clipboard!', 'shared-files') ?>",
          width: 240
        });

        jQuery(clipboardtarget).tipso('show');
        
        setTimeout(function () {
          showpanel(clipboardtarget);
        }, 2000);
        
        function showpanel(clipboardtarget) {
          jQuery(clipboardtarget).tipso('hide');
          jQuery(clipboardtarget).tipso('destroy');
        }
        
      });
  
      clipboard.on('error', function(e) {
//        console.log(e);
      });
      </script>

    </div>
    <?php
  }

}
