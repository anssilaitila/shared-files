<?php

class SharedFilesAdminContacts {

  public function register_contacts_page() {
    add_submenu_page(
      'edit.php?post_type=shared_file',
      sanitize_text_field( __('Contacts of Shared Files', 'shared-files') ),
      sanitize_text_field( __('Contacts', 'shared-files') ),
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
  
    <div class="shared-files-help-support wrap">
  
      <h1 style="margin-bottom: 20px;"><?php echo esc_html__('Contacts of Shared Files', 'shared-files'); ?></h1>
  
      <div class="shared-files-admin-section shared-files-admin-section-statistics">
          
        <h2><?php echo esc_html__('Contacts', 'shared-files') ?></h2>
  
        <br />
  
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
        
        $total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
        $total = $wpdb->get_var( $total_query );
  
        $results = $wpdb->get_results( $query . ' ORDER BY created_at DESC LIMIT ' . $offset . ', ' .  $items_per_page, OBJECT );
  
        ?>
        
        <table class="shared-files-download-log">
        <tr>
          <th><?php echo esc_html__('Date', 'shared-files') ?></th>
          <th><?php echo esc_html__('Ask for email ID', 'shared-files') ?></th>
          <th><?php echo esc_html__('Embed ID', 'shared-files') ?></th>
          <th><?php echo esc_html__('Email', 'shared-files') ?></th>
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
                <?php if (isset($row->embed_id)): ?>
                  <?php echo esc_html( $row->embed_id ) ?>
                <?php endif; ?>
              </td>
              <td>
                <?php if (isset($row->email)): ?>
                  <?php echo esc_html( $row->email ) ?>
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
            <td colspan="3">
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
