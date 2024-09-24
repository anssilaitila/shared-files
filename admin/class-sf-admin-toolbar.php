<?php

class SharedFilesAdminToolbar {
    public function admin_body_class( $classes ) {
        $screen = get_current_screen();
        $admin_pages = [
            'edit-shared_file',
            'shared_file',
            'edit-shared-file-tag',
            //        'edit-post_tag',
            'edit-shared-file-category',
            'shared_file_page_shared-files-sync-files',
            'shared_file_page_shared-files-sync-media-library',
            'settings_page_shared-files',
            'settings_page_shared-files-account',
            'shared_file_page_shared-files-download-log',
            'shared_file_page_shared-files-statistics',
            'shared_file_page_shared-files-contacts',
            'shared_file_page_shared-files-shortcodes',
            'shared_file_page_shared-files-restrict-access',
            'shared_file_page_shared-files-support',
            'shared_file_page_shared-files-categories-info',
        ];
        $add_class = 0;
        if ( isset( $screen->id ) && ($screen_id = $screen->id) ) {
            $screen_post_type = '';
            if ( isset( $screen->post_type ) ) {
                $screen_post_type = $screen->post_type;
            }
            if ( $screen_post_type == 'shared_file' && $screen_id == 'edit-post_tag' ) {
                $add_class = 1;
            } elseif ( in_array( $screen_id, $admin_pages ) ) {
                $add_class = 1;
            } else {
                $add_class = 0;
            }
        }
        if ( $add_class ) {
            $classes .= ' shared-files-admin-page';
        }
        return $classes;
    }

