<?php

class SharedFilesAdminInlineScripts {

  public function inline_scripts() {

      ?>

      <?php $current_screen = get_current_screen(); ?>

      <?php if (!isset($current_screen->id) || (isset($current_screen->id) && $current_screen->id !== 'shared_file_page_shared-files-sync-files' && $current_screen->id !== 'shared_file_page_shared-files-sync-media-library')): ?>
        <style>#adminmenu a[href="edit.php?post_type=shared_file&page=shared-files-sync-media-library"] { display: none; visibility: hidden; }</style>
      <?php endif; ?>

      <?php if (isset($current_screen->id) && ($current_screen->id === 'edit-shared_file' || $current_screen->id === 'edit-shared-file-category')): ?>
  
        <link rel="stylesheet" href="<?= esc_url( SHARED_FILES_URI ) ?>dist/tipso.min.css">
        <script src="<?= esc_url( SHARED_FILES_URI ) ?>dist/tipso.min.js"></script>
        <script src="<?= esc_url( SHARED_FILES_URI ) ?>dist/clipboard.min.js"></script>
    
        <script>
          
          jQuery(function ($) {

            $(document).on('click', '.shared-files-copy', function (e) {
              e.preventDefault();
            });
              
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
  //          console.log(e);
            });
      
          });
  
        </script>
      
      <?php endif; ?>
      
      <?php

  }

}
