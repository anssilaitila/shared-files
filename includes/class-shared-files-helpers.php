<?php

class SharedFilesHelpers
{
    public static function getFiletypes()
    {
        $filetypes = array(
            'image/png'                                                               => 'image',
            'image/jpg'                                                               => 'image',
            'image/jpeg'                                                              => 'image',
            'image/svg+xml'                                                           => 'image',
            'application/pdf'                                                         => 'pdf',
            'application/postscript'                                                  => 'ai',
            'application/msword'                                                      => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'doc',
            'application/vnd.ms-fontobject'                                           => 'font',
            'font/otf'                                                                => 'font',
            'font/ttf'                                                                => 'font',
            'font/woff'                                                               => 'font',
            'font/woff2'                                                              => 'font',
            'text/html'                                                               => 'html',
            'audio/mpeg3'                                                             => 'mp3',
            'audio/x-mpeg-3'                                                          => 'mp3',
            'audio/mpeg'                                                              => 'mp3',
            'video/x-msvideo'                                                         => 'video',
            'video/mpeg'                                                              => 'video',
            'video/x-mpeg'                                                            => 'video',
            'video/ogg'                                                               => 'video',
            'video/webm'                                                              => 'video',
            'video/3gpp'                                                              => 'video',
            'video/3gpp2'                                                             => 'video',
            'application/vnd.ms-excel'                                                => 'xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'       => 'xlsx',
            'application/zip'                                                         => 'zip',
            'application/x-7z-compressed'                                             => 'zip',
            'application/x-indesign'                                                  => 'indd',
        );
        return $filetypes;
    }
    
    public static function getCustomIcons()
    {
        $s = get_option( 'shared_files_settings' );
        $filetypes = array(
            'image/png'                                                                 => ( isset( $s['icon_for_image'] ) ? $s['icon_for_image'] : '' ),
            'image/jpg'                                                                 => ( isset( $s['icon_for_image'] ) ? $s['icon_for_image'] : '' ),
            'image/jpeg'                                                                => ( isset( $s['icon_for_image'] ) ? $s['icon_for_image'] : '' ),
            'application/pdf'                                                           => ( isset( $s['icon_for_pdf'] ) ? $s['icon_for_pdf'] : '' ),
            'application/postscript'                                                    => ( isset( $s['icon_for_ai'] ) ? $s['icon_for_ai'] : '' ),
            'application/msword'                                                        => ( isset( $s['icon_for_doc'] ) ? $s['icon_for_doc'] : '' ),
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => ( isset( $s['icon_for_doc'] ) ? $s['icon_for_doc'] : '' ),
            'application/vnd.ms-fontobject'                                             => ( isset( $s['icon_for_font'] ) ? $s['icon_for_font'] : '' ),
            'font/otf'                                                                  => ( isset( $s['icon_for_font'] ) ? $s['icon_for_font'] : '' ),
            'font/ttf'                                                                  => ( isset( $s['icon_for_font'] ) ? $s['icon_for_font'] : '' ),
            'font/woff'                                                                 => ( isset( $s['icon_for_font'] ) ? $s['icon_for_font'] : '' ),
            'font/woff2'                                                                => ( isset( $s['icon_for_font'] ) ? $s['icon_for_font'] : '' ),
            'text/html'                                                                 => ( isset( $s['icon_for_html'] ) ? $s['icon_for_html'] : '' ),
            'audio/mpeg3'                                                               => ( isset( $s['icon_for_mp3'] ) ? $s['icon_for_mp3'] : '' ),
            'audio/x-mpeg-3'                                                            => ( isset( $s['icon_for_mp3'] ) ? $s['icon_for_mp3'] : '' ),
            'audio/mpeg'                                                                => ( isset( $s['icon_for_mp3'] ) ? $s['icon_for_mp3'] : '' ),
            'video/x-msvideo'                                                           => ( isset( $s['icon_for_video'] ) ? $s['icon_for_video'] : '' ),
            'video/mpeg'                                                                => ( isset( $s['icon_for_video'] ) ? $s['icon_for_video'] : '' ),
            'video/x-mpeg'                                                              => ( isset( $s['icon_for_video'] ) ? $s['icon_for_video'] : '' ),
            'video/ogg'                                                                 => ( isset( $s['icon_for_video'] ) ? $s['icon_for_video'] : '' ),
            'video/webm'                                                                => ( isset( $s['icon_for_video'] ) ? $s['icon_for_video'] : '' ),
            'video/3gpp'                                                                => ( isset( $s['icon_for_video'] ) ? $s['icon_for_video'] : '' ),
            'video/3gpp2'                                                               => ( isset( $s['icon_for_video'] ) ? $s['icon_for_video'] : '' ),
            'application/vnd.ms-excel'                                                  => ( isset( $s['icon_for_xlsx'] ) ? $s['icon_for_xlsx'] : '' ),
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         => ( isset( $s['icon_for_xlsx'] ) ? $s['icon_for_xlsx'] : '' ),
            'application/zip'                                                           => ( isset( $s['icon_for_zip'] ) ? $s['icon_for_zip'] : '' ),
            'application/x-7z-compressed'                                               => ( isset( $s['icon_for_zip'] ) ? $s['icon_for_zip'] : '' ),
            'application/mspowerpoint'                                                  => ( isset( $s['icon_for_pptx'] ) ? $s['icon_for_pptx'] : '' ),
            'application/powerpoint'                                                    => ( isset( $s['icon_for_pptx'] ) ? $s['icon_for_pptx'] : '' ),
            'application/vnd.ms-powerpoint'                                             => ( isset( $s['icon_for_pptx'] ) ? $s['icon_for_pptx'] : '' ),
            'application/x-mspowerpoint'                                                => ( isset( $s['icon_for_pptx'] ) ? $s['icon_for_pptx'] : '' ),
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => ( isset( $s['icon_for_pptx'] ) ? $s['icon_for_pptx'] : '' ),
            'application/x-indesign'                                                    => ( isset( $s['icon_for_indd'] ) ? $s['icon_for_indd'] : '' ),
            'image/vnd.adobe.photoshop'                                                 => ( isset( $s['icon_for_psd'] ) ? $s['icon_for_psd'] : '' ),
            'application/photoshop'                                                     => ( isset( $s['icon_for_psd'] ) ? $s['icon_for_psd'] : '' ),
            'image/svg+xml'                                                             => ( isset( $s['icon_for_svg'] ) ? $s['icon_for_svg'] : '' ),
        );
        return $filetypes;
    }
    