    public function admin_header() {
        $screen = get_current_screen();
        $admin_pages = [
            'edit-shared_file',
            'shared_file',
            'edit-shared-file-tag',
            //      'edit-post_tag',
            'edit-shared-file-category',
            'shared_file_page_shared-files-sync-files',
            'shared_file_page_shared-files-sync-media-library',
            'settings_page_shared-files',
            'settings_page_shared-files-account',
            'shared_file_page_shared-files-download-log',
            'shared_file_page_shared-files-statistics',
            'shared_file_page_shared-files-contacts',
            'shared_file_page_shared-files-shortcodes',
            'shared_file_page_shared-files-restrict-access',
            'shared_file_page_shared-files-support',
            'shared_file_page_shared-files-categories-info',
        ];
        $current_admin_page = '';
        $show_toolbar = 0;
        if ( isset( $screen->id ) && ($screen_id = $screen->id) ) {
            $screen_post_type = '';
            if ( isset( $screen->post_type ) ) {
                $screen_post_type = $screen->post_type;
            }
            if ( $screen_post_type == 'shared_file' && $screen_id == 'edit-post_tag' ) {
                $show_toolbar = 1;
                $current_admin_page = $screen_id;
            } elseif ( in_array( $screen_id, $admin_pages ) ) {
                $show_toolbar = 1;
                $current_admin_page = $screen_id;
            } else {
                $show_toolbar = 0;
            }
        }
        ?>

    <?php 
        if ( $show_toolbar ) {
            ?>

      <div class="shared-files-admin-toolbar">

        <div class="shared-files-admin-toolbar-left">

          <div class="shared-files-admin-toolbar-left-plugin-title">

            <span class="shared-files-admin-toolbar-plugin-title">
              <?php 
            echo esc_html__( 'Shared Files', 'shared-files' );
            ?>
              <?php 
            if ( shared_files_fs()->is_plan_or_trial( 'business' ) ) {
                ?>
                PRO
              <?php 
            } elseif ( shared_files_fs()->is_plan_or_trial( 'pro' ) ) {
                ?>
                PRO
              <?php 
            } elseif ( shared_files_fs()->is_plan_or_trial( 'personal' ) ) {
                ?>
                PRO
              <?php 
            }
            ?>
            </span>

            <?php 
            if ( shared_files_fs()->is_plan_or_trial( 'business' ) ) {
                ?>
              <span class="shared-files-admin-plan-small">MAX</span>
            <?php 
            } elseif ( shared_files_fs()->is_plan_or_trial( 'pro' ) ) {
                ?>
              <?php 
                // ...
                ?>
            <?php 
            } elseif ( shared_files_fs()->is_plan_or_trial( 'personal' ) ) {
                ?>
              <span class="shared-files-admin-plan-small">LITE</span>
            <?php 
            }
            ?>

          </div>

          <div class="shared-files-admin-toolbar-left-links">

            <a href="<?php 
            echo esc_url_raw( get_admin_url( null, './edit.php?post_type=shared_file' ) );
            ?>"><?php 
            echo esc_html__( 'All files', 'shared-files' );
            ?></a>
            <a href="<?php 
            echo esc_url_raw( get_admin_url( null, './post-new.php?post_type=shared_file' ) );
            ?>"><?php 
            echo esc_html__( 'Add new file', 'shared-files' );
            ?></a>
            <a href="<?php 
            echo esc_url_raw( get_admin_url( null, './edit-tags.php?taxonomy=' . SHARED_FILES_TAG_SLUG . '&post_type=shared_file' ) );
            ?>"><?php 
            echo esc_html__( 'Tags', 'shared-files' );
            ?></a>

            <?php 
            $is_premium = 0;
            ?>

            <?php 
            ?>

            <?php 
            if ( !$is_premium ) {
                ?>

              <a href="<?php 
                echo esc_url_raw( get_admin_url( null, './edit.php?post_type=shared_file&page=shared-files-categories-info' ) );
                ?>"><?php 
                echo esc_html__( 'Categories', 'shared-files' );
                ?></a>

            <?php 
            }
            ?>

            <a href="<?php 
            echo esc_url_raw( get_admin_url( null, './edit-tags.php?taxonomy=' . SHARED_FILES_TAG_SLUG . '&post_type=shared_file' ) );
            ?>"><?php 
            echo esc_html__( 'Sync Files', 'shared-files' );
            ?></a>

            <span class="shared-files-admin-toolbar-divider"></span>

            <a class="shared-files-btn-alt" href="<?php 
            echo esc_url_raw( get_admin_url( null, './options-general.php?page=shared-files' ) );
            ?>"><?php 
            echo esc_html__( 'Settings', 'shared-files' );
            ?></a>

            <?php 
            $freemius_user = shared_files_fs()->get_user();
            ?>

            <?php 
            if ( $freemius_user ) {
                ?>

              <a class="shared-files-btn-alt" href="<?php 
                echo esc_url_raw( get_admin_url( null, './options-general.php?page=shared-files-account' ) );
                ?>"><?php 
                echo esc_html__( 'Account', 'shared-files' );
                ?></a>

            <?php 
            }
            ?>

            <span class="shared-files-admin-toolbar-divider"></span>

            <a href="<?php 
            echo esc_url_raw( get_admin_url( null, './edit.php?post_type=shared_file&page=shared-files-download-log' ) );
            ?>"><?php 
            echo esc_html__( 'Download log', 'shared-files' );
            ?></a>
            <a href="<?php 
            echo esc_url_raw( get_admin_url( null, './edit.php?post_type=shared_file&page=shared-files-statistics' ) );
            ?>"><?php 
            echo esc_html__( 'Statistics', 'shared-files' );
            ?></a>
            <a href="<?php 
            echo esc_url_raw( get_admin_url( null, './edit.php?post_type=shared_file&page=shared-files-contacts' ) );
            ?>"><?php 
            echo esc_html__( 'Leads', 'shared-files' );
            ?></a>
            <a href="<?php 
            echo esc_url_raw( get_admin_url( null, './edit.php?post_type=shared_file&page=shared-files-shortcodes' ) );
            ?>"><?php 
            echo esc_html__( 'Shortcodes', 'shared-files' );
            ?></a>
            <a href="<?php 
            echo esc_url_raw( get_admin_url( null, './edit.php?post_type=shared_file&page=shared-files-support' ) );
            ?>"><?php 
            echo esc_html__( 'Support', 'shared-files' );
            ?></a>
          </div>

        </div>

        <div class="shared-files-admin-toolbar-right">

          <?php 
            if ( SharedFilesHelpers::isPremium() == 0 ) {
                ?>

            <a href="https://www.sharedfilespro.com/pricing/?utm_source=Shared+Files+Free&utm_medium=wpadminplugin&utm_campaign=Shared+Files+upgrade&utm_content=header" target="_blank">
              <?php 
                echo esc_html__( 'Unlock Extra Features with Shared Files PRO', 'shared-files' );
                ?> ➜
            </a>

          <?php 
            }
            ?>

        </div>

      </div>

      <?php 
            $page_title = sanitize_text_field( __( 'Shared Files', 'shared-files' ) );
            switch ( $current_admin_page ) {
                case 'edit-shared_file':
                    $page_title = sanitize_text_field( __( 'All files', 'shared-files' ) );
                    break;
                case 'shared_file':
                    if ( isset( $_GET['action'] ) && $_GET['action'] == 'edit' ) {
                        $page_title = sanitize_text_field( __( 'Edit file', 'shared-files' ) );
                    } else {
                        $page_title = sanitize_text_field( __( 'Add new file', 'shared-files' ) );
                    }
                    break;
                case 'edit-shared-file-category':
                    $page_title = sanitize_text_field( __( 'Categories', 'shared-files' ) );
                    break;
                case 'edit-shared-file-tag':
                case 'edit-post_tag':
                    if ( isset( $_GET['tag_ID'] ) ) {
                        $page_title = sanitize_text_field( __( 'Edit tag', 'shared-files' ) );
                    } else {
                        $page_title = sanitize_text_field( __( 'Tags', 'shared-files' ) );
                    }
                    break;
                case 'shared_file_page_shared-files-sync-files':
                    $page_title = sanitize_text_field( __( 'Sync Files', 'shared-files' ) );
                    break;
                case 'shared_file_page_shared-files-sync-media-library':
                    $page_title = sanitize_text_field( __( 'Sync Files / Media Library', 'shared-files' ) );
                    break;
                case 'shared_file_page_shared-files-download-log':
                    $page_title = sanitize_text_field( __( 'Download log', 'shared-files' ) );
                    break;
                case 'shared_file_page_shared-files-statistics':
                    $page_title = sanitize_text_field( __( 'Statistics', 'shared-files' ) );
                    break;
                case 'shared_file_page_shared-files-contacts':
                    $page_title = sanitize_text_field( __( 'Leads', 'shared-files' ) );
                    break;
                case 'shared_file_page_shared-files-shortcodes':
                    $page_title = sanitize_text_field( __( 'Shortcodes', 'shared-files' ) );
                    break;
                case 'shared_file_page_shared-files-restrict-access':
                    $page_title = sanitize_text_field( __( 'Restrict Access', 'shared-files' ) );
                    break;
                case 'shared_file_page_shared-files-support':
                    $page_title = sanitize_text_field( __( 'Support', 'shared-files' ) );
                    break;
                case 'shared_file_page_shared-files-categories-info':
                    $page_title = sanitize_text_field( __( 'Categories', 'shared-files' ) );
                    break;
                case 'settings_page_shared-files':
                    $page_title = sanitize_text_field( __( 'Settings', 'shared-files' ) );
                    break;
                case 'settings_page_shared-files-account':
                    $page_title = sanitize_text_field( __( 'Account', 'shared-files' ) );
                    break;
                default:
                    break;
            }
            ?>

      <div class="shared-files-admin-titlebar">
        <h1><?php 
            echo esc_html( $page_title );
            ?></h1>
      </div>

    <?php 
        }
        ?>

    <?php 
    }

}
