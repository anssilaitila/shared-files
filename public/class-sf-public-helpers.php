<?php

class SharedFilesPublicHelpers
{
    public static function proFeaturePublicMarkup()
    {
        $html = '';
        $html .= '<div class="shared-files-public-pro-feature">';
        $html .= '<span class="shared-files-public-pro-feature-title">';
        $html .= sanitize_text_field( __( 'This feature is available in the Pro version.', 'shared-files' ) );
        $html .= '</span>';
        $html .= '<span>';
        $html .= sanitize_text_field( __( 'You can use the shortcodes', 'shared-files' ) . ' [shared_files] ' . __( 'and', 'shared-files' ) . ' [shared_files_simple].' );
        $html .= '</span>';
        $html .= '<span>';
        $html .= sanitize_text_field( __( 'More info on shortcodes at', 'shared-files' ) . ' <a href="https://www.sharedfilespro.com/support/shortcodes/" target="_blank">sharedfilespro.com</a>.' );
        $html .= '</span>';
        $html .= '</div>';
        return $html;
    }
    
    public static function getFileURL(
        $file_id = 0,
        $download = 0,
        $force_direct_url = 0,
        $atts = array()
    )
    {
        $file_id = intval( $file_id );
        $s = get_option( 'shared_files_settings' );
        $c = get_post_custom( $file_id );
        $file_url = '';
        
        if ( isset( $c['_sf_filename'] ) ) {
            $obfuscated = 0;
            if ( !$obfuscated ) {
                $file_url = SharedFilesHelpers::sf_root() . '/shared-files/' . $file_id . '/' . SharedFilesHelpers::wp_engine() . sanitize_text_field( $c['_sf_filename'][0] );
            }
            
            if ( $download && SharedFilesHelpers::wp_engine() ) {
                $file_url .= '&download=1';
            } elseif ( $download ) {
                $file_url .= '?download=1';
            }
        
        }
        
        return $file_url;
    }
    
    public static function getFileType( $file_id = 0 )
    {
        $file_id = intval( $file_id );
        $c = get_post_custom( $file_id );
        $file = get_post_meta( $file_id, '_sf_file', true );
        $file_type = '';
        $file_ext = '';
        $external_url = ( isset( $c['_sf_external_url'] ) ? esc_url_raw( $c['_sf_external_url'][0] ) : '' );
        
        if ( $external_url && (substr( $external_url, 0, strlen( 'https://www.youtube.com' ) ) === 'https://www.youtube.com' || substr( $external_url, 0, strlen( 'https://youtu.be' ) ) === 'https://youtu.be') ) {
            $file_type = 'youtube';
        } elseif ( isset( $file['file'] ) ) {
            $file_ext = pathinfo( sanitize_text_field( $file['file'] ), PATHINFO_EXTENSION );
            switch ( $file_ext ) {
                case 'jpg':
                case 'jpeg':
                case 'jpe':
                case 'png':
                case 'gif':
                    $file_type = 'image';
                    break;
                case 'mp4':
                case 'webm':
                case 'ogg':
                case 'mov':
                    $file_type = 'video/' . sanitize_text_field( $file_ext );
                    break;
            }
        }
        
        return $file_type;
    }
    
    public static function limitActive( $file_id )
    {
        $file_id = intval( $file_id );
        $load_cnt = (int) get_post_meta( $file_id, '_sf_load_cnt', true );
        $load_limit = (int) get_post_meta( $file_id, '_sf_limit_downloads', true );
        $limit_active = 0;
        if ( $load_limit && $load_cnt >= $load_limit ) {
            $limit_active = 1;
        }
        return $limit_active;
    }
    
    public static function sharedFilesSimpleMarkup( $wp_query, $include_children = 0, $atts = array() )
    {
        $s = get_option( 'shared_files_settings' );
        $html = '';
        $html .= '<div class="shared-files-search">';
        $html .= '<div class="shared-files-simple-list">';
        if ( isset( $s['simple_list_show_titles_for_columns'] ) ) {
            $html .= SharedFilesPublicHelpers::singleFileSimpleTitlesMarkup( $atts );
        }
        if ( $wp_query->have_posts() ) {
            while ( $wp_query->have_posts() ) {
                $wp_query->the_post();
                $id = intval( get_the_id() );
                $html .= SharedFilesPublicHelpers::singleFileSimpleMarkup( $id, 0, $atts );
            }
        }
        $html .= '</div><hr class="clear" />';
        $html .= '</div>';
        wp_reset_postdata();
        return $html;
    }
    
