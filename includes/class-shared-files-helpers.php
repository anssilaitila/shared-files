<?php

class SharedFilesHelpers
{
    public static function getText( $text_id, $default_text )
    {
        $s = get_option( 'shared_files_settings' );
        $text = sanitize_text_field( $default_text );
        if ( isset( $s[$text_id] ) && $s[$text_id] ) {
            $text = sanitize_text_field( $s[$text_id] );
        }
        return $text;
    }
    
    public static function createElemClass()
    {
        $elem_class = 'shared-files-embed-' . uniqid();
        return $elem_class;
    }
    
    public static function writeLog( $title = '', $message = '' )
    {
        global  $wpdb ;
        $wpdb->insert( $wpdb->prefix . 'shared_files_log', array(
            'title'   => sanitize_text_field( $title ),
            'message' => sanitize_textarea_field( $message ),
        ) );
    }
    
    public static function getCatPassword( $file_id )
    {
        $cat_password = '';
        $terms = get_the_terms( $file_id, 'shared-file-category' );
        if ( $terms ) {
            foreach ( $terms as $term ) {
                //        $password = get_term_meta($term->term_id, '_sf_cat_password', true);
                $password = sanitize_text_field( SharedFilesTermMetadata::get_hierarchichal_term_metadata( $term, '_sf_cat_password' ) );
                if ( $password ) {
                    $cat_password = $password;
                }
            }
        }
        return $cat_password;
    }
    
    public static function getCatPasswordProtectionType( $file_id )
    {
        $cat_password_protection_type = '';
        $terms = get_the_terms( $file_id, 'shared-file-category' );
        if ( $terms ) {
            foreach ( $terms as $term ) {
                $password_protection_type = sanitize_text_field( SharedFilesTermMetadata::get_hierarchichal_term_metadata( $term, '_sf_cat_password_protection_type' ) );
                if ( $password_protection_type ) {
                    $cat_password_protection_type = $password_protection_type;
                }
            }
        }
        return $cat_password_protection_type;
    }
    
    public static function maxUploadSize()
    {
        $s = get_option( 'shared_files_settings' );
        $max_upload_size = size_format( wp_max_upload_size() );
        
        if ( isset( $s['maximum_size_text'] ) && $s['maximum_size_text'] ) {
            $max_upload_size = $s['maximum_size_text'];
        } elseif ( !$max_upload_size ) {
            $max_upload_size = 0;
        }
        
        return $max_upload_size;
    }
    
    public static function getFiletypes()
    {
        $filetypes = array(
            'text/css'                                                                  => 'css',
            'text/csv'                                                                  => 'csv',
            'text/html'                                                                 => 'html',
            'video/mp4'                                                                 => 'mp4',
            'text/plain'                                                                => 'txt',
            'audio/wave'                                                                => 'wav',
            'audio/wav'                                                                 => 'wav',
            'audio/x-wav'                                                               => 'wav',
            'audio/x-pn-wav'                                                            => 'wav',
            'image/png'                                                                 => 'png',
            'image/jpg'                                                                 => 'jpg',
            'image/jpeg'                                                                => 'jpg',
            'image/gif'                                                                 => 'gif',
            'image/svg+xml'                                                             => 'image',
            'application/pdf'                                                           => 'pdf',
            'application/postscript'                                                    => 'ai',
            'application/msword'                                                        => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => 'doc',
            'application/vnd.ms-fontobject'                                             => 'font',
            'application/mspowerpoint'                                                  => 'ppt',
            'application/powerpoint'                                                    => 'ppt',
            'application/vnd.ms-powerpoint'                                             => 'ppt',
            'application/x-mspowerpoint'                                                => 'ppt',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'ppt',
            'font/otf'                                                                  => 'font',
            'font/ttf'                                                                  => 'font',
            'font/woff'                                                                 => 'font',
            'font/woff2'                                                                => 'font',
            'text/html'                                                                 => 'html',
            'audio/mpeg3'                                                               => 'mp3',
            'audio/x-mpeg-3'                                                            => 'mp3',
            'audio/mpeg'                                                                => 'mp3',
            'video/x-msvideo'                                                           => 'video',
            'video/mpeg'                                                                => 'video',
            'video/x-mpeg'                                                              => 'video',
            'video/ogg'                                                                 => 'video',
            'video/webm'                                                                => 'video',
            'video/3gpp'                                                                => 'video',
            'video/3gpp2'                                                               => 'video',
            'application/vnd.ms-excel'                                                  => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         => 'xls',
            'application/zip'                                                           => 'zip',
            'application/x-7z-compressed'                                               => 'zip',
            'application/x-indesign'                                                    => 'indd',
        );
        return $filetypes;
    }
    
