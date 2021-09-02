<?php

class SharedFilesAdminSendMail
{
    public static function file_limit_send_email( $post_id, $post )
    {
        $post_title = sanitize_text_field( get_the_title( $post_id ) );
        $s = get_option( 'shared_files_settings' );
        
        if ( isset( $s['recipient_email'] ) && is_email( $s['recipient_email'] ) && $post->post_type == 'shared_file' ) {
            $headers = [ 'Content-Type: text/html; charset=UTF-8' ];
            $subject = sanitize_text_field( __( 'Download limit reached for', 'shared-files' ) ) . ' ' . sanitize_text_field( $post_title );
            $body_html = '';
            $body_html .= '<html><head><title></title></head><body>';
            $body_html .= '<h3 style="color: #000;">' . sanitize_text_field( __( 'Download limit reached for', 'shared-files' ) ) . ' ' . $post_title . '</h3>';
            $body_url = esc_url_raw( admin_url( 'edit.php?post_type=shared_file' ) );
            $body_html .= '<p><a href="' . $body_url . '" target="_blank">' . sanitize_text_field( __( 'File management &raquo;', 'shared-files' ) ) . '</a></p>';
            $is_premium = 0;
            if ( !$is_premium ) {
                $body_html .= '<table cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
        <tr>
          <td style="border-top: 1px solid #eee; color: #bbb; padding-top: 3px; width: 100%;">
            ' . sanitize_text_field( __( 'Sent by Shared Files for WordPress', 'shared-files' ) ) . '
          </td>
        </tr>
        </table>';
            }
            $body_html .= '</body></html>';
            $resp = wp_mail(
                $s['recipient_email'],
                $subject,
                $body_html,
                $headers
            );
        }
    
    }
    
    public function file_expired_send_email()
    {
        $s = get_option( 'shared_files_settings' );
        
        if ( isset( $s['recipient_email'] ) && is_email( $s['recipient_email'] ) ) {
            $wpb_all_query_all_files = new WP_Query( array(
                'post_type'      => 'shared_file',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'meta_query'     => array(
                'relation' => 'AND',
                array(
                'key'     => '_sf_expiration_date',
                'compare' => 'EXISTS',
            ),
            ),
            ) );
            if ( isset( $wpb_all_query_all_files ) && $wpb_all_query_all_files->have_posts() ) {
                while ( $wpb_all_query_all_files->have_posts() ) {
                    $wpb_all_query_all_files->the_post();
                    $id = intval( get_the_id() );
                    $c = get_post_custom( $id );
                    $filename = sanitize_text_field( $c['_sf_filename'][0] );
                    $post_title = get_the_title( $id ) . ' / ' . $filename;
                    $expiration_date = get_post_meta( $id, '_sf_expiration_date', true );
                    $expiration_date_formatted = '';
                    $expiration_date_alert = 0;
                    
                    if ( $expiration_date instanceof DateTime ) {
                        $dt_now = new DateTime( 'now' );
                        
                        if ( $expiration_date <= $dt_now ) {
                            $headers = [ 'Content-Type: text/html; charset=UTF-8' ];
                            $subject = sanitize_text_field( __( 'File expired:', 'shared-files' ) ) . ' ' . sanitize_text_field( $post_title );
                            $body_html = '';
                            $body_html .= '<html><head><title></title></head><body>';
                            $body_html .= '<h3 style="color: #000;">' . sanitize_text_field( __( 'File expired:', 'shared-files' ) ) . ' ' . sanitize_text_field( $post_title ) . '</h3>';
                            $body_url = admin_url( 'edit.php?post_type=shared_file' );
                            $body_html .= '<p><a href="' . esc_url_raw( $body_url ) . '" target="_blank">' . sanitize_text_field( __( 'File management &raquo;', 'shared-files' ) ) . '</a></p>';
                            $is_premium = 0;
                            if ( !$is_premium ) {
                                $body_html .= '<table cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
                <tr>
                  <td style="border-top: 1px solid #eee; color: #bbb; padding-top: 3px; width: 100%;">
                    ' . sanitize_text_field( __( 'Sent by Shared Files for WordPress', 'shared-files' ) ) . '
                  </td>
                </tr>
                </table>';
                            }
                            $body_html .= '</body></html>';
                            $resp = wp_mail(
                                $s['recipient_email'],
                                $subject,
                                $body_html,
                                $headers
                            );
                        }
                    
                    }
                
                }
            }
        }
    
    }

}