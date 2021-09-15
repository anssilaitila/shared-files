<?php

class SharedFilesAdminSyncFiles
{
    public function register_page()
    {
        $menu_pos = 3;
        if ( SharedFilesHelpers::isPremium() == 1 ) {
            $menu_pos = 4;
        }
        add_submenu_page(
            'edit.php?post_type=shared_file',
            sanitize_text_field( __( 'Sync Files', 'shared-files' ) ),
            sanitize_text_field( __( 'Sync Files', 'shared-files' ) ),
            'manage_options',
            'shared-files-sync-files',
            [ $this, 'register_page_callback' ],
            $menu_pos
        );
    }
    
    public function register_page_callback()
    {
        ?>
    
    <div class="shared-files-sync-files">
      <h1><?php 
        echo  esc_html__( 'Sync Files', 'shared-files' ) ;
        ?></h1>

      <?php 
        if ( SharedFilesHelpers::isPremium() == 0 ) {
            echo  SharedFilesAdminHelpers::sfProFeatureMarkup() ;
        }
        ?>

      <?php 
        $path = SharedFilesFileHandling::getBaseDir();
        ?>

      <p>
        <?php 
        echo  esc_html__( 'You may transfer many files at once using FTP to the folder mentioned below, and then sync the files here so they will be usable by the plugin.', 'shared-files' ) ;
        ?>
      </p>

      <p>
        <?php 
        echo  esc_html__( 'If a file is inactive, it means that it exists on the server, but has not yet been activated for the plugin.', 'shared-files' ) ;
        ?>
      </p>

      <p>

        <form method="post">
          
          <?php 
        $taxonomy_slug = 'shared-file-category';
        ?>
        
          <?php 
        
        if ( get_taxonomy( $taxonomy_slug ) ) {
            ?>
  
            <span class="shared-files-category-for-new-files"><?php 
            echo  esc_html__( 'Category for new files:', 'shared-files' ) ;
            ?></span>
  
            <?php 
            echo  wp_dropdown_categories( [
                'show_option_all' => ' ',
                'hide_empty'      => 0,
                'hierarchical'    => 1,
                'show_count'      => 1,
                'orderby'         => 'name',
                'name'            => $taxonomy_slug,
                'value_field'     => 'slug',
                'taxonomy'        => $taxonomy_slug,
                'echo'            => 0,
                'class'           => 'select_v2',
                'show_option_all' => sanitize_text_field( __( 'Choose category', 'shared-files' ) ),
            ] ) ;
            ?><br />
            
          <?php 
        }
        
        ?>
  
          <?php 
        wp_nonce_field( 'sf-sync-files', 'sf-sync-files-nonce' );
        ?>

          <input type="hidden" name="shared-files-op" value="sync-files" />
          <input type="hidden" name="add_file" value="all_files" />
  
          <input type="submit" class="shared-files-activate <?php 
        echo  ( SharedFilesHelpers::isPremium() == 0 ? 'shared-files-pro-required' : '' ) ;
        ?>" value="<?php 
        echo  esc_html__( 'Activate all inactive files', 'shared-files' ) ;
        ?>" />
        
        </form>
      </p>

      <p>
        <?php 
        echo  esc_html__( 'Files found on the server at', 'shared-files' ) ;
        ?>
        <span class="shared-files-path"><?php 
        echo  esc_html( $path ) ;
        ?></span>:
      </p>

      <?php 
        
        if ( isset( $_GET['files'] ) && $_GET['files'] == 'error' ) {
            echo  '<p class="shared-files-error">' . esc_html__( 'Error processing file(s).', 'shared-files' ) . '</p>' ;
        } elseif ( isset( $_GET['files'] ) ) {
            $num = (int) $_GET['files'];
            
            if ( $num == 1 ) {
                echo  '<p class="shared-files-files-activated">' . esc_attr( $num ) . ' ' . esc_html__( 'file activated.', 'shared-files' ) . '</p>' ;
            } else {
                echo  '<p class="shared-files-files-activated">' . esc_attr( $num ) . ' ' . esc_html__( 'files activated.', 'shared-files' ) . '</p>' ;
            }
        
        }
        
        echo  '<table>' ;
        echo  '<tr><th>' . esc_html__( 'Filename', 'shared-files' ) . '</th><th>' . esc_html__( 'File size', 'shared-files' ) . '</th><th>' . esc_html__( 'Last modified', 'shared-files' ) . '</th><th>' . esc_html__( 'Status', 'shared-files' ) . '</th></tr>' ;
        $files = array_diff( scandir( $path ), array( '.', '..' ) );
        foreach ( $files as $file ) {
            $item = SharedFilesFileHandling::getBaseDir() . $file;
            
            if ( $file == 'index.php' ) {
                continue;
            } elseif ( is_dir( $item ) ) {
                $files_in_subdir = array_diff( scandir( $item ), array( '.', '..' ) );
                foreach ( $files_in_subdir as $file_in_subdir ) {
                    $sub_item = $item . '/' . $file_in_subdir;
                    $this::getFileRow( $file_in_subdir, $sub_item );
                }
            } else {
                $this::getFileRow( $file, $item );
            }
        
        }
        echo  '</table>' ;
        ?>

    </div>
    <?php 
    }
    
