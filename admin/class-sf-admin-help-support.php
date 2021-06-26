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
    
      $html = '<div class="shared-files-permalinks-alert"><strong>' . esc_html__('Please note', 'shared-files') . '</strong>: ' . esc_html__('you have currently "Plain" selected in the permalink settings. You should change this to any other available setting to enable the Shared Files to operate normally. Thank you!', 'shared-files') . '</div>';
    
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
      <h1><?= esc_html__('How to use Shared Files', 'shared-files'); ?></h1>
      <div class="shared-files-examples">
        <p><?= esc_html__('Some examples on how you can use different views available at', 'shared-files') ?> <a href="https://www.sharedfilespro.com/shared-files/" target="_blank"><?= __('sharedfilespro.com', 'shared-files') ?></a>.</p>
        <p><?= esc_html__('Any kind of feedback is welcome. You may contact the author at', 'shared-files') ?> <a href="https://www.sharedfilespro.com/support/" target="_blank">sharedfilespro.com/support/</a>.</p>
      </div>

      <div class="shared-files-admin-section">

        <h2><?= esc_html__('Instructions for basic usage', 'shared-files') ?></h2>
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
            <?= esc_html__('Insert either one of these shortcodes to any page or post:', 'shared-files'); ?><br />
  
            <ul>
              <li><?= esc_html__('The default file list:', 'shared-files') ?><br /><?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-only shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>
              <li><?= esc_html__('A simpler list of files:', 'shared-files') ?><br /><?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-only shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files_simple]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>
              <li><?= esc_html__('Front-end file uploader:', 'shared-files') ?><br /><?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-only shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files file_upload=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>
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

        <h2><?= esc_html__('Help regarding finding the correct settings', 'shared-files') ?></h2>
  
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
            <?= esc_html__('Set the file opening method to "Redirect".', 'shared-files') ?>
          </li>
          <li>
            <?= esc_html__('Check the checkbox for "WP Engine compatibility mode".', 'shared-files') ?>
          </li>
          <li>
            <p><?= esc_html__('Define the "WordPress location" if you have WP installed under a subdirectory.', 'shared-files') ?></p>
            <p><?= esc_html__('For example: if you have "https://www.yoursite.com/example" set for WordPress Address (URL) in the general settings of WordPress, you should set "/example/" for WordPress location in the plugin settings.', 'shared-files') ?></p>

          </li>
        </ul>
        
        <p><?= esc_html__('If the issue still persists, we are happy to help at', 'shared-files') ?> <a href="https://www.sharedfilespro.com/support/" target="_blank">sharedfilespro.com/support/</a>. <?= esc_html__('You can just send the debug info below and we will take a look at it.', 'shared-files') ?> <?= esc_html__('Thank you!', 'shared-files') ?></p>
        
      </div>

      <div class="shared-files-admin-section">
      
        <h2><?= esc_html__('Ratings & Reviews', 'shared-files') ?></h2>

        <p>
          <?php
          $text = sprintf(
            wp_kses(
              __('If you like <strong>Shared Files</strong> please consider leaving a ★★★★★ rating.', 'shared-files'),
              array('strong' => array())
            )
          );
          echo $text;
          ?>

        </p>
        <p>
          <?= esc_html__('A huge thanks in advance!', 'shared-files'); ?>
        </p>
      
        <a href="https://wordpress.org/support/view/plugin-reviews/shared-files?filter=5#postform" target="_blank" class="button-primary"><?= esc_html__('Leave a rating', 'shared-files'); ?></a>
        
      </div>

      <script>
        jQuery(function ($) {
          $('.shared-files-toggle-debug-info').on('click', function() {
            if ($('.shared-files-debug-info-container').is(':hidden')) {
              $('.shared-files-debug-info-container').show();
              $(this).text("<?= esc_js( __('Close', 'shared-files') ) ?>");
            } else {
              $('.shared-files-debug-info-container').hide();
              $(this).text("<?= esc_js( __('Open', 'shared-files') ) ?>");
            }
          });
        });
      </script>

      <div class="shared-files-admin-section">

        <h2><?= esc_html__('Debug Info', 'shared-files'); ?> <button class="shared-files-toggle-debug-info"><?= esc_html__('Open', 'shared-files'); ?></button></h2>
  
        <div class="shared-files-debug-info-container">
  
          <div class="shared-files-info-small">
            <p><?= esc_html__('This section contains some debug info, which may be useful when trying to solve abnormal behaviour of the plugin.', 'shared-files') ?></a></p>
          </div>
    
          <?php global $wp; ?>
    
          <h3><?= esc_html__('Variables', 'shared-files') ?></h3>
          site_url(): <?= site_url() ?><br />
          home_url(): <?= home_url() ?><br />
          wp_upload_dir()['path']: <?= wp_upload_dir()['path'] ?><br />
          wp_upload_dir()['url']: <?= wp_upload_dir()['url'] ?><br />
          wp_upload_dir()['subdir']: <?= wp_upload_dir()['subdir'] ?><br />
          wp_upload_dir()['basedir']: <?= wp_upload_dir()['basedir'] ?><br />
          wp_upload_dir()['baseurl']: <?= wp_upload_dir()['baseurl'] ?><br />
          wp_upload_dir()['error']: <?= wp_upload_dir()['error'] ?><br />
          sf_root: <?= SharedFilesHelpers::sf_root() ? SharedFilesHelpers::sf_root() : esc_html__('(not set)', 'shared-files') ?><br />
          get_template_directory(): <?php echo get_template_directory() ?><br />
          get_template_directory_uri(): <?= get_template_directory_uri() ?><br />
          permalinks: <?= get_option('permalink_structure') ?><br />
          
          <?php
          $zlib = 0;
          
          if (function_exists('ini_get') && ini_get('zlib.output_compression')) {
            $zlib = 1;
          }
          ?>
          
          zlib: <?= $zlib ?><br />
          
    
          <?php
            $wp_query = new WP_Query(array(
              'post_type' => 'shared_file',
              'post_status' => 'publish',
              'posts_per_page' => 5,
              'orderby' => 'date',
              'order'   => 'DESC',
              ));
          ?>
    
          <h3><?= esc_html__('Sample file data (5 newest files)', 'shared-files') ?></h3>
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

          <h3><?= esc_html__('More detailed data on newest file', 'shared-files') ?></h3>

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
                <?php $filename_with_path = SharedFilesFileOpen::getUpdatedPathAndFilename($file['file']) ?>
                1: <?php echo $filename_with_path ?><br />
                
                <?php if (file_exists($filename_with_path)): ?>
                  2: <?php echo esc_html__('(file found)', 'shared-files') ?><br />
                <?php else: ?>
                  2: <?php echo esc_html__('(file not found)', 'shared-files') ?><br />
                <?php endif; ?>
                
                3: <?php echo $file['url'] ?><br />
                4: <?php echo $file['type'] ?><br />
                
                <?php if (isset($file['error']) && $file['error']): ?>
                  5: <?php echo $file['error'] ?><br />
                <?php endif; ?>

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
                <?php $filename_with_path = SharedFilesFileOpen::getUpdatedPathAndFilename($file['file']) ?>
                1: <?php echo $filename_with_path ?><br />
                
                <?php if (file_exists($filename_with_path)): ?>
                  2: <?php echo esc_html__('(file found)', 'shared-files') ?><br />
                <?php else: ?>
                  2: <?php echo esc_html__('(file not found)', 'shared-files') ?><br />
                <?php endif; ?>

                3: <?php echo $file['url'] ?><br />
                4: <?php echo $file['type'] ?><br />
                
                <?php if (isset($file['error']) && $file['error']): ?>
                  5: <?php echo $file['error'] ?><br />
                <?php endif; ?>
                
              <?php endif; ?>
                        
            <?php
            endwhile;
          endif;
          ?>

          <h3><?php echo esc_html__('Debug log', 'shared-files') ?></h3>
          
          <?php
          global $wpdb;
          $table_name = $wpdb->prefix . 'shared_files_log';
          $msg = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC LIMIT 200");
          ?>
          
          <table class="shared-files-debug-log" style="min-width: 400px;">
          
          <tr>
            <th><?= esc_html__('Date', 'shared-files') ?></th>
            <th><?= esc_html__('Title', 'shared-files') ?></th>
            <th><?= esc_html__('Message', 'shared-files') ?></th>
          </tr>
          
          <?php if (sizeof($msg) > 0): ?>
          
            <?php foreach ($msg as $row): ?>
              <tr>
          
                <td style="white-space: nowrap;">
                  <?= $row->created_at ?>
                </td>
          
                <td>
                  <?= $row->title ?><br />
                </td>
          
                <td>
                  <?php if (isset($row->message)): ?>
                    <?= nl2br( $row->message ) ?>
                  <?php endif; ?>
                </td>
          
              </tr>
            <?php endforeach; ?>
          
          <?php else: ?>
          
            <tr>
              <td colspan="3">
                <?= esc_html__('No data logged yet.', 'shared-files') ?>
              </td>
            </tr>
          
          <?php endif; ?>

        </div>
        
      </div>

      <script src="<?= SHARED_FILES_URI ?>dist/clipboard.min.js"></script>
  
      <script>
      var clipboard = new ClipboardJS('.shared-files-copy');
  
      clipboard.on('success', function(e) {

        e.clearSelection();

        let clipboardtarget = jQuery(e.trigger).data('clipboard-target');

        jQuery(clipboardtarget).tipso({
          content: "<?= esc_js( __('Shortcode copied to clipboard!', 'shared-files') ) ?>",
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
