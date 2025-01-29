<?php

class SharedFilesSettingsTabs {

  public function settings_page() {
  ?>

    <?php echo SharedFilesAdminHelpSupport::permalinks_alert() ?>

    <div class="shared-files-admin-page-content-container">

      <form action="options.php" method="post" class="shared-files-settings-form shared-files-admin-page">

        <h1><?php echo esc_html__('Shared Files Settings', 'shared-files') ?></h1>

        <div class="shared-files-settings-tabs-container">
          <ul class="shared-files-settings-tabs">

            <li class="shared-files-settings-tab-1-title" data-settings-container="shared-files-settings-tab-1">
              <span><?php echo esc_html__('General settings', 'shared-files')?></span>
            </li>

            <li class="shared-files-settings-tab-2-title" data-settings-container="shared-files-settings-tab-2">
              <span><?php echo esc_html__('Technical', 'shared-files')?></span>
            </li>

            <li class="shared-files-settings-tab-3-title" data-settings-container="shared-files-settings-tab-3">
              <span><?php echo esc_html__('Layout', 'shared-files')?></span>
            </li>

            <li class="shared-files-settings-tab-4-title" data-settings-container="shared-files-settings-tab-4">
              <span><?php echo esc_html__('Custom fields', 'shared-files')?></span>
            </li>

            <li class="shared-files-settings-tab-5-title" data-settings-container="shared-files-settings-tab-5">
              <span><?php echo esc_html__('File upload', 'shared-files')?></span>
            </li>

            <li class="shared-files-settings-tab-51-title" data-settings-container="shared-files-settings-tab-51">
              <span><?php echo esc_html__('Allow more file types', 'shared-files')?></span>
            </li>

            <li class="shared-files-settings-tab-6-title" data-settings-container="shared-files-settings-tab-6">
              <span><?php echo esc_html__('Icons', 'shared-files')?></span>
            </li>

            <li class="shared-files-settings-tab-7-title" data-settings-container="shared-files-settings-tab-7">
              <span><?php echo esc_html__('Custom icons', 'shared-files')?></span>
            </li>

            <li class="shared-files-settings-tab-8-title" data-settings-container="shared-files-settings-tab-8">
              <span><?php echo esc_html__('Email', 'shared-files')?></span>
            </li>

            <li class="shared-files-settings-tab-9-title" data-settings-container="shared-files-settings-tab-9">
              <span><?php echo esc_html__('Admin list', 'shared-files')?></span>
            </li>

            <li class="shared-files-settings-tab-10-title" data-settings-container="shared-files-settings-tab-10">
              <span><?php echo esc_html__('File edit', 'shared-files')?></span>
            </li>

            <li class="shared-files-settings-tab-13-title" data-settings-container="shared-files-settings-tab-13">
              <span><?php echo esc_html__('Simple list', 'shared-files')?></span>
            </li>

            <li class="shared-files-settings-tab-11-title" data-settings-container="shared-files-settings-tab-11">
              <span><?php echo esc_html__('Favorites', 'shared-files')?></span>
            </li>

            <li class="shared-files-settings-tab-12-title" data-settings-container="shared-files-settings-tab-12">
              <span><?php echo esc_html__('Wait countdown page', 'shared-files')?></span>
            </li>

            <li class="shared-files-settings-tab-14-title" data-settings-container="shared-files-settings-tab-14">
              <span><?php echo esc_html__('Custom post type', 'shared-files')?></span>
            </li>

            <li class="shared-files-settings-tab-15-title" data-settings-container="shared-files-settings-tab-15">
              <span><?php echo esc_html__('Lead generation', 'shared-files')?></span>
            </li>

            <?php $slug = 'single-file'; ?>
            <li class="shared-files-settings-tab-<?php echo esc_attr( $slug ) ?>-title" data-settings-container="shared-files-settings-tab-<?php echo esc_attr( $slug ) ?>">
              <span><?php echo esc_html__('Single file', 'shared-files')?></span>
            </li>

            <?php $slug = 'exact-search'; ?>
            <li class="shared-files-settings-tab-<?= esc_attr( $slug ) ?>-title" data-settings-container="shared-files-settings-tab-<?= esc_attr( $slug ) ?>">
              <span><?php echo esc_html__('Exact search', 'shared-files')?></span>
            </li>

            <?php $slug = 'search-log'; ?>
            <li class="shared-files-settings-tab-<?= esc_attr( $slug ) ?>-title" data-settings-container="shared-files-settings-tab-<?= esc_attr( $slug ) ?>">
              <span><?php echo esc_html__('Search log', 'shared-files')?></span>
            </li>

            <hr class="clear" />
          </ul>
        </div>

        <div class="shared-files-settings-container">

          <div class="shared-files-settings-tab-1">
            <?php settings_fields('shared-files'); ?>
            <?php do_settings_sections('shared-files'); ?>
          </div>

          <?php submit_button(); ?>

        </div>

      </form>

    </div>
    <?php
  }