    private static function getFileRow( $file, $item )
    {
        $item_array = explode( '/', $item );
        $item_array_sliced = array_slice( $item_array, -2, 2 );
        $subdir = '';
        
        if ( is_array( $item_array_sliced ) && $item_array_sliced[0] == 'shared-files' ) {
            \array_splice( $item_array_sliced, 0, 1 );
        } elseif ( is_array( $item_array_sliced ) ) {
            $subdir = $item_array_sliced[0];
        }
        
        echo  '<tr>' ;
        echo  '<td>' . esc_html( implode( '/', $item_array_sliced ) ) . '</td>' ;
        echo  '<td>' . esc_html( SharedFilesFileHandling::human_filesize( filesize( $item ) ) ) . '</td>' ;
        echo  '<td>' . esc_html( date( "Y-m-d", filemtime( $item ) ) ) . '</td>' ;
        echo  '<td>' ;
        $meta_query = array(
            'relation' => 'AND',
        );
        $meta_query[] = array(
            'key'     => '_sf_filename',
            'compare' => '=',
            'value'   => $file,
        );
        
        if ( $subdir ) {
            $meta_query[] = array(
                'key'     => '_sf_subdir',
                'compare' => '=',
                'value'   => $subdir,
            );
        } else {
            $meta_query[] = array(
                'key'     => '_sf_subdir',
                'compare' => 'NOT EXISTS',
                'value'   => '',
            );
        }
        
        $wp_query = new WP_Query( array(
            'post_type'      => 'shared_file',
            'post_status'    => 'publish',
            'posts_per_page' => 1,
            'meta_query'     => $meta_query,
        ) );
        
        if ( $wp_query->have_posts() ) {
            while ( $wp_query->have_posts() ) {
                $wp_query->the_post();
                $id = intval( get_the_id() );
                $c = get_post_custom( $id );
                echo  '<span class="shared-files-active">' . esc_html__( 'Active', 'shared-files' ) . '</span>' ;
            }
            wp_reset_postdata();
        } else {
            echo  '<span class="shared-files-inactive">' . esc_html__( 'Inactive', 'shared-files' ) . '</span><br />' ;
            $is_premium = 0;
            
            if ( !$is_premium ) {
                echo  '<form method="post">' ;
                echo  '<input type="submit" class="shared-files-activate ' . (( SharedFilesHelpers::isPremium() == 0 ? 'shared-files-pro-required' : '' )) . '" value="' . esc_attr__( 'Activate', 'shared-files' ) . '" />' ;
                echo  '</form>' ;
            }
        
        }
        
        echo  '</td>' ;
        echo  '</tr>' ;
    }

}