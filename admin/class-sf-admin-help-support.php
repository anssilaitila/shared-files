<?php

class SharedFilesAdminHelpSupport
{
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

      <script>
        jQuery(function ($) {
          $('.shared-files-toggle-debug-info').on('click', function() {
            if ($('.shared-files-debug-info-container').is(':hidden')) {
              $('.shared-files-debug-info-container').show();
              $(this).text("<?php 
        echo  __( 'Close', 'shared-files' ) ;
        ?>");
            } else {
              $('.shared-files-debug-info-container').hide();
              $(this).text("<?php 
        echo  __( 'Open', 'shared-files' ) ;
        ?>");
            }
          });
        });
      </script>

      <h1><?php 
        echo  __( 'Debug Info', 'shared-files' ) ;
        ?> <button class="shared-files-toggle-debug-info">Open</button></h1>

      <div class="shared-files-debug-info-container">

        <div class="shared-files-info-small">
          <p><?php 
        echo  __( 'This section contains some debug info, which may be useful when trying to solve abnormal behaviour of the plugin.', 'shared-files' ) ;
        ?></a></p>
        </div>
  
        <?php 
        global  $wp ;
        ?>
  
        <h3><?php 
        echo  __( 'Variables', 'shared-files' ) ;
        ?></h3>
        site_url(): <?php 
        echo  site_url() ;
        ?><br />
        home_url(): <?php 
        echo  home_url() ;
        ?><br />
        wp_upload_dir()['path']: <?php 
        echo  wp_upload_dir()['path'] ;
        ?><br />
        wp_upload_dir()['url']: <?php 
        echo  wp_upload_dir()['url'] ;
        ?><br />
        wp_upload_dir()['subdir']: <?php 
        echo  wp_upload_dir()['subdir'] ;
        ?><br />
        wp_upload_dir()['basedir']: <?php 
        echo  wp_upload_dir()['basedir'] ;
        ?><br />
        wp_upload_dir()['baseurl']: <?php 
        echo  wp_upload_dir()['baseurl'] ;
        ?><br />
        wp_upload_dir()['error']: <?php 
        echo  wp_upload_dir()['error'] ;
        ?><br />
        sf_root: <?php 
        echo  ( SharedFilesHelpers::sf_root() ? SharedFilesHelpers::sf_root() : '(not set)' ) ;
        ?><br />
        <br />
  
        <?php 
        $wp_query = new WP_Query( array(
            'post_type'      => 'shared_file',
            'post_status'    => 'publish',
            'posts_per_page' => 5,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ) );
        ?>
  
        <h3><?php 
        echo  __( 'Sample file data (5 newest files)', 'shared-files' ) ;
        ?></h3>
        <?php 
        if ( $wp_query->have_posts() ) {
            while ( $wp_query->have_posts() ) {
                $wp_query->the_post();
                $id = get_the_id();
                $c = get_post_custom( $id );
                $file = ( isset( $c['_sf_filename'] ) ? SharedFilesHelpers::sf_root() . '/shared-files/' . get_the_id() . '/' . $c['_sf_filename'][0] : '' );
                ?>
    
            <?php 
                echo  $file ;
                ?> | <?php 
                echo  get_the_date() ;
                ?><br />
  
            <?php 
            }
        }
        ?>

      </div>

    </div>
    <?php 
    }

}