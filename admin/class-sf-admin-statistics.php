<?php

class SharedFilesAdminStatistics {

  public function register_statistics_page() {
    add_submenu_page(
      'edit.php?post_type=shared_file',
      sanitize_text_field( __('Statistics of Shared Files', 'shared-files') ),
      sanitize_text_field( __('Statistics', 'shared-files') ),
      'manage_options',
      'shared-files-statistics',
      [$this, 'register_statistics_page_callback'],
      700
    );
  }

  public function register_statistics_page_callback() {
    ?>

    <?php echo SharedFilesAdminHelpSupport::permalinks_alert() ?>

    <?php $s = get_option('shared_files_settings') ?>

    <div class="shared-files-help-support wrap shared-files-admin-page">

      <h1><?php echo esc_html__('Statistics of Shared Files', 'shared-files'); ?></h1>

      <div class="shared-files-examples">

        <p>
        <?php
        $url = 'https://wordpress.org/support/plugin/shared-files/';
        echo sprintf(
          wp_kses(
            /* translators: %s: link to the support forum */
            __('If you wish to see some other statistics, contact the author at <a href="%s" target="_blank">the support forum</a>.', 'shared-files'),
            array('a' => array('href' => array(), 'target' => array()))
          ),
          esc_url($url)
        );
        ?>
        </p>

      </div>

      <div class="shared-files-admin-section-statistics-container">

        <div class="shared-files-admin-section shared-files-admin-section-statistics">

          <h2><?php echo esc_html__('Top 50 most popular files', 'shared-files') ?></h2>

          <?php
          $wp_query = new WP_Query(array(
            'post_type'       => 'shared_file',
            'post_status'     => 'publish',

            'posts_per_page'  => 50,

            'orderby'         => 'meta_value_num',
            'order'           => 'DESC',
            'meta_key'        => '_sf_load_cnt',
          ));
          ?>

          <?php if (isset($wp_query) && $wp_query->have_posts()): ?>

            <table>

            <tr>
              <th></th>
              <th><?php echo esc_html__('File', 'shared-files'); ?></th>
              <th style="width: 50px;"><?php echo esc_html__('Downloads', 'shared-files'); ?></th>
            </tr>

            <?php $row = 1; ?>

            <?php while ($wp_query->have_posts()): $wp_query->the_post(); ?>

              <?php $id = intval( get_the_id() ); ?>
              <?php $c = get_post_custom($id); ?>

              <tr>
                <td style="width: 10px; padding-right: 0; text-align: right;">
                  <?php echo esc_html( $row ) ?>.
                </td>
                <td>
                  <a href="<?php echo esc_url_raw( get_edit_post_link( $id ) ); ?>"><?php echo esc_html( get_the_title() ) ?></a>
                </td>
                <td style="text-align: right; width: 50px;">
                  <?php $download_cnt = intval( $c['_sf_load_cnt'][0] ); ?>
                  <?php echo esc_html( $download_cnt ); ?>
                </td>
              </tr>

              <?php $row++; ?>

            <?php endwhile; ?>

            </table>

          <?php else: ?>

            <p><?php echo esc_html__('No files added yet.', 'shared-files'); ?></p>

          <?php endif; ?>

        </div>


        <div class="shared-files-admin-section shared-files-admin-section-statistics">

          <h2><?php echo esc_html__('Top 50 countries', 'shared-files') ?></h2>

          <?php
          global $wpdb;
          $msg = $wpdb->get_results("SELECT user_country, COUNT(user_country) AS ROWS_CNT FROM {$wpdb->prefix}shared_files_download_log WHERE user_country != '' GROUP BY user_country ORDER BY ROWS_CNT DESC LIMIT 50");
          ?>

          <table>
          <tr>
            <th></th>
            <th><?php echo esc_html__('Country', 'shared-files') ?></th>
            <th style="width: 50px;"><?php echo esc_html__('Downloads', 'shared-files') ?></th>
          </tr>

          <?php $row_num = 1; ?>

          <?php if (sizeof($msg) > 0): ?>

            <?php foreach ($msg as $row): ?>

              <tr>
                <td style="width: 10px; padding-right: 0; text-align: right;">
                  <?php echo esc_html( $row_num ) ?>.
                </td>
                <td>
                  <?php echo esc_html( $row->user_country ) ?>
                </td>
                <td style="text-align: right; width: 50px;">
                  <?php echo esc_html( $row->ROWS_CNT ) ?><br />
                </td>

              </tr>

              <?php $row_num++; ?>

            <?php endforeach; ?>

          <?php else: ?>

            <tr>
              <td colspan="3">
                <?php echo esc_html__('Country data not yet stored.', 'shared-files') ?>
              </td>
            </tr>

          <?php endif; ?>

          </table>

          <p style="margin-top: 24px;"><?php
          $url = 'https://www.maxmind.com';
          echo sprintf(
            wp_kses(
              /* translators: %s: link to maxmind.com, the provider of geographical data */
              __('This product includes GeoLite2 data created by MaxMind, available from <a href="%s" target="_blank">maxmind.com</a>.', 'shared-files'),
              array('a' => array('href' => array(), 'target' => array()))
            ),
            esc_url($url)
          );
          ?></p>

        </div>

      </div>

    </div>

    <?php
  }

}