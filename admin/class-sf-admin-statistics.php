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

        <?php if (shared_files_fs()->can_use_premium_code()): ?>

          <p><?php echo esc_html__('If you wish to see some other statistics, contact the author at', 'shared-files') ?> <a href="https://www.sharedfilespro.com/support/?utm_source=plugin-shortcodes" target="_blank">sharedfilespro.com/support/</a>.</p>

        <?php else: ?>

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

        <?php endif; ?>

      </div>

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
            <th><?php echo esc_html__('Downloads', 'shared-files'); ?></th>
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
              <td style="text-align: right;">
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

    </div>

    <?php
  }

}
