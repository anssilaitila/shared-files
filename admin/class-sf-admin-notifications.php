<?php

class SharedFilesAdminNotifications
{
    public function notifications_html()
    {
        
        if ( current_user_can( 'manage_options' ) ) {
            $screen = get_current_screen();
            
            if ( isset( $screen->id ) && $screen->id == 'edit-shared_file' ) {
                $how_to_show_notice = sanitize_text_field( get_option( 'shared_files_how_to_show_notice' ) );
                
                if ( $how_to_show_notice ) {
                    echo  '<div class="shared-files-notice-how-to-get-started">' ;
                    echo  '<div class="shared-files-notice-how-to-get-started-title">' ;
                    echo  '<div class="shared-files-notice-how-to-get-started-text">' ;
                    echo  '<h2>' . esc_html__( 'How to get started', 'shared-files' ) . '</h2>' ;
                    echo  '</div>' ;
                    echo  '<div class="shared-files-notice-how-to-get-started-close">' ;
                    echo  '<form method="GET" action="' . esc_url_raw( get_admin_url() . 'edit.php' ) . '">' ;
                    echo  '<input name="post_type" value="shared_file" type="hidden" />' ;
                    $user_id = intval( get_current_user_id() );
                    echo  wp_nonce_field(
                        'shared_files_ignore_how_to_notify',
                        '_shared_files_ignore_how_to_notify_' . intval( $user_id ),
                        true,
                        false
                    ) ;
                    echo  "<input type='submit' class='shared-files-notice-how-to-get-dismiss' value='&#10005;' />" ;
                    echo  '</form>' ;
                    echo  '</div>' ;
                    echo  '</div>' ;
                    echo  '<div class="shared-files-notice-how-to-get-started-content">' ;
                    echo  '<ol>' ;
                    echo  '<li>' . esc_html__( 'Add some files from the file management below (click the Add New button)', 'shared-files' ) . '</li>' ;
                    echo  '<li>' ;
                    echo  esc_html__( 'Insert one of these shortcodes to any page or post on your site', 'shared-files' ) ;
                    echo  '<ul>' ;
                    echo  '<li>' ;
                    echo  '<h3>' . esc_html__( 'List of all files', 'shared-files' ) . '</h3>' ;
                    echo  '<span class="shared-files-shortcode-admin-list shared-files-shortcode-admin-list-file shared-files-shortcode-info-1" title="[shared_files]">[shared_files]</span>' ;
                    echo  '<button class="shared-files-copy shared-files-copy-for-all shared-files-copy-admin-list" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-info-1">' . esc_html__( 'Copy', 'shared-files' ) . '</button>' ;
                    echo  '</li>' ;
                    echo  '<li>' ;
                    echo  '<h3>' . esc_html__( 'List of all files, simpler view', 'shared-files' ) . '</h3>' ;
                    echo  '<span class="shared-files-shortcode-admin-list shared-files-shortcode-admin-list-file shared-files-shortcode-info-2" title="[shared_files_simple]">[shared_files_simple]</span>' ;
                    echo  '<button class="shared-files-copy shared-files-copy-for-all shared-files-copy-admin-list" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-info-2">' . esc_html__( 'Copy', 'shared-files' ) . '</button>' ;
                    echo  '</li>' ;
                    echo  '<li>' ;
                    echo  '<h3>' . esc_html__( 'Front end file uploader', 'shared-files' ) . '</h3>' ;
                    echo  '<span class="shared-files-shortcode-admin-list shared-files-shortcode-admin-list-file shared-files-shortcode-info-3" title="[shared_files file_upload=1]">[shared_files file_upload=1]</span>' ;
                    echo  '<button class="shared-files-copy shared-files-copy-for-all shared-files-copy-admin-list" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-info-3">' . esc_html__( 'Copy', 'shared-files' ) . '</button>' ;
                    echo  '</li>' ;
                    echo  '</ul>' ;
                    echo  '</li>' ;
                    echo  '<li>' ;
                    $url = esc_url_raw( get_admin_url() . 'options-general.php?page=shared-files' );
                    echo  sprintf( wp_kses(
                        /* translators: %s: link to the plugin settings */
                        __( 'Check the <a href="%s">plugin settings</a> for some customization options', 'shared-files' ),
                        array(
                            'a' => array(
                            'href'   => array(),
                            'target' => array(),
                        ),
                        )
                    ), esc_url( $url ) ) ;
                    echo  '</li>' ;
                    echo  '<li>' ;
                    $url = esc_url_raw( get_admin_url() . 'edit.php?post_type=shared_file&page=shared-files-shortcodes' );
                    echo  sprintf( wp_kses(
                        /* translators: %s: link to the shortcodes page */
                        __( 'List of all available shortcodes <a href="%s">here</a>', 'shared-files' ),
                        array(
                            'a' => array(
                            'href'   => array(),
                            'target' => array(),
                        ),
                        )
                    ), esc_url( $url ) ) ;
                    echo  '</li>' ;
                    echo  '</ol>' ;
                    echo  '</div>' ;
                    echo  '</div>' ;
                }
            
            }
        
        }
    
    }
    
    public function process_notifications()
    {
        
        if ( current_user_can( 'manage_options' ) ) {
            $sf_nonce = '';
            $user_id = intval( get_current_user_id() );
            $nonce_field_name = '_shared_files_ignore_how_to_notify_' . $user_id;
            
            if ( isset( $_GET[$nonce_field_name] ) ) {
                $sf_nonce = sanitize_text_field( $_GET[$nonce_field_name] );
                if ( $sf_nonce && wp_verify_nonce( $sf_nonce, 'shared_files_ignore_how_to_notify' ) ) {
                    update_option( 'shared_files_how_to_show_notice', 0, false );
                }
            }
        
        }
    
    }
    
    public function sf_get_current_time()
    {
        $current_time = time();
        return $current_time;
    }

}