<?php

class SharedFilesAdminHelpSupport {
    public function register_support_page() {
        add_submenu_page(
            'edit.php?post_type=shared_file',
            sanitize_text_field( __( 'How to use Shared Files', 'shared-files' ) ),
            sanitize_text_field( __( 'Help / Support', 'shared-files' ) ),
            'manage_options',
            'shared-files-support',
            [$this, 'register_support_page_callback'],
            999
        );
    }

    public static function permalinks_alert() {
        $html = '';
        if ( !get_option( 'permalink_structure' ) ) {
            $html = '<div class="shared-files-permalinks-alert">';
            $html .= '<strong>' . sanitize_text_field( __( 'Please note', 'shared-files' ) ) . '</strong>: ';
            $url = get_admin_url() . 'options-permalink.php';
            $html .= sprintf( wp_kses(
                /* translators: %s: link to the support forum */
                __( 'you have currently "Plain" selected in <a href="%s">the permalink settings</a>. You should change this to any other available setting to enable the Shared Files to operate normally. Thank you!', 'shared-files' ),
                array(
                    'a' => array(
                        'href'   => array(),
                        'target' => array(),
                    ),
                )
             ), esc_url( $url ) );
            $html .= '</div>';
        }
        return $html;
    }

    public function register_support_page_callback() {
        ?>

    <?php
        $s = get_option( 'shared_files_settings' );
        ?>

    <?php
        echo SharedFilesAdminHelpSupport::permalinks_alert();
        ?>

    <?php
        $num = 0;
        ?>

    <div class="shared-files-help-support wrap shared-files-admin-page">

      <h1><?php
        echo esc_html__( 'How to use Shared Files', 'shared-files' );
        ?></h1>

      <div class="shared-files-examples">

        <p><?php
          echo esc_html__( 'Some examples on how you can use different views available at', 'shared-files' );
          ?> <a href="https://www.sharedfilespro.com/shared-files/?utm_source=Shared+Files+Free&utm_medium=plugin-examples" target="_blank"><?php
          echo esc_html__( 'sharedfilespro.com', 'shared-files' );
          ?></a>.</p>

        <p>
        <?php
          $url = 'https://wordpress.org/support/plugin/shared-files/';
          echo sprintf( wp_kses(
              /* translators: %s: link to the support forum */
              __( 'Any kind of feedback is welcome. You may contact the author at <a href="%s" target="_blank">the support forum</a>.', 'shared-files' ),
              array(
                  'a' => array(
                      'href'   => array(),
                      'target' => array(),
                  ),
              )
           ), esc_url( $url ) );
          ?>
        </p>
        <p>
        <?php
          $url = 'https://www.sharedfilespro.com/pricing/?utm_source=Shared+Files+Free&utm_medium=plugin-free-support';
          echo sprintf( wp_kses(
              /* translators: %s: link to the pricing page of the paid version of the plugin */
              __( 'The forum is actively monitored by the author, but for more personal support by email, please consider one of the <a href="%s" target="_blank">paid plans</a>.', 'shared-files' ),
              array(
                  'a' => array(
                      'href'   => array(),
                      'target' => array(),
                  ),
              )
           ), esc_url( $url ) );
          ?>
        </p>

      </div>

      <div class="shared-files-admin-section">

        <h2><?php
        echo esc_html__( 'Instructions for basic usage', 'shared-files' );
        ?></h2>

        <ol>
          <li>

            <?php
        $url = esc_url_raw( get_admin_url() . 'edit.php?post_type=shared_file' );
        echo sprintf( wp_kses(
            /* translators: %s: link to file management */
            __( 'Add the files from the <a href="%s" target="_blank">file management</a> page.', 'shared-files' ),
            array(
                'a' => array(
                    'href'   => array(),
                    'target' => array(),
                ),
            )
         ), esc_url( $url ) );
        ?>

          </li>
          <li>

            <?php
        echo esc_html__( 'Insert one of these shortcodes to any page or post:', 'shared-files' );
        ?><br />

            <ul>

              <li><?php
        echo esc_html__( 'The default file list:', 'shared-files' );
        ?><br /><?php
        $num++;
        ?><span class="shared-files-shortcode shared-files-shortcode-only shared-files-shortcode-<?php
        echo esc_attr( $num );
        ?>" data-tooltip-class="shared-files-shortcode-<?php
        echo esc_attr( $num );
        ?>">[shared_files]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php
        echo esc_attr( $num );
        ?>"><?php
        echo esc_html__( 'Copy', 'shared-files' );
        ?></button></li>

              <li><?php
        echo esc_html__( 'A simpler list of files:', 'shared-files' );
        ?><br /><?php
        $num++;
        ?><span class="shared-files-shortcode shared-files-shortcode-only shared-files-shortcode-<?php
        echo esc_attr( $num );
        ?>" data-tooltip-class="shared-files-shortcode-<?php
        echo esc_attr( $num );
        ?>">[shared_files_simple]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php
        echo esc_attr( $num );
        ?>"><?php
        echo esc_html__( 'Copy', 'shared-files' );
        ?></button></li>

              <li><?php
        echo esc_html__( 'Front-end file uploader:', 'shared-files' );
        ?><br /><?php
        $num++;
        ?><span class="shared-files-shortcode shared-files-shortcode-only shared-files-shortcode-<?php
        echo esc_attr( $num );
        ?>" data-tooltip-class="shared-files-shortcode-<?php
        echo esc_attr( $num );
        ?>">[shared_files file_upload=1]</span><button class="shared-files-copy" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-<?php
        echo esc_attr( $num );
        ?>"><?php
        echo esc_html__( 'Copy', 'shared-files' );
        ?></button></li>

            </ul>

            <strong>
            <?php
        $url = esc_url_raw( get_admin_url() . 'edit.php?post_type=shared_file&page=shared-files-shortcodes' );
        echo sprintf( wp_kses(
            /* translators: %s: link to the list of available shortcodes */
            __( 'A complete list of available shortcodes can be found <a href="%s">here</a>.', 'shared-files' ),
            array(
                'a' => array(
                    'href'   => array(),
                    'target' => array(),
                ),
            )
         ), esc_url( $url ) );
        ?>
            </strong>

          </li>
        </ol>

      </div>

      <div class="shared-files-admin-section">

        <h2><?php
        echo esc_html__( 'Help regarding finding the correct settings', 'shared-files' );
        ?></h2>

        <p>

          <?php
        $url = esc_url_raw( get_admin_url() . 'options-general.php?page=shared-files' );
        echo sprintf( wp_kses(
            /* translators: %s: link to plugin settings */
            __( 'In case you are getting 404-errors from file URLs, you should change the following <a href="%s" target="_blank">settings</a> (either one or both):', 'shared-files' ),
            array(
                'a' => array(
                    'href'   => array(),
                    'target' => array(),
                ),
            )
         ), esc_url( $url ) );
        ?>

        </p>

        <ul>

          <li>
            <?php
        echo esc_html__( 'Set the file opening method to "Redirect".', 'shared-files' );
        ?>
          </li>

          <li>
            <?php
        echo esc_html__( 'Check the checkbox for "Compatibility mode".', 'shared-files' );
        ?>
          </li>

          <li>
            <p><?php
        echo esc_html__( 'Define the "WordPress location" if you have WP installed under a subdirectory.', 'shared-files' );
        ?></p>
            <p><?php
        echo esc_html__( 'For example: if you have "https://www.yoursite.com/example" set for WordPress Address (URL) in the general settings of WordPress, you should set "/example/" for WordPress location in the plugin settings.', 'shared-files' );
        ?></p>

          </li>

        </ul>

        <?php
        $is_premium = 0;
        ?>

        <?php
        ?>

        <?php
        if ( !$is_premium ) {
            ?>

          <p><?php
            echo esc_html__( 'If the issue still persists, we are happy to help at', 'shared-files' );
            ?> <a href="https://wordpress.org/support/plugin/shared-files/" target="_blank">the support forum</a>. <?php
            echo esc_html__( 'The forum is actively monitored by the plugin author.', 'shared-files' );
            ?></p>

        <?php
        }
        ?>

      </div>

      <div class="shared-files-admin-section">

        <h2><?php
        echo esc_html__( 'Ratings & Reviews', 'shared-files' );
        ?></h2>

        <p>
          <?php
        echo sprintf( wp_kses( __( 'If you like <strong>Shared Files</strong> please consider leaving a ★★★★★ rating. It helps the plugin in getting more audience.', 'shared-files' ), array(
            'strong' => array(),
        ) ) );
        ?>
        </p>

        <?php
        ?>

        <p>
          <?php
        echo esc_html__( 'A huge thanks in advance!', 'shared-files' );
        ?>
        </p>

        <a href="https://wordpress.org/support/view/plugin-reviews/shared-files/reviews/#new-post" target="_blank" class="button-primary"><?php
        echo esc_html__( 'Leave a rating', 'shared-files' );
        ?></a>

      </div>

    </div>
    <?php
    }

