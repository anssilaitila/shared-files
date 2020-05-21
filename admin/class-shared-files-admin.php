<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://anssilaitila.fi
 * @since      1.0.0
 *
 * @package    Shared_Files
 * @subpackage Shared_Files/admin
 */
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Shared_Files
 * @subpackage Shared_Files/admin
 * @author     Anssi Laitila <anssi.laitila@gmail.com>
 */
class Shared_Files_Admin
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
     * @param    string    $plugin_name       The name of this plugin.
     * @param    string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }
    
    public function enqueue_styles()
    {
        wp_enqueue_style(
            $this->plugin_name,
            SHARED_FILES_URI . 'dist/css/main.css',
            array(),
            $this->version,
            'all'
        );
    }
    
    /**
     * Custom meta box for file edit view.
     *
     * @since    1.0.0
     */
    public function adding_custom_meta_boxes( $post )
    {
        add_meta_box(
            'my-meta-box',
            __( 'File info' ),
            array( $this, 'custom_metadata' ),
            'shared_file',
            'normal',
            'default'
        );
    }
    
    public function custom_metadata()
    {
        wp_nonce_field( plugin_basename( __FILE__ ), '_sf_file_nonce' );
        $file = get_post_meta( get_the_ID(), '_sf_file', true );
        $filename = get_post_meta( get_the_ID(), '_sf_filename', true );
        $description = get_post_meta( get_the_ID(), '_sf_description', true );
        $external_url = get_post_meta( get_the_ID(), '_sf_external_url', true );
        $limit_downloads = get_post_meta( get_the_ID(), '_sf_limit_downloads', true );
        $expiration_date = get_post_meta( get_the_ID(), '_sf_expiration_date', true );
        $expiration_date_formatted = '';
        $notify_email = get_post_meta( get_the_ID(), '_sf_notify_email', true );
        if ( $expiration_date instanceof DateTime ) {
            $expiration_date_formatted = $expiration_date->format( 'Y-m-d' );
        }
        $password = get_post_meta( get_the_ID(), '_sf_password', true );
        $html = '';
        
        if ( $file ) {
            $file_url = $this->sf_root() . '/shared-files/' . get_the_ID() . '/' . $filename;
            $html .= __( 'Current file:', 'shared-files' ) . ' <a href="' . $file_url . '" target="_blank">' . $file_url . '</a>';
            $html .= '<br /><br /><b>' . __( 'Replace with a new file', 'shared-files' ) . ':</b><br />';
            $html .= '<input type="file" id="sf_file" name="_sf_file" value="" size="25" /><br />';
        } else {
            $html .= '<input type="file" id="sf_file" name="_sf_file" value="" size="25" /><br />';
        }
        
        $html .= SharedFilesAdminViews::sfProMoreFeaturesMarkup();
        $html .= '<div id="shared-file-description-title">' . __( 'Description', 'shared-files' ) . '</div>';
        echo  $html ;
        $settings = array(
            'media_buttons' => false,
            'teeny'         => true,
            'wpautop'       => false,
            'textarea_rows' => 16,
        );
        wp_editor( $description, '_sf_description', $settings );
        $html = '';
        $html .= "\n    <script>\n      jQuery(document).ready(function(\$) {\n        \$('form#post').attr('enctype', 'multipart/form-data');\n      });\n    </script>\n    ";
        if ( !$file ) {
            $html .= "\n      <script>\n        jQuery(document).ready(function(\$) {\n          \$('#post').submit(function() {\n            if (\$('#shared-file-external-url').val().length == 0 && \$('#sf_file').prop('files').length == 0) {\n              alert('" . __( 'Please insert the file first or define an external URL.', 'shared-files' ) . "');\n              return false;\n            }\n          });\n        });\n      </script>\n      ";
        }
        echo  $html ;
    }
    
    /**
     * Serve the file itself and update necessary metadata.
     *
     * @since    1.0.0
     */
    public function alter_the_query( $request )
    {
        global  $wp ;
        $url = home_url( $wp->request );
        $sf_query = 0;
        $sf_sub = 0;
        $url_parts = parse_url( $url );
        if ( isset( $url_parts['path'] ) ) {
            $path_parts = explode( '/', $url_parts['path'] );
        }
        
        if ( isset( $path_parts[2] ) && $path_parts[2] == 'shared-files' ) {
            $sf_query = 1;
            $sf_sub = 1;
        } else {
            if ( isset( $path_parts[1] ) && $path_parts[1] == 'shared-files' ) {
                $sf_query = 1;
            }
        }
        
        
        if ( $sf_query ) {
            $file_id = 0;
            
            if ( $sf_sub ) {
                $file_id = ( isset( $path_parts[3] ) ? (int) $path_parts[3] : 0 );
            } else {
                $file_id = ( isset( $path_parts[2] ) ? (int) $path_parts[2] : 0 );
            }
            
            
            if ( $file_id ) {
                $password = get_post_meta( $file_id, '_sf_password', true );
                $given_password = ( isset( $_POST['password'] ) ? $_POST['password'] : '' );
                
                if ( $password && (!$given_password || $given_password != $password) ) {
                    echo  SharedFilesPublicViews::passwordProtectedMarkup() ;
                    die;
                }
                
                $external_url = esc_url_raw( get_post_meta( $file_id, '_sf_external_url', true ) );
                $this->file_load_send_email( $file_id, get_post( $file_id ) );
                
                if ( $external_url ) {
                    // Update load counter and last access
                    $load_cnt = (int) get_post_meta( $file_id, '_sf_load_cnt', true );
                    $load_limit = (int) get_post_meta( $file_id, '_sf_limit_downloads', true );
                    
                    if ( $load_limit && $load_cnt >= $load_limit ) {
                        $this->file_limit_send_email( $file_id, get_post( $file_id ) );
                        echo  SharedFilesPublicViews::downloadLimitMarkup() ;
                        die;
                    }
                    
                    update_post_meta( $file_id, '_sf_load_cnt', $load_cnt + 1 );
                    update_post_meta( $file_id, '_sf_last_access', current_time( 'Y-m-d H:i:s' ) );
                    header( 'Location: ' . $external_url );
                    die;
                } elseif ( $file = get_post_meta( $file_id, '_sf_file', true ) ) {
                    $filename = $file['file'];
                    $file_mime = mime_content_type( $filename );
                    // Update load counter, last access and bandwidth usage
                    $load_cnt = (int) get_post_meta( $file_id, '_sf_load_cnt', true );
                    $load_limit = (int) get_post_meta( $file_id, '_sf_limit_downloads', true );
                    
                    if ( $load_limit && $load_cnt >= $load_limit ) {
                        $this->file_limit_send_email( $file_id, get_post( $file_id ) );
                        echo  SharedFilesPublicViews::downloadLimitMarkup() ;
                        die;
                    }
                    
                    $bandwidth_usage = get_post_meta( $file_id, '_sf_bandwidth_usage', true );
                    $filesize = get_post_meta( $file_id, '_sf_filesize', true );
                    update_post_meta( $file_id, '_sf_load_cnt', $load_cnt + 1 );
                    update_post_meta( $file_id, '_sf_last_access', current_time( 'Y-m-d H:i:s' ) );
                    update_post_meta( $file_id, '_sf_bandwidth_usage', $bandwidth_usage + $filesize );
                    // Set headers
                    header( 'Content-type: ' . $file_mime );
                    readfile( $filename );
                    die;
                }
            
            }
        
        }
        
        return $request;
    }
    
    public function file_load_send_email( $post_id, $post )
    {
        $post_title = get_the_title( $post_id );
        $s = get_option( 'shared_files_settings' );
        
        if ( isset( $s['send_email'] ) && isset( $s['recipient_email'] ) && is_email( $s['recipient_email'] ) && $post->post_type == 'shared_file' ) {
            $headers = [ 'Content-Type: text/html; charset=UTF-8' ];
            $subject = 'File downloaded: ' . $post_title;
            $body_html = '';
            $body_html .= '<html><head><title></title></head><body>';
            $body_html .= '<h3 style="color: #000;">File was downloaded: ' . $post_title . '</h3>';
            $body_html .= '<p style="color: #bbb;">-- <br />This email was sent by Shared Files Pro</p>';
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
                    $id = get_the_id();
                    $c = get_post_custom( $id );
                    $filename = $c['_sf_filename'][0];
                    $post_title = get_the_title( $id ) . ' / ' . $filename;
                    $expiration_date = get_post_meta( $id, '_sf_expiration_date', true );
                    $expiration_date_formatted = '';
                    $expiration_date_alert = 0;
                    
                    if ( $expiration_date instanceof DateTime ) {
                        $dt_now = new DateTime( 'now' );
                        
                        if ( $expiration_date <= $dt_now ) {
                            $headers = [ 'Content-Type: text/html; charset=UTF-8' ];
                            $subject = 'File expired: ' . $post_title;
                            $body_html = '';
                            $body_html .= '<html><head><title></title></head><body>';
                            $body_html .= '<h3 style="color: #000;">File expired: ' . $post_title . '</h3>';
                            $body_html .= '<p style="color: #bbb;">-- <br />This email was sent by Shared Files Pro</p>';
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
    
    public function file_limit_send_email( $post_id, $post )
    {
        $post_title = get_the_title( $post_id );
        $s = get_option( 'shared_files_settings' );
        
        if ( isset( $s['recipient_email'] ) && is_email( $s['recipient_email'] ) && $post->post_type == 'shared_file' ) {
            $headers = [ 'Content-Type: text/html; charset=UTF-8' ];
            $subject = 'Download limit reached for ' . $post_title;
            $body_html = '';
            $body_html .= '<html><head><title></title></head><body>';
            $body_html .= '<h3 style="color: #000;">Download limit reached for ' . $post_title . '</h3>';
            $body_html .= '<p style="color: #bbb;">-- <br />This email was sent by Shared Files Pro</p>';
            $body_html .= '</body></html>';
            $resp = wp_mail(
                $s['recipient_email'],
                $subject,
                $body_html,
                $headers
            );
        }
    
    }
    
    /**
     * Create custom post type.
     *
     * @since    1.0.0
     */
    public function create_custom_post_type()
    {
        register_post_type( 'shared_file', [
            'labels'             => [
            'name'          => 'Shared Files',
            'singular_name' => __( 'File', 'shared-files' ),
            'add_new_item'  => __( 'Add New File', 'shared-files' ),
            'edit_item'     => __( 'Edit File', 'shared-files' ),
            'not_found'     => __( 'No files found.', 'shared-files' ),
            'all_items'     => __( 'File Management', 'shared-files' ),
            'add_new'       => __( 'Add New', 'shared-files' ),
        ],
            'public'             => true,
            'has_archive'        => false,
            'publicly_queryable' => false,
            'menu_icon'          => 'dashicons-index-card',
        ] );
        remove_post_type_support( 'shared_file', 'editor' );
        function human_filesize( $bytes, $decimals = 2 )
        {
            $size = array(
                'bytes',
                'KB',
                'MB',
                'GB',
                'TB',
                'PB',
                'EB',
                'ZB',
                'YB'
            );
            $factor = floor( (strlen( $bytes ) - 1) / 3 );
            return sprintf( "%.{$decimals}f", $bytes / pow( 1024, $factor ) ) . ' ' . @$size[$factor];
        }
    
    }
    
    /**
     * Custom columns for shared file.
     *
     * @since    1.0.0
     */
    public function shared_file_custom_columns( $defaults )
    {
        $s = get_option( 'shared_files_settings' );
        $defaults['file_url'] = __( 'Shortcode & URL', 'shared-files' );
        $defaults['filesize'] = __( 'File size', 'shared-files' );
        $defaults['load_cnt'] = __( 'File loads', 'shared-files' );
        if ( !isset( $s['hide_limit_downloads'] ) ) {
            $defaults['limit_downloads'] = __( 'Limit downloads', 'shared-files' );
        }
        if ( !isset( $s['hide_file_added'] ) ) {
            $defaults['file_added'] = __( 'File added', 'shared-files' );
        }
        if ( !isset( $s['hide_last_access'] ) ) {
            $defaults['last_access'] = __( 'Last access', 'shared-files' );
        }
        if ( !isset( $s['hide_bandwidth_usage'] ) ) {
            $defaults['bandwidth_usage'] = __( 'Bandwidth usage (estimate)', 'shared-files' );
        }
        if ( !isset( $s['hide_expiration_date'] ) ) {
            $defaults['expiration_date'] = __( 'Expiration date', 'shared-files' );
        }
        return $defaults;
    }
    
    public function set_custom_shared_files_sortable_columns( $columns )
    {
        $columns['taxonomy-shared-file-category'] = 'shared-file-category';
        $columns['expiration_date'] = '_sf_expiration_date';
        $columns['file_added'] = '_sf_file_added';
        $columns['last_access'] = '_sf_last_access';
        $columns['load_cnt'] = '_sf_load_cnt';
        $columns['limit_downloads'] = '_sf_limit_downloads';
        $columns['filesize'] = '_sf_filesize';
        return $columns;
    }
    
    public function sort_posts_by_meta_value( $query )
    {
        if ( !is_admin() || !$query->is_main_query() ) {
            return;
        }
        global  $pagenow ;
        if ( is_admin() && $pagenow == 'edit.php' && isset( $_GET['post_type'] ) && $_GET['post_type'] == 'shared_file' && isset( $_GET['orderby'] ) && $_GET['orderby'] != 'None' ) {
            
            if ( $_GET['orderby'] == '_sf_expiration_date' ) {
                $query->query_vars['orderby'] = 'meta_value';
                $query->query_vars['meta_key'] = $_GET['orderby'];
            } elseif ( $_GET['orderby'] == '_sf_file_added' ) {
                $query->query_vars['orderby'] = 'meta_value';
                $query->query_vars['meta_key'] = $_GET['orderby'];
                $query->query_vars['meta_type'] = 'DATETIME';
            } elseif ( $_GET['orderby'] == '_sf_last_access' ) {
                $query->query_vars['orderby'] = 'meta_value';
                $query->query_vars['meta_key'] = $_GET['orderby'];
                $query->query_vars['meta_type'] = 'DATETIME';
            } elseif ( $_GET['orderby'] == '_sf_load_cnt' ) {
                $query->query_vars['orderby'] = 'meta_value';
                $query->query_vars['meta_key'] = $_GET['orderby'];
                $query->query_vars['meta_type'] = 'numeric';
            } elseif ( $_GET['orderby'] == '_sf_limit_downloads' ) {
                $query->query_vars['orderby'] = 'meta_value';
                $query->query_vars['meta_key'] = $_GET['orderby'];
                $query->query_vars['meta_type'] = 'numeric';
            } elseif ( $_GET['orderby'] == '_sf_filesize' ) {
                $query->query_vars['orderby'] = 'meta_value';
                $query->query_vars['meta_key'] = $_GET['orderby'];
                $query->query_vars['meta_type'] = 'numeric';
            }
        
        }
    }
    
    /**
     * Custom column content for shared file.
     *
     * @since    1.0.0
     */
    public function shared_file_custom_columns_content( $column_name, $post_ID )
    {
        switch ( $column_name ) {
            case 'file_url':
                echo  '<span class="shared-files-shortcode">[shared_files file_id=' . $post_ID . ']</span>' ;
                $file = get_post_meta( get_the_ID(), '_sf_file', true );
                $file_url = $this->sf_root() . '/shared-files/' . $post_ID . '/' . get_post_meta( $post_ID, '_sf_filename', true );
                echo  '<a href="' . $file_url . '" target="_blank">' . $file_url . '</a>' ;
                break;
            case 'filesize':
                
                if ( get_post_meta( $post_ID, '_sf_external_url', true ) ) {
                    echo  'n/a' ;
                } else {
                    echo  $this->human_filesize( get_post_meta( $post_ID, '_sf_filesize', true ) ) ;
                }
                
                break;
            case 'load_cnt':
                echo  '<div class="shared-files-pro-only">' . __( 'Pro' ) . '</div>' ;
                break;
            case 'limit_downloads':
                echo  '<div class="shared-files-pro-only">' . __( 'Pro' ) . '</div>' ;
                break;
            case 'file_added':
                echo  get_post_meta( $post_ID, '_sf_file_added', true ) ;
                break;
            case 'last_access':
                echo  '<div class="shared-files-pro-only">' . __( 'Pro' ) . '</div>' ;
                break;
            case 'bandwidth_usage':
                echo  '<div class="shared-files-pro-only">' . __( 'Pro' ) . '</div>' ;
                break;
            case 'expiration_date':
                echo  '<div class="shared-files-pro-only">' . __( 'Pro' ) . '</div>' ;
                break;
        }
    }
    
    function filter_files_by_taxonomies( $post_type, $which )
    {
        // Apply this only on a specific post type
        if ( $post_type !== 'shared_file' ) {
            return;
        }
        $taxonomy_slug = 'shared-file-category';
        $current_category_slug = ( isset( $_GET['shared-file-category'] ) ? $_GET['shared-file-category'] : '' );
        if ( get_taxonomy( $taxonomy_slug ) ) {
            wp_dropdown_categories( [
                'show_option_all' => get_taxonomy( $taxonomy_slug )->labels->all_items,
                'hide_empty'      => 1,
                'hierarchical'    => 1,
                'show_count'      => 1,
                'orderby'         => 'name',
                'name'            => $taxonomy_slug,
                'value_field'     => 'slug',
                'taxonomy'        => $taxonomy_slug,
                'selected'        => $current_category_slug,
            ] );
        }
    }
    
    /**
     * Provide the file size in human readable form.
     *
     * @since    1.0.0
     */
    public function human_filesize( $bytes, $decimals = 2 )
    {
        $size = array(
            'bytes',
            'KB',
            'MB',
            'GB',
            'TB',
            'PB',
            'EB',
            'ZB',
            'YB'
        );
        $factor = floor( (strlen( $bytes ) - 1) / 3 );
        return ( $bytes ? sprintf( "%.{$decimals}f", $bytes / pow( 1024, $factor ) ) . ' ' . @$size[$factor] : 0 );
    }
    
    public function sf_root()
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
    
    public function create_shared_files_custom_taxonomy()
    {
        $labels = array(
            'name'              => __( 'Category', 'shared-files' ),
            'singular_name'     => __( 'Category', 'shared-files' ),
            'search_items'      => __( 'Search Categories', 'shared-files' ),
            'all_items'         => __( 'All Categories', 'shared-files' ),
            'parent_item'       => __( 'Parent Category', 'shared-files' ),
            'parent_item_colon' => __( 'Parent Category:', 'shared-files' ),
            'edit_item'         => __( 'Edit Category', 'shared-files' ),
            'update_item'       => __( 'Update Category', 'shared-files' ),
            'add_new_item'      => __( 'Add New Category', 'shared-files' ),
            'new_item_name'     => __( 'New Type Name', 'shared-files' ),
            'menu_name'         => __( 'Categories', 'shared-files' ),
        );
    }
    
    /**
     * Save the user submitted file itself and it's metadata.
     *
     * @since    1.0.0
     */
    public function save_custom_meta_data( $id )
    {
        
        if ( !empty($_FILES) ) {
            /* --- security verification --- */
            if ( !isset( $_POST['_sf_file_nonce'] ) || !wp_verify_nonce( $_POST['_sf_file_nonce'], plugin_basename( __FILE__ ) ) ) {
                return $id;
            }
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return $id;
            }
            
            if ( $_POST['post_type'] == 'page' ) {
                if ( !current_user_can( 'edit_page', $id ) ) {
                    return $id;
                }
            } else {
                if ( !current_user_can( 'edit_page', $id ) ) {
                    return $id;
                }
            }
            
            /* - end security verification - */
            $limit_downloads = '';
            
            if ( isset( $_POST['_sf_limit_downloads'] ) ) {
                $limit_downloads = (int) $_POST['_sf_limit_downloads'];
                if ( $limit_downloads == 0 ) {
                    $limit_downloads = '';
                }
            }
            
            $expiration_date = '';
            
            if ( isset( $_POST['_sf_expiration_date'] ) ) {
                $dt = DateTime::createFromFormat( "Y-m-d", $_POST['_sf_expiration_date'] );
                if ( $dt !== false && !array_sum( $dt::getLastErrors() ) ) {
                    $expiration_date = $dt;
                }
            }
            
            update_post_meta( $id, '_sf_limit_downloads', $limit_downloads );
            update_post_meta( $id, '_sf_expiration_date', $expiration_date );
            //      update_post_meta($id, '_sf_expiration_date', isset($_POST['_sf_expiration_date']) ? (int) $_POST['_sf_expiration_date'] : '');
            update_post_meta( $id, '_sf_password', ( isset( $_POST['_sf_password'] ) ? $_POST['_sf_password'] : '' ) );
            
            if ( $_POST['_sf_description'] ) {
                $description = balanceTags( wp_kses_post( $_POST['_sf_description'] ), 1 );
                update_post_meta( $id, '_sf_description', $description );
            } else {
                update_post_meta( $id, '_sf_description', '' );
            }
            
            
            if ( $_POST['_sf_external_url'] ) {
                $external_url = esc_url_raw( $_POST['_sf_external_url'] );
                update_post_meta( $id, '_sf_external_url', $external_url );
                $filename = basename( $external_url );
                update_post_meta( $id, '_sf_filename', $filename );
                update_post_meta( $id, '_sf_load_cnt', 0 );
                update_post_meta( $id, '_sf_bandwidth_usage', 0 );
                update_post_meta( $id, '_sf_file_added', current_time( 'Y-m-d H:i:s' ) );
            } elseif ( !empty($_FILES['_sf_file']['name']) ) {
                // Get the file type of the upload
                $arr_file_type = wp_check_filetype( basename( $_FILES['_sf_file']['name'] ) );
                $uploaded_type = $arr_file_type['type'];
                add_filter( 'upload_dir', [ $this, 'set_upload_dir' ] );
                // Use the WordPress API to upload the file
                $upload = wp_upload_bits( $_FILES['_sf_file']['name'], null, file_get_contents( $_FILES['_sf_file']['tmp_name'] ) );
                if ( $upload['error'] ) {
                    wp_die( $upload['error'] );
                }
                remove_filter( 'upload_dir', [ $this, 'set_upload_dir' ] );
                
                if ( isset( $upload['error'] ) && $upload['error'] != 0 ) {
                    wp_die( 'There was an error uploading your file. The error is: ' . $upload['error'] );
                } else {
                    add_post_meta( $id, '_sf_file', $upload );
                    update_post_meta( $id, '_sf_file', $upload );
                    $filename = substr( strrchr( $upload['file'], "/" ), 1 );
                    update_post_meta( $id, '_sf_filename', $filename );
                    update_post_meta( $id, '_sf_filesize', $_FILES['_sf_file']['size'] );
                    update_post_meta( $id, '_sf_load_cnt', 0 );
                    update_post_meta( $id, '_sf_bandwidth_usage', 0 );
                    update_post_meta( $id, '_sf_file_added', current_time( 'Y-m-d H:i:s' ) );
                    $post_title = $_POST['post_title'];
                    
                    if ( !$post_title ) {
                        $my_post = array(
                            'ID'         => $id,
                            'post_title' => $filename,
                        );
                        remove_action( 'save_post', [ $this, 'save_custom_meta_data' ] );
                        wp_update_post( $my_post );
                        add_action( 'save_post', [ $this, 'save_custom_meta_data' ] );
                    } else {
                        $my_post = array(
                            'ID'        => $id,
                            'post_name' => $id,
                        );
                        remove_action( 'save_post', [ $this, 'save_custom_meta_data' ] );
                        wp_update_post( $my_post );
                        add_action( 'save_post', [ $this, 'save_custom_meta_data' ] );
                    }
                
                }
            
            }
        
        }
    
    }
    
    /**
     * Set the custom upload directory.
     *
     * @since    1.0.0
     */
    public function set_upload_dir( $dir )
    {
        return array(
            'path'   => $dir['basedir'] . '/shared-files',
            'url'    => $dir['baseurl'] . '/shared-files',
            'subdir' => '/shared-files',
        ) + $dir;
    }
    
    /**
     * Set the file itself when permanentyly deleting post.
     *
     * @since    1.0.0
     */
    function delete_shared_file( $post_id )
    {
        $file = get_post_meta( $post_id, '_sf_file', true );
        if ( isset( $file['file'] ) && file_exists( $file['file'] ) ) {
            unlink( $file['file'] );
        }
    }
    
    public function register_categories_info_page()
    {
        add_submenu_page(
            'edit.php?post_type=shared_file',
            __( 'Categories', 'shared-files' ),
            __( 'Categories', 'shared-files' ),
            'manage_options',
            'shared-files-categories-info',
            [ $this, 'register_categories_info_page_callback' ]
        );
    }
    
    public function register_support_page()
    {
        add_submenu_page(
            'edit.php?post_type=shared_file',
            __( 'How to use Shared Files', 'shared-files' ),
            __( 'Help / Support', 'shared-files' ),
            'manage_options',
            'shared-files-support',
            [ $this, 'register_support_page_callback' ]
        );
    }
    
    public function add_settings_link()
    {
        global  $submenu ;
        $permalink = './options-general.php?page=shared-files';
        $submenu['edit.php?post_type=shared_file'][] = array( __( 'Settings&nbsp;&nbsp;➤', 'shared-files' ), 'manage_options', $permalink );
    }
    
    public function add_upgrade_link()
    {
        global  $submenu ;
        $permalink = './options-general.php?page=shared-files-pricing';
        $submenu['edit.php?post_type=shared_file'][] = array(
            __( 'Upgrade&nbsp;&nbsp;➤', 'shared-files' ),
            'manage_options',
            $permalink,
            '',
            'shared-files-upgrade'
        );
    }
    
    public function register_categories_info_page_callback()
    {
        ?>

    <div class="wrap">
      <h1><?php 
        echo  __( 'Categories', 'shared-files' ) ;
        ?></h1>

      <?php 
        echo  SharedFilesAdminViews::sfProFeatureMarkup() ;
        ?>

    </div>
    <?php 
    }
    
    public function sort_by_custom_taxonomy( $clauses, $wp_query )
    {
        global  $wpdb ;
        
        if ( isset( $wp_query->query['orderby'] ) && $wp_query->query['orderby'] == 'shared-file-category' ) {
            $clauses['join'] .= "\n        LEFT OUTER JOIN {$wpdb->term_relationships} ON {$wpdb->posts}.ID={$wpdb->term_relationships}.object_id\n        LEFT OUTER JOIN {$wpdb->term_taxonomy} USING (term_taxonomy_id)\n        LEFT OUTER JOIN {$wpdb->terms} USING (term_id)\n        ";
            $clauses['where'] .= " AND (taxonomy = 'shared-file-category' OR taxonomy IS NULL)";
            $clauses['groupby'] = "object_id";
            $clauses['orderby'] = "GROUP_CONCAT({$wpdb->terms}.name ORDER BY name ASC) ";
            $clauses['orderby'] .= ( 'ASC' == strtoupper( $wp_query->get( 'order' ) ) ? 'ASC' : 'DESC' );
        }
        
        return $clauses;
    }
    
    public function update_db_check()
    {
        //    wp_clear_scheduled_hook('check_expired_files');
        if ( !wp_next_scheduled( 'check_expired_files' ) ) {
            wp_schedule_event( time(), 'daily', 'check_expired_files' );
        }
    }
    
    public function register_support_page_callback()
    {
        ?>

    <div class="wrap">
      <h1><?php 
        echo  __( 'How to use Shared Files', 'shared-files' ) ;
        ?></h1>
      <div class="shared-files-examples">
        <p><?php 
        echo  __( 'Some examples on how you can use different views available at', 'shared-files' ) ;
        ?> <a href="https://www.sharedfilespro.com/shared-files/" target="_blank"><?php 
        echo  __( 'sharedfilespro.com', 'shared-files' ) ;
        ?></a>.</p>
        <p><?php 
        echo  __( 'Any feedback is welcome. You may contact the author at', 'shared-files' ) . ' <a href="https://anssilaitila.fi/" target="_blank">anssilaitila.fi</a> ' . __( 'or by email:', 'shared-files' ) . ' <a href="mailto:&#97;&#110;&#115;&#115;&#105;&#46;&#108;&#97;&#105;&#116;&#105;&#108;&#97;&#64;&#103;&#109;&#97;&#105;&#108;&#46;&#99;&#111;&#109;">&#97;&#110;&#115;&#115;&#105;&#46;&#108;&#97;&#105;&#116;&#105;&#108;&#97;&#64;&#103;&#109;&#97;&#105;&#108;&#46;&#99;&#111;&#109;</a>' ;
        ?></p>
      </div>
      <ol>
        <li><?php 
        echo  __( 'Add the files via the File Management page', 'shared-files' ) ;
        ?></li>
        <li><?php 
        echo  __( 'Choose one of the following methods:', 'shared-files' ) ;
        ?>
          <ul style="list-style: disc; padding-left: 20px; padding-top: 8px;">
            <li><b><?php 
        echo  __( 'List all the files:', 'shared-files' ) ;
        ?></b><br /><?php 
        echo  __( 'Insert the shortcode', 'shared-files' ) ;
        ?> <span class="shared-files-shortcode">[shared_files]</span> <?php 
        echo  __( 'to the content editor of any page you wish the file list to appear. If there are more than one category, a dropdown of categories will appear above the file list.', 'shared-files' ) ;
        ?>
              <ul class="shared-files-help-list-level-2">
                <li><?php 
        echo  __( 'Using the parameter hide_search you may hide the search form like so:', 'shared-files' ) ;
        ?> <span class="shared-files-shortcode">[shared_files hide_search=1]</span></li>
                <li><?php 
        echo  __( 'More additional parameters:', 'shared-files' ) ;
        ?>

                  <?php 
        ?>
                    <a href="<?php 
        echo  get_admin_url() ;
        ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">Pro</a>
                  <?php 
        ?>

                  <ul class="shared-files-help-list-level-3">
                    <li><?php 
        echo  __( 'Hide file description:', 'shared-files' ) ;
        ?> <span class="shared-files-shortcode">[shared_files hide_description=1]</li>
                    <li><?php 
        echo  __( 'Layout as "2 cards on the same row":', 'shared-files' ) ;
        ?> <span class="shared-files-shortcode">[shared_files layout=2-cards-on-the-same-row]</li>
                    <li><?php 
        echo  __( 'Layout as "3 cards on the same row":', 'shared-files' ) ;
        ?> <span class="shared-files-shortcode">[shared_files layout=3-cards-on-the-same-row]</li>
                    <li><?php 
        echo  __( 'Layout as "4 cards on the same row":', 'shared-files' ) ;
        ?> <span class="shared-files-shortcode">[shared_files layout=4-cards-on-the-same-row]</li>
                    <li><?php 
        echo  __( 'You can also use multiple parameters:', 'shared-files' ) ;
        ?> <span class="shared-files-shortcode">[shared_files layout=2-cards-on-the-same-row hide_description=1]</li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><b><?php 
        echo  __( 'Search form only that targets all the files, sorted by category', 'shared-files' ) ;
        ?></b>
            
            <?php 
        ?>
              <a href="<?php 
        echo  get_admin_url() ;
        ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">Pro</a>
            <?php 
        ?>
            
            <br /><?php 
        echo  __( 'Insert the shortcode', 'shared-files' ) ;
        ?> <span class="shared-files-shortcode">[shared_files_search]</span></li>
            <li><b><?php 
        echo  __( 'List only files in certain category:', 'shared-files' ) ;
        ?></b> 

            <?php 
        ?>
              <a href="<?php 
        echo  get_admin_url() ;
        ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">Pro</a>
            <?php 
        ?>

            <br /><?php 
        echo  __( 'Insert the shortcode', 'shared-files' ) ;
        ?> <span class="shared-files-shortcode">[shared_files category="category_slug"]</span>. <?php 
        echo  __( 'You can find / define the category slug by editing the category.', 'shared-files' ) ;
        ?></li>
            <li><b><?php 
        echo  __( 'List categories / list files by category:', 'shared-files' ) ;
        ?></b> 
            
            <?php 
        ?>
              <a href="<?php 
        echo  get_admin_url() ;
        ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">Pro</a>
            <?php 
        ?>
            
            <br /><?php 
        echo  __( 'Insert the shortcode', 'shared-files' ) ;
        ?> <span class="shared-files-shortcode">[shared_files_categories]</span> <?php 
        echo  __( 'or', 'shared-files' ) ;
        ?> <span class="shared-files-shortcode">[shared_files_categories category="category_slug"]</span>. <?php 
        echo  __( 'You can find / define the category slug by editing the category.', 'shared-files' ) ;
        ?></li>
            <li><b><?php 
        echo  __( 'List a single file:', 'shared-files' ) ;
        ?></b>

            <?php 
        ?>
              <a href="<?php 
        echo  get_admin_url() ;
        ?>options-general.php?page=shared-files-pricing" class="shared-files-pro-only-inline">Pro</a>
            <?php 
        ?>
            
            <br /><?php 
        echo  __( 'Insert the shortcode', 'shared-files' ) ;
        ?> <span class="shared-files-shortcode">[shared_files file_id=12345]</span>. <?php 
        echo  __( 'The file_id parameter is unique for each file and can be found under the Shortcode column in File Management page.', 'shared-files' ) ;
        ?></li>
          </ul>
        </li>
      </ol>

      <hr class="style-one" />

      <h2><?php 
        echo  __( 'Give a rating for the plugin', 'shared-files' ) ;
        ?></h2>
      <p><?php 
        echo  __( "Whether it's 1 star or 5 stars, I'm grateful for your rating. You may rate the plugin", 'shared-files' ) ;
        ?> <a href="https://wordpress.org/support/plugin/shared-files/reviews/" target="_blank"><?php 
        echo  __( 'here', 'shared-files' ) ;
        ?></a>.</p>

    </div>
    <?php 
    }

}