    public static function getExternalFiletypes()
    {
        $external_filetypes = array(
            'png'  => 'image',
            'jpg'  => 'image',
            'pdf'  => 'pdf',
            'ai'   => 'ai',
            'doc'  => 'doc',
            'docx' => 'doc',
            'mp3'  => 'mp3',
            'mpeg' => 'video',
            'mpg'  => 'video',
            'ogg'  => 'video',
            'webm' => 'video',
            'xls'  => 'xlsx',
            'xlsx' => 'xlsx',
            'zip'  => 'zip',
        );
        return $external_filetypes;
    }
    
    public static function tagTitleMarkup( $tag_slug, $type = '', $hide_description = 0 )
    {
        $html = '';
        
        if ( $tag_slug ) {
            $current_tag = get_term_by( 'slug', $tag_slug, 'post_tag' );
            $html .= '<div class="' . $type . '">';
            $html .= '<span class="shared-files-tag-title">' . $current_tag->name . '</span>';
            $html .= '<a class="shared-files-tags-show-all-files shared-files-tag-link" data-hide-description="' . $hide_description . '" href="./?sf_tag=">' . __( 'Show all files', 'shared-files' ) . '</a>';
            $html .= '</div>';
        }
        
        return $html;
    }
    
    public static function getPreviewButton( $file_id, $file_url )
    {
        $s = get_option( 'shared_files_settings' );
        if ( isset( $s['hide_preview_button'] ) ) {
            return '';
        }
        $file = get_post_meta( $file_id, '_sf_file', true );
        $filetype = '';
        if ( isset( $file['type'] ) ) {
            $filetype = $file['type'];
        }
        $html = '';
        $ok = array(
            'application/msword',
            'application/pdf',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/mspowerpoint',
            'application/powerpoint',
            'application/vnd.ms-powerpoint',
            'application/x-mspowerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation'
        );
        if ( in_array( $filetype, $ok ) ) {
            $html .= '<a href="https://docs.google.com/viewer?embedded=true&url=' . urlencode( get_site_url() . $file_url ) . '" target="_blank" class="shared-files-preview-button">' . __( 'Preview', 'shared-files' ) . '</a>';
        }
        return $html;
    }
    
