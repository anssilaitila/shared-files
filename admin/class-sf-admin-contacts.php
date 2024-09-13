<?php

class SharedFilesAdminContacts {

  public function register_contacts_page() {
    add_submenu_page(
      'edit.php?post_type=shared_file',
      sanitize_text_field( __('Leads collected by Shared Files', 'shared-files') ),
      sanitize_text_field( __('Leads', 'shared-files') ),
      'manage_options',
      'shared-files-contacts',
      [$this, 'register_contacts_page_callback'],
      700
    );
  }

  public function register_contacts_page_callback() {
    ?>

    <?php echo SharedFilesAdminHelpSupport::permalinks_alert() ?>

    <?php $s = get_option('shared_files_settings') ?>

    <div class="shared-files-help-support wrap shared-files-admin-page">

      <h1 style="margin-bottom: 20px;"><?php echo esc_html__('Leads collected by Shared Files', 'shared-files'); ?></h1>

      <div class="shared-files-admin-section shared-files-admin-section-statistics">

        <h2><?php echo esc_html__('Leads', 'shared-files') ?></h2>

        <div class="shared-files-admin-lead-export">

          <h3><?php echo esc_html__('Export leads', 'shared-files') ?></h3>

          <p>
            <?php echo esc_html__('You may export the leads to a csv file. There will be one contact per row, columns separated by comma.', 'shared-files') ?>
          </p>

          <?php

          global $wpdb;
          $contacts = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}shared_files_contacts ORDER BY created_at DESC");

          ?>

          <p><?php echo sizeof( $contacts ) ?> <?php echo esc_html__('contact(s) found.', 'shared-files') ?></p>

          <form action="edit.php" method="get" enctype="multipart/form-data">

            <div class="input-row">
              <input type="hidden" name="post_type" value="shared_file" />
              <input type="hidden" name="page" value="shared-files-contacts" />
              <input type="hidden" name="export" value="1" />
              <button type="submit" id="submit" class="btn-submit shared-files-start-export"><?php echo esc_html__('Start export', 'shared-files') ?></button>
              <br />
            </div>

            <div id="labelError"></div>

            <?php echo wp_nonce_field('_shared-files-export-leads', '_wpnonce', true, false) ?>

          </form>

        </div>



        <?php if ( isset( $_GET['export'] ) && isset( $_REQUEST['_wpnonce'] ) ): ?>

          <?php $wp_nonce = sanitize_text_field( $_REQUEST['_wpnonce'] ); ?>

          <?php if ( wp_verify_nonce($wp_nonce, '_shared-files-export-leads') ): ?>

            <?php
            $filename_random = SharedFilesHelpers::getExportRandomFilename( 'leads' );

            $file_with_path = SharedFilesHelpers::getExportUploadDir() . $filename_random;
            $file_url = SharedFilesHelpers::getExportUploadURL() . $filename_random;

            $outstream = fopen($file_with_path, 'w');
            fprintf($outstream, chr(0xEF).chr(0xBB).chr(0xBF));

            $fields = array('id', 'created_at', 'file_list_id', 'name', 'email', 'phone', 'description', 'url');

            fputcsv($outstream, $fields);

            $values = array();

            foreach ($contacts as $contact) {

              $contact_data = [];

              $contact_data['id'] = sanitize_text_field( $contact->id );
              $contact_data['created_at'] = sanitize_text_field( $contact->created_at );
              $contact_data['file_list_id'] = sanitize_text_field( $contact->ask_for_email_id );
              $contact_data['name'] = sanitize_text_field( $contact->name );
              $contact_data['email'] = sanitize_text_field( $contact->email );
              $contact_data['phone'] = sanitize_text_field( $contact->phone );
              $contact_data['description'] = sanitize_text_field( $contact->descr );
              $contact_data['url'] = sanitize_text_field( $contact->referer_url );

              fputcsv($outstream, $contact_data);

            }

            fclose($outstream);
            ?>

            <?php if ($outstream && $file_url): ?>

              <p style="font-weight: bold; margin-top: 32px;"><?php echo esc_html__('CSV-file created succesfully:', 'shared-files') ?> <?php echo esc_url_raw( $file_url ) ?></p>
              <a href="<?php echo esc_url( $file_url ) ?>" style="font-weight: bold; font-size: 16px;"><?php echo esc_html__('Download', 'shared-files') ?></a><br /><br /><br />