  public function shared_files_settings_general_section_callback() {

    echo '<div class="shared-files-how-to-get-started">';
    echo '<h2>' . esc_html__('How to get started', 'shared-files') . '</h2>';
    echo '<ol>';
    echo '<li><span>';

    $url = esc_url_raw( get_admin_url() . 'edit.php?post_type=shared_file' );
    echo sprintf(
      wp_kses(
        /* translators: %s: link to file management */
        __('Insert files from the <a href="%s" target="_blank">file management</a>.', 'shared-files'),
        array('a' => array('href' => array(), 'target' => array()))
      ),
      esc_url($url)
    );

    echo '</span></li>';
    echo '<li><span>';

    echo wp_kses(
              __('Insert the shortcode <span class="shared-files-mini-shortcode">[shared_files]</span>, <span class="shared-files-mini-shortcode">[shared_files_simple]</span> or <span class="shared-files-mini-shortcode">[shared_files file_upload=1]</span> to the content editor of any page or post.', 'shared-files'),
              array('span' => array('class' => array()))
            );

    echo '</span></li>';

    echo '</ol>';

    echo '<div class="general-info" style="display: flex; align-items: center; align-content: center; border: 1px solid #333; background: #fff; border-radius: 2px;">';

    echo '<div class="shared-files-new-feature-container" style="margin-bottom: 0;">';
    echo '<div class="shared-files-new-feature">';
    echo esc_html__('New', 'shared-files');
    echo '</div>';
    echo '</div>';

    echo '<a href="#shared-files-country-detector" style="margin-left: 7px; color: #333; font-weight: 700;">';
    echo esc_html__("Country and city detector in download log", 'shared-files');
    echo '</a>';

    echo '</div>';

    echo '</div>';

  }

  public function shared_files_settings_tab_2_callback() {
    echo '</div>';
    echo '<div class="shared-files-settings-tab-2">';

    echo '<h2>' . esc_html__('Technical settings', 'shared-files') . '</h2>';

  //    echo '<p>' . esc_html__('Use these settings to...', 'shared-files') . '</p>';

  }

  public function shared_files_settings_tab_3_callback() {
    echo '</div>';
    echo '<div class="shared-files-settings-tab-3">';

    echo '<h2>' . esc_html__('Layout settings', 'shared-files') . '</h2>';

  }

  public function shared_files_settings_tab_4_callback() {
    echo '</div>';
    echo '<div class="shared-files-settings-tab-4">';

    echo '<h2>' . esc_html__('Custom fields', 'shared-files') . '</h2>';

  }

  public function shared_files_settings_tab_5_callback() {
    echo '</div>';
    echo '<div class="shared-files-settings-tab-5">';

    echo '<h2>' . esc_html__('Front-end file uploader settings', 'shared-files') . '</h2>';

  }

  public function shared_files_settings_tab_51_callback() {
    echo '</div>';
    echo '<div class="shared-files-settings-tab-51">';

    echo '<h2>' . esc_html__('Allow more file types', 'shared-files') . '</h2>';

    echo '<p>' . esc_html__('WordPress allows certain file types by default and you can allow more file types here.', 'shared-files') . '</p>';

    $url = 'https://codex.wordpress.org/Uploading_Files';
    echo sprintf(
      wp_kses(
        /* translators: %s: link to codex.wordpress.org/Uploading_Files */
        __('A complete list of the file types allowed by default can be found here <a href="%s" target="_blank">here</a>.', 'shared-files'),
        array('a' => array('href' => array(), 'target' => array()))
      ),
      esc_url($url)
    );

  }

  public function shared_files_settings_tab_6_callback() {
    echo '</div>';
    echo '<div class="shared-files-settings-tab-6">';

    echo '<h2>' . esc_html__('Change default icons', 'shared-files') . '</h2>';

  }