    public static function getCustomIcons()
    {
        $s = get_option( 'shared_files_settings' );
        $filetypes = array(
            'image/png'                                                                 => ( isset( $s['icon_for_image'] ) ? sanitize_text_field( $s['icon_for_image'] ) : '' ),
            'image/jpg'                                                                 => ( isset( $s['icon_for_image'] ) ? sanitize_text_field( $s['icon_for_image'] ) : '' ),
            'image/jpeg'                                                                => ( isset( $s['icon_for_image'] ) ? sanitize_text_field( $s['icon_for_image'] ) : '' ),
            'application/pdf'                                                           => ( isset( $s['icon_for_pdf'] ) ? sanitize_text_field( $s['icon_for_pdf'] ) : '' ),
            'application/postscript'                                                    => ( isset( $s['icon_for_ai'] ) ? sanitize_text_field( $s['icon_for_ai'] ) : '' ),
            'application/msword'                                                        => ( isset( $s['icon_for_doc'] ) ? sanitize_text_field( $s['icon_for_doc'] ) : '' ),
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => ( isset( $s['icon_for_doc'] ) ? sanitize_text_field( $s['icon_for_doc'] ) : '' ),
            'application/vnd.ms-fontobject'                                             => ( isset( $s['icon_for_font'] ) ? sanitize_text_field( $s['icon_for_font'] ) : '' ),
            'font/otf'                                                                  => ( isset( $s['icon_for_font'] ) ? sanitize_text_field( $s['icon_for_font'] ) : '' ),
            'font/ttf'                                                                  => ( isset( $s['icon_for_font'] ) ? sanitize_text_field( $s['icon_for_font'] ) : '' ),
            'font/woff'                                                                 => ( isset( $s['icon_for_font'] ) ? sanitize_text_field( $s['icon_for_font'] ) : '' ),
            'font/woff2'                                                                => ( isset( $s['icon_for_font'] ) ? sanitize_text_field( $s['icon_for_font'] ) : '' ),
            'text/html'                                                                 => ( isset( $s['icon_for_html'] ) ? sanitize_text_field( $s['icon_for_html'] ) : '' ),
            'audio/mpeg3'                                                               => ( isset( $s['icon_for_mp3'] ) ? sanitize_text_field( $s['icon_for_mp3'] ) : '' ),
            'audio/x-mpeg-3'                                                            => ( isset( $s['icon_for_mp3'] ) ? sanitize_text_field( $s['icon_for_mp3'] ) : '' ),
            'audio/mpeg'                                                                => ( isset( $s['icon_for_mp3'] ) ? sanitize_text_field( $s['icon_for_mp3'] ) : '' ),
            'video/x-msvideo'                                                           => ( isset( $s['icon_for_video'] ) ? sanitize_text_field( $s['icon_for_video'] ) : '' ),
            'video/mpeg'                                                                => ( isset( $s['icon_for_video'] ) ? sanitize_text_field( $s['icon_for_video'] ) : '' ),
            'video/x-mpeg'                                                              => ( isset( $s['icon_for_video'] ) ? sanitize_text_field( $s['icon_for_video'] ) : '' ),
            'video/ogg'                                                                 => ( isset( $s['icon_for_video'] ) ? sanitize_text_field( $s['icon_for_video'] ) : '' ),
            'video/webm'                                                                => ( isset( $s['icon_for_video'] ) ? sanitize_text_field( $s['icon_for_video'] ) : '' ),
            'video/3gpp'                                                                => ( isset( $s['icon_for_video'] ) ? sanitize_text_field( $s['icon_for_video'] ) : '' ),
            'video/3gpp2'                                                               => ( isset( $s['icon_for_video'] ) ? sanitize_text_field( $s['icon_for_video'] ) : '' ),
            'application/vnd.ms-excel'                                                  => ( isset( $s['icon_for_xlsx'] ) ? sanitize_text_field( $s['icon_for_xlsx'] ) : '' ),
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         => ( isset( $s['icon_for_xlsx'] ) ? sanitize_text_field( $s['icon_for_xlsx'] ) : '' ),
            'application/zip'                                                           => ( isset( $s['icon_for_zip'] ) ? sanitize_text_field( $s['icon_for_zip'] ) : '' ),
            'application/x-7z-compressed'                                               => ( isset( $s['icon_for_zip'] ) ? sanitize_text_field( $s['icon_for_zip'] ) : '' ),
            'application/mspowerpoint'                                                  => ( isset( $s['icon_for_pptx'] ) ? sanitize_text_field( $s['icon_for_pptx'] ) : '' ),
            'application/powerpoint'                                                    => ( isset( $s['icon_for_pptx'] ) ? sanitize_text_field( $s['icon_for_pptx'] ) : '' ),
            'application/vnd.ms-powerpoint'                                             => ( isset( $s['icon_for_pptx'] ) ? sanitize_text_field( $s['icon_for_pptx'] ) : '' ),
            'application/x-mspowerpoint'                                                => ( isset( $s['icon_for_pptx'] ) ? sanitize_text_field( $s['icon_for_pptx'] ) : '' ),
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => ( isset( $s['icon_for_pptx'] ) ? sanitize_text_field( $s['icon_for_pptx'] ) : '' ),
            'application/x-indesign'                                                    => ( isset( $s['icon_for_indd'] ) ? sanitize_text_field( $s['icon_for_indd'] ) : '' ),
            'image/vnd.adobe.photoshop'                                                 => ( isset( $s['icon_for_psd'] ) ? sanitize_text_field( $s['icon_for_psd'] ) : '' ),
            'application/photoshop'                                                     => ( isset( $s['icon_for_psd'] ) ? sanitize_text_field( $s['icon_for_psd'] ) : '' ),
            'image/svg+xml'                                                             => ( isset( $s['icon_for_svg'] ) ? sanitize_text_field( $s['icon_for_svg'] ) : '' ),
        );
        return $filetypes;
    }
    