    public static function singleFileSimpleTitlesMarkup( $atts = array() )
    {
        $s = get_option( 'shared_files_settings' );
        $html = '';
        $html .= '<div class="shared-files-simple-list-row">';
        $html .= '<div class="shared-files-simple-list-col shared-files-simple-list-col-name shared-files-simple-list-col-title"><span>' . SharedFilesHelpers::getText( 'simple_list_title_file', __( 'File', 'shared-files' ) ) . '</span></div>';
        
        if ( isset( $s['simple_list_show_tag'] ) ) {
            $html .= '<div class="shared-files-simple-list-col shared-files-simple-list-col-title"><span>';
            $html .= SharedFilesHelpers::getText( 'simple_list_title_tag', __( 'Tag', 'shared-files' ) );
            $html .= '</span></div>';
        }
        
        $html .= '</div>';
        return $html;
    }
    
    public static function singleFileSimpleMarkup( $id, $showGroups = 0, $atts = array() )
    {
        $id = intval( $id );
        $s = get_option( 'shared_files_settings' );
        $c = get_post_custom( $id );
        $file_id = intval( get_the_id() );
        $password = get_post_meta( $file_id, '_sf_password', true );
        $external_url = ( isset( $c['_sf_external_url'] ) ? esc_url_raw( $c['_sf_external_url'][0] ) : '' );
        $html = '';
        $html .= '<div class="shared-files-simple-list-row">';
        $html .= '<div class="shared-files-simple-list-col shared-files-simple-list-col-name"><span>';
        //    $file_url = (isset($c['_sf_filename']) ? SharedFilesHelpers::sf_root() . '/shared-files/' . intval( get_the_id() ) . '/' . SharedFilesHelpers::wp_engine() . sanitize_text_field( $c['_sf_filename'][0] ) : '');
        $file_url = SharedFilesPublicHelpers::getFileURL( $file_id );
        $data_file_type = '';
        $data_file_url = '';
        $data_video_url_redir = '';
        $data_external_url = '';
        $data_image_url = '';
        
        if ( !$password && !SharedFilesPublicHelpers::limitActive( $file_id ) ) {
            $this_file_type = SharedFilesPublicHelpers::getFileType( $file_id );
            $data_file_type = ' data-file-type="' . esc_attr( self::getFileType( $file_id ) ) . '" ';
            $data_file_url = ' data-file-url="' . esc_url_raw( self::getFileURL( $file_id ) ) . '" ';
            $data_external_url = ' data-external-url="' . esc_url_raw( $external_url ) . '" ';
            $data_image_url = ' data-image-url="' . esc_url_raw( get_the_post_thumbnail_url( $file_id, 'large' ) ) . '" ';
            if ( isset( $s['file_open_method'] ) && $s['file_open_method'] == 'redirect' ) {
                
                if ( substr( $this_file_type, 0, strlen( 'video' ) ) === 'video' ) {
                    $file_uri = SharedFilesFileOpen::getRedirectTarget( $file_id );
                    $data_video_url_redir = ' data-video-url-redir="' . esc_url_raw( $file_uri ) . '" ';
                }
            
            }
        }
        
        $html .= '<a class="shared-files-file-title" ' . $data_file_type . $data_file_url . $data_video_url_redir . $data_external_url . $data_image_url . 'href="' . $file_url . '" target="_blank">' . sanitize_text_field( get_the_title() ) . '</a>';
        if ( isset( $c['_sf_filesize'] ) && !isset( $s['hide_file_size_from_card'] ) ) {
            $html .= '<span class="shared-file-size">' . SharedFilesAdminHelpers::human_filesize( sanitize_text_field( $c['_sf_filesize'][0] ) ) . '</span>';
        }
        $html .= SharedFilesHelpers::getPreviewButton( $id, $file_url );
        if ( !isset( $s['simple_list_hide_file_description'] ) ) {
            if ( isset( $c['_sf_description'] ) ) {
                
                if ( isset( $s['textarea_for_file_description'] ) && $s['textarea_for_file_description'] && isset( $c['_sf_description'][0] ) && $c['_sf_description'][0] ) {
                    $html .= '<p>' . wp_kses_post( nl2br( $c['_sf_description'][0] ) ) . '</p>';
                } else {
                    $html .= wp_kses_post( $c['_sf_description'][0] );
                }
            
            }
        }
        $html .= '</span></div>';
        
        if ( isset( $s['simple_list_show_tag'] ) ) {
            $html .= '<div class="shared-files-simple-list-col"><span>';
            $terms = get_the_terms( $id, 'post_tag' );
            
            if ( $terms ) {
                $html .= '<div class="shared-files-simple-tags">';
                foreach ( $terms as $term ) {
                    $t_id = intval( $term->term_id );
                    $custom_fields = get_option( "taxonomy_term_{$t_id}" );
                    if ( !isset( $custom_fields['hide_group'] ) ) {
                        $html .= '<span>' . sanitize_text_field( $term->name ) . '</span>';
                    }
                }
                $html .= '</div>';
            }
            
            $html .= '</span></div>';
        }
        
        // row END
        $html .= '</div>';
        return $html;
    }

}