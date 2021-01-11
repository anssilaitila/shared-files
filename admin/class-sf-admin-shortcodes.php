<?php

class SharedFilesAdminShortcodes {

  public function register_shortcodes_page() {
    add_submenu_page(
      'edit.php?post_type=shared_file',
      __('Available shortcodes for Shared Files', 'shared-files'),
      __('Shortcodes', 'shared-files'),
      'manage_options',
      'shared-files-shortcodes',
      [$this, 'register_shortcodes_page_callback'],
      800
    );
  }

  public function register_shortcodes_page_callback() {
    ?>
    
    <?= SharedFilesAdminHelpSupport::permalinks_alert() ?>

    <link rel="stylesheet" href="<?= SHARED_FILES_URI ?>dist/tipso.min.css">
    <script src="<?= SHARED_FILES_URI ?>dist/tipso.min.js"></script>

    <div class="shared-files-help-support wrap">
      <h1><?= __('Available shortcodes for Shared Files', 'shared-files'); ?></h1>
      <div class="shared-files-examples">
        <p><?= __('If you have an idea for a new shortcode or parameter, you may contact the author at', 'shared-files') . ' <a href="https://www.sharedfilespro.com/support/" target="_blank">sharedfilespro.com/support/</a> ' . __('or by email:', 'shared-files') ?> <a href="javascript:location='mailto:\u0063\u006f\u006e\u0074\u0061\u0063\u0074\u0040\u0074\u0061\u006d\u006d\u0065\u0072\u0073\u006f\u0066\u0074\u002e\u0063\u006f\u006d';void 0"><script type="text/javascript">document.write('\u0063\u006f\u006e\u0074\u0061\u0063\u0074\u0040\u0074\u0061\u006d\u006d\u0065\u0072\u0073\u006f\u0066\u0074\u002e\u0063\u006f\u006d')</script></a></p>
      </div>

      <ul style="padding-left: 20px;">

        <li>
          <h2><?= __('Default file list:', 'shared-files') ?></h2><br />
          
          <?= __('Insert the shortcode', 'shared-files') ?> <span class="shared-files-shortcode shared-files-shortcode-1" data-tooltip-class="shared-files-shortcode-1">[shared_files]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-1"><?= __('Copy', 'shared-files') ?></button> <?= __('to the content editor of any page you wish the file list to appear. If there are more than one category, a dropdown of categories will appear above the file list.', 'shared-files'); ?>

          <ul class="shared-files-help-list-level-2">

            <li><?= __('Using the parameter hide_search you may hide the search form like so:', 'shared-files') ?> <span class="shared-files-shortcode shared-files-shortcode-2" data-tooltip-class="shared-files-shortcode-2">[shared_files hide_search=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-1"><?= __('Copy', 'shared-files') ?></button></li>

            <li><b><?= __('More parameters:', 'shared-files') ?></b>

              <?php if (SharedFilesHelpers::isPremium() == 1): ?>
                <span class="shared-files-pro-only-inline-inactive">Pro</span>
              <?php else: ?>
                <a href="<?= get_admin_url() ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">Pro</a>
              <?php endif; ?>

              <?php $num = 3 ?>

              <ul class="shared-files-help-list-level-3">
                <li><?= __('Limit the number of files (and hide pagination):', 'shared-files') ?> <span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files limit=5]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= __('Copy', 'shared-files') ?></button></li>
                <li><?= __('Hide file description:', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files hide_description=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= __('Copy', 'shared-files') ?></button></li>
                <li><?= __('Hide category dropdown:', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files hide_category_dropdown=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= __('Copy', 'shared-files') ?></button></li>
                <li><?= __('Layout as "2 columns":', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files layout=2-columns]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= __('Copy', 'shared-files') ?></button></li>
                <li><?= __('Layout as "3 columns":', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files layout=3-columns]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= __('Copy', 'shared-files') ?></button></li>
                <li><?= __('Layout as "4 columns":', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files layout=4-columns]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= __('Copy', 'shared-files') ?></button></li>
                <li><?= __('You can also use multiple parameters:', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files layout=2-cards-on-the-same-row hide_description=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= __('Copy', 'shared-files') ?></button></li>
              </ul>
            </li>
          </ul>

        </li>

        <li>
          <h2><?= __('Simple list:', 'shared-files'); ?></h2><br />
          <?= __('Insert the shortcode', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files_simple]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= __('Copy', 'shared-files') ?></button> <?= __('to the content editor of any page you wish the file list to appear.', 'shared-files'); ?>
        </li>

        <li>
          
          <h2><?= __('Search form only that targets all the files, sorted by category', 'shared-files') ?></h2>
        
          <?php if (SharedFilesHelpers::isPremium() == 1): ?>
            <span class="shared-files-pro-only-inline-inactive">Pro</span>
          <?php else: ?>
            <a href="<?= get_admin_url() ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">Pro</a>
          <?php endif; ?>
        
          <br /><?= __('Insert the shortcode', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files_search]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= __('Copy', 'shared-files') ?></button></span>

          <h4><?= __('Additional parameters:', 'shared-files') ?></h4>

          <ul class="shared-files-help-list-level-3">
            <li><?= __('Don\'t sort by categories', 'shared-files') ?>: <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files_search not_sorted_by_categories=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= __('Copy', 'shared-files') ?></button></li>
          </ul>
        
        </li>
        <li>
        
          <h2><?= __('List only files in certain category:', 'shared-files') ?></h2> 

          <?php if (SharedFilesHelpers::isPremium() == 1): ?>
            <span class="shared-files-pro-only-inline-inactive">Pro</span>
          <?php else: ?>
            <a href="<?= get_admin_url() ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">Pro</a>
          <?php endif; ?>

          <br /><?= __('Insert the shortcode', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files category="category_slug"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= __('Copy', 'shared-files') ?></button>. <?= __('You can find / define the category slug by editing the category.', 'shared-files'); ?>
          
        </li>
        <li>
        
          <h2><?= __('List categories / list files by category:', 'shared-files') ?></h2> 
        
          <?php if (SharedFilesHelpers::isPremium() == 1): ?>
            <span class="shared-files-pro-only-inline-inactive">Pro</span>
          <?php else: ?>
            <a href="<?= get_admin_url() ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">Pro</a>
          <?php endif; ?>
          
          <br /><?= __('Insert the shortcode', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files_categories]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= __('Copy', 'shared-files') ?></button> <?= __('or', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files_categories category="category_slug"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= __('Copy', 'shared-files') ?></button>. <?= __('You can find / define the category slug by editing the category.', 'shared-files'); ?>
        </li>

        <li>
          <h2><?= __('List a single file:', 'shared-files') ?></h2>

          <?php if (SharedFilesHelpers::isPremium() == 1): ?>
            <span class="shared-files-pro-only-inline-inactive">Pro</span>
          <?php else: ?>
            <a href="<?= get_admin_url() ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">Pro</a>
          <?php endif; ?>
          
          <br /><?= __('Insert the shortcode', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files file_id=12345]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= __('Copy', 'shared-files') ?></button>. <?= __('The file_id parameter is unique for each file and can be found under the Shortcode column in File Management page.', 'shared-files'); ?>
          
        </li>

        <li>
          <h2><?= __('Front-end uploader:', 'shared-files') ?></h2>

          <?php if (SharedFilesHelpers::isPremium() == 1): ?>
            <span class="shared-files-pro-only-inline-inactive">Pro</span>
          <?php else: ?>
            <a href="<?= get_admin_url() ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">Pro</a>
          <?php endif; ?>

          <ul class="shared-files-help-list-level-3">
          
            <li><?= __('To enable the uploader insert the shortcode', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files file_upload=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= __('Copy', 'shared-files') ?></button></li>
  
            <li><?= __('To hide other files use parameter "only_uploaded_files" like so:', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files file_upload=1 only_uploaded_files=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= __('Copy', 'shared-files') ?></button></li>
  
            <li><?= __('Hide the file list and show only the file upload form:', 'shared-files') ?> <span class="sf-new-feature-inline"><?= __('New', 'shared-files') ?></span> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files file_upload=1 hide_file_list=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= __('Copy', 'shared-files') ?></button></li>
  
            <li><?= __('Pre-define the category and hide category dropdown:', 'shared-files') ?> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files file_upload=1 category=CATEGORY_SLUG]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= __('Copy', 'shared-files') ?></button></li>
  
            <li><?= __('Show category checkboxes for the uploader:', 'shared-files') ?> <span class="sf-new-feature-inline"><?= __('New', 'shared-files') ?></span> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files file_upload=1 category_checkboxes=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= __('Copy', 'shared-files') ?></button></li>
  
            <li><?= __('Show tag checkboxes for the uploader:', 'shared-files') ?> <span class="sf-new-feature-inline"><?= __('New', 'shared-files') ?></span> <?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files file_upload=1 tag_checkboxes=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= __('Copy', 'shared-files') ?></button></li>
  
            <li><?= __('See live demo at', 'shared-files') ?> <a href="https://www.sharedfilespro.com/shared-files/file-upload-1/" style="font-weight: bold;" target="_blank">sharedfilespro.com</a></li>
          
          </ul>

        </li>

<li>
  
<h2><?= __('How to define the order of the files for each shortcode:', 'shared-files') ?></h2>

<div style="font-style: italic; margin-bottom: 10px;">
(choose one value from the list separated by "|")
</div>

<ul class="shared-files-help-list-level-3">
  <li>
<?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files order_by="post_date|_sf_main_date|title" order="ASC|DESC"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= __('Copy', 'shared-files') ?></button>
  </li>
  <li>
<?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files_search order_by="post_date|_sf_main_date|title" order="ASC|DESC"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= __('Copy', 'shared-files') ?></button>
  </li>
  <li>
<?php $num++ ?><span class="shared-files-shortcode shared-files-shortcode-<?= $num ?>" data-tooltip-class="shared-files-shortcode-<?= $num ?>">[shared_files_categories order_by="post_date|_sf_main_date|title" order="ASC|DESC"]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?= $num ?>"><?= __('Copy', 'shared-files') ?></button>
  </li>
</ul>
  
</li>
      </ul>

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