    public function register_debug_page() {
        $menu_pos = 4;

        $menu_pos = 1000;
        add_submenu_page(
            'edit.php?post_type=shared_file',
            sanitize_text_field( __( 'Debug info', 'shared-files' ) ),
            '<span style="font-size: 15px; margin: 0 2px 0 5px;">&#8627;</span> ' . sanitize_text_field( __( 'Debug info', 'shared-files' ) ),
            'manage_options',
            'shared-files-debug-info',
            [$this, 'register_debug_page_callback'],
            $menu_pos
        );
    }

    public function register_debug_page_callback() {
        ?>

    <?php
        $s = get_option( 'shared_files_settings' );
        ?>

    <?php
        echo SharedFilesAdminHelpSupport::permalinks_alert();
        ?>

    <?php
        $num = 0;
        ?>

    <div class="wrap shared-files-help-support shared-files-admin-page">

      <h2 style="display: none;"></h2>

      <div class="shared-files-admin-section">

        <h2><?php
        echo esc_html__( 'A collection of useful debug information', 'shared-files' );
        ?></h2>

        <div>

          <div class="shared-files-info-small">
            <p><?php
        echo esc_html__( 'This section contains some debug info, which may be useful when trying to solve abnormal behaviour of the plugin.', 'shared-files' );
        ?></a></p>
          </div>

          <?php
        global $wp;
        ?>


          <?php
        ?>


          <h3><?php
        echo esc_html__( 'Variables', 'shared-files' );
        ?></h3>
          site_url(): <?php
        echo esc_html( site_url() );
        ?><br />
          home_url(): <?php
        echo esc_html( home_url() );
        ?><br />
          wp_upload_dir()['path']: <?php
        echo esc_html( wp_upload_dir()['path'] );
        ?><br />
          wp_upload_dir()['url']: <?php
        echo esc_html( wp_upload_dir()['url'] );
        ?><br />
          wp_upload_dir()['subdir']: <?php
        echo esc_html( wp_upload_dir()['subdir'] );
        ?><br />
          wp_upload_dir()['basedir']: <?php
        echo esc_html( wp_upload_dir()['basedir'] );
        ?><br />
          wp_upload_dir()['baseurl']: <?php
        echo esc_html( wp_upload_dir()['baseurl'] );
        ?><br />
          wp_upload_dir()['error']: <?php
        echo esc_html( wp_upload_dir()['error'] );
        ?><br />
          sf_root: <?php
        echo ( SharedFilesHelpers::sf_root() ? esc_html( SharedFilesHelpers::sf_root() ) : esc_html__( '(not set)', 'shared-files' ) );
        ?><br />
          get_template_directory(): <?php
        echo esc_html( get_template_directory() );
        ?><br />
          get_template_directory_uri(): <?php
        echo esc_html( get_template_directory_uri() );
        ?><br />
          permalinks: <?php
        echo esc_html( get_option( 'permalink_structure' ) );
        ?><br />

          <?php
        $zlib = 0;
        if ( function_exists( 'ini_get' ) && ini_get( 'zlib.output_compression' ) ) {
            $zlib = 1;
        }
        ?>

          zlib: <?php
        echo esc_attr( $zlib );
        ?><br />


          <?php
        $wp_query = new WP_Query(array(
            'post_type'      => 'shared_file',
            'post_status'    => 'publish',
            'posts_per_page' => 5,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ));
        ?>

          <h3><?php
        echo esc_html__( 'Sample file data (5 newest files)', 'shared-files' );
        ?></h3>

          <?php
        if ( $wp_query->have_posts() ) {
            while ( $wp_query->have_posts() ) {
                $wp_query->the_post();
                $id = intval( get_the_id() );
                $c = get_post_custom( $id );
                $file = ( isset( $c['_sf_filename'] ) ? SharedFilesHelpers::sf_root() . '/shared-files/' . $id . '/' . SharedFilesHelpers::wp_engine() . sanitize_text_field( $c['_sf_filename'][0] ) : '' );
                ?>

              <?php
                echo esc_html( $file );
                ?> | <?php
                echo esc_html( get_the_date() );
                ?><br />

            <?php
            }
        }
        ?>

          <?php
        $wp_query = new WP_Query(array(
            'post_type'      => 'shared_file',
            'post_status'    => 'publish',
            'posts_per_page' => 1,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ));
        ?>

          <h3><?php
        echo esc_html__( 'More detailed data on newest file', 'shared-files' );
        ?></h3>

          <?php
        if ( $wp_query->have_posts() ) {
            while ( $wp_query->have_posts() ) {
                $wp_query->the_post();
                $id = intval( get_the_id() );
                $c = get_post_custom( $id );
                $file = ( isset( $c['_sf_filename'] ) ? SharedFilesHelpers::sf_root() . '/shared-files/' . $id . '/' . SharedFilesHelpers::wp_engine() . sanitize_text_field( $c['_sf_filename'][0] ) : '' );
                ?>

              <div style="background: #fff; padding: 6px 8px; margin-bottom: 4px;">
                <?php
                echo esc_html( $file );
                ?> | <?php
                echo esc_html( get_the_date() );
                ?>
              </div>

              <?php
                $file = get_post_meta( $id, '_sf_file', true );
                ?>

              <?php
                if ( isset( $file['file'] ) ) {
                    ?>

                <?php
                    $filename_with_path = SharedFilesFileOpen::getUpdatedPathAndFilename( $file['file'] );
                    ?>
                file: <?php
                    echo esc_html( $file['file'] );
                    ?><br />
                path: <?php
                    echo esc_html( $filename_with_path );
                    ?><br />

                <?php
                    if ( file_exists( $filename_with_path ) ) {
                        ?>
                  <div style="color: mediumseagreen; font-weight: 700;"><?php
                        echo esc_html__( '(file found)', 'shared-files' );
                        ?></div>
                <?php
                    } else {
                        ?>
                  <div style="color: crimson; font-weight: 700;"><?php
                        echo esc_html__( '(file not found)', 'shared-files' );
                        ?></div>
                <?php
                    }
                    ?>

                url: <?php
                    echo esc_html( $file['url'] );
                    ?><br />
                type: <?php
                    echo esc_html( $file['type'] );
                    ?><br />

                <?php
                    if ( isset( $file['error'] ) && $file['error'] ) {
                        ?>
                  error: <?php
                        echo esc_html( $file['error'] );
                        ?><br />
                <?php
                    }
                    ?>

              <?php
                }
                ?>

            <?php
            }
        }
        ?>

          <?php
        $wp_query = new WP_Query(array(
            'post_type'      => 'shared_file',
            'post_status'    => 'publish',
            'posts_per_page' => 1,
            'orderby'        => 'date',
            'order'          => 'ASC',
        ));
        ?>

          <h3><?php
        echo esc_html__( 'Oldest file', 'shared-files' );
        ?></h3>

          <?php
        if ( $wp_query->have_posts() ) {
            while ( $wp_query->have_posts() ) {
                $wp_query->the_post();
                $id = intval( get_the_id() );
                $c = get_post_custom( $id );
                $file = ( isset( $c['_sf_filename'] ) ? SharedFilesHelpers::sf_root() . '/shared-files/' . $id . '/' . SharedFilesHelpers::wp_engine() . sanitize_text_field( $c['_sf_filename'][0] ) : '' );
                ?>

              <div style="background: #fff; padding: 6px 8px; margin-bottom: 4px;">
                <?php
                echo esc_html( $file );
                ?> | <?php
                echo esc_html( get_the_date() );
                ?>
              </div>

              <?php
                $file = get_post_meta( $id, '_sf_file', true );
                ?>

              <?php
                if ( isset( $file['file'] ) ) {
                    ?>
                <?php
                    $filename_with_path = SharedFilesFileOpen::getUpdatedPathAndFilename( $file['file'] );
                    ?>
                file: <?php
                    echo esc_html( $file['file'] );
                    ?><br />
                path: <?php
                    echo esc_html( $filename_with_path );
                    ?><br />

                <?php
                    if ( file_exists( $filename_with_path ) ) {
                        ?>
                  <div style="color: mediumseagreen; font-weight: 700;"><?php
                        echo esc_html__( '(file found)', 'shared-files' );
                        ?></div>
                <?php
                    } else {
                        ?>
                  <div style="color: crimson; font-weight: 700;"><?php
                        echo esc_html__( '(file not found)', 'shared-files' );
                        ?></div>
                <?php
                    }
                    ?>

                url: <?php
                    echo esc_html( $file['url'] );
                    ?><br />
                type: <?php
                    echo esc_html( $file['type'] );
                    ?><br />

                <?php
                    if ( isset( $file['error'] ) && $file['error'] ) {
                        ?>
                  error: <?php
                        echo esc_html( $file['error'] );
                        ?><br />
                <?php
                    }
                    ?>
              <?php
                }
                ?>

            <?php
            }
        }
        ?>

          <h3><?php
        echo esc_html__( 'Debug log', 'shared-files' );
        ?></h3>

          <?php
        global $wpdb;
        $items_per_page = 200;
        $page = ( isset( $_GET['log-page'] ) ? abs( (int) $_GET['log-page'] ) : 1 );
        $offset = $page * $items_per_page - $items_per_page;
        $query = "SELECT * FROM {$wpdb->prefix}shared_files_log";
        $total_query = "SELECT COUNT(1) FROM ({$query}) AS combined_table";
        $total = $wpdb->get_var( $total_query );
        $results = $wpdb->get_results( $query . ' ORDER BY id DESC LIMIT ' . $offset . ', ' . $items_per_page, OBJECT );
        ?>

          <table class="shared-files-debug-log" style="min-width: 400px;">

          <tr>
            <th><?php
        echo esc_html__( 'Date', 'shared-files' );
        ?></th>
            <th><?php
        echo esc_html__( 'Title', 'shared-files' );
        ?></th>
            <th><?php
        echo esc_html__( 'Message', 'shared-files' );
        ?></th>
          </tr>

          <?php
        if ( sizeof( $results ) > 0 ) {
            ?>

            <?php
            foreach ( $results as $row ) {
                ?>
              <tr>

                <td style="white-space: nowrap;">
                  <?php
                echo esc_html( $row->created_at );
                ?>
                </td>

                <td>
                  <?php
                echo esc_html( $row->title );
                ?><br />
                </td>

                <td>
                  <?php
                if ( isset( $row->message ) ) {
                    ?>
                    <?php
                    echo wp_kses_post( nl2br( $row->message ) );
                    ?>
                  <?php
                }
                ?>
                </td>

              </tr>
            <?php
            }
            ?>

          <?php
        } else {
            ?>

            <tr>
              <td colspan="3">
                <?php
            echo esc_html__( 'No data logged yet.', 'shared-files' );
            ?>
              </td>
            </tr>

          <?php
        }
        ?>

          </table>

          <div class="shared-files-admin-pagination-container">

            <?php
        echo paginate_links( array(
            'base'      => add_query_arg( 'log-page', '%#%' ),
            'format'    => '',
            'prev_text' => __( '&laquo;' ),
            'next_text' => __( '&raquo;' ),
            'total'     => ceil( $total / $items_per_page ),
            'current'   => $page,
        ) );
        ?>

          </div>

        </div>

      </div>

    </div>

    <?php
    }

}