  public function shared_files_settings_tab_7_callback() {
    echo '</div>';
    echo '<div class="shared-files-settings-tab-7">';

    echo '<h2>' . esc_html__('Custom icons', 'shared-files') . '</h2>';

    echo '<p>' . esc_html__('Define extensions and icons for custom file types here. You may add the files to the media library and then copy the URL to the appropriate field below.', 'shared-files') . '</p>';

  }

  public function shared_files_settings_tab_8_callback() {
    echo '</div>';
    echo '<div class="shared-files-settings-tab-8">';

    echo '<h2>' . esc_html__('Email settings', 'shared-files') . '</h2>';

  }

  public function shared_files_settings_admin_list_section_callback() {
    echo '</div>';
    echo '<div class="shared-files-settings-tab-9">';

    echo '<h2>' . esc_html__('Admin list', 'shared-files') . '</h2>';

  }

  public function shared_files_settings_tab_10_callback() {
    echo '</div>';
    echo '<div class="shared-files-settings-tab-10">';

    echo '<h2>' . esc_html__('File edit settings', 'shared-files') . '</h2>';

    echo '<p>' . esc_html__('These settings are valid for shortcodes [shared_files edit=1] and [shared_files_categories edit=1].', 'shared-files') . '</p>';

    echo '<p>' . esc_html__('The following user roles have the permissions to edit any file:', 'shared-files') . '</p>';

  }

  public function shared_files_settings_tab_10_2_callback() {

    echo '<p>' . esc_html__('More settings for file edit view:', 'shared-files') . '</p>';

  }

  public function shared_files_settings_tab_11_callback() {
    echo '</div>';
    echo '<div class="shared-files-settings-tab-11">';

    echo '<h2>' . esc_html__('Favorites', 'shared-files') . '</h2>';

  }

  public function shared_files_settings_tab_12_callback() {
    echo '</div>';
    echo '<div class="shared-files-settings-tab-12">';

    echo '<h2>' . esc_html__('Wait countdown page', 'shared-files') . '</h2>';

  }

  public function shared_files_settings_tab_13_callback() {
    echo '</div>';
    echo '<div class="shared-files-settings-tab-13">';

    echo '<h2>' . esc_html__('Simple list', 'shared-files') . '</h2>';

  }

  public function shared_files_settings_tab_14_callback() {
    echo '</div>';
    echo '<div class="shared-files-settings-tab-14">';

    echo '<h2>' . esc_html__('Custom post type', 'shared-files') . '</h2>';

  }

  public function shared_files_settings_tab_15_callback() {
    echo '</div>';
    echo '<div class="shared-files-settings-tab-15">';

    echo '<h2>' . esc_html__('Lead generation / ask for contact info before showing the file(s)', 'shared-files') . '</h2>';

    echo '<p>' . esc_html__('These settings are valid for shortcodes with the parameter ask_for_contact_info like [shared_files ask_for_contact_info=1].', 'shared-files') . '</p>';

    echo '<p>' . esc_html__('The user is asked to fill in their contact info before showing the file list.', 'shared-files') . '</p>';

  }

  public function shared_files_settings_tab_single_file_callback() {

    $slug = 'single-file';

    echo '</div>';
    echo '<div class="shared-files-settings-tab-' . esc_attr( $slug ) . '">';

    echo '<h2>' . esc_html__('Single file', 'shared-files') . '</h2>';

    echo '<p>' . esc_html__('These settings are valid for shortcodes with the parameter file_id like [shared_files file_id=12345].', 'shared-files') . '</p>';

  }

  public function shared_files_settings_tab_exact_search_callback() {

    $slug = 'exact-search';

    echo '</div>';
    echo '<div class="shared-files-settings-tab-' . esc_attr( $slug ) . '">';

    echo '<h2>' . esc_html__('Exact search', 'shared-files') . '</h2>';

    echo '<p>' . esc_html__('These settings are valid for the shortcode [shared_files_exact_search].', 'shared-files') . '</p>';

    echo '<p>' . esc_html__('The exact search targets all files (only their titles by default) and shows the files after enter is pressed.', 'shared-files') . '</p>';

  }

  public function shared_files_settings_tab_exact_search_more_callback() {

    echo '<hr />';

  }

  public function shared_files_settings_tab_search_log_callback() {

    $slug = 'search-log';

    echo '</div>';
    echo '<div class="shared-files-settings-tab-' . esc_attr( $slug ) . '">';

    echo '<h2>' . esc_html__('Search log', 'shared-files') . '</h2>';

    echo '<p>' . esc_html__('These settings are valid for all shortcodes and blocks that contain the search input field.', 'shared-files') . '</p>';

  }

}
