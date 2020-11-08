<?php

class SharedFilesAdminInlineScripts {

  public function inline_scripts() {

      ?>

      <?php $current_screen = get_current_screen(); ?>

      <?php if (isset($current_screen->id) && ($current_screen->id === 'edit-shared_file' || $current_screen->id === 'edit-shared-file-category')): ?>
  
        <link rel="stylesheet" href="<?= SHARED_FILES_URI ?>dist/tipso.min.css">
        <script src="<?= SHARED_FILES_URI ?>dist/tipso.min.js"></script>
        <script src="<?= SHARED_FILES_URI ?>dist/clipboard.min.js"></script>
    
        <script>
          
          jQuery(function ($) {

            $('.shared-files-copy').on('click', function (e) {
              e.preventDefault();
            });
              
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
  //          console.log(e);
            });
      
          });
  
        </script>
      
      <?php endif; ?>
      
      <?php

  }

}
