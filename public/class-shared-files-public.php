<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://anssilaitila.fi
 * @since      1.0.0
 *
 * @package    Shared_Files
 * @subpackage Shared_Files/public
 */
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Shared_Files
 * @subpackage Shared_Files/public
 * @author     Anssi Laitila <anssi.laitila@gmail.com>
 */
class Shared_Files_Public
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private  $plugin_name ;
    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private  $version ;
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    string    $plugin_name       The name of the plugin.
     * @param    string    $version           The version of this plugin.
     */
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }
    
    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'shared-files-public.css',
            array(),
            $this->version,
            'all'
        );
    }
    
    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'shared-files-public.js',
            array( 'jquery' ),
            $this->version,
            false
        );
    }
    
    /**
     * Register the shortcodes.
     *
     * @since    1.0.0
     */
    public function register_shortcodes()
    {
        add_shortcode( 'shared_files', array( 'Shared_Files_Public', 'shared_files_search' ) );
        add_shortcode( 'shared_files_search', array( 'Shared_Files_Public', 'shared_files_search_only' ) );
    }
    
    public static function shared_files_search_only( $atts = array(), $content = null, $tag = '' )
    {
        $html = sfProFeaturePublicMarkup();
        return $html;
    }
    
    /**
     * Search view embeddable via shortcode.
     *
     * @since    1.0.0
     */
    public static function shared_files_search( $atts = array(), $content = null, $tag = '' )
    {
        // normalize attribute keys, lowercase
        $atts = array_change_key_case( (array) $atts, CASE_LOWER );
        $s = get_option( 'shared_files_settings' );
        
        if ( isset( $atts['file_id'] ) ) {
            $file_id = (int) $atts['file_id'];
            $html = '';
            $wpb_all_query = new WP_Query( array(
                'post_type'      => 'shared_file',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'p'              => $file_id,
            ) );
            $filetypes = array(
                'image/png'                                                               => 'image',
                'image/jpg'                                                               => 'image',
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
            );
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
            $html .= '<div id="shared-files-search">';
            $html .= '<ul id="myList">';
            
            if ( $wpb_all_query->have_posts() ) {
                while ( $wpb_all_query->have_posts() ) {
                    $wpb_all_query->the_post();
                    $id = get_the_id();
                    $c = get_post_custom( $id );
                    $external_url = ( isset( $c['_sf_external_url'] ) ? $c['_sf_external_url'][0] : '' );
                    $imagefile = 'generic.png';
                    $filetype = '';
                    
                    if ( $external_url ) {
                        $ext = pathinfo( $external_url, PATHINFO_EXTENSION );
                        if ( array_key_exists( $ext, $external_filetypes ) ) {
                            if ( isset( $external_filetypes[$ext] ) ) {
                                $imagefile = $external_filetypes[$ext] . '.png';
                            }
                        }
                    } else {
                        $file = get_post_meta( get_the_ID(), '_sf_file', true );
                        $filetype = $file['type'];
                        if ( array_key_exists( $filetype, $filetypes ) ) {
                            if ( isset( $filetypes[$filetype] ) ) {
                                $imagefile = $filetypes[$filetype] . '.png';
                            }
                        }
                    }
                    
                    $html .= '<li>';
                    $html .= '<div class="shared-files-main-elements">';
                    $html .= '<div class="shared-files-main-elements-left" style="background: url(' . plugins_url( '../img/' . $imagefile, __FILE__ ) . ') right top no-repeat;"></div>';
                    $html .= '<div class="shared-files-main-elements-right">';
                    $html .= '<a href="' . sf_root() . '/shared-files/' . get_the_id() . '/' . $c['_sf_filename'][0] . '" target="_blank">' . get_the_title() . '</a>';
                    if ( isset( $c['_sf_filesize'] ) ) {
                        $html .= '<span class="shared-file-size">' . human_filesize( $c['_sf_filesize'][0] ) . '</span>';
                    }
                    $html .= '<span class="shared-file-date">' . get_the_date() . '</span>';
                    if ( isset( $c['_sf_description'] ) && !isset( $atts['hide_description'] ) ) {
                        $html .= '<p class="shared-file-description">' . $c['_sf_description'][0] . '</p>';
                    }
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '</li>';
                }
            } else {
                $html .= '<div class="sf_error">' . __( 'File not found', 'shared-files' ) . '</div>';
            }
            
            $html .= '</ul>';
            $html .= '</div>';
            return $html;
        } else {
            $layout = '';
            
            if ( isset( $atts['layout'] ) ) {
                $layout = $atts['layout'];
            } elseif ( isset( $s['layout'] ) && $s['layout'] ) {
                $layout = $s['layout'];
            }
            
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
                
                if ( $s['card_background'] == 'white' ) {
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
            
            $html .= '<div class="shared-files-container ' . (( $layout ? 'shared-files-' . $layout : '' )) . '">';
            $html .= '<div id="shared-files-search">';
            
            if ( isset( $atts['category'] ) ) {
                $html = sfProFeaturePublicMarkup();
                return $html;
            } else {
                
                if ( isset( $_GET['c'] ) && $_GET['c'] != 'all_files' ) {
                    $term_slug = sanitize_title( $_GET['c'] );
                    $wpb_all_query = new WP_Query( array(
                        'post_type'      => 'shared_file',
                        'post_status'    => 'publish',
                        'posts_per_page' => -1,
                        'tax_query'      => array( array(
                        'taxonomy'         => 'shared-file-category',
                        'field'            => 'slug',
                        'terms'            => $term_slug,
                        'include_children' => true,
                    ) ),
                    ) );
                    $wpb_all_query_all_files = new WP_Query( array(
                        'post_type'      => 'shared_file',
                        'post_status'    => 'publish',
                        'posts_per_page' => -1,
                        'tax_query'      => array( array(
                        'taxonomy'         => 'shared-file-category',
                        'field'            => 'slug',
                        'terms'            => $term_slug,
                        'include_children' => true,
                    ) ),
                    ) );
                } else {
                    $paged = ( get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1 );
                    $wpb_all_query = new WP_Query( array(
                        'post_type'      => 'shared_file',
                        'post_status'    => 'publish',
                        'posts_per_page' => 20,
                        'paged'          => $paged,
                    ) );
                    $wpb_all_query_all_files = new WP_Query( array(
                        'post_type'      => 'shared_file',
                        'post_status'    => 'publish',
                        'posts_per_page' => -1,
                    ) );
                }
            
            }
            
            $filetypes = array(
                'image/png'                                                               => 'image',
                'image/jpg'                                                               => 'image',
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
            );
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
            $html .= '<div id="shared-files-files-found"></div>';
            $html .= '<span id="shared-files-one-file-found">' . __( 'file found.', 'shared-files' ) . '</span><span id="shared-files-more-than-one-file-found">' . __( 'files found.', 'shared-files' ) . '</span>';
            $html .= '<ul id="myList">';
            if ( $wpb_all_query->have_posts() ) {
                while ( $wpb_all_query->have_posts() ) {
                    $wpb_all_query->the_post();
                    $id = get_the_id();
                    $c = get_post_custom( $id );
                    $external_url = ( isset( $c['_sf_external_url'] ) ? $c['_sf_external_url'][0] : '' );
                    $imagefile = 'generic.png';
                    $filetype = '';
                    
                    if ( $external_url ) {
                        $ext = pathinfo( $external_url, PATHINFO_EXTENSION );
                        if ( array_key_exists( $ext, $external_filetypes ) ) {
                            if ( isset( $external_filetypes[$ext] ) ) {
                                $imagefile = $external_filetypes[$ext] . '.png';
                            }
                        }
                    } else {
                        $file = get_post_meta( get_the_ID(), '_sf_file', true );
                        
                        if ( isset( $file['type'] ) ) {
                            $filetype = $file['type'];
                            if ( array_key_exists( $filetype, $filetypes ) ) {
                                if ( isset( $filetypes[$filetype] ) ) {
                                    $imagefile = $filetypes[$filetype] . '.png';
                                }
                            }
                        }
                    
                    }
                    
                    $html .= '<li>';
                    $html .= '<div class="shared-files-main-elements">';
                    $html .= '<div class="shared-files-main-elements-left" style="background: url(' . plugins_url( '../img/' . $imagefile, __FILE__ ) . ') right top no-repeat;"></div>';
                    $html .= '<div class="shared-files-main-elements-right">';
                    $html .= '<a href="' . sf_root() . '/shared-files/' . get_the_id() . '/' . $c['_sf_filename'][0] . '" target="_blank">' . get_the_title() . '</a>';
                    if ( isset( $c['_sf_filesize'] ) ) {
                        $html .= '<span class="shared-file-size">' . human_filesize( $c['_sf_filesize'][0] ) . '</span>';
                    }
                    $html .= '<span class="shared-file-date">' . get_the_date() . '</span>';
                    if ( isset( $c['_sf_description'] ) && !isset( $atts['hide_description'] ) ) {
                        $html .= '<p class="shared-file-description">' . $c['_sf_description'][0] . '</p>';
                    }
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '</li>';
                }
            }
            $html .= '</ul>';
            $pagination_args = array(
                'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                'total'        => $wpb_all_query->max_num_pages,
                'current'      => max( 1, get_query_var( 'paged' ) ),
                'format'       => '?paged=%#%',
                'show_all'     => true,
                'type'         => 'plain',
                'prev_next'    => false,
                'add_args'     => false,
                'add_fragment' => '',
            );
            $html .= '<div id="shared-files-pagination" class="shared-files-pagination">';
            if ( paginate_links( $pagination_args ) ) {
                $html .= '<span class="shared-files-more-files">' . __( 'Browse more files:', 'shared-files' ) . '</span>' . paginate_links( $pagination_args );
            }
            $html .= '</div>';
            $html .= '<div id="shared-files-nothing-found">';
            $html .= __( 'No files found.', 'shared-files' );
            $html .= '</div>';
            $html .= '</div></div><hr class="clear" />';
            wp_reset_postdata();
            return $html;
        }
    
    }

}
function sf_root()
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