    public static function getExternalFiletypes()
    {
        $external_filetypes = array(
            'png'  => 'png',
            'jpg'  => 'jpg',
            'pdf'  => 'pdf',
            'ai'   => 'ai',
            'doc'  => 'doc',
            'docx' => 'doc',
            'mp3'  => 'mp3',
            'mpeg' => 'video',
            'mpg'  => 'video',
            'ogg'  => 'video',
            'webm' => 'video',
            'xls'  => 'xls',
            'xlsx' => 'xls',
            'zip'  => 'zip',
        );
        return $external_filetypes;
    }
    
    public static function filetypesExt()
    {
        $filetypes_ext = array(
            'avi' => 'avi',
            'dll' => 'dll',
            'eml' => 'eml',
            'vob' => 'vob',
            'eps' => 'eps',
            'exe' => 'exe',
            'mov' => 'mov',
            'psd' => 'psd',
            'rar' => 'rar',
            'raw' => 'raw',
        );
        return $filetypes_ext;
    }
    
    public static function tagTitleMarkup( $tag_slug, $type = '', $hide_description = 0 )
    {
        $html = '';
        
        if ( $tag_slug ) {
            $current_tag = get_term_by( 'slug', $tag_slug, 'post_tag' );
            $html .= '<div class="' . esc_attr( $type ) . '">';
            $html .= '<span class="shared-files-tag-title">' . sanitize_text_field( $current_tag->name ) . '</span>';
            $html .= '<a class="shared-files-tags-show-all-files shared-files-tag-link" data-hide-description="' . esc_attr( $hide_description ) . '" href="./?sf_tag=0">' . esc_html__( 'Show all files', 'shared-files' ) . '</a>';
            $html .= '</div>';
        }
        
        return $html;
    }
    
