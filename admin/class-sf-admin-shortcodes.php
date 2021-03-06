<?php

class SharedFilesAdminShortcodes {

  public function register_shortcodes_page() {
    add_submenu_page(
      'edit.php?post_type=shared_file',
      esc_html__('Available shortcodes for Shared Files', 'shared-files'),
      esc_html__('Shortcodes', 'shared-files'),
      'manage_options',
      'shared-files-shortcodes',
      [$this, 'register_shortcodes_page_callback'],
      800
    );
  }

  public function register_shortcodes_page_callback() {
    ?>
    
    <?= SharedFilesAdminHelpSupport::permalinks_alert() ?>

    <?php $s = get_option('shared_files_settings') ?>

    <link rel="stylesheet" href="<?= SHARED_FILES_URI ?>dist/tipso.min.css">
    <script src="<?= SHARED_FILES_URI ?>dist/tipso.min.js"></script>

    <div class="shared-files-help-support wrap">

      <h1><?= esc_html__('Available shortcodes for Shared Files', 'shared-files'); ?></h1>

      <div class="shared-files-examples">
        <p><?= esc_html__('If you have an idea for a new shortcode or parameter, you may contact the author at', 'shared-files') ?> <a href="https://www.sharedfilespro.com/support/" target="_blank">sharedfilespro.com/support/</a>.</p>
      </div>
  
      <div class="shared-files-admin-section shared-files-admin-section-shortcodes">
  
        <h2><?= esc_html__('Default file list', 'shared-files') ?></h2>

        <ul>
          <li>

            <?= esc_html__('Insert the shortcode', 'shared-files') ?> <span class="shared-files-shortcode shared-files-shortcode-1" data-tooltip-class="shared-files-shortcode-1">[shared_files]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-1"><?= esc_html__('Copy', 'shared-files') ?></button> <?= esc_html__('to the content editor of any page you wish the file list to appear. If there are more than one category, a dropdown of categories will appear above the file list.', 'shared-files'); ?>
  
            <ul>
  
              <li><?= esc_html__('Using the parameter hide_search you may hide the search form like so:', 'shared-files') ?> <span class="shared-files-shortcode shared-files-shortcode-2" data-tooltip-class="shared-files-shortcode-2">[shared_files hide_search=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-2"><?= esc_html__('Copy', 'shared-files') ?></button></li>

              <?php $num = 3 ?>

              <li><?= esc_html__('Hide files first (files are shown when searched or category/tag is selected):', 'shared-files') ?> <?php $num++ ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files hide_files_first=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>

              <li style="margin-top: 8px;"><b><?= esc_html__('More parameters:', 'shared-files') ?></b>
  
                <?php if (SharedFilesHelpers::isPremium() == 1): ?>
                  <span class="shared-files-pro-only-inline-inactive">Pro</span>
                <?php else: ?>
                  <a href="<?= get_admin_url() ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">Pro</a>
                <?php endif; ?>
  
                <ul>
                  <li><?= esc_html__('Limit the number of files (and hide pagination):', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files limit=5]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>
                  <li><?= esc_html__('Hide file description:', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files hide_description=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>
                  <li><?= esc_html__('Hide category dropdown:', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files hide_category_dropdown=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>
                  <li><?= esc_html__('Layout as "2 columns":', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files layout=2-columns]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>
                  <li><?= esc_html__('Layout as "3 columns":', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files layout=3-columns]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>
                  <li><?= esc_html__('Layout as "4 columns":', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files layout=4-columns]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>
                  <li><?= esc_html__('Show tag dropdown:', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files show_tag_dropdown=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>
                  
                  <li><?= esc_html__('Exclude categories (by slug):', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files exclude_cat="category-1,category-2"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>
                  
                  <li><?= esc_html__('Define an embed id (required, if there are multiple instances of [shared_files] on the same page):', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files embed_id="my-files"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>
                  
                  <li><?= esc_html__('Show files that belong to all of these categories (you can also hide the search form using the parameter hide_search=1):', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files categories__and="category-1,category-2"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>

                  <li><?= esc_html__('Show files that belong to all of these tags (can also be used with only one tag):', 'shared-files') ?> <span class="sf-new-feature-inline"><?= esc_html__('New', 'shared-files') ?></span> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files tags__and="tag-1,tag-2"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button>

                    <ul>
                      <li><?= esc_html__('categories__and and tags__and can be combined:', 'shared-files') ?> <span class="sf-new-feature-inline"><?= esc_html__('New', 'shared-files') ?></span> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files categories_and="category-1,category-2" tags__and="tag-1,tag-2"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>
                    </ul>

                  </li>

                  <li><?= esc_html__('You can also use multiple parameters:', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files layout=2-columns hide_description=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>
                </ul>
              </li>
            </ul>
  
          </li>
        </ul>
  
      </div>

      <div class="shared-files-admin-section shared-files-admin-section-shortcodes">      
  
        <h2><?= esc_html__('Simple list', 'shared-files'); ?></h2>
  
        <ul>
  
          <li>
            <?= esc_html__('Insert the shortcode', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files_simple]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button> <?= esc_html__('to the content editor of any page you wish the file list to appear.', 'shared-files'); ?>
          </li>

          <li style="margin-top: 8px;"><b><?= esc_html__('More parameters:', 'shared-files') ?></b>
            
            <?php if (SharedFilesHelpers::isPremium() == 1): ?>
              <span class="shared-files-pro-only-inline-inactive">Pro</span>
            <?php else: ?>
              <a href="<?= get_admin_url() ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">Pro</a>
            <?php endif; ?>
            
            <ul>
              <li><?= esc_html__('Limit the number of files (and hide pagination):', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files_simple limit=5]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>
            </ul>

          </li>          

        </ul>
      </div>

      <div class="shared-files-admin-section shared-files-admin-section-shortcodes">      
                    
        <h2>
          <?= esc_html__('Enable front-end editor for all files') ?>
      
          <?php if (SharedFilesHelpers::isPremium() == 1): ?>
            <span class="shared-files-pro-only-inline-inactive">Pro</span>
          <?php else: ?>
            <a href="<?= get_admin_url() ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">Pro</a>
          <?php endif; ?>
      
        </h2>

        <p><?= esc_html__('Enable front-end edit using the following shortcodes (user roles must also be activated from the plugin settings):', 'shared-files') ?></p>
      
        <ul>  
         <li>
            <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files edit=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></span>
         </li>
         <li>
            <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files_categories edit=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></span>
          </li>
        </ul>
      </div>

      <div class="shared-files-admin-section shared-files-admin-section-shortcodes">      
      
        <h2>
          <?= esc_html__('Front-end uploader', 'shared-files') ?>
        </h2>
      
        <ul>
        
          <li><?= esc_html__('To enable the uploader insert the shortcode', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files file_upload=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>
      
          <li><?= esc_html__('To hide other files use parameter "only_uploaded_files" like so:', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files file_upload=1 only_uploaded_files=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>
      
          <li><?= esc_html__('Hide the file list and show only the file upload form:', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files file_upload=1 hide_file_list=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>

          <li><?= esc_html__('Show tag dropdown for the uploader:', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files file_upload=1 tag_dropdown=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>
            
          <li><?= esc_html__('Show tag checkboxes for the uploader:', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files file_upload=1 tag_checkboxes=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>

          <li><?= esc_html__('Allow the uploader to create a new category:', 'shared-files') ?>

          <?php if (SharedFilesHelpers::isPremium() == 1): ?>
            <span class="shared-files-pro-only-inline-inactive">Pro</span>
          <?php else: ?>
            <a href="<?= get_admin_url() ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">Pro</a>
          <?php endif; ?>
          
          <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files file_upload=1 new_category=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>

          <li><?= esc_html__('Allow the uploader to create new tags:', 'shared-files') ?>
          
          <span class="sf-new-feature-inline"><?= esc_html__('New', 'shared-files') ?></span>
          
          <?php if (SharedFilesHelpers::isPremium() == 1): ?>
            <span class="shared-files-pro-only-inline-inactive">Pro</span>
          <?php else: ?>
            <a href="<?= get_admin_url() ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">Pro</a>
          <?php endif; ?>
          
          <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files file_upload=1 new_tags=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>
      
          <li><?= esc_html__('Pre-define the category and hide category dropdown:', 'shared-files') ?>
          
          <?php if (SharedFilesHelpers::isPremium() == 1): ?>
            <span class="shared-files-pro-only-inline-inactive">Pro</span>
          <?php else: ?>
            <a href="<?= get_admin_url() ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">Pro</a>
          <?php endif; ?>
          
          <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files file_upload=1 category=CATEGORY_SLUG]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>
          
          <li><?= esc_html__('Show category checkboxes for the uploader:', 'shared-files') ?>
          
          <?php if (SharedFilesHelpers::isPremium() == 1): ?>
            <span class="shared-files-pro-only-inline-inactive">Pro</span>
          <?php else: ?>
            <a href="<?= get_admin_url() ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">Pro</a>
          <?php endif; ?>
          
          <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files file_upload=1 category_checkboxes=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>

          <li><?= esc_html__('Exclude categories:', 'shared-files') ?>
         
          <?php if (SharedFilesHelpers::isPremium() == 1): ?>
            <span class="shared-files-pro-only-inline-inactive">Pro</span>
          <?php else: ?>
            <a href="<?= get_admin_url() ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">Pro</a>
          <?php endif; ?>
          
          <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files file_upload=1 file_upload_exclude_cat="category-1,category-2"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>

          <li><?= esc_html__('See live demo at', 'shared-files') ?> <a href="https://www.sharedfilespro.com/shared-files/file-upload-1/" style="font-weight: bold;" target="_blank">sharedfilespro.com</a></li>
  
        </ul>
      
      </div>
      
      <div class="shared-files-admin-section shared-files-admin-section-shortcodes">      
                    
        <h2>
          <?= esc_html__('Search form only that targets all the files, sorted by category', 'shared-files') ?>

          <?php if (SharedFilesHelpers::isPremium() == 1): ?>
          <span class="shared-files-pro-only-inline-inactive">Pro</span>
          <?php else: ?>
          <a href="<?= get_admin_url() ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">Pro</a>
          <?php endif; ?>
      
        </h2>
 
        <ul>  
         <li>
         
            <?= esc_html__('Insert the shortcode', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files_search]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></span>
  
            <h3><?= esc_html__('Additional parameters:', 'shared-files') ?></h3>
  
            <ul>
              <li><?= esc_html__('Don\'t sort by categories', 'shared-files') ?>: <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files_search not_sorted_by_categories=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>
            </ul>
          
          </li>
        </ul>
      </div>
      
      <div class="shared-files-admin-section shared-files-admin-section-shortcodes">      
  
        <h2>
            <?= esc_html__('List only files in certain category', 'shared-files') ?>
  
            <?php if (SharedFilesHelpers::isPremium() == 1): ?>
              <span class="shared-files-pro-only-inline-inactive">Pro</span>
            <?php else: ?>
              <a href="<?= get_admin_url() ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">Pro</a>
            <?php endif; ?>
  
        </h2> 
  
        <ul>
          <li>
  
            <?= esc_html__('Insert the shortcode', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files category="category_slug"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button>. <?= esc_html__('You can find / define the category slug by editing the category.', 'shared-files'); ?>
            
          </li>
        </ul>
        
      </div>
  
      <div class="shared-files-admin-section shared-files-admin-section-shortcodes">      
  
        <h2>
          <?= esc_html__('List categories / list files by category', 'shared-files') ?>    
          <?php if (SharedFilesHelpers::isPremium() == 1): ?>
            <span class="shared-files-pro-only-inline-inactive">Pro</span>
          <?php else: ?>
            <a href="<?= get_admin_url() ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">Pro</a>
          <?php endif; ?>
        </h2> 
  
        <ul>
          <li>              
            <?= esc_html__('Insert the shortcode', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files_categories]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button> <?= esc_html__('or', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files_categories category="category_slug"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button>. <?= esc_html__('You can find / define the category slug by editing the category.', 'shared-files'); ?>

            <h3><?= esc_html__('Additional parameters:', 'shared-files') ?></h3>
            
            <ul>
              <li><?= esc_html__('Exclude categories (by slug):', 'shared-files') ?> <?php $num++ ?> <span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files_categories exclude_cat="category-1,category-2"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button></li>
            </ul>

          </li>

        </ul>
          
      </div>
      
      <div class="shared-files-admin-section shared-files-admin-section-shortcodes">      
  
        <h2>
          <?= esc_html__('List a single file', 'shared-files') ?>
  
          <?php if (SharedFilesHelpers::isPremium() == 1): ?>
            <span class="shared-files-pro-only-inline-inactive">Pro</span>
          <?php else: ?>
            <a href="<?= get_admin_url() ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">Pro</a>
          <?php endif; ?>
        </h2>
  
        <ul>
          <li>
            
            <?= esc_html__('Insert the shortcode', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files file_id=12345]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button>. <?= esc_html__('The file_id parameter is unique for each file and can be found under the Shortcode column in File Management page.', 'shared-files'); ?>
            
          </li>
        </ul>
  
      </div>
  
      <div class="shared-files-admin-section shared-files-admin-section-shortcodes">      
          
        <h2><?= esc_html__('How to define the order of the files for each shortcode', 'shared-files') ?></h2>
  
        <ul>
          <li>
        
            <div style="font-style: italic; margin-bottom: 10px;">
              <?= esc_html__('Choose one value from the list separated by "|":', 'shared-files') ?>
            </div>
            
            <ul>
              <li>
                <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files order_by="post_date|_sf_main_date|title" order="ASC|DESC"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button>
              </li>
              <li>
                <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files_search order_by="post_date|_sf_main_date|title" order="ASC|DESC"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button>
              </li>
              <li>
                <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files_categories order_by="post_date|_sf_main_date|title" order="ASC|DESC"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'shared-files') ?></button>
              </li>
            </ul>
    
          </li>
        </ul>
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