            <?php else: ?>

              <p style="color: crimson; font-weight: bold;"><?php echo esc_html__('Error creating file.', 'shared-files') ?></p>

            <?php endif; ?>

          <?php else: ?>

            <p><?php echo esc_html__('Nonce error.', 'shared-files'); ?></p>

          <?php endif; ?>

        <?php endif; ?>

        <?php if (isset($_GET['contacts_emptied'])): ?>

          <?php echo '<div class="shared-files-download-log-success" style="font-weight: 700; color: green;">' . esc_html__('Contacts successfully emptied.', 'shared-files') . '</div>'; ?>

        <?php elseif (isset($_GET['contacts_emptied_error'])): ?>

          <?php echo '<div class="shared-files-download-log-success-error" style="font-weight: 700; color: crimson;">' . esc_html__('Contacts not emptied.', 'shared-files') . '</div>'; ?>

        <?php else: ?>

          <form method="post" class="shared-files-empty-contacts-form">
          <input type="hidden" name="_shared_files_empty_contacts" value="1" />

          <?php echo wp_nonce_field('_shared-files-empty-contacts', '_wpnonce', true, false) ?>

          <input type="submit" value="<?php echo esc_attr__('Empty contacts', 'shared-files') ?>" class="shared-files-empty-download-log" />
          </form>

        <?php endif; ?>

        <?php

        global $wpdb;

        $items_per_page = 200;
        $page = isset( $_GET['log-page'] ) ? abs( (int) $_GET['log-page'] ) : 1;
        $offset = ( $page * $items_per_page ) - $items_per_page;

        $query = "SELECT * FROM {$wpdb->prefix}shared_files_contacts";

        $total_query = "SELECT COUNT(1) FROM ({$query}) AS combined_table";
        $total = $wpdb->get_var( $total_query );

        $results = $wpdb->get_results( $query . ' ORDER BY created_at DESC LIMIT ' . $offset . ', ' .  $items_per_page, OBJECT );

        ?>

        <table class="shared-files-download-log">
        <tr>
          <th><?php echo esc_html__('Created at', 'shared-files') ?></th>
          <th><?php echo esc_html__('File list ID', 'shared-files') ?></th>
          <th><?php echo esc_html__('Name', 'shared-files') ?></th>
          <th><?php echo esc_html__('Email', 'shared-files') ?></th>
          <th><?php echo esc_html__('Phone', 'shared-files') ?></th>
          <th><?php echo esc_html__('Description', 'shared-files') ?></th>
          <th><?php echo esc_html__('URL', 'shared-files') ?></th>
        </tr>

        <?php if (sizeof($results) > 0): ?>

          <?php foreach ($results as $row): ?>

            <tr>
              <td>
                <?php echo esc_html( $row->created_at ) ?>
              </td>
              <td>
                <?php if (isset($row->ask_for_email_id)): ?>
                  <?php echo esc_html( $row->ask_for_email_id ) ?>
                <?php endif; ?>
              </td>
              <td>
                <?php if (isset($row->name)): ?>
                  <?php echo esc_html( $row->name ) ?>
                <?php endif; ?>
              </td>
              <td>
                <?php if (isset($row->email)): ?>
                  <?php echo esc_html( $row->email ) ?>
                <?php endif; ?>
              </td>
              <td>
                <?php if (isset($row->phone)): ?>
                  <?php echo esc_html( $row->phone ) ?>
                <?php endif; ?>
              </td>
              <td>
                <?php if (isset($row->descr)): ?>
                  <?php echo esc_html( $row->descr ) ?>
                <?php endif; ?>
              </td>
              <td>
                <?php if (isset($row->referer_url)): ?>
                  <?php $referer_url = esc_url_raw( $row->referer_url ); ?>
                  <?php echo '<a href="' . esc_url_raw( $referer_url ) . '" target="_blank">' . esc_url_raw( $referer_url ) . '</a>' ?>
                <?php endif; ?>
              </td>

            </tr>

          <?php endforeach; ?>

        <?php else: ?>

          <tr>
            <td colspan="7">
              <?php echo esc_html__('No contacts added yet.', 'shared-files') ?>
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