    public static function getPreviewButton( $file_id, $file_url )
    {
        $s = get_option( 'shared_files_settings' );
        $password = '';
        $cat_password = '';
        $file_password = '';
        $enable_preview_with_password = 0;
        if ( isset( $s['enable_preview_for_password_protected_files'] ) ) {
            $enable_preview_with_password = 1;
        }
        if ( isset( $s['hide_preview_button'] ) || $password && $enable_preview_with_password == 0 || SharedFilesPublicHelpers::limitActive( $file_id ) ) {
            return '';
        }
        $file = get_post_meta( $file_id, '_sf_file', true );
        $media_library_post_id = intval( get_post_meta( $file_id, '_sf_media_library_post_id', true ) );
        $filetype = '';
        
        if ( isset( $file['type'] ) && $file['type'] ) {
            $filetype = sanitize_text_field( $file['type'] );
        } elseif ( $media_library_post_id ) {
        }
        
        $html = '';
        $image_types = array( 'image/jpeg', 'image/png', 'image/gif' );
        $pdf_types = array(
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
        $pdf_types = array( 'application/pdf' );
        
        if ( in_array( $filetype, $image_types ) ) {
            $image_url = esc_url_raw( get_the_post_thumbnail_url( $file_id, 'large' ) );
            if ( !$image_url ) {
                $image_url = esc_url_raw( $file['url'] );
            }
            
            if ( $password && $enable_preview_with_password ) {
                $html .= '<a href="' . esc_url_raw( SharedFilesPublicHelpers::getFileURL( $file_id ) ) . '" target="_blank" class="shared-files-preview-button shared-files-preview-image">' . sanitize_text_field( __( 'Preview', 'shared-files' ) ) . '</a>';
            } else {
                $html .= '<a href="' . esc_url_raw( $image_url ) . '" class="shared-files-preview-button shared-files-preview-image" data-file-type="image">' . sanitize_text_field( __( 'Preview', 'shared-files' ) ) . '</a>';
            }
        
        } elseif ( isset( $s['always_preview_pdf'] ) && !$password && in_array( $filetype, $pdf_types ) ) {
            
            if ( isset( $s['file_open_method'] ) && $s['file_open_method'] == 'redirect' ) {
                $file_url = esc_url_raw( $file['url'] );
            } else {
                $file_url = esc_url_raw( get_site_url() . $file_url );
            }
            
            
            if ( isset( $s['bypass_preview_pdf'] ) ) {
                $html .= '<a href="' . esc_url( $file_url ) . '" target="_blank" class="shared-files-preview-button">' . sanitize_text_field( __( 'Preview', 'shared-files' ) ) . '</a>';
            } else {
                $html .= '<a href="https://docs.google.com/viewer?embedded=true&url=' . urlencode( esc_url( $file_url ) ) . '" target="_blank" class="shared-files-preview-button">' . sanitize_text_field( __( 'Preview', 'shared-files' ) ) . '</a>';
            }
        
        } elseif ( isset( $s['preview_service'] ) && $s['preview_service'] == 'microsoft' ) {
            $ok = array(
                'application/msword',
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
                
                if ( isset( $s['file_open_method'] ) && $s['file_open_method'] == 'redirect' ) {
                    $file_url = esc_url_raw( $file['url'] );
                } else {
                    $file_url = esc_url_raw( get_site_url() . $file_url );
                }
                
                $password_protected = 0;
                if ( !$password_protected ) {
                    $html .= '<a href="https://view.officeapps.live.com/op/view.aspx?src=' . urlencode( esc_url( $file_url ) ) . '" target="_blank" class="shared-files-preview-button">' . esc_html__( 'Preview', 'shared-files' ) . '</a>';
                }
            }
        
        } else {
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
                
                if ( isset( $s['file_open_method'] ) && $s['file_open_method'] == 'redirect' ) {
                    $file_url = esc_url_raw( $file['url'] );
                } else {
                    $file_url = esc_url_raw( get_site_url() . $file_url );
                }
                
                $password_protected = 0;
                if ( !$password_protected ) {
                    $html .= '<a href="https://docs.google.com/viewer?embedded=true&url=' . urlencode( esc_url( $file_url ) ) . '" target="_blank" class="shared-files-preview-button">' . sanitize_text_field( __( 'Preview', 'shared-files' ) ) . '</a>';
                }
            }
        
        }
        
        return $html;
    }
    