    public static function getImageFile( $file_id, $external_url )
    {
        $s = get_option( 'shared_files_settings' );
        $file = get_post_meta( $file_id, '_sf_file', true );
        $filetypes = SharedFilesHelpers::getFiletypes();
        $external_filetypes = SharedFilesHelpers::getExternalFiletypes();
        $custom_icons = SharedFilesHelpers::getCustomIcons();
        $imagefile = 'generic.png';
        $file_type_icon_url = '';
        $file_ext = '';
        if ( isset( $file['file'] ) ) {
            $file_ext = pathinfo( $file['file'], PATHINFO_EXTENSION );
        }
        // Featured image override
        if ( !isset( $s['card_featured_image_as_extra'] ) && ($featured_img_url = get_the_post_thumbnail_url( $file_id, 'thumbnail' )) ) {
            return $featured_img_url;
        }
        // Custom file type definition overrides everything else
        
        if ( $file_ext ) {
            $num = [
                1,
                2,
                3,
                4,
                5,
                6
            ];
            foreach ( $num as $n ) {
                $custom_ext = 'custom_' . $n . '_ext';
                $custom_icon_url = 'custom_' . $n . '_icon';
                if ( isset( $s[$custom_ext] ) && $file_ext == $s[$custom_ext] && isset( $s[$custom_icon_url] ) && $s[$custom_icon_url] ) {
                    return $s[$custom_icon_url];
                }
            }
        }
        
        
        if ( $external_url ) {
            
            if ( substr( $external_url, 0, strlen( 'https://www.youtube.com' ) ) === 'https://www.youtube.com' && isset( $s['icon_for_youtube'] ) ) {
                $file_type_icon_url = $s['icon_for_youtube'];
            } else {
                $ext = pathinfo( $external_url, PATHINFO_EXTENSION );
                if ( array_key_exists( $ext, $external_filetypes ) ) {
                    
                    if ( isset( $external_filetypes[$ext] ) ) {
                        $imagefile = $external_filetypes[$ext] . '.png';
                        $file_type_icon_url = SHARED_FILES_URI . 'img/' . $imagefile;
                    }
                
                }
            }
        
        } else {
            
            if ( isset( $file_ext ) && $file_ext == 'psd' ) {
                $file_type_icon_url = $s['icon_for_psd'];
            } elseif ( isset( $file['type'] ) ) {
                $filetype = $file['type'];
                
                if ( isset( $custom_icons[$filetype] ) && $custom_icons[$filetype] ) {
                    $file_type_icon_url = $custom_icons[$filetype];
                } elseif ( array_key_exists( $filetype, $filetypes ) && isset( $filetypes[$filetype] ) ) {
                    $imagefile = $filetypes[$filetype] . '.png';
                    $file_type_icon_url = SHARED_FILES_URI . 'img/' . $imagefile;
                } elseif ( isset( $s['icon_for_other'] ) ) {
                    $file_type_icon_url = $s['icon_for_other'];
                }
            
            }
        
        }
        
        if ( !$file_type_icon_url ) {
            
            if ( isset( $s['icon_for_other'] ) && strlen( $s['icon_for_other'] ) > 0 ) {
                $file_type_icon_url = $s['icon_for_other'];
            } else {
                $file_type_icon_url = SHARED_FILES_URI . 'img/generic.png';
            }
        
        }
        return $file_type_icon_url;
    }
    
    public static function sf_root()
    {
        $s = get_option( 'shared_files_settings' );
        $sf_root = '';
        
        if ( isset( $s['wp_location'] ) && isset( $s['wp_location'] ) ) {
            $sf_root = rtrim( $s['wp_location'], '/' );
        } else {
            $url_parts = parse_url( get_admin_url() );
            $path_parts = explode( '/', $url_parts['path'] );
            if ( isset( $path_parts[2] ) && $path_parts[2] == 'wp-admin' ) {
                $sf_root = '/' . $path_parts[1];
            }
        }
        
        return $sf_root;
    }
    
