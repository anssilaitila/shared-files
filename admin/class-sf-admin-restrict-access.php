<?php

class SharedFilesAdminRestrictAccess {

  public function register_page() {

    $menu_pos = 8;

    if (SharedFilesHelpers::isPremium() == 1) {
      $menu_pos = 9;
    }
    
    add_submenu_page(
      'edit.php?post_type=shared_file',
      sanitize_text_field( __('Restrict access to files', 'shared-files') ),
      '<span style="font-size: 15px; margin: 0 2px 0 5px;">&#8627;</span> ' . sanitize_text_field( __('Restrict Access', 'shared-files') ),
      'manage_options',
      'shared-files-restrict-access',
      [$this, 'register_page_callback'],
      $menu_pos
    );

  }

  public function register_page_callback() {
    ?>
    
    <div class="shared-files-sync-files">
      <h1><?php echo esc_html__('Restrict access to files on server level', 'shared-files'); ?></h1>

      <?php if (0): ?>
        <p>
          <?php echo esc_html__('The following information should be noted when using the password protection or restricting the access to files for specific users and roles.', 'shared-files') ?>
        </p>
      <?php endif; ?>

      <div style="background: #fff; display: inline-block; padding: 1rem; font-size: 15px;">
        <?php echo esc_html__('The following information should be noted <b>when using the password protection or restricting the access to files for specific users and roles</b>.', 'shared-files') ?>
      </div>
      
      <hr class="clear" />

      <p><?php echo esc_html__('The setting "File opening method" defines the way the file urls work (plugin settings, Technical tab).', 'shared-files') ?></p>
      
      <h3><?php echo esc_html__('File opening method: Default', 'shared-files') ?></h3>
      
      <p><?php echo esc_html__('Default method means opening the files using the following url format:', 'shared-files') ?></p>
      
      <div style="background: #fff; display: inline-block; padding: 3px 8px;">
        <?php echo esc_html__('/shared-files/123/this-is-a-file.pdf', 'shared-files') ?>
      </div>

      <p><?php echo esc_html__('When the file is opened, the user will see that same url on the browser. The plugin will locate the actual file on the server, check for password protection and access restrictions and serve it to the user.', 'shared-files') ?></p>
      
      <h3><?php echo esc_html__('File opening method: Redirect', 'shared-files') ?></h3>
      
      <p><?php echo esc_html__('Redirect method means that while the file url is at first the same as it is using the default method, the user will be redirected to the actual location on server like so:', 'shared-files') ?></p>
      
      <div style="background: #fff; display: inline-block; padding: 3px 8px;">
        <?php echo esc_html__('/wp-content/uploads/shared-files/this-is-a-file.pdf', 'shared-files') ?>
      </div>
      
      <h3><?php echo esc_html__('How to prevent direct access to files on the server', 'shared-files') ?></h3>
      
      <p><?php echo esc_html__('When using either one of the file opening methods and regardless of passwords or other restrictions, the direct access to file urls like /wp-content/uploads/shared-files/this-is-a-file.pdf remains.', 'shared-files') ?></p>
      
      <p style="font-weight: 700;"><?php echo esc_html__('If you wish to prevent anyone from opening the files using the direct urls like /wp-content/uploads/shared-files/this-is-a-file.pdf, you should make the necessary restrictions to the web server configuration (Nginx, Apache, etc.) and use the default file opening method (file urls formatted like /shared-files/123/this-is-a-file.pdf).', 'shared-files') ?></p>
      
      <p><?php echo esc_html__("If you don't make such adjustments, the plugin will work normally, but it should be noted that the files would be accessible using the direct urls like /wp-content/uploads/shared-files/this-is-a-file.pdf.", "shared-files") ?></p>

    </div>
    <?php
  }

}
