<?php

class SharedFilesAdminNotifications {
    public function notifications_html() {
        if ( current_user_can( 'manage_options' ) ) {
            $screen = get_current_screen();
            if ( isset( $screen->id ) && $screen->id == 'edit-shared_file' ) {
                $sf_rating_show_notice_now = get_option( 'shared_files_rating_show_notice_now_v2' );
                $sf_rating_notice_status = get_option( 'shared_files_rating_notice_status_v2' );
                $sf_rating_notice_later_seconds = get_transient( 'shared_files_rating_notice_later_seconds_v2' );
                $should_show_rating_notice = 0;
                if ( $sf_rating_show_notice_now && $sf_rating_notice_status != 'dismissed' ) {
                    if ( $sf_rating_notice_status != 'later' ) {
                        $should_show_rating_notice = 1;
                    } elseif ( !$sf_rating_notice_later_seconds ) {
                        $should_show_rating_notice = 1;
                    }
                }
                if ( $should_show_rating_notice ) {
                    $dismiss_url = add_query_arg( 'sf_ignore_rating_notice_notify', '1' );
                    $later_url = add_query_arg( 'sf_ignore_rating_notice_notify', 'later' );
                    $file_posts = wp_count_posts( 'shared_file' );
                    $file_cnt = intval( $file_posts->publish );
                    $user_id = intval( get_current_user_id() );
                    $dismiss_url_with_nonce = add_query_arg( '_shared_files_ignore_rating_notify_' . intval( $user_id ), wp_create_nonce( 'shared_files_ignore_rating_notify' ), $dismiss_url );
                    $later_url_with_nonce = add_query_arg( '_shared_files_ignore_rating_notify_' . intval( $user_id ), wp_create_nonce( 'shared_files_ignore_rating_notify' ), $later_url );
                    echo "\n            <div class='sf_notice sf_review_notice'>\n              <div class='shared-files-notice-text'>\n                " . '<div style=\'margin-bottom: 8px;\'><p style=\'font-size: 15px;\'>' . sprintf(
                        __( "Hey, I noticed that you have added %s%d files%s with the Shared Files plugin – that's awesome!" ),
                        '<strong style=\'font-weight: 700;\'>',
                        esc_attr( $file_cnt ),
                        '</strong>'
                    ) . '</p></div>' . '<div style=\'margin-bottom: 8px;\'><p style=\'font-size: 15px;\'>' . sprintf( __( "Could you please do me a BIG favour and give it a 5-star rating on WordPress? It will help to spread the word and boost our motivation." ) ) . '</p></div>' . '<p style=\'font-size: 15px;\'>– Anssi (Lead developer)</p>' . "\n                <p class='links'>\n                  <a class='sf_notice_dismiss' style='border: 1px solid green; background: green; color: #fff; font-weight: 700; padding: 5px 10px; border-radius: 3px; text-decoration: none; margin-right: 10px;' href='https://wordpress.org/support/plugin/shared-files/reviews/#new-post' target='_blank'>" . esc_html__( 'Sure, I\'d love to!', 'shared-files' ) . "</a>\n                  &middot;\n                  <a class='sf_notice_dismiss' href='" . esc_url( $dismiss_url_with_nonce ) . "'>" . esc_html__( 'No thanks', 'shared-files' ) . "</a>\n                  &middot;\n                  <a class='sf_notice_dismiss' href='" . esc_url( $dismiss_url_with_nonce ) . "'>" . esc_html__( 'I\'ve already given a review', 'shared-files' ) . "</a>\n                  &middot;\n                  <a class='sf_notice_dismiss' href='" . esc_url( $later_url_with_nonce ) . "'>" . esc_html__( 'Ask Me Later', 'shared-files' ) . "</a>\n                </p>\n              </div>\n              <a class='sf_notice_close' href='" . esc_url( $dismiss_url_with_nonce ) . "'>x</a>\n            </div>";
                }
            }
            if ( isset( $screen->id ) && $screen->id == 'edit-shared_file' ) {
                $how_to_show_notice = sanitize_text_field( get_option( 'shared_files_how_to_show_notice' ) );
                if ( $how_to_show_notice ) {
                    echo '<div class="shared-files-notice-how-to-get-started">';
                    echo '<div class="shared-files-notice-how-to-get-started-title">';
                    echo '<div class="shared-files-notice-how-to-get-started-text">';
                    echo '<h2>' . esc_html__( 'How to get started', 'shared-files' ) . '</h2>';
                    echo '</div>';
                    echo '<div class="shared-files-notice-how-to-get-started-close">';
                    echo '<form method="GET" action="' . esc_url_raw( get_admin_url() . 'edit.php' ) . '">';
                    echo '<input name="post_type" value="shared_file" type="hidden" />';
                    $user_id = intval( get_current_user_id() );
                    echo wp_nonce_field(
                        'shared_files_ignore_how_to_notify',
                        '_shared_files_ignore_how_to_notify_' . intval( $user_id ),
                        true,
                        false
                    );
                    echo "<input type='submit' class='shared-files-notice-how-to-get-dismiss' value='&#10005;' />";
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="shared-files-notice-how-to-get-started-content">';
                    echo '<ol>';
                    echo '<li>' . esc_html__( 'Add some files from the file management below (click the Add New File button)', 'shared-files' ) . '</li>';
                    echo '<li>';
                    echo esc_html__( 'Insert one of these shortcodes to any page or post on your site', 'shared-files' );
                    echo '<ul>';
                    echo '<li>';
                    echo '<h3>' . esc_html__( 'List of all files', 'shared-files' ) . '</h3>';
                    echo '<span class="shared-files-shortcode-admin-list shared-files-shortcode-admin-list-file shared-files-shortcode-info-1" title="[shared_files]">[shared_files]</span>';
                    echo '<button class="shared-files-copy shared-files-copy-for-all shared-files-copy-admin-list" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-info-1">' . esc_html__( 'Copy', 'shared-files' ) . '</button>';
                    echo '</li>';
                    echo '<li>';
                    echo '<h3>' . esc_html__( 'List of all files, simpler view', 'shared-files' ) . '</h3>';
                    echo '<span class="shared-files-shortcode-admin-list shared-files-shortcode-admin-list-file shared-files-shortcode-info-2" title="[shared_files_simple]">[shared_files_simple]</span>';
                    echo '<button class="shared-files-copy shared-files-copy-for-all shared-files-copy-admin-list" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-info-2">' . esc_html__( 'Copy', 'shared-files' ) . '</button>';
                    echo '</li>';
                    echo '<li>';
                    echo '<h3>' . esc_html__( 'Front end file uploader', 'shared-files' ) . '</h3>';
                    echo '<span class="shared-files-shortcode-admin-list shared-files-shortcode-admin-list-file shared-files-shortcode-info-3" title="[shared_files file_upload=1]">[shared_files file_upload=1]</span>';
                    echo '<button class="shared-files-copy shared-files-copy-for-all shared-files-copy-admin-list" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-info-3">' . esc_html__( 'Copy', 'shared-files' ) . '</button>';
                    echo '</li>';
                    echo '</ul>';
                    echo '</li>';
                    echo '<li>';
                    $url = esc_url_raw( get_admin_url() . 'options-general.php?page=shared-files' );
                    echo sprintf( wp_kses( 
                        /* translators: %s: link to the plugin settings */
                        __( 'Check the <a href="%s">plugin settings</a> for some customization options', 'shared-files' ),
                        array(
                            'a' => array(
                                'href'   => array(),
                                'target' => array(),
                            ),
                        )
                     ), esc_url( $url ) );
                    echo '</li>';
                    echo '<li>';
                    $url = esc_url_raw( get_admin_url() . 'edit.php?post_type=shared_file&page=shared-files-shortcodes' );
                    echo sprintf( wp_kses( 
                        /* translators: %s: link to the shortcodes page */
                        __( 'List of all available shortcodes <a href="%s">here</a>', 'shared-files' ),
                        array(
                            'a' => array(
                                'href'   => array(),
                                'target' => array(),
                            ),
                        )
                     ), esc_url( $url ) );
                    echo '</li>';
                    echo '</ol>';
                    echo '</div>';
                    echo '</div>';
                }
            }
        }
    }