    public static function initLayout( $s )
    {
        $html = '';
        if ( isset( $s['card_small_font_size'] ) && $s['card_small_font_size'] ) {
            $html .= '<style>.shared-files-main-elements p { font-size: 15px; }</style>';
        }
        if ( isset( $s['card_font'] ) && $s['card_font'] ) {
            
            if ( $s['card_font'] == 'roboto' ) {
                $html .= '<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">';
                $html .= '<style>.shared-files-main-elements * { font-family: "Roboto", sans-serif; }</style>';
            } elseif ( $s['card_font'] == 'ubuntu' ) {
                $html .= '<link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">';
                $html .= '<style>.shared-files-main-elements * { font-family: "Ubuntu", sans-serif; }</style>';
            }
        
        }
        
        if ( isset( $s['card_background'] ) && $s['card_background'] ) {
            $html .= '<style>.shared-files-container #myList li { margin-bottom: 5px; } </style>';
            
            if ( $s['card_background'] == 'custom_color' && isset( $s['card_background_custom_color'] ) && $s['card_background_custom_color'] ) {
                $custom_color = '#' . $s['card_background_custom_color'];
                
                if ( $custom_color && preg_match( '/^#([0-9A-F]{3}){1,2}$/i', $custom_color ) ) {
                    $html .= '<style>.shared-files-main-elements { background: ' . $custom_color . '; padding: 20px 10px; border-radius: 10px; margin-bottom: 20px; } </style>';
                } else {
                    $html .= '<style>.shared-files-main-elements { background: #f7f7f7; padding: 20px 10px; border-radius: 10px; margin-bottom: 20px; } </style>';
                }
            
            } elseif ( $s['card_background'] == 'white' ) {
                $html .= '<style>.shared-files-main-elements { background: #fff; padding: 20px 10px; border-radius: 10px; margin-bottom: 20px; } </style>';
            } elseif ( $s['card_background'] == 'light_gray' ) {
                $html .= '<style>.shared-files-main-elements { background: #f7f7f7; padding: 20px 10px; border-radius: 10px; margin-bottom: 20px; } </style>';
            }
        
        }
        
        
        if ( isset( $s['card_height'] ) && $s['card_height'] ) {
            $html .= '<style>.shared-files-2-cards-on-the-same-row #myList li .shared-files-main-elements { height: ' . $s['card_height'] . 'px; } </style>';
            $html .= '<style>.shared-files-3-cards-on-the-same-row #myList li .shared-files-main-elements { height: ' . $s['card_height'] . 'px; } </style>';
            $html .= '<style>.shared-files-4-cards-on-the-same-row #myList li .shared-files-main-elements { height: ' . $s['card_height'] . 'px; } </style>';
            $html .= '<style> @media (max-width: 500px) { .shared-files-2-cards-on-the-same-row #myList li .shared-files-main-elements { height: auto; } } </style>';
            $html .= '<style> @media (max-width: 500px) { .shared-files-3-cards-on-the-same-row #myList li .shared-files-main-elements { height: auto; } } </style>';
            $html .= '<style> @media (max-width: 500px) { .shared-files-4-cards-on-the-same-row #myList li .shared-files-main-elements { height: auto; } } </style>';
        }
        
        return $html;
    }
    
    public static function isPremium()
    {
        $is_premium = 0;
        return $is_premium;
    }
    
    public static function getOrder( $atts )
    {
        $order = 'DESC';
        $s = get_option( 'shared_files_settings' );
        
        if ( isset( $atts['order'] ) && $atts['order'] ) {
            $order = $atts['order'];
        } elseif ( isset( $s['order'] ) && $s['order'] ) {
            $order = $s['order'];
        }
        
        return $order;
    }
    
    public static function getOrderBy( $atts )
    {
        $order_by = 'post_date';
        $s = get_option( 'shared_files_settings' );
        
        if ( isset( $atts['order_by'] ) && $atts['order_by'] == '_sf_main_date' ) {
            $order_by = 'meta_value';
        } elseif ( isset( $atts['order_by'] ) && $atts['order_by'] ) {
            $order_by = $atts['order_by'];
        } elseif ( isset( $s['order_by'] ) && $s['order_by'] == '_sf_main_date' ) {
            $order_by = 'meta_value';
        } elseif ( isset( $s['order_by'] ) && $s['order_by'] ) {
            $order_by = $s['order_by'];
        }
        
        return $order_by;
    }
    
    public static function getMetaKey( $atts )
    {
        $meta_key = '';
        $s = get_option( 'shared_files_settings' );
        
        if ( isset( $atts['order_by'] ) && $atts['order_by'] == '_sf_main_date' ) {
            $meta_key = $atts['order_by'];
        } elseif ( isset( $s['order_by'] ) && $s['order_by'] == '_sf_main_date' ) {
            $meta_key = $s['order_by'];
        }
        
        return $meta_key;
    }

}