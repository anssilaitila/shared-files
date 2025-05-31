<?php

class SharedFilesAdminSearchLog {

  public function register_search_log_page() {
    add_submenu_page(
      'edit.php?post_type=shared_file',
      sanitize_text_field( __('Search log', 'shared-files') ),
      sanitize_text_field( __('Search log', 'shared-files') ),
      'manage_options',
      'shared-files-search-log',
      [ $this, 'register_search_log_page_callback' ]
    );
  }

  public function register_search_log_page_callback() {

    $s = get_option('shared_files_settings');

    ?>

    <div class="wrap shared-files-admin-page">

      <h1 style="margin-bottom: 20px; display: none;"><?php echo esc_html__('Search log', 'shared-files'); ?></h1>

      <div class="shared-files-admin-section">

        <h2><?php echo esc_html__('Search log', 'shared-files') ?></h2>

        <?php if ( !isset( $s['enable_search_log'] ) ): ?>

          <div class="shared-files-black-box"><?php echo esc_html__('Search log is currently disabled and can be activated from the plugin settings.', 'shared-files'); ?></div>

        <?php endif; ?>

        <?php if (isset($_GET['search_log_emptied'])): ?>

          <?php echo '<div class="shared-files-search-log-success">' . esc_html__('Search log successfully emptied.', 'shared-files') . '</div>'; ?>

        <?php elseif (isset($_GET['search_log_emptied_error'])): ?>

          <?php echo '<div class="shared-files-search-log-success-error">' . esc_html__('Search log not emptied.', 'shared-files') . '</div>'; ?>

        <?php else: ?>

          <form method="post" class="shared-files-empty-search-log-form">
          <input type="hidden" name="_shared_files_empty_search_log" value="1" />

          <?php echo wp_nonce_field('_shared-files-empty-search-log', '_wpnonce', true, false) ?>

          <input type="submit" value="<?php echo esc_attr__('Empty search log', 'shared-files') ?>" class="shared-files-empty-search-log" />
          </form>

        <?php endif; ?>

        <?php

        global $wpdb;

        $items_per_page = 200;
        $page = isset( $_GET['log-page'] ) ? abs( (int) $_GET['log-page'] ) : 1;
        $offset = ( $page * $items_per_page ) - $items_per_page;

        $query = "SELECT * FROM {$wpdb->prefix}shared_files_search_log";

        $total_query = "SELECT COUNT(1) FROM ({$query}) AS combined_table";
        $total = $wpdb->get_var( $total_query );

        $results = $wpdb->get_results( $query . ' ORDER BY id DESC LIMIT ' . $offset . ', ' .  $items_per_page, OBJECT );

        ?>

        <table class="shared-files-admin-log">
        <tr>
          <th><?php echo esc_html__('Date', 'shared-files') ?></th>
          <th><?php echo esc_html__('Search term', 'shared-files') ?></th>
          <th><?php echo esc_html__('Search container', 'shared-files') ?></th>
          <th><?php echo esc_html__('User IP', 'shared-files') ?></th>
          <th><?php echo esc_html__('Country', 'shared-files') ?></th>

          <?php if ( isset( $s['esl_user_city'] ) ): ?>
            <th><?php echo esc_html__('City', 'shared-files') ?></th>
          <?php endif; ?>

          <th><?php echo esc_html__('Referer URL', 'shared-files') ?></th>
          <th><?php echo esc_html__('User agent', 'shared-files') ?></th>
        </tr>

        <?php if (sizeof($results) > 0): ?>

          <?php foreach ($results as $row): ?>

            <tr>
              <td>
                <?php echo esc_html( $row->created_at ) ?>
              </td>
              <td>
                <?php if (isset($row->search)): ?>
                  <?php echo esc_html( $row->search ) ?>
                <?php endif; ?>
              </td>
              <td>

                <?php

                  if (isset($row->post_id) && $post_id = $row->post_id) {
                    $current_permalink = esc_url_raw( get_permalink( $post_id ) );
                    $edit_url = esc_url_raw( get_admin_url(null, './post.php?post=' . $post_id . '&action=edit') );
                    echo '<div>' . esc_url( $row->permalink ) . '</div>';
                    echo '<a class="shared-files-admin-log-edit-btn" href="' . esc_url( $edit_url ) . '">' . esc_html__('Edit', 'shared-files') . '</a>';

                  }

                ?>

              </td>

              <td>
                <?php if (isset($row->user_ip)): ?>
                  <?php echo esc_html( $row->user_ip ) ?>
                <?php endif; ?>
              </td>
              <td>
                <?php if (isset($row->user_country)): ?>
                  <?php echo esc_html( $row->user_country ) ?>
                <?php endif; ?>
              </td>

              <?php if ( isset( $s['esl_user_city'] ) ): ?>
                <td>
                  <?php if (isset($row->user_city)): ?>
                    <?php echo esc_html( $row->user_city ) ?>
                  <?php endif; ?>
                </td>
              <?php endif; ?>

              <td>
                <?php if (isset($row->referer_url)): ?>
                  <?php echo esc_html( $row->referer_url ) ?>
                <?php endif; ?>
              </td>
              <td>
                <?php if (isset($row->user_agent)): ?>
                  <?php echo esc_html( $row->user_agent ) ?>
                <?php endif; ?>
              </td>
            </tr>

          <?php endforeach; ?>

        <?php else: ?>

          <tr>
            <td colspan="8">
              <?php echo esc_html__('No search log stored yet.', 'shared-files') ?>
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
