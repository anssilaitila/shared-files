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
        } elseif ( $current_screen_id == 'shared_file_page_shared-files-contacts' ) {
            $js .= "jQuery( document ).ready( function(\$) {\n\n        \$('.shared-files-empty-contacts-form').submit(function() {\n\n          return confirm('" . esc_js( __( 'Are you sure that you want to empty the contacts?', 'shared-files' ) ) . ' ' . esc_js( __( 'This action is irreversible.', 'shared-files' ) ) . "');\n\n        });\n\n      });";
        } elseif ( $current_screen_id === 'shared_file' ) {
            $post_id = intval( get_the_ID() );
            $file = get_post_meta( $post_id, '_sf_file', true );
            $js .= "jQuery( document ).ready( function(\$) {";
            $js .= "\n        \$('form#post').attr('enctype', 'multipart/form-data');\n      ";
            $is_premium = 0;
            if ( !$is_premium ) {
                if ( !$file ) {
                    $js .= "\n            \$('#post').submit(function() {\n              if (\$('#sf_file').prop('files').length == 0) {\n                alert('" . esc_js( __( 'Please insert the file first.', 'shared-files' ) ) . "');\n                return false;\n              }\n            });\n          ";
                }
            }
            $js .= "});";
        } elseif ( $current_screen_id === 'edit-shared_file' || $current_screen_id === 'edit-shared-file-category' || $current_screen_id === 'shared_file_page_shared-files-shortcodes' || $current_screen_id === 'shared_file_page_shared-files-support' ) {
            $is_premium = 0;
            $js .= "jQuery( document ).ready( function(\$) {";
            if ( $current_screen_id === 'edit-shared_file' ) {
                if ( !$is_premium ) {
                    $url = 'https://wordpress.org/support/plugin/shared-files/';
                    $support_html = sprintf( wp_kses( 
                        /* translators: %s: link to the support forum */
                        __( 'If you have any questions in mind, please contact us at <a href="%s" target="_blank">the support forum</a>.', 'shared-files' ),
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
        return $js;
    }

}