    public function process_notifications() {
        if ( current_user_can( 'manage_options' ) ) {
            $user_id = intval( get_current_user_id() );
            // Rating notice
            $file_posts = wp_count_posts( 'shared_file' );
            $file_cnt = intval( $file_posts->publish );
            $sf_nonce = '';
            $nonce_field_name = '_shared_files_ignore_rating_notify_' . $user_id;
            $sf_rating_current_status = get_option( 'shared_files_rating_notice_status_v2' );
            if ( isset( $_GET[$nonce_field_name] ) ) {
                $sf_nonce = sanitize_text_field( $_GET[$nonce_field_name] );
                if ( $sf_nonce && wp_verify_nonce( $sf_nonce, 'shared_files_ignore_rating_notify' ) ) {
                    if ( isset( $_GET['sf_ignore_rating_notice_notify'] ) ) {
                        if ( (int) $_GET['sf_ignore_rating_notice_notify'] === 1 ) {
                            update_option( 'shared_files_rating_notice_status_v2', 'dismissed', false );
                        } elseif ( $_GET['sf_ignore_rating_notice_notify'] === 'later' ) {
                            update_option( 'shared_files_rating_notice_status_v2', 'later', false );
                            set_transient( 'shared_files_rating_notice_later_seconds_v2', '_later', 2 * WEEK_IN_SECONDS );
                        }
                    }
                }
            } elseif ( !$sf_rating_current_status && $file_cnt > 50 ) {
                update_option( 'shared_files_rating_show_notice_now_v2', 1, false );
            }
            $sf_nonce = '';
            $nonce_field_name = '_shared_files_ignore_how_to_notify_' . $user_id;
            if ( isset( $_GET[$nonce_field_name] ) ) {
                $sf_nonce = sanitize_text_field( $_GET[$nonce_field_name] );
                if ( $sf_nonce && wp_verify_nonce( $sf_nonce, 'shared_files_ignore_how_to_notify' ) ) {
                    update_option( 'shared_files_how_to_show_notice', 0, false );
                }
            }
        }
    }

    public function sf_get_current_time() {
        $current_time = time();
        return $current_time;
    }

}
