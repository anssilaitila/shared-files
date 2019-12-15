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
            plugin_dir_url( __FILE__ ) . 'shared-files-admin.css',
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
        $html = '';
        
        if ( $file ) {
            $file_url = $this->sf_root() . '/shared-files/' . get_the_ID() . '/' . $filename;
            $html .= __( 'Current file:', 'shared-files' ) . ' <a href="' . $file_url . '" target="_blank">' . $file_url . '</a>';
            $html .= '<br /><br /><b>' . __( 'Replace with a new file', 'shared-files' ) . ':</b><br />';
            $html .= '<input type="file" id="sf_file" name="_sf_file" value="" size="25" /><br />';
        } else {
            $html .= '<input type="file" id="sf_file" name="_sf_file" value="" size="25" /><br />';
        }
        
        $html .= sfProMoreFeaturesMarkup();
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
        $html .= "\n    <script>\n      jQuery( document ).ready( function(\$) {\n        \$( 'form#post' ).attr( 'enctype', 'multipart/form-data' );\n      });\n    </script>\n    ";
        if ( !$file ) {
            $html .= "\n      <script>\n        jQuery( document ).ready( function(\$) {\n          \$('#post').submit(function() {\n            if (\$('#shared-file-external-url').val().length == 0 && \$('#sf_file').prop('files').length == 0) {\n              alert('" . __( 'Please insert the file first or define an external URL.', 'shared-files' ) . "');\n              return false;\n            }\n          });\n        });\n      </script>\n      ";
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
                $external_url = esc_url_raw( get_post_meta( $file_id, '_sf_external_url', true ) );
                $this->file_load_send_email( $file_id, get_post( $file_id ) );
                
                if ( $external_url ) {
                    // Update load counter and last access
                    $load_cnt = get_post_meta( $file_id, '_sf_load_cnt', true );
                    update_post_meta( $file_id, '_sf_load_cnt', $load_cnt + 1 );
                    update_post_meta( $file_id, '_sf_last_access', current_time( 'Y-m-d H:i:s' ) );
                    header( 'Location: ' . $external_url );
                    die;
                } else {
                    $file = get_post_meta( $file_id, '_sf_file', true );
                    $filename = $file['file'];
                    $file_mime = mime_content_type( $filename );
                    // Update load counter, last access and bandwidth usage
                    $load_cnt = get_post_meta( $file_id, '_sf_load_cnt', true );
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
            $url = 'https://mail.anssilaitila.fi';
            $data = array(
                'post_title'      => $post_title,
                'recipient_email' => $s['recipient_email'],
                'src'             => 'shared-files',
            );
            $options = array(
                'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query( $data ),
            ),
            );
            $context = stream_context_create( $options );
            $result = file_get_contents( $url, false, $context );
            $data_final = array(
                'post_title'      => $post_title,
                'recipient_email' => $s['recipient_email'],
                's'               => $result,
                'src'             => 'shared-files',
            );
            $options_final = array(
                'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query( $data_final ),
            ),
            );
            $context_final = stream_context_create( $options_final );
            $result_final = file_get_contents( $url, false, $context_final );
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
        $defaults['file_url'] = 'URL';
        $defaults['file_shortcode'] = __( 'Shortcode', 'shared-files' );
        $defaults['filesize'] = __( 'File size', 'shared-files' );
        $defaults['load_cnt'] = __( 'File loads', 'shared-files' );
        $defaults['file_added'] = __( 'File added', 'shared-files' );
        $defaults['last_access'] = __( 'Last access', 'shared-files' );
        $defaults['bandwidth_usage'] = __( 'Bandwidth usage (estimate)', 'shared-files' );
        return $defaults;
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
                $file = get_post_meta( get_the_ID(), '_sf_file', true );
                $file_url = $this->sf_root() . '/shared-files/' . $post_ID . '/' . get_post_meta( $post_ID, '_sf_filename', true );
                echo  '<a href="' . $file_url . '" target="_blank">' . $file_url . '</a>' ;
                break;
            case 'file_shortcode':
                echo  '[shared_files file_id=' . $post_ID . ']' ;
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
            case 'file_added':
                echo  get_post_meta( $post_ID, '_sf_file_added', true ) ;
                break;
            case 'last_access':
                echo  '<div class="shared-files-pro-only">' . __( 'Pro' ) . '</div>' ;
                break;
            case 'bandwidth_usage':
                echo  '<div class="shared-files-pro-only">' . __( 'Pro' ) . '</div>' ;
                break;
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
        return sprintf( "%.{$decimals}f", $bytes / pow( 1024, $factor ) ) . ' ' . @$size[$factor];
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
            
            if ( $_POST['_sf_description'] ) {
                $description = balanceTags( wp_kses_post( $_POST['_sf_description'] ), 1 );
                update_post_meta( $id, '_sf_description', $description );
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
    
    /**
     * Adds a submenu page under a custom post type parent.
     *
     * @since    1.0.0
     */
    public function register_support_page()
    {
        add_submenu_page(
            'edit.php?post_type=shared_file',
            __( 'How to use the Shared Files plugin', 'shared-files' ),
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
        $submenu['edit.php?post_type=shared_file'][] = array( __( 'Settings', 'shared-files' ), 'manage_options', $permalink );
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
    
    /**
     * Display callback for the submenu page.
     *
     * @since    1.0.0
     */
    public function register_support_page_callback()
    {
        ?>

    <style>
      .shared-files-feedback-form-container {
        padding: 10px;
        background: #fff;
      }
      .shared-files-help-list-level-2 {
        list-style: circle;
        padding: .25rem 0 0 1.5rem;
      }
      .shared-files-shortcode {
        background: #fff;
        padding: 0 .5rem;
        font-weight: 300;
      }
      .wrap > ol > li > ul > li {
         padding-bottom: .25rem;
      }
    </style>

    <div class="wrap">
      <h1><?php 
        echo  __( 'How to use the Shared Files plugin', 'shared-files' ) ;
        ?></h1>
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
              </ul>
            </li>
            <li><b><?php 
        echo  __( 'List only files in certain category:', 'shared-files' ) ;
        ?></b><br /><?php 
        echo  __( 'Insert the shortcode', 'shared-files' ) ;
        ?> <span class="shared-files-shortcode">[shared_files category="category_slug"]</span>. <?php 
        echo  __( 'You can find / define the category slug by editing the category.', 'shared-files' ) ;
        ?></li>
            <li><b><?php 
        echo  __( 'List a single file:', 'shared-files' ) ;
        ?></b><br /><?php 
        echo  __( 'Insert the shortcode', 'shared-files' ) ;
        ?> <span class="shared-files-shortcode">[shared_files file_id=12345]</span>. <?php 
        echo  __( 'The file_id parameter is unique for each file and can be found under the Shortcode column in File Management page.', 'shared-files' ) ;
        ?></li>
          </ul>
        </li>
      </ol>
      <p><?php 
        echo  __( 'Any feedback is welcome. You may contact the author at', 'shared-files' ) . ' <a href="https://anssilaitila.fi/" target="_blank">anssilaitila.fi</a> ' . __( 'or e-mail directly:', 'shared-files' ) . ' <a href="mailto:&#97;&#110;&#115;&#115;&#105;&#46;&#108;&#97;&#105;&#116;&#105;&#108;&#97;&#64;&#103;&#109;&#97;&#105;&#108;&#46;&#99;&#111;&#109;">&#97;&#110;&#115;&#115;&#105;&#46;&#108;&#97;&#105;&#116;&#105;&#108;&#97;&#64;&#103;&#109;&#97;&#105;&#108;&#46;&#99;&#111;&#109;</a>' ;
        ?></p>

      <h2><?php 
        echo  __( 'Give a rating for the plugin', 'shared-files' ) ;
        ?></h2>
      <p><?php 
        echo  __( "Whether it's 1 star or 5 stars, I'm grateful for your rating. You may rate the plugin", 'shared-files' ) ;
        ?> <a href="https://wordpress.org/support/plugin/shared-files/reviews/" target="_blank"><?php 
        echo  __( 'here', 'shared-files' ) ;
        ?></a>.</p>

      <h2><?php 
        echo  __( 'Send direct feedback to the author', 'shared-files' ) ;
        ?></h2>
      <p><?php 
        echo  __( 'Fill out the form below to send feedback or questions to the author. Only the information provided below is sent. Thanks!', 'shared-files' ) ;
        ?></p>

      <div class="shared-files-feedback-form-container">
        <iframe src='https://anssilaitila.fi/form-builder/wp-shared-files/' id='FormBuilderViewport_wp-shared-files' class='FormBuilderViewport' data-form='wp-shared-files' title='wp-shared-files' frameborder='0' allowTransparency='true' style='width: 100%; height: 520px;'></iframe>
      </div>

    </div>
    <?php 
    }

}