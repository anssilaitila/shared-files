<?php

class SharedFilesAdminShortcodes {

  public function register_shortcodes_page() {
    add_submenu_page(
      'edit.php?post_type=shared_file',
      sanitize_text_field( __('Available shortcodes for Shared Files', 'shared-files') ),
      sanitize_text_field( __('Shortcodes', 'shared-files') ),
      'manage_options',
      'shared-files-shortcodes',
      [$this, 'register_shortcodes_page_callback'],
      800
    );
  }

  public function register_shortcodes_page_callback() {
    ?>
    
    <?php echo SharedFilesAdminHelpSupport::permalinks_alert() ?>

    <?php $s = get_option('shared_files_settings') ?>

    <div class="shared-files-help-support wrap">

      <h1><?php echo esc_html__('Available shortcodes for Shared Files', 'shared-files'); ?></h1>

      <div class="shared-files-examples">

        <?php if (shared_files_fs()->can_use_premium_code()): ?>

          <p><?php echo esc_html__('If you have any questions regarding the shortcodes, you may contact the author at', 'shared-files') ?> <a href="https://www.sharedfilespro.com/support/?utm_source=plugin-shortcodes" target="_blank">sharedfilespro.com/support/</a>.</p>
          
        <?php else: ?>

          <p>
          <?php
          $url = 'https://wordpress.org/support/plugin/shared-files/';
          echo sprintf(
            wp_kses(
              /* translators: %s: link to the support forum */
              __('If you have any questions regarding the shortcodes, you may contact the author at <a href="%s" target="_blank">the support forum</a>.', 'shared-files'),
              array('a' => array('href' => array(), 'target' => array()))
            ),
            esc_url($url) 
          );
          ?>
          </p>
                
        <?php endif; ?>

        <div class="shared-files-all-paid-plans">

          <?php if (SharedFilesHelpers::isPremium() == 1): ?>

            <span class="shared-files-pro-only-inline-inactive" style="margin-left: 0; margin-right: 1px;">All Plans</span>

            <?php echo esc_html__('means that the shortcode / parameter exists in all of the paid plans.', 'shared-files') ?>

          <?php else: ?>

            <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline" style="margin-left: 0; margin-right: 1px;">All Plans</a>

            <?php
            echo wp_kses(
                /* translators: %s: link to the support forum */
                __('means that the shortcode / parameter exists in all of the <strong>paid</strong> plans.', 'shared-files'),
                array('strong' => array())
              );
            ?>

          <?php endif; ?>

        </div>

      </div>
  
      <div class="shared-files-admin-section shared-files-admin-section-shortcodes">
  
        <h2><?php echo esc_html__('Default file list', 'shared-files') ?></h2>

        <ul>
          <li>

            <?php echo esc_html__('Insert the shortcode', 'shared-files') ?> <span class="shared-files-shortcode shared-files-shortcode-1" data-tooltip-class="shared-files-shortcode-1">[shared_files]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-1"><?php echo esc_html__('Copy', 'shared-files') ?></button> <?php echo esc_html__('to the content editor of any page you wish the file list to appear. If there are more than one category, a dropdown of categories will appear above the file list.', 'shared-files'); ?>
  
            <ul>
  
              <li><?php echo esc_html__('Using the parameter hide_search you may hide the search form like so:', 'shared-files') ?> <span class="shared-files-shortcode shared-files-shortcode-2" data-tooltip-class="shared-files-shortcode-2">[shared_files hide_search=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-2"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>

              <?php $num = 3 ?>

              <li><?php echo esc_html__('Hide files first (files are shown when searched or category/tag is selected):', 'shared-files') ?> <?php $num++ ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files hide_files_first=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>

              <li><?php echo esc_html__('Hide search form:', 'shared-files') ?> <?php $num++ ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files hide_search_form=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>

              <li><?php echo esc_html__('Show tag dropdown:', 'shared-files') ?> <?php $num++ ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files show_tag_dropdown=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>

              <?php if ( shared_files_fs()->is_free_plan() || shared_files_fs()->is_plan_or_trial('business') ): ?>

                <li><?php echo esc_html__('Use wait countdown page:', 'shared-files') ?>
  
                <span class="sf-new-feature-inline" style="color: #3c434a;"><?php echo esc_html__('New', 'shared-files') ?></span>
          
                <?php if (SharedFilesHelpers::isPremium() == 1): ?>
                  <span class="shared-files-pro-only-inline-inactive">Business</span>
                <?php else: ?>
                  <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">Business</a>
                <?php endif; ?>
                
                <?php $num++ ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files use_wait_page=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>
                
              <?php endif; ?>

              <li style="margin-top: 8px;"><b><?php echo esc_html__('More parameters:', 'shared-files') ?></b>
  
                <?php if (SharedFilesHelpers::isPremium() == 1): ?>
                  <span class="shared-files-pro-only-inline-inactive">All Plans</span>
                <?php else: ?>
                  <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">All Plans</a>
                <?php endif; ?>
  
                <ul>
                  <li><?php echo esc_html__('Limit the number of files (and hide pagination):', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files limit=5]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>
                  <li><?php echo esc_html__('Hide file description:', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files hide_description=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>
                  <li><?php echo esc_html__('Hide category dropdown:', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files hide_category_dropdown=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>
                  <li><?php echo esc_html__('Layout as "2 columns":', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files layout=2-columns]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>
                  <li><?php echo esc_html__('Layout as "3 columns":', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files layout=3-columns]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>
                  <li><?php echo esc_html__('Layout as "4 columns":', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files layout=4-columns]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>

                  <li><?php echo esc_html__('Hide tags:', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files hide_tags=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>
                  
                  <li><?php echo esc_html__('Exclude categories (by slug):', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files exclude_cat="category-1,category-2"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>
                  
                  <li><?php echo esc_html__('Define an embed id (required, if there are multiple instances of [shared_files] on the same page):', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files embed_id="my-files"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>
                  
                  <li><?php echo esc_html__('Show files that belong to all of these categories (you can also hide the search form using the parameter hide_search=1):', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files categories__and="category-1,category-2"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>

                  <li><?php echo esc_html__('Show files that belong to all of these tags (can also be used with only one tag):', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files tags__and="tag-1,tag-2"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button>

                    <ul>
                      <li><?php echo esc_html__('categories__and and tags__and can be combined:', 'shared-files') ?>  <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files categories__and="category-1,category-2" tags__and="tag-1,tag-2"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>
                    </ul>

                  </li>

                  <li><?php echo esc_html__('Show files that belong to any these tags:', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files tags__or="tag-1,tag-2"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button>

                  <li><?php echo esc_html__('You can also use multiple parameters:', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files layout=2-columns hide_description=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>
                </ul>
              </li>
            </ul>
  
          </li>
        </ul>
  
      </div>

      <div class="shared-files-admin-section shared-files-admin-section-shortcodes">      
  
        <h2><?php echo esc_html__('Simple list', 'shared-files'); ?></h2>
  
        <ul>
  
          <li>
            <?php echo esc_html__('Insert the shortcode', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files_simple]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button> <?php echo esc_html__('to the content editor of any page you wish the file list to appear.', 'shared-files'); ?>
          </li>

          <li style="margin-top: 8px;"><b><?php echo esc_html__('More parameters:', 'shared-files') ?></b>
            
            <?php if (SharedFilesHelpers::isPremium() == 1): ?>
              <span class="shared-files-pro-only-inline-inactive">All Plans</span>
            <?php else: ?>
              <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">All Plans</a>
            <?php endif; ?>
            
            <ul>
              <li><?php echo esc_html__('Hide the search:', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files_simple hide_search=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>
              <li><?php echo esc_html__('Limit the number of files (and hide pagination):', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files_simple limit=5]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>
              <li><?php echo esc_html__('Show files from a category:', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files_simple category="sample-category-1"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>
              <li><?php echo esc_html__('Enable the front-end file editor:', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files_simple edit=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>
            </ul>

          </li>          

        </ul>
      </div>

      <div class="shared-files-admin-section shared-files-admin-section-shortcodes">      
  
        <h2>
          <?php echo esc_html__('Exact search from all files', 'shared-files'); ?>

          <?php if (SharedFilesHelpers::isPremium() == 1): ?>
            <span class="shared-files-pro-only-inline-inactive">Professional</span>
          <?php else: ?>
            <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">Professional</a>
          <?php endif; ?>
        
        </h2>
  
        <ul>
  
          <li>
            <?php echo esc_html__('Insert the shortcode', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files_exact_search]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button> <?php echo esc_html__('to the content editor of any page you wish the file list to appear.', 'shared-files'); ?>
          </li>
          <li>
            <?php echo esc_html__('This search targets all files (their titles) and shows the files after enter is pressed.', 'shared-files') ?>
          </li>
          <li>
            <?php echo esc_html__('Minimum number of characters required for the search to function is defined in the plugin settings (default is 3).', 'shared-files') ?>
          </li>

        </ul>
      </div>

      <div class="shared-files-admin-section shared-files-admin-section-shortcodes">      
                    
        <h2>
          <?php echo esc_html__('Enable front-end editor for all files') ?>
      
          <?php if (SharedFilesHelpers::isPremium() == 1): ?>
            <span class="shared-files-pro-only-inline-inactive">All Plans</span>
          <?php else: ?>
            <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">All Plans</a>
          <?php endif; ?>
      
        </h2>

        <p><?php echo esc_html__('Enable front-end edit using the following shortcodes (user roles must also be activated from the plugin settings):', 'shared-files') ?></p>
      
        <ul>  
         <li>
            <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files edit=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></span>
         </li>
         <li>
            <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files_categories edit=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></span>
          </li>
        </ul>
      </div>

      <div class="shared-files-admin-section shared-files-admin-section-shortcodes">      
      
        <h2>
          <?php echo esc_html__('Front-end uploader', 'shared-files') ?>
        </h2>
      
        <ul>
        
          <li><?php echo esc_html__('To enable the uploader insert the shortcode', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files file_upload=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>
      
          <li><?php echo esc_html__('To hide other files use parameter "only_uploaded_files" like so:', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files file_upload=1 only_uploaded_files=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>
      
          <li><?php echo esc_html__('Hide the file list and show only the file upload form:', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files file_upload=1 hide_file_list=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>

          <li><?php echo esc_html__('Show tag dropdown for the uploader:', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files file_upload=1 tag_dropdown=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>
            
          <li><?php echo esc_html__('Show tag checkboxes for the uploader:', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files file_upload=1 tag_checkboxes=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>

          <li><?php echo esc_html__('Define an ID for the files and display only these uploaded files, having the same ID:', 'shared-files') ?>
          
          <?php if (SharedFilesHelpers::isPremium() == 1): ?>
            <span class="shared-files-pro-only-inline-inactive">All Plans</span>
          <?php else: ?>
            <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">All Plans</a>
          <?php endif; ?>
          
          <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files file_upload=1 upload_id="name-for-id"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>

          <li><?php echo esc_html__('Hide category dropdown:', 'shared-files') ?>
                    
          <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files file_upload=1 hide_category_dropdown=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>

          <li><?php echo esc_html__('Allow the uploader to create a new category:', 'shared-files') ?>
          
          <?php if (SharedFilesHelpers::isPremium() == 1): ?>
            <span class="shared-files-pro-only-inline-inactive">All Plans</span>
          <?php else: ?>
            <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">All Plans</a>
          <?php endif; ?>
          
          <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files file_upload=1 new_category=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>

          <li><?php echo esc_html__('Allow the uploader to create new tags:', 'shared-files') ?>
          
          <?php if (SharedFilesHelpers::isPremium() == 1): ?>
            <span class="shared-files-pro-only-inline-inactive">All Plans</span>
          <?php else: ?>
            <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">All Plans</a>
          <?php endif; ?>
          
          <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files file_upload=1 new_tags=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>
      
          <li><?php echo esc_html__('Pre-define the category and hide category dropdown:', 'shared-files') ?>
          
          <?php if (SharedFilesHelpers::isPremium() == 1): ?>
            <span class="shared-files-pro-only-inline-inactive">All Plans</span>
          <?php else: ?>
            <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">All Plans</a>
          <?php endif; ?>
          
          <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files file_upload=1 category=CATEGORY_SLUG]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>
          
          <li><?php echo esc_html__('Show category checkboxes for the uploader:', 'shared-files') ?>
          
          <?php if (SharedFilesHelpers::isPremium() == 1): ?>
            <span class="shared-files-pro-only-inline-inactive">All Plans</span>
          <?php else: ?>
            <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">All Plans</a>
          <?php endif; ?>
          
          <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files file_upload=1 category_checkboxes=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>

          <li><?php echo esc_html__('Exclude categories:', 'shared-files') ?>
         
          <?php if (SharedFilesHelpers::isPremium() == 1): ?>
            <span class="shared-files-pro-only-inline-inactive">All Plans</span>
          <?php else: ?>
            <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">All Plans</a>
          <?php endif; ?>
          
          <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files file_upload=1 file_upload_exclude_cat="category-1,category-2"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>

          <li><?php echo esc_html__('Exclude tags:', 'shared-files') ?>
          
          <?php if (SharedFilesHelpers::isPremium() == 1): ?>
            <span class="shared-files-pro-only-inline-inactive">All Plans</span>
          <?php else: ?>
            <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">All Plans</a>
          <?php endif; ?>
          
          <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files file_upload=1 file_upload_exclude_tag="tag-1,tag-2"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>

          <li><?php echo esc_html__('See live demo at', 'shared-files') ?> <a href="https://www.sharedfilespro.com/shared-files/file-upload-1/" style="font-weight: bold;" target="_blank">sharedfilespro.com</a></li>
  
        </ul>
      
      </div>

      <?php if ( shared_files_fs()->is_free_plan() || shared_files_fs()->is_plan_or_trial('pro') || shared_files_fs()->is_plan_or_trial('business') ): ?>

        <div class="shared-files-admin-section shared-files-admin-section-shortcodes">      
                      
          <h2>
            <?php echo esc_html__('File list restricted by permissions', 'shared-files') ?>
            
            <span class="sf-new-feature-inline" style="color: #3c434a;"><?php echo esc_html__('New', 'shared-files') ?></span>
        
            <?php if (SharedFilesHelpers::isPremium() == 1): ?>
              <span class="shared-files-pro-only-inline-inactive">Professional</span>
            <?php else: ?>
              <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">Professional</a>
            <?php endif; ?>
        
          </h2>

          <ul>  
           <li>
           
              <?php echo esc_html__('Insert the shortcode', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files_restricted]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></span>
              
              <p><?php echo esc_html__('This shortcode will list only such files that are readable by the logged in user.', 'shared-files') ?></p>

              <p><?php echo esc_html__('A file is listed for the logged in user, if any of the following matches:', 'shared-files') ?></p>

              <ul>
                <li><?php echo esc_html__('The user was specifically given permissions to read the file (by editing the file).', 'shared-files') ?><br />
                <?php echo esc_html__('When a user uploads a file, that user is automatically given permissions to read that file.', 'shared-files') ?></li>
                <li><?php echo esc_html__('The logged in user belongs to a role that has permissions to read the file.', 'shared-files') ?></li>
              </ul>

              <p><?php echo esc_html__('The following should also be noted:', 'shared-files') ?></p>

              <ul>
                <li><?php echo esc_html__('A user having the administrator role can open any file.', 'shared-files') ?></li>
                <li><?php echo esc_html__('A caching plugin should not be used for logged in users, to prevent the file list storing in the cache.', 'shared-files') ?></li>
                <li><?php echo esc_html__('It is advisable to block direct access to file urls like /wp-content/uploads/shared-files/* on the server level (Apache, Nginx, etc.)', 'shared-files') ?> – <a href="<?php echo esc_url( get_admin_url(null, 'edit.php?post_type=shared_file&page=shared-files-restrict-access' ) ) ?>"><?php echo esc_html__('More information &raquo;', 'shared-files') ?></a></li>

                <?php if (0): ?>
                  <li><?php echo esc_html__('If you have any questions regarding the items above, you can always contact us at https://www.sharedfilespro.com/support/ and we\'ll help.', 'shared-files') ?></li>
                <?php endif; ?>

                </ul>
        
              <h3><?php echo esc_html__('Additional parameters:', 'shared-files') ?></h3>
        
              <ul>

                <li><?php echo esc_html__('Show the file uploader', 'shared-files') ?>: <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files_restricted file_upload=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>

                <li><?php echo esc_html__('Show only the file uploader, hide file list', 'shared-files') ?>: <span class="sf-new-feature-inline" style="color: #3c434a;"><?php echo esc_html__('New', 'shared-files') ?></span> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files_restricted file_upload=1 hide_file_list=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>

                <li><?php echo esc_html__('Enable the front-end editor', 'shared-files') ?>: <span class="sf-new-feature-inline" style="color: #3c434a;"><?php echo esc_html__('New', 'shared-files') ?></span> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files_restricted edit=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>

              </ul>
            
            </li>
          </ul>

        </div>

        <div class="shared-files-admin-section shared-files-admin-section-shortcodes">      
                      
          <h2>
            <?php echo esc_html__('Accordion', 'shared-files') ?>

            <?php if (0): ?>
              <span class="sf-new-feature-inline" style="color: #3c434a;"><?php echo esc_html__('New', 'shared-files') ?></span>
            <?php endif; ?>
        
            <?php if (SharedFilesHelpers::isPremium() == 1): ?>
              <span class="shared-files-pro-only-inline-inactive">Professional</span>
            <?php else: ?>
              <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">Professional</a>
            <?php endif; ?>
        
          </h2>
        
          <ul>  
           <li>
           
              <?php echo esc_html__('Insert the shortcode', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files_accordion]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></span>
        
              <h3><?php echo esc_html__('Additional parameters:', 'shared-files') ?></h3>
        
              <ul>

                <li><?php echo esc_html__('Group and order files by month', 'shared-files') ?>: <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files_accordion group_files_by_month=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>

                <li><?php echo esc_html__('Group files by month and use the "file date" as date (default is file publish date)', 'shared-files') ?>: <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files_accordion group_files_by_month=1 order_by="_sf_main_date"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>

                <li><?php echo esc_html__('Only the following categories', 'shared-files') ?>: <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files_accordion categories="sample-category-1,sample-category-2"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>

                <li><?php echo esc_html__('Exclude categories', 'shared-files') ?>: <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files_accordion exclude_cat="sample-category-1,sample-category-2"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>

                <li><?php echo esc_html__('Restrict file list by permissions', 'shared-files') ?>: <span class="sf-new-feature-inline" style="color: #3c434a;"><?php echo esc_html__('New', 'shared-files') ?></span> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files_accordion restricted=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>

                <li><?php echo esc_html__('Enable the front-end file editor', 'shared-files') ?>: <span class="sf-new-feature-inline" style="color: #3c434a;"><?php echo esc_html__('New', 'shared-files') ?></span> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files_accordion edit=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>

              </ul>
            
            </li>
          </ul>
        </div>
        
      <?php endif; ?>

      <?php if ( shared_files_fs()->is_free_plan() || shared_files_fs()->is_plan_or_trial('business') ): ?>
      
        <div class="shared-files-admin-section shared-files-admin-section-shortcodes">      
                      
          <h2>
            <?php echo esc_html__('Favorite files', 'shared-files') ?>
            
            <?php if (SharedFilesHelpers::isPremium() == 1): ?>
              <span class="shared-files-pro-only-inline-inactive">Business</span>
            <?php else: ?>
              <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">Business</a>
            <?php endif; ?>
        
          </h2>
        
          <ul>  
           <li>
           
              <?php echo esc_html__('Insert the shortcode', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files_favorites]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></span>
        
            </li>
          </ul>
        </div>
      
      <?php endif; ?>
      
      <div class="shared-files-admin-section shared-files-admin-section-shortcodes">      
                    
        <h2>
          <?php echo esc_html__('Search form only that targets all the files, sorted by category', 'shared-files') ?>

          <?php if (SharedFilesHelpers::isPremium() == 1): ?>
            <span class="shared-files-pro-only-inline-inactive">All Plans</span>
          <?php else: ?>
            <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">All Plans</a>
          <?php endif; ?>
      
        </h2>
 
        <ul>  
         <li>
         
            <?php echo esc_html__('Insert the shortcode', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files_search]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></span>
  
            <h3><?php echo esc_html__('Additional parameters:', 'shared-files') ?></h3>
  
            <ul>
              <li><?php echo esc_html__('Don\'t sort by categories', 'shared-files') ?>: <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files_search not_sorted_by_categories=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>
            </ul>
          
          </li>
        </ul>
      </div>
      
      <div class="shared-files-admin-section shared-files-admin-section-shortcodes">      
  
        <h2>
            <?php echo esc_html__('List only files in certain category', 'shared-files') ?>
  
            <?php if (SharedFilesHelpers::isPremium() == 1): ?>
              <span class="shared-files-pro-only-inline-inactive">All Plans</span>
            <?php else: ?>
              <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">All Plans</a>
            <?php endif; ?>
  
        </h2> 
  
        <ul>
          <li>
  
            <?php echo esc_html__('Insert the shortcode', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files category="category_slug"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button>. <?php echo esc_html__('You can find / define the category slug by editing the category.', 'shared-files'); ?>
            
          </li>
        </ul>
        
      </div>
  
      <div class="shared-files-admin-section shared-files-admin-section-shortcodes">      
  
        <h2>
          <?php echo esc_html__('List categories / list files by category', 'shared-files') ?>    
          <?php if (SharedFilesHelpers::isPremium() == 1): ?>
            <span class="shared-files-pro-only-inline-inactive">All Plans</span>
          <?php else: ?>
            <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">All Plans</a>
          <?php endif; ?>
        </h2> 
  
        <ul>
          <li>              
            <?php echo esc_html__('Insert the shortcode', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files_categories]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button> <?php echo esc_html__('or', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files_categories category="category_slug"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button>. <?php echo esc_html__('You can find / define the category slug by editing the category.', 'shared-files'); ?>

            <h3><?php echo esc_html__('Additional parameters:', 'shared-files') ?></h3>
            
            <ul>
              <li><?php echo esc_html__('Exclude categories (by slug):', 'shared-files') ?> <?php $num++ ?> <span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files_categories exclude_cat="category-1,category-2"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>
              <li><?php echo esc_html__('Show files under current category, even if there are subcategories present:', 'shared-files') ?> <?php $num++ ?> <span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files_categories show_files_always=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>
              <li><?php echo esc_html__('Restrict file list by permissions', 'shared-files') ?>: <span class="sf-new-feature-inline" style="color: #3c434a;"><?php echo esc_html__('New', 'shared-files') ?></span> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files_categories restricted=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button></li>
            </ul>

          </li>

        </ul>
          
      </div>
      
      <div class="shared-files-admin-section shared-files-admin-section-shortcodes">      
  
        <h2>
          <?php echo esc_html__('List a single file', 'shared-files') ?>
  
          <?php if (SharedFilesHelpers::isPremium() == 1): ?>
            <span class="shared-files-pro-only-inline-inactive">All Plans</span>
          <?php else: ?>
            <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">All Plans</a>
          <?php endif; ?>
        </h2>
  
        <ul>
          <li>
            
            <?php echo esc_html__('Insert the shortcode', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files file_id=12345]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button>
            
          </li>
          <li>

            <?php echo esc_html__('Minimal layout:', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files file_id=12345 layout="minimal"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button><br /><br />
            
            <?php echo esc_html__('The file_id parameter is unique for each file and can be found under the Shortcode column in File Management page.', 'shared-files'); ?>
            
          </li>
        </ul>
  
      </div>
  
      <div class="shared-files-admin-section shared-files-admin-section-shortcodes">      
          
        <h2><?php echo esc_html__('How to define the order of the files for each shortcode', 'shared-files') ?></h2>
  
        <ul>
          <li>
        
            <div style="font-style: italic; margin-bottom: 10px;">
              <?php echo esc_html__('Choose one value from the list separated by "|":', 'shared-files') ?>
            </div>
            
            <ul>
              <li>
                <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files order_by="post_date|_sf_main_date|title" order="ASC|DESC"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button>
              </li>
              <li>
                <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files_search order_by="post_date|_sf_main_date|title" order="ASC|DESC"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button>
              </li>
              <li>
                <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?php echo esc_attr( $num ) ?>" data-tooltip-class="shared-files-shortcode-<?php echo esc_attr( $num ) ?>">[shared_files_categories order_by="post_date|_sf_main_date|title" order="ASC|DESC"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php echo esc_attr( $num ) ?>"><?php echo esc_html__('Copy', 'shared-files') ?></button>
              </li>
            </ul>
    
          </li>
        </ul>
      </div>

    </div>
    <?php
  }

}