    public static function getImageFile( $file_id, $external_url )
    {
        $s = get_option( 'shared_files_settings' );
        $file = get_post_meta( $file_id, '_sf_file', true );
        $media_library_post_id = (int) get_post_meta( $file_id, '_sf_media_library_post_id', true );
        $media_library_post_mime_type = '';
        if ( $media_library_post_id ) {
            $media_library_post_mime_type = get_post_mime_type( $media_library_post_id );
        }
        $filetypes = SharedFilesHelpers::getFiletypes();
        $external_filetypes = SharedFilesHelpers::getExternalFiletypes();
        $filetypes_ext = SharedFilesHelpers::filetypesExt();
        $custom_icons = SharedFilesHelpers::getCustomIcons();
        $password = sanitize_text_field( get_post_meta( $file_id, '_sf_password', true ) );
        $imagefile = 'generic.png';
        $file_type_icon_url = '';
        $file_ext = '';
        $file_realpath = '';
        if ( isset( $file['file'] ) && $file['file'] ) {
            $file_realpath = SharedFilesFileOpen::getUpdatedPathAndFilename( $file['file'] );
        }
        if ( $file_realpath ) {
            $file_ext = pathinfo( $file_realpath, PATHINFO_EXTENSION );
        }
        $featured_img_url = get_the_post_thumbnail_url( $file_id, 'thumbnail' );
        // Featured image override
        if ( !isset( $s['card_featured_image_as_extra'] ) && (!$password || isset( $s['show_featured_image_for_password_protected_files'] )) && !SharedFilesPublicHelpers::limitActive( $file_id ) && $featured_img_url ) {
            return $featured_img_url;
        }
        $icon_set = 2020;
        if ( isset( $s['icon_set'] ) && $s['icon_set'] == 2019 ) {
            $icon_set = 2019;
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
                    return esc_url_raw( $s[$custom_icon_url] );
                }
            }
        }
        
        
        if ( $external_url ) {
            
            if ( (substr( $external_url, 0, strlen( 'https://www.youtube.com' ) ) === 'https://www.youtube.com' || substr( $external_url, 0, strlen( 'https://youtu.be' ) ) === 'https://youtu.be') && isset( $s['icon_for_youtube'] ) ) {
                
                if ( isset( $s['icon_for_youtube'] ) && $s['icon_for_youtube'] ) {
                    $file_type_icon_url = $s['icon_for_youtube'];
                } else {
                    $file_type_icon_url = SHARED_FILES_URI . 'img/2020/video.svg';
                    if ( $icon_set == 2019 ) {
                        $file_type_icon_url = SHARED_FILES_URI . 'img/video.png';
                    }
                }
            
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
            } elseif ( isset( $file['type'] ) || $media_library_post_mime_type ) {
                $filetype = ( $media_library_post_mime_type ? $media_library_post_mime_type : $file['type'] );
                if ( !$filetype && isset( $file_realpath ) && file_exists( $file_realpath ) && is_readable( $file_realpath ) ) {
                    
                    if ( function_exists( 'mime_content_type' ) ) {
                        $filetype = mime_content_type( $file_realpath );
                    } elseif ( function_exists( 'finfo_open' ) && function_exists( 'finfo_file' ) ) {
                        $finfo = finfo_open( FILEINFO_MIME_TYPE );
                        $filetype = finfo_file( $finfo, $file_realpath );
                        finfo_close( $finfo );
                    }
                
                }
                
                if ( isset( $custom_icons[$filetype] ) && $custom_icons[$filetype] ) {
                    $file_type_icon_url = $custom_icons[$filetype];
                } elseif ( array_key_exists( $filetype, $filetypes ) && isset( $filetypes[$filetype] ) ) {
                    $imagefile = $filetypes[$filetype] . '.svg';
                    $file_type_icon_url = SHARED_FILES_URI . 'img/2020/' . $imagefile;
                    
                    if ( $icon_set == 2019 ) {
                        $imagefile = $filetypes[$filetype] . '.png';
                        $file_type_icon_url = SHARED_FILES_URI . 'img/' . $imagefile;
                    }
                
                } elseif ( isset( $file_ext ) && array_key_exists( $file_ext, $filetypes_ext ) ) {
                    
                    if ( isset( $filetypes_ext[$file_ext] ) ) {
                        $imagefile = $filetypes_ext[$file_ext] . '.svg';
                        $file_type_icon_url = SHARED_FILES_URI . 'img/2020/' . $imagefile;
                        
                        if ( $icon_set == 2019 ) {
                            $imagefile = $filetypes_ext[$file_ext] . '.png';
                            $file_type_icon_url = SHARED_FILES_URI . 'img/' . $imagefile;
                        }
                    
                    }
                
                } elseif ( isset( $s['icon_for_other'] ) ) {
                    $file_type_icon_url = sanitize_text_field( $s['icon_for_other'] );
                }
            
            }
        
        }
        
        if ( !$file_type_icon_url ) {
            
            if ( isset( $s['icon_for_other'] ) && strlen( $s['icon_for_other'] ) > 0 ) {
                $file_type_icon_url = esc_url_raw( $s['icon_for_other'] );
            } elseif ( $icon_set == 2020 ) {
                $file_type_icon_url = SHARED_FILES_URI . 'img/2020/generic.svg';
            } else {
                $file_type_icon_url = SHARED_FILES_URI . 'img/generic.png';
            }
        
        }
        return $file_type_icon_url;
    }
    
    public static function wp_engine()
    {
        $s = get_option( 'shared_files_settings' );
        $extra = '';
        if ( isset( $s['wp_engine_compatibility_mode'] ) ) {
            $extra = '?';
        }
        return $extra;
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
        
        
        if ( is_multisite() ) {
            $multisite_path_part = str_replace( '/', '', get_blog_details()->path );
            if ( $multisite_path_part ) {
                $sf_root = '/' . $multisite_path_part . $sf_root;
            }
        }
        
        return $sf_root;
    }
    
    public static function getLayout( $s, $atts )
    {
        $layout = '';
        
        if ( isset( $atts['layout'] ) ) {
            $layout = sanitize_text_field( $atts['layout'] );
            
            if ( $layout == '2-columns' ) {
                $layout = '2-cards-on-the-same-row';
            } elseif ( $layout == '3-columns' ) {
                $layout = '3-cards-on-the-same-row';
            } elseif ( $layout == '4-columns' ) {
                $layout = '4-cards-on-the-same-row';
            }
        
        } elseif ( isset( $s['layout'] ) && $s['layout'] ) {
            $layout = sanitize_text_field( $s['layout'] );
        }
        
        return $layout;
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
                $custom_color = '#' . esc_attr( $s['card_background_custom_color'] );
                
                if ( $custom_color && preg_match( '/^#([0-9A-F]{3}){1,2}$/i', $custom_color ) ) {
                    $html .= '<style>.shared-files-main-elements { background: ' . esc_attr( $custom_color ) . '; padding: 20px 10px; border-radius: 10px; margin-bottom: 20px; } </style>';
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
            $html .= '<style>.shared-files-2-cards-on-the-same-row #myList li .shared-files-main-elements { height: ' . esc_attr( $s['card_height'] ) . 'px; } </style>';
            $html .= '<style>.shared-files-3-cards-on-the-same-row #myList li .shared-files-main-elements { height: ' . esc_attr( $s['card_height'] ) . 'px; } </style>';
            $html .= '<style>.shared-files-4-cards-on-the-same-row #myList li .shared-files-main-elements { height: ' . esc_attr( $s['card_height'] ) . 'px; } </style>';
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
            $order = sanitize_text_field( $atts['order'] );
        } elseif ( isset( $s['order'] ) && $s['order'] ) {
            $order = sanitize_text_field( $s['order'] );
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
            $order_by = sanitize_text_field( $atts['order_by'] );
        } elseif ( isset( $s['order_by'] ) && $s['order_by'] == '_sf_main_date' ) {
            $order_by = 'meta_value';
        } elseif ( isset( $s['order_by'] ) && $s['order_by'] ) {
            $order_by = sanitize_text_field( $s['order_by'] );
        }
        
        return $order_by;
    }
    
    public static function getMetaKey( $atts )
    {
        $meta_key = '';
        $s = get_option( 'shared_files_settings' );
        
        if ( isset( $atts['order_by'] ) && $atts['order_by'] == '_sf_main_date' ) {
            $meta_key = sanitize_text_field( $atts['order_by'] );
        } elseif ( isset( $s['order_by'] ) && $s['order_by'] == '_sf_main_date' ) {
            $meta_key = sanitize_text_field( $s['order_by'] );
        }
        
        return $meta_key;
    }
    
    public static function addFeaturedImage(
        $file_id,
        $upload,
        $uploaded_type,
        $filename
    )
    {
        $file_id = intval( $file_id );
        if ( !function_exists( 'wp_crop_image' ) ) {
            include ABSPATH . 'wp-admin/includes/image.php';
        }
        // if ! x 2 ...
        if ( $file_id && $upload && $uploaded_type && $filename ) {
            switch ( $uploaded_type ) {
                case 'image/jpeg':
                case 'image/png':
                case 'image/gif':
                    $image_url = $upload['file'];
                    // Prepare an array of post data for the attachment.
                    $attachment = array(
                        'guid'           => $image_url,
                        'post_mime_type' => $uploaded_type,
                        'post_title'     => $filename,
                        'post_content'   => '',
                        'post_status'    => 'inherit',
                    );
                    $attach_id = wp_insert_attachment( $attachment, $image_url, $file_id );
                    $attach_data = wp_generate_attachment_metadata( $attach_id, $image_url );
                    wp_update_attachment_metadata( $attach_id, $attach_data );
                    set_post_thumbnail( $file_id, $attach_id );
                    break;
            }
        }
    }

}