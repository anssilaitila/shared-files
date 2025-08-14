<?php

class SharedFilesAdminInlineScripts {
    public static function inline_scripts() {
        $current_screen = get_current_screen();
        $current_screen_id = '';
        if ( isset( $current_screen->id ) ) {
            $current_screen_id = $current_screen->id;
        }
        $js = '';
        if ( $current_screen_id == 'shared_file_page_shared-files-download-log' ) {
            $js .= "jQuery( document ).ready( function(\$) {\n\n        \$('.shared-files-empty-download-log-form').submit(function() {\n\n          return confirm('" . esc_js( __( 'Are you sure that you want to empty the download log?', 'shared-files' ) ) . ' ' . esc_js( __( 'This action is irreversible.', 'shared-files' ) ) . "');\n\n        });\n\n      });";
        } elseif ( $current_screen_id == 'shared_file_page_shared-files-search-log' ) {
            $js .= "jQuery( document ).ready( function(\$) {\n\n        \$('.shared-files-empty-search-log-form').submit(function() {\n\n          return confirm('" . esc_js( __( 'Are you sure that you want to empty the search log?', 'shared-files' ) ) . ' ' . esc_js( __( 'This action is irreversible.', 'shared-files' ) ) . "');\n\n        });\n\n      });";
        } elseif ( $current_screen_id == 'shared_file_page_shared-files-contacts' ) {
            $js .= "jQuery( document ).ready( function(\$) {\n\n        \$('.shared-files-empty-contacts-form').submit(function() {\n\n          return confirm('" . esc_js( __( 'Are you sure that you want to empty the contacts?', 'shared-files' ) ) . ' ' . esc_js( __( 'This action is irreversible.', 'shared-files' ) ) . "');\n\n        });\n\n      });";
        } elseif ( $current_screen_id === 'shared_file' ) {
            $post_id = intval( get_the_ID() );
            $file = get_post_meta( $post_id, '_sf_file', true );
            $js .= "jQuery( document ).ready( function(\$) {";
            $js .= "\n        \$('form#post').attr('enctype', 'multipart/form-data');\n      ";
            $plupload_nonce = wp_create_nonce( "plupload_nonce" );
            $js .= "\n\n        var uploader = new plupload.Uploader({\n\n          browse_button: 'browse-button',\n          container: 'shared-files-file-uploader-container',\n\n          url: '" . esc_url_raw( admin_url( 'admin-ajax.php' ) ) . "',\n\n          multipart_params: {\n            'action': 'shared_files_file_upload',\n            '_wpnonce': '" . $plupload_nonce . "',\n          },\n\n          multi_selection: false,\n\n          urlstream_upload: true,\n\n          init: {\n\n            FilesAdded: function(up, files) {\n\n              plupload.each(files, function(file) {\n\n                up.start();\n\n                \$('.shared-files-file-upload-status').removeClass('shared-files-file-upload-status-error');\n                \$('.shared-files-file-upload-status').removeClass('file-upload-status-ok');\n\n                \$('.shared-files-progress-bar-fill').addClass('shared-files-progress-bar-fill-active');\n\n                \$('.shared-files-progress-bar-fill').html('');\n\n                \$('.shared-files-progress-bar-fill').css('width', '');\n\n                \$('.shared-files-file-upload-status').addClass('shared-files-file-upload-status-default');\n\n                \$('.shared-files-file-upload-status').html('<div>" . sanitize_text_field( __( 'Please wait', 'shared-files' ) ) . "...</div>');\n\n              });\n\n            },\n\n            UploadProgress: function(up, file) {\n\n              \$('#' + file.id + ' b').html(file.percent + '%');\n\n              \$('.shared-files-progress-bar-fill').css('width', file.percent + '%');\n\n              \$('.shared-files-progress-bar-fill').html(file.percent + '%');\n\n\n            },\n\n            Error: function(up, err) {\n\n              \$('.shared-files-file-upload-status').html('<div>" . sanitize_text_field( __( 'Error', 'shared-files' ) ) . ": ' + err.message + '</div>');\n\n              console.log( err );\n\n            },\n\n            FileUploaded: function(up, file, response) {\n\n\n              let res;\n\n              try {\n                res = JSON.parse(response.response);\n              } catch (e) {\n                console.error('Invalid server response', response.response);\n\n                \$('.shared-files-file-upload-status').html('" . sanitize_text_field( __( 'Upload failed: Invalid response from server.', 'shared-files' ) ) . "');\n\n                return;\n              }\n\n              if (!res.success) {\n                console.error('Server reported error:', res.data?.error || 'Unknown error');\n\n                \$('.shared-files-file-upload-status').addClass('shared-files-file-upload-status-error');\n\n                \$('.shared-files-file-upload-status').html( '" . sanitize_text_field( __( 'Upload failed', 'shared-files' ) ) . ": ' + (res.data?.error || 'Unknown error') );\n\n                return;\n              }\n\n              \$('.shared-files-file-upload-status').addClass('file-upload-status-ok');\n\n              var filename_parts = res.data.file.split('/');\n              var filename = filename_parts.pop();\n\n              \$('.shared-files-file-upload-status').html( '" . sanitize_text_field( __( 'File uploaded', 'shared-files' ) ) . ": ' + filename);\n\n              \$('.shared-files-file-upload-status-next-steps').show();\n\n              \$('#major-publishing-actions').css('border', '4px dashed crimson');\n\n              \$('.shared-files-file-uploaded-file').val( res.data.file );\n              \$('.shared-files-file-uploaded-type').val( res.data.type );\n              \$('.shared-files-file-uploaded-url').val( res.data.url );\n\n            }\n\n          }\n\n        });\n\n        uploader.init();\n\n      ";
            $is_premium = 0;
            $js .= "});";
        } elseif ( $current_screen_id === 'edit-shared_file' || $current_screen_id === 'edit-shared-file-category' || $current_screen_id === 'shared_file_page_shared-files-shortcodes' || $current_screen_id === 'shared_file_page_shared-files-support' ) {
            $is_premium = 0;
            $js .= "jQuery( document ).ready( function(\$) {";
            if ( $current_screen_id === 'edit-shared_file' ) {
                if ( !$is_premium ) {
                    $url = 'https://wordpress.org/support/plugin/shared-files/';
                    $support_html = sprintf( wp_kses( 
                        /* translators: %s: link to the support forum */
                        __( 'If you have any questions in mind, please contact the author at <a href="%s" target="_blank">the support forum</a>. The forum is actively monitored and any kind of feedback is welcome.', 'shared-files' ),
                        array(
                            'a' => array(
                                'href'   => array(),
                                'target' => array(),
                            ),
                        )
                     ), esc_url( $url ) );
                    //              return '<a href=\"\" class=\"page-title-action shared-files-add-multiple-files\">XXX Add multiple files</div>';
                    $js .= "\n            \$('.post-type-shared_file .page-title-action').after(function() {\n\n\n              return '<div class=\"shared-files-admin-support-box\">" . $support_html . "</div>';\n\n            });\n          ";
                }
            } elseif ( $current_screen_id === 'shared_file_page_shared-files-support' ) {
                $js .= "\n          \$('.shared-files-toggle-debug-info').on('click', function() {\n            if (\$('.shared-files-debug-info-container').is(':hidden')) {\n              \$('.shared-files-debug-info-container').show();\n              \$(this).text('" . esc_js( __( 'Close', 'shared-files' ) ) . "');\n            } else {\n              \$('.shared-files-debug-info-container').hide();\n              \$(this).text('" . esc_js( __( 'Open', 'shared-files' ) ) . "');\n            }\n          });\n        ";
            }
            $js .= "\n        \$(document).on('click', '.shared-files-copy', function (e) {\n          e.preventDefault();\n        });\n      ";
            if ( $current_screen_id != 'shared_file_page_shared-files-shortcodes' ) {
                if ( !$is_premium ) {
                    $js .= "\n            \$('.shared-files-copy:not(.shared-files-copy-for-all):not(.shared-files-copy-single)').tipso({\n              content: '" . esc_js( __( 'This feature is available in the paid plans.', 'shared-files' ) ) . "',\n              width: 280,\n              background: '#2271b1',\n            });\n          ";
                }
            }
            $js .= "\n        var clipboard = new ClipboardJS('.shared-files-copy');\n\n        clipboard.on('success', function(e) {\n\n          e.clearSelection();\n\n          let clipboardtarget = jQuery(e.trigger).data('clipboard-target');\n\n          jQuery(clipboardtarget).tipso({\n            content: '" . esc_js( __( 'Shortcode copied to clipboard!', 'shared-files' ) ) . "',\n            width: 240\n          });\n\n          jQuery(clipboardtarget).tipso('show');\n\n          setTimeout(function () {\n            showpanel(clipboardtarget);\n          }, 2000);\n\n          function showpanel(clipboardtarget) {\n            jQuery(clipboardtarget).tipso('hide');\n            jQuery(clipboardtarget).tipso('destroy');\n          }\n\n        });\n\n        clipboard.on('error', function(e) {\n        });\n\n      ";
            $js .= "});";
        }
        $admin_pages = SharedFilesAdminToolbar::get_admin_pages();
        if ( SharedFilesHelpers::isPremium() == 0 && in_array( $current_screen_id, $admin_pages ) ) {
            if ( $current_screen_id == 'settings_page_shared-files' ) {
                $js .= "\n        jQuery( document ).ready( function(\$) {\n          \$( '.shared-files-admin-pro-features-container' ).appendTo( '.shared-files-admin-page-content-container' ).css( 'display', 'block' );\n        });\n        ";
            } else {
                $js .= "\n        jQuery( document ).ready( function(\$) {\n          \$( '.shared-files-admin-pro-features-container' ).appendTo( '#wpbody-content .wrap' ).css( 'display', 'block' );\n        });\n        ";
            }
        }
        return $js;
    }

}
