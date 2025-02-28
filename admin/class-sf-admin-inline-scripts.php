<?php

class SharedFilesAdminInlineScripts {

  public static function inline_scripts() {

    $current_screen = get_current_screen();
    $current_screen_id = '';

    if (isset($current_screen->id)) {
      $current_screen_id = $current_screen->id;
    }

    $js = '';

    if ($current_screen_id == 'shared_file_page_shared-files-download-log') {

      $js .= "jQuery( document ).ready( function($) {

        $('.shared-files-empty-download-log-form').submit(function() {

          return confirm('" . esc_js( __('Are you sure that you want to empty the download log?', 'shared-files') ) . ' ' . esc_js( __('This action is irreversible.', 'shared-files') ) . "');

        });

      });";

    } elseif ($current_screen_id == 'shared_file_page_shared-files-search-log') {

      $js .= "jQuery( document ).ready( function($) {

        $('.shared-files-empty-search-log-form').submit(function() {

          return confirm('" . esc_js( __('Are you sure that you want to empty the search log?', 'shared-files') ) . ' ' . esc_js( __('This action is irreversible.', 'shared-files') ) . "');

        });

      });";

    } elseif ($current_screen_id == 'shared_file_page_shared-files-contacts') {

      $js .= "jQuery( document ).ready( function($) {

        $('.shared-files-empty-contacts-form').submit(function() {

          return confirm('" . esc_js( __('Are you sure that you want to empty the contacts?', 'shared-files') ) . ' ' . esc_js( __('This action is irreversible.', 'shared-files') ) . "');

        });

      });";

    } elseif ($current_screen_id === 'shared_file') {

      $post_id = intval( get_the_ID() );
      $file = get_post_meta($post_id, '_sf_file', true);

      $js .= "jQuery( document ).ready( function($) {";

      $js .= "
        $('form#post').attr('enctype', 'multipart/form-data');
      ";


      if (!$file) {
        $js .= "
          $('#post').submit(function() {
            if ($('#sf_file').prop('files').length == 0) {
              alert('" . esc_js( __('Please insert the file first.', 'shared-files') ) . "');
              return false;
            }
          });
        ";
      }

      $js .= "});";

    } elseif ($current_screen_id === 'edit-shared_file' || $current_screen_id === 'edit-shared-file-category' || $current_screen_id === 'shared_file_page_shared-files-shortcodes' || $current_screen_id === 'shared_file_page_shared-files-support') {

      $js .= "jQuery( document ).ready( function($) {";

      if ($current_screen_id === 'edit-shared_file') {

        $url = 'https://wordpress.org/support/plugin/shared-files/';
        $support_html = sprintf(
          wp_kses(
            /* translators: %s: link to the support forum */
            __('If you have any questions in mind, please contact the author at <a href="%s" target="_blank">the support forum</a>. The forum is actively monitored and any kind of feedback is welcome.', 'shared-files'),
            array('a' => array('href' => array(), 'target' => array()))
          ),
          esc_url($url)
        );

        $js .= "
          $('.post-type-shared_file .page-title-action').after(function() {


            return '<div class=\"shared-files-admin-support-box\">" . $support_html . "</div>';

          });
        ";

      } elseif ($current_screen_id === 'shared_file_page_shared-files-support') {

        $js .= "
          $('.shared-files-toggle-debug-info').on('click', function() {
            if ($('.shared-files-debug-info-container').is(':hidden')) {
              $('.shared-files-debug-info-container').show();
              $(this).text('" . esc_js( __('Close', 'shared-files') ) . "');
            } else {
              $('.shared-files-debug-info-container').hide();
              $(this).text('" . esc_js( __('Open', 'shared-files') ) . "');
            }
          });
        ";

      }

      $js .= "
        $(document).on('click', '.shared-files-copy', function (e) {
          e.preventDefault();
        });
      ";

      if ( $current_screen_id != 'shared_file_page_shared-files-shortcodes' ) {

        $js .= "
          $('.shared-files-copy:not(.shared-files-copy-for-all):not(.shared-files-copy-single)').tipso({
            content: '" . esc_js( __('This feature is available in the paid plans.', 'shared-files') ) . "',
            width: 280,
            background: '#2271b1',
          });
        ";

      }

      $js .= "
        var clipboard = new ClipboardJS('.shared-files-copy');

        clipboard.on('success', function(e) {

          e.clearSelection();

          let clipboardtarget = jQuery(e.trigger).data('clipboard-target');

          jQuery(clipboardtarget).tipso({
            content: '" . esc_js( __('Shortcode copied to clipboard!', 'shared-files') ) . "',
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
        });

      ";

      $js .= "});";


    }

    $admin_pages = SharedFilesAdminToolbar::get_admin_pages();

    if ( in_array( $current_screen_id, $admin_pages ) ) {

      if ( $current_screen_id == 'settings_page_shared-files' ) {

        $js .= "
        jQuery( document ).ready( function($) {
          $( '.shared-files-admin-pro-features-container' ).appendTo( '.shared-files-admin-page-content-container' ).css( 'display', 'block' );
        });
        ";

      } else {

        $js .= "
        jQuery( document ).ready( function($) {
          $( '.shared-files-admin-pro-features-container' ).appendTo( '#wpbody-content .wrap' ).css( 'display', 'block' );
        });
        ";

      }

    }

    return $js;

  }

}