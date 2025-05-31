<?php

class SharedFilesAdminDownloadLog {

  public function register_download_log_page() {
    add_submenu_page(
      'edit.php?post_type=shared_file',
      sanitize_text_field( __('Download log of Shared Files', 'shared-files') ),
      sanitize_text_field( __('Download log', 'shared-files') ),
      'manage_options',
      'shared-files-download-log',
      [$this, 'register_download_log_page_callback'],
      600
    );
  }

  public function register_download_log_page_callback() {
    ?>

    <?php echo SharedFilesAdminHelpSupport::permalinks_alert() ?>

    <?php $s = get_option('shared_files_settings') ?>

    <div class="shared-files-help-support wrap shared-files-admin-page">

      <h1 style="margin-bottom: 20px;"><?php echo esc_html__('Download log of Shared Files', 'shared-files'); ?></h1>

      <div class="shared-files-admin-section shared-files-admin-section-statistics">

        <h2><?php echo esc_html__('Downloaded files', 'shared-files') ?></h2>

        <br />

        <?php if (isset($_GET['download_log_emptied'])): ?>

          <?php echo '<div class="shared-files-download-log-success" style="font-weight: 700; color: green;">' . esc_html__('Download log successfully emptied.', 'shared-files') . '</div>'; ?>

        <?php elseif (isset($_GET['download_log_emptied_error'])): ?>

          <?php echo '<div class="shared-files-download-log-success-error" style="font-weight: 700; color: crimson;">' . esc_html__('Download log not emptied.', 'shared-files') . '</div>'; ?>

        <?php else: ?>

          <form method="post" class="shared-files-empty-download-log-form">
          <input type="hidden" name="_shared_files_empty_download_log" value="1" />

          <?php echo wp_nonce_field('_shared-files-empty-download-log', '_wpnonce', true, false) ?>

          <input type="submit" value="<?php echo esc_attr__('Empty download log', 'shared-files') ?>" class="shared-files-empty-download-log" />
          </form>

        <?php endif; ?>

        <?php

        global $wpdb;

        $items_per_page = 200;
        $page = isset( $_GET['log-page'] ) ? abs( (int) $_GET['log-page'] ) : 1;
        $offset = ( $page * $items_per_page ) - $items_per_page;

        $query = "SELECT * FROM {$wpdb->prefix}shared_files_download_log";

        $total_query = "SELECT COUNT(1) FROM ({$query}) AS combined_table";
        $total = $wpdb->get_var( $total_query );

        $results = $wpdb->get_results( $query . ' ORDER BY created_at DESC LIMIT ' . $offset . ', ' .  $items_per_page, OBJECT );

        ?>

        <table class="shared-files-admin-log">
        <tr>
          <th><?php echo esc_html__('Date', 'shared-files') ?></th>
          <th><?php echo esc_html__('File', 'shared-files') ?></th>
          <th><?php echo esc_html__('File size', 'shared-files') ?></th>
          <th><?php echo esc_html__('Download count', 'shared-files') ?></th>

          <?php $cols = 3; ?>

          <?php if ( isset( $s['log_enable_user_data'] ) ): ?>

            <th><?php echo esc_html__('User ID', 'shared-files') ?></th>
            <?php $cols++; ?>

            <th><?php echo esc_html__('Name', 'shared-files') ?></th>
            <?php $cols++; ?>

          <?php endif; ?>

          <?php if ( isset( $s['log_enable_ip'] ) ): ?>

            <th><?php echo esc_html__('IP address', 'shared-files') ?></th>
            <?php $cols++; ?>

          <?php endif; ?>

          <?php if ( isset( $s['log_enable_country'] ) ): ?>

            <th><?php echo esc_html__('Country', 'shared-files') ?></th>
            <?php $cols++; ?>

          <?php endif; ?>

          <?php if ( isset( $s['log_enable_city'] ) ): ?>

            <th><?php echo esc_html__('City', 'shared-files') ?></th>
            <?php $cols++; ?>

          <?php endif; ?>


          <?php if ( isset( $s['log_enable_user_agent'] ) ): ?>

            <th><?php echo esc_html__('User agent', 'shared-files') ?></th>
            <?php $cols++; ?>

          <?php endif; ?>

          <?php if ( isset( $s['log_enable_referer_url'] ) ): ?>

            <th><?php echo esc_html__('Referer URL', 'shared-files') ?></th>
            <?php $cols++; ?>

          <?php endif; ?>

        </tr>

        <?php if (sizeof($results) > 0): ?>

          <?php foreach ($results as $row): ?>

            <tr>
              <td>
                <?php echo esc_html( $row->created_at ) ?>
              </td>
              <td>
                <?php if (isset($row->file_title)): ?>
                  <a href="<?php echo get_edit_post_link( $row->file_id ); ?>"><?php echo sanitize_text_field( $row->file_title ) ?></a>
                <?php endif; ?>
              </td>
              <td>
                <?php if (isset($row->file_size)): ?>
                  <?php echo esc_html( SharedFilesAdminHelpers::human_filesize( sanitize_text_field( $row->file_size ) ) ) ?>
                <?php endif; ?>
              </td>
              <td>
                <?php if (isset($row->download_cnt)): ?>
                  <?php echo esc_html( $row->download_cnt ) ?>
                <?php endif; ?>
              </td>

              <?php if ( isset( $s['log_enable_user_data'] ) ): ?>

                <td>
                  <?php if (isset($row->user_id)): ?>
                    <?php echo esc_html( $row->user_id ) ?>
                  <?php endif; ?>
                </td>

                <td>
                  <?php if (isset($row->user_login)): ?>
                    <?php echo esc_html( $row->user_login ) ?><br />
                  <?php endif; ?>

                  <?php if (isset($row->user_name)): ?>
                    <?php echo esc_html( $row->user_name ) ?>
                  <?php endif; ?>
                </td>

              <?php endif; ?>


              <?php if ( isset( $s['log_enable_ip'] ) ): ?>

                <td>
                  <?php if (isset($row->ip)): ?>
                    <?php echo esc_html( $row->ip ) ?>
                  <?php endif; ?>
                </td>

              <?php endif; ?>

              <?php if ( isset( $s['log_enable_country'] ) ): ?>

                <td>
                  <?php if (isset($row->user_country)): ?>
                    <?php echo esc_html( $row->user_country ) ?>
                  <?php endif; ?>
                </td>

              <?php endif; ?>

              <?php if ( isset( $s['log_enable_city'] ) ): ?>

                <td>
                  <?php if (isset($row->user_city)): ?>
                    <?php echo esc_html( $row->user_city ) ?>
                  <?php endif; ?>
                </td>

              <?php endif; ?>

              <?php if ( isset( $s['log_enable_user_agent'] ) ): ?>

                <td>
                  <?php if (isset($row->user_agent)): ?>
                    <?php echo esc_html( $row->user_agent ) ?>
                  <?php endif; ?>
                </td>

              <?php endif; ?>

              <?php if ( isset( $s['log_enable_referer_url'] ) ): ?>

                <td>
                  <?php if (isset($row->referer_url)): ?>
                    <?php echo esc_html( $row->referer_url ) ?>
                  <?php endif; ?>
                </td>

              <?php endif; ?>

            </tr>

          <?php endforeach; ?>

        <?php else: ?>

          <tr>
            <td colspan="<?php echo esc_html( $cols ) ?>">
              <?php echo esc_html__('No files downloaded yet.', 'shared-files') ?>
            </td>
          </tr>

        <?php endif; ?>

        </table>

        <div class="shared-files-admin-pagination-container">

          <?php
          echo paginate_links( array(
            'base' => add_query_arg( 'log-page', '%#%' ),
            'format' => '',
            'prev_text' => __('&laquo;'),
            'next_text' => __('&raquo;'),
            'total' => ceil($total / $items_per_page),
            'current' => $page
          ));
          ?>

        </div>

      </div>

    </div>

    <?php

  }

}
