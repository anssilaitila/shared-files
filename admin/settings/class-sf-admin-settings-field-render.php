<?php

class SharedFilesSettingsFieldRender {

  public function checkbox_render($args) {

    if ($field_name = $args['field_name']) {
      $options = get_option('shared_files_settings');
      ?>

      <?php $free = 0 ?>
      <?php $free_class = '' ?>
      <?php $plan_required = 'All Plans' ?>

      <?php $show_info = 0 ?>

      <?php if (substr($field_name, 0, strlen('_FREE_')) === '_FREE_'): ?>
        <?php $free = 1 ?>
        <?php $free_class = 'shared-files-setting-container-free' ?>

        <?php if (strpos($field_name, '_use_as_search_filter') !== false): ?>
          <?php $plan_required = 'Pro' ?>
        <?php elseif (strpos($field_name, 'file_upload_multiple_new_categories') !== false): ?>
          <?php $plan_required = 'Pro' ?>
        <?php elseif (strpos($field_name, 'file_upload_multiple_new_tags') !== false): ?>
          <?php $plan_required = 'Pro' ?>

        <?php elseif (strpos($field_name, 'file_edit_hide_external_url') !== false): ?>
          <?php $plan_required = 'Pro' ?>
        <?php elseif (strpos($field_name, 'file_edit_hide_category_checkboxes') !== false): ?>
          <?php $plan_required = 'Pro' ?>
        <?php elseif (strpos($field_name, 'file_edit_hide_new_categories') !== false): ?>
          <?php $plan_required = 'Pro' ?>
        <?php elseif (strpos($field_name, 'file_edit_hide_tag_checkboxes') !== false): ?>
          <?php $plan_required = 'Pro' ?>
        <?php elseif (strpos($field_name, 'file_edit_hide_new_tags') !== false): ?>
          <?php $plan_required = 'Pro' ?>
        <?php elseif (strpos($field_name, 'file_edit_hide_description') !== false): ?>
          <?php $plan_required = 'Pro' ?>
        <?php elseif (strpos($field_name, 'remove_link_from_file_title') !== false): ?>
          <?php $plan_required = 'Pro' ?>
        <?php elseif (strpos($field_name, 'exact_search_whole_words_only') !== false): ?>
          <?php $plan_required = 'Pro' ?>
        <?php elseif (strpos($field_name, 'exact_search_ignore_file_extension') !== false): ?>
          <?php $plan_required = 'Pro' ?>
        <?php elseif (strpos($field_name, 'remove_obsolete_file_metadata_automatically') !== false): ?>
          <?php $plan_required = 'Pro' ?>
        <?php elseif (strpos($field_name, 'exact_search_more_fields') !== false): ?>
          <?php $plan_required = 'Pro' ?>
        <?php elseif (strpos($field_name, 'exact_search_custom_field_') !== false): ?>
          <?php $plan_required = 'Pro' ?>

        <?php elseif ($field_name == '_FREE_enable_single_file_page'): ?>
          <?php $plan_required = 'Pro' ?>
        <?php elseif ($field_name == '_FREE_show_files_in_site_search_results'): ?>
          <?php $plan_required = 'Pro' ?>
        <?php elseif ($field_name == '_FREE_file_upload_enable_restrict_access_for_users'): ?>
          <?php $plan_required = 'Pro' ?>
        <?php elseif ($field_name == '_FREE_file_upload_enable_restrict_access_for_roles'): ?>
          <?php $plan_required = 'Pro' ?>
        <?php elseif ($field_name == '_FREE_send_file_uploaded_email_to_users'): ?>
          <?php $plan_required = 'Pro' ?>

        <?php elseif (strpos($field_name, 'log_enable_city') !== false): ?>
          <?php $plan_required = 'Pro' ?>
        <?php elseif (strpos($field_name, 'esl_user_city') !== false): ?>
          <?php $plan_required = 'Pro' ?>

        <?php elseif (strpos($field_name, 'activate_favorite_files') !== false): ?>
          <?php $plan_required = 'Max' ?>
        <?php elseif (strpos($field_name, 'activate_favorite_files_non_logged_in') !== false): ?>
          <?php $plan_required = 'Max' ?>
        <?php elseif (strpos($field_name, 'show_title_above_favorite_files') !== false): ?>
          <?php $plan_required = 'Max' ?>

        <?php elseif (strpos($field_name, 'activate_wait_page') !== false): ?>
          <?php $plan_required = 'Max' ?>
        <?php elseif (strpos($field_name, 'wait_page_hide_download_button') !== false): ?>
          <?php $plan_required = 'Max' ?>
        <?php elseif (strpos($field_name, 'obfuscate_file_urls') !== false): ?>
          <?php $plan_required = 'Max' ?>
          <?php $show_info = 1 ?>

        <?php endif; ?>

      <?php endif; ?>

      <div class="shared-files-setting-container <?php echo esc_attr( $free_class ) ?>">

        <?php if ($free): ?>

          <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing">
            <div class="shared-files-settings-pro-feature-overlay"><div><?php echo esc_html( $plan_required ) ?></div></div>
          </a>

        <?php else: ?>

          <div class="shared-files-setting">
            <input type="checkbox" id="shared-files-<?php echo esc_attr( $field_name ) ?>" name="shared_files_settings[<?php echo esc_attr( $field_name ) ?>]" <?php echo isset($options[$field_name]) ? 'checked="checked"' : ''; ?>>
          </div>

        <?php endif; ?>

      </div>

      <?php if ($args['field_name'] == 'wp_engine_compatibility_mode'): ?>
        <div class="email-info">
          <?php echo esc_html__('An extra "?" is automatically added to the URLs before the filename:', 'shared-files') ?><br /><b>/shared-files/123/?this-is-a-file.pdf</b>
        </div>
      <?php elseif ($args['field_name'] == 'file_access_logged_in_only' || $args['field_name'] == '_FREE_file_access_logged_in_only'): ?>
        <div class="email-info">
          <?php echo esc_html__('When checked, file lists are readable, but opening and downloading files will require a login.', 'shared-files') ?><br />
        </div>
      <?php elseif ($args['field_name'] == 'uncheck_hide_from_other_pages'): ?>
        <div class="email-info">
          <?php echo esc_html__('If checked, all uploaded files will be instantly listed on also other shortcodes/pages.', 'shared-files') ?><br />
        </div>
      <?php elseif ($args['field_name'] == 'exact_search_ignore_file_extension'): ?>
        <div class="email-info">
          <?php echo esc_html__('Ignores the last dot and all characters after that in the file title, otherwise an exact match is required when the setting "Search whole words only" is also active.', 'shared-files') ?><br />
        </div>
      <?php elseif ($args['field_name'] == 'obfuscate_file_urls' || $show_info): ?>
        <div class="email-info">
          <?php echo esc_html__('Generate long random urls for files, like so:', 'shared-files') ?><br />
          <strong>/shared-files/5348-9f13c19ce03475aa0565010094d83678/this-is-a-file.pdf</strong><br /><br />
          <?php echo esc_html__("Files can't be opened without knowing the exact long part before the filename.", 'shared-files') ?><br />
        </div>
      <?php elseif ($args['field_name'] == 'remove_obsolete_file_metadata_automatically'): ?>
        <div class="email-info">
          <?php echo esc_html__("If a file isn't readable or doesn't exist at all (you may have manually deleted the file from the server), you may want to delete the file metadata automatically, so there won't be an error message in the frontend file list.", 'shared-files') ?><br /><br />
          <?php echo esc_html__("If this setting is checked, the related file metadata is automatically moved to trash.", 'shared-files') ?>
        </div>
      <?php elseif ( isset( $args['placeholder'] ) && $args['placeholder'] ): ?>
        <div class="email-info">
          <?php echo esc_html( $args['placeholder'] ) ?><br />
        </div>

      <?php elseif ($field_name == 'enable_single_file_page' || $field_name == '_FREE_enable_single_file_page'): ?>

        <div class="general-info">
          <?php echo esc_html__("Each file will have their own page under slug 'shared_file', and as content the regular file card, url being like so:", 'shared-files') ?>
          /shared_file/sample-file/<br /><br />

          <?php echo esc_html__("It's also possible to customize the template by having the file single-shared_file.php in your theme.", 'shared-files') ?>

        </div>

      <?php elseif ($field_name == 'show_files_in_site_search_results' || $field_name == '_FREE_show_files_in_site_search_results'): ?>

          <div class="general-info">
            <?php echo esc_html__("Show the files in the site search results. Proper function requires also the single file pages enabled.", 'shared-files') ?>
          </div>

      <?php elseif ($field_name == 'log_enable_country' || $field_name == '_FREE_log_enable_country'): ?>

          <div class="general-info" id="shared-files-country-detector">
            <div class="shared-files-new-feature-container">
              <div class="shared-files-new-feature">
                <?= esc_html__('New', 'shared-files') ?>
              </div>
            </div>

            <p><?php echo esc_html__("If enabled, the downloader's country is automatically detected based on the downloader's IP address by using an external service at ws.tammersoft.com, hosted and maintained by the plugin developer.", 'shared-files') ?></p>

            <p><?php echo esc_html__("The following information is sent to ws.tammersoft.com in the process:", 'shared-files') ?></p>

            <ul class="shared-files-ws-details">
              <li><?php echo esc_html__('IP address', 'shared-files') ?></li>
              <li><?php echo esc_html__('Site URL', 'shared-files') ?></li>
              <li><?php echo esc_html__('Freemius User ID (number)', 'shared-files') ?></li>
              <li><?php echo esc_html__('Freemius License ID (number)', 'shared-files') ?></li>
              <li><?php echo esc_html__('Freemius Install ID (number)', 'shared-files') ?></li>
            </ul>

            <p><?php echo esc_html__("Using the service requires an active subscription or a lifetime license.", 'shared-files') ?></p>

            <p><?php
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

      <?php elseif ($field_name == 'log_enable_city' || $field_name == '_FREE_log_enable_city'): ?>

        <div class="general-info">
          <div class="shared-files-new-feature-container">
            <div class="shared-files-new-feature">
              <?= esc_html__('New', 'shared-files') ?>
            </div>
          </div>

          <p><?php echo esc_html__("The city is detected the same way as the country (described above).", 'shared-files') ?></p>

        </div>

      <?php elseif ($field_name == 'esl_user_country' || $field_name == '_FREE_esl_user_country'): ?>

          <div class="general-info">
            <div class="shared-files-new-feature-container">
              <div class="shared-files-new-feature">
                <?= esc_html__('New', 'shared-files') ?>
              </div>
            </div>

            <p><?php echo esc_html__("If enabled, the searcher's country is automatically detected based on the their IP address by using an external service at ws.tammersoft.com, hosted and maintained by the plugin developer.", 'shared-files') ?></p>

            <p><?php echo esc_html__("The following information is sent to ws.tammersoft.com in the process:", 'shared-files') ?></p>

            <ul class="shared-files-ws-details">
              <li><?php echo esc_html__('IP address', 'shared-files') ?></li>
              <li><?php echo esc_html__('Site URL', 'shared-files') ?></li>
              <li><?php echo esc_html__('Freemius User ID (number)', 'shared-files') ?></li>
              <li><?php echo esc_html__('Freemius License ID (number)', 'shared-files') ?></li>
              <li><?php echo esc_html__('Freemius Install ID (number)', 'shared-files') ?></li>
            </ul>

            <p><?php echo esc_html__("Using the service requires an active subscription or a lifetime license.", 'shared-files') ?></p>

            <p><?php
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

      <?php elseif ($field_name == 'esl_user_city' || $field_name == '_FREE_esl_user_city'): ?>

          <div class="general-info">
            <div class="shared-files-new-feature-container">
              <div class="shared-files-new-feature">
                <?= esc_html__('New', 'shared-files') ?>
              </div>
            </div>

            <p><?php echo esc_html__("The city is detected the same way as the country (described above).", 'shared-files') ?></p>

          </div>

      <?php endif; ?>

      <?php

    }
  }

  public function restrict_file_types_render($args) {

    if ($field_name = $args['field_name']) {
      $options = get_option('shared_files_settings');

      $val = '';

      if (isset($options[$args['field_name']])) {
        $val = sanitize_text_field( $options[$args['field_name']] );
      }
      ?>

      <?php $free = 0 ?>
      <?php $free_class = '' ?>

      <?php if (substr($field_name, 0, strlen('_FREE_')) === '_FREE_'): ?>
        <?php $free = 1 ?>
        <?php $free_class = 'shared-files-setting-container-free' ?>
      <?php endif; ?>

      <div class="shared-files-setting-container <?php echo esc_attr( $free_class ) ?>">

        <?php if ($free): ?>

          <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing">
            <div class="shared-files-settings-pro-feature-overlay"><div><?php echo esc_html__('All Plans', 'shared-files') ?></div></div>
          </a>

        <?php else: ?>

          <div class="shared-files-setting">

            <select name="shared_files_settings[<?php echo esc_attr( $args['field_name'] ) ?>]">
              <option value="" <?php echo ($val == '') ? 'selected' : ''; ?>></option>
              <option value="any_sound_file" <?php echo $val == 'any_sound_file' ? 'selected' : ''; ?>><?php echo esc_html__('Any sound file', 'shared-files'); ?></option>
              <option value="any_video_file" <?php echo $val == 'any_video_file' ? 'selected' : ''; ?>><?php echo esc_html__('Any video file', 'shared-files'); ?></option>
              <option value="any_image_file" <?php echo $val == 'any_image_file' ? 'selected' : ''; ?>><?php echo esc_html__('Any image file', 'shared-files'); ?></option>
            </select>

          </div>

        <?php endif; ?>

      </div>

      <?php

    }
  }

  public function custom_fields_cnt_render($args) {

    if ($field_name = $args['field_name']) {
      $options = get_option('shared_files_settings');

      $val = '';

      if (isset($options[$args['field_name']])) {
        $val = sanitize_text_field( $options[$args['field_name']] );
      }
      ?>

      <?php $free = 0 ?>
      <?php $free_class = '' ?>
      <?php $plan_required = 'Pro' ?>

      <?php if (substr($field_name, 0, strlen('_FREE_')) === '_FREE_'): ?>
        <?php $free = 1 ?>
        <?php $free_class = 'shared-files-setting-container-free' ?>
      <?php endif; ?>

      <div class="shared-files-setting-container <?php echo esc_attr( $free_class ) ?>">

        <?php if ($free): ?>

          <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing">
            <div class="shared-files-settings-pro-feature-overlay"><div><?php echo esc_html( $plan_required ) ?></div></div>
          </a>

        <?php else: ?>

          <div class="shared-files-setting">

            <select name="shared_files_settings[<?php echo esc_attr( $args['field_name'] ) ?>]">
              <option value="" <?php echo ($val == '') ? 'selected' : ''; ?>></option>
              <option value="1" <?php echo $val == '1' ? 'selected' : ''; ?>>1</option>
              <option value="2" <?php echo $val == '2' ? 'selected' : ''; ?>>2</option>
              <option value="3" <?php echo $val == '3' ? 'selected' : ''; ?>>3</option>
              <option value="4" <?php echo $val == '4' ? 'selected' : ''; ?>>4</option>
              <option value="5" <?php echo $val == '5' ? 'selected' : ''; ?>>5</option>
              <option value="6" <?php echo $val == '6' ? 'selected' : ''; ?>>6</option>
              <option value="7" <?php echo $val == '7' ? 'selected' : ''; ?>>7</option>
              <option value="8" <?php echo $val == '8' ? 'selected' : ''; ?>>8</option>
              <option value="9" <?php echo $val == '9' ? 'selected' : ''; ?>>9</option>
              <option value="10" <?php echo $val == '10' ? 'selected' : ''; ?>>10</option>
              <option value="11" <?php echo $val == '11' ? 'selected' : ''; ?>>11</option>
              <option value="12" <?php echo $val == '12' ? 'selected' : ''; ?>>12</option>
              <option value="13" <?php echo $val == '13' ? 'selected' : ''; ?>>13</option>
              <option value="14" <?php echo $val == '14' ? 'selected' : ''; ?>>14</option>
              <option value="15" <?php echo $val == '15' ? 'selected' : ''; ?>>15</option>
              <option value="16" <?php echo $val == '16' ? 'selected' : ''; ?>>16</option>
              <option value="17" <?php echo $val == '17' ? 'selected' : ''; ?>>17</option>
              <option value="18" <?php echo $val == '18' ? 'selected' : ''; ?>>18</option>
              <option value="19" <?php echo $val == '19' ? 'selected' : ''; ?>>19</option>
              <option value="20" <?php echo $val == '20' ? 'selected' : ''; ?>>20</option>
            </select>

            <div class="email-info">
              <?php echo esc_html__('Choose a value and save the settings, and the new custom fields will be usable.', 'shared-files') ?>
            </div>

          </div>

        <?php endif; ?>

      </div>

      <?php

    }
  }

  public function custom_file_types_cnt_render($args) {

    if ($field_name = $args['field_name']) {
      $options = get_option('shared_files_settings');

      $val = '';

      if (isset($options[$args['field_name']])) {
        $val = sanitize_text_field( $options[$args['field_name']] );
      }
      ?>

      <div class="shared-files-setting-container">

        <div class="shared-files-setting">

          <select name="shared_files_settings[<?php echo esc_attr( $args['field_name'] ) ?>]">
            <option value="" <?php echo ($val == '') ? 'selected' : ''; ?>></option>
            <option value="1" <?php echo $val == '1' ? 'selected' : ''; ?>>1</option>
            <option value="2" <?php echo $val == '2' ? 'selected' : ''; ?>>2</option>
            <option value="3" <?php echo $val == '3' ? 'selected' : ''; ?>>3</option>
            <option value="4" <?php echo $val == '4' ? 'selected' : ''; ?>>4</option>
            <option value="5" <?php echo $val == '5' ? 'selected' : ''; ?>>5</option>
            <option value="6" <?php echo $val == '6' ? 'selected' : ''; ?>>6</option>
            <option value="7" <?php echo $val == '7' ? 'selected' : ''; ?>>7</option>
            <option value="8" <?php echo $val == '8' ? 'selected' : ''; ?>>8</option>
            <option value="9" <?php echo $val == '9' ? 'selected' : ''; ?>>9</option>
            <option value="10" <?php echo $val == '10' ? 'selected' : ''; ?>>10</option>
            <option value="11" <?php echo $val == '11' ? 'selected' : ''; ?>>11</option>
            <option value="12" <?php echo $val == '12' ? 'selected' : ''; ?>>12</option>
            <option value="13" <?php echo $val == '13' ? 'selected' : ''; ?>>13</option>
            <option value="14" <?php echo $val == '14' ? 'selected' : ''; ?>>14</option>
            <option value="15" <?php echo $val == '15' ? 'selected' : ''; ?>>15</option>
            <option value="16" <?php echo $val == '16' ? 'selected' : ''; ?>>16</option>
            <option value="17" <?php echo $val == '17' ? 'selected' : ''; ?>>17</option>
            <option value="18" <?php echo $val == '18' ? 'selected' : ''; ?>>18</option>
            <option value="19" <?php echo $val == '19' ? 'selected' : ''; ?>>19</option>
            <option value="20" <?php echo $val == '20' ? 'selected' : ''; ?>>20</option>
          </select>

          <div class="email-info">
            <?php echo esc_html__('Choose a value and save the settings, and the new fields will be usable.', 'shared-files') ?>
          </div>

        </div>

      </div>

      <?php

    }
  }

  public function textarea_render($args) {

    if ($field_name = $args['field_name']) {
      $options = get_option('shared_files_settings');
      ?>

      <?php $free = 0 ?>
      <?php $free_class = '' ?>

      <?php if (substr($field_name, 0, strlen('_FREE_')) === '_FREE_'): ?>
        <?php $free = 1 ?>
        <?php $free_class = 'shared-files-setting-container-free' ?>
      <?php endif; ?>

      <div class="shared-files-setting-container <?php echo esc_attr( $free_class ) ?>">

        <?php if ($free): ?>

          <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing">
            <div class="shared-files-settings-pro-feature-overlay"><div><?php echo esc_html__('All Plans', 'shared-files') ?></div></div>
          </a>

        <?php else: ?>

          <div class="shared-files-setting">

              <?php $val = '' ?>

              <?php if ( isset($options[$field_name]) && $options[$field_name] ): ?>
                <?php $val = sanitize_textarea_field( $options[$field_name] ) ?>
              <?php endif; ?>

              <textarea class="textarea-field" id="shared-files-<?php echo esc_attr( $field_name ) ?>" name="shared_files_settings[<?php echo esc_attr( $field_name ) ?>]" placeholder="<?php echo $args['placeholder'] ? esc_attr( $args['placeholder'] ) : '' ?>"><?php echo isset($val) ? esc_html( $val ) : ''; ?></textarea>

          </div>

        <?php endif; ?>

      </div>

      <?php

    }
  }

  public function input_render($args) {

    if ($field_name = $args['field_name']) {
      $options = get_option('shared_files_settings');
      ?>

      <?php $free = 0 ?>
      <?php $free_class = '' ?>
      <?php $plan_required = 'All Plans' ?>

      <?php if (substr($field_name, 0, strlen('_FREE_')) === '_FREE_'): ?>
        <?php $free = 1 ?>
        <?php $free_class = 'shared-files-setting-container-free' ?>

        <?php if (strpos($field_name, 'cf_') !== false && strpos($field_name, '_select_title') !== false): ?>
          <?php $plan_required = 'Pro' ?>
        <?php elseif (strpos($field_name, 'exact_search_min_chars') !== false): ?>
          <?php $plan_required = 'Pro' ?>

        <?php elseif (strpos($field_name, 'favorite_files_text_add_to_favorites') !== false): ?>
          <?php $plan_required = 'Max' ?>
        <?php elseif (strpos($field_name, 'favorite_files_text_favorited') !== false): ?>
          <?php $plan_required = 'Max' ?>
        <?php elseif (strpos($field_name, 'favorite_files_title_text') !== false): ?>
          <?php $plan_required = 'Max' ?>
        <?php elseif (strpos($field_name, 'favorite_files_text_delete_from_favorites') !== false): ?>
          <?php $plan_required = 'Max' ?>
        <?php elseif (strpos($field_name, 'favorite_files_text_deleted') !== false): ?>
          <?php $plan_required = 'Max' ?>

        <?php elseif (strpos($field_name, 'wait_page_text_before_seconds') !== false): ?>
          <?php $plan_required = 'Max' ?>
        <?php elseif (strpos($field_name, 'wait_page_countdown_seconds') !== false): ?>
          <?php $plan_required = 'Max' ?>
        <?php elseif (strpos($field_name, 'wait_page_text_after_seconds') !== false): ?>
          <?php $plan_required = 'Max' ?>
        <?php elseif (strpos($field_name, 'wait_page_download_button_text') !== false): ?>
          <?php $plan_required = 'Max' ?>

        <?php endif; ?>

      <?php endif; ?>

      <div class="shared-files-setting-container <?php echo esc_attr( $free_class ) ?>">

        <?php if ($free): ?>

          <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing">
            <div class="shared-files-settings-pro-feature-overlay"><div><?php echo esc_html( $plan_required ) ?></div></div>
          </a>

        <?php else: ?>

          <div class="shared-files-setting">

            <?php $val = '' ?>

            <?php if ( isset($options[$field_name]) ): ?>
              <?php $val = sanitize_text_field( $options[$field_name] ) ?>
            <?php endif; ?>

            <?php if ($field_name == 'card_background_custom_color'): ?>
              # <input type="text" style="width: 100px;" class="input-field <?php echo isset($args['wide']) ? 'input-field-wide' : '' ?>" id="shared-files-<?php echo esc_attr( $field_name ) ?>" name="shared_files_settings[<?php echo esc_attr( $field_name ) ?>]" value="<?php echo isset($val) ? esc_attr( $val ) : ''; ?>" placeholder="<?php echo isset($args['placeholder']) ? esc_attr( $args['placeholder'] ) : '' ?>">
            <?php elseif (isset($args['ext'])): ?>
              filename.<input type="text" class="input-field <?php echo isset($args['wide']) ? 'input-field-wide' : '' ?>" id="shared-files-<?php echo esc_attr( $field_name ) ?>" name="shared_files_settings[<?php echo esc_attr( $field_name ) ?>]" value="<?php echo isset($val) ? esc_attr( $val ) : ''; ?>" placeholder="<?php echo isset($args['placeholder']) ? esc_attr( $args['placeholder'] ) : '' ?>" style="width: 80px;">
            <?php else: ?>
              <input type="text" class="input-field <?php echo isset($args['wide']) ? 'input-field-wide' : '' ?>" id="shared-files-<?php echo esc_attr( $field_name ) ?>" name="shared_files_settings[<?php echo esc_attr( $field_name ) ?>]" value="<?php echo isset($val) ? esc_attr( $val ) : ''; ?>" placeholder="<?php echo isset($args['placeholder']) ? esc_attr( $args['placeholder'] ) : '' ?>">
            <?php endif; ?>

          </div>

        <?php endif; ?>

      </div>

      <?php if ($field_name == 'wp_location'): ?>
        <div class="email-info">
          <?php echo esc_html__('This setting is required, if you have installed WordPress in a subdirectory.', 'shared-files') ?><br /><br />
          <?php echo esc_html__('Please check the WordPress Address (URL) of your site from WP admin / Settings / General, if there is a path after the domain, you should add the same path here.', 'shared-files') ?><br /><br />
          <?php echo esc_html__('If this is set, the file URLs are automatically formatted like so:', 'shared-files') ?><br /><b>/wp-folder/shared-files/123/this-is-a-file.pdf</b>
        </div>
      <?php elseif ($field_name == 'folder_for_new_files'): ?>
        <div class="email-info">
          <?php echo esc_html__('Normally the files are saved under wp-content/uploads/shared-files/.', 'shared-files') ?><br /><br />
          <?php echo esc_html__('If you wish the new files to be saved to a subfolder under wp-content/uploads/shared-files/, define the folder name here.', 'shared-files') ?><br /><br />
          <?php echo esc_html__('When this folder name is defined, new files will be saved under this path:', 'shared-files') ?><br/>
          <?php echo esc_html__('wp-content/uploads/shared-files/folder-name/', 'shared-files') ?>
        </div>
      <?php elseif ($field_name == 'maximum_size_text'): ?>
        <div class="email-info">
          <?php echo esc_html__('This is for informational purposes only.') ?><br />
          <?php echo esc_html__('The text defined here replaces the default automatically detected maximum file size.', 'shared-files') ?>
        </div>
      <?php elseif ($field_name == 'icon_for_image' || $field_name == 'custom_1_icon' || $field_name == 'folder_icon_uri'): ?>
        <p><?php echo esc_html__('e.g. /wp-content/uploads/2023/01/custom-icon.png', 'shared-files') ?></p>
      <?php elseif ($field_name == 'file_upload_send_email'): ?>
        <div class="email-info">
          <?php echo esc_html__('Enter an email address to receive the notify, or multiple email addresses separated by a comma.', 'shared-files') ?>
        </div>
      <?php elseif ($field_name == 'file_upload_custom_field_1'): ?>
        <div class="email-info">
          <?php echo esc_html__('Enter a title here and the custom field (an input field) is automatically activated.', 'shared-files') ?>
        </div>
      <?php elseif ($field_name == 'file_upload_restrict_file_extensions'): ?>
        <div class="email-info">
          <?php echo esc_html__('A comma separated list of accepted file extensions and/or file types, for example:', 'shared-files') ?>
          <ul style="list-style: inside; padding-left: 10px; margin-bottom: 0;">
            <li>.gif, .jpg, .png, .doc</li>
            <li>.doc, .docx, application/msword</li>
            <li><?php echo esc_html__('More information', 'shared-files') ?> <a href="https://developer.mozilla.org/en-US/docs/Web/HTML/Attributes/accept" target="_blank"><?php echo esc_html__('here', 'shared-files') ?></a></li>
          </ul>
        </div>
      <?php endif; ?>

      <?php

    }
  }

  public function layout_render($args) {

    if ($args['field_name']) {
      $options = get_option('shared_files_settings');
      $layout = '';

      if (isset($options[$args['field_name']])) {
        $layout = sanitize_text_field( $options[$args['field_name']] );
      }
      ?>
      <select name="shared_files_settings[<?php echo esc_attr( $args['field_name'] ) ?>]">
          <option value=""><?php echo esc_html__('Default list', 'shared-files'); ?></option>
          <option value="2-cards-on-the-same-row" <?php echo $layout == '2-cards-on-the-same-row' ? 'selected' : ''; ?>><?php echo esc_html__('2 columns', 'shared-files'); ?></option>
          <option value="3-cards-on-the-same-row" <?php echo $layout == '3-cards-on-the-same-row' ? 'selected' : ''; ?>><?php echo esc_html__('3 columns', 'shared-files'); ?></option>
          <option value="4-cards-on-the-same-row" <?php echo $layout == '4-cards-on-the-same-row' ? 'selected' : ''; ?>><?php echo esc_html__('4 columns', 'shared-files'); ?></option>
      </select>
      <?php

    }
  }

  public function wait_page_render($args) {

    if ($field_name = $args['field_name']) {
      $options = get_option('shared_files_settings');

      $val = '';

      if (isset($options[$field_name])) {
        $val = sanitize_text_field( $options[$field_name] );
      }
      ?>

      <?php $free = 0 ?>
      <?php $free_class = '' ?>

      <?php if (substr($field_name, 0, strlen('_FREE_')) === '_FREE_'): ?>
        <?php $free = 1 ?>
        <?php $free_class = 'shared-files-setting-container-free' ?>
      <?php endif; ?>

      <div class="shared-files-setting-container <?php echo esc_attr( $free_class ) ?>">

        <?php if ($free): ?>

          <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing">
            <div class="shared-files-settings-pro-feature-overlay"><div><?php echo esc_html__('Max', 'shared-files') ?></div></div>
          </a>

        <?php else: ?>

          <div class="shared-files-setting">

            <?php
            $pages_args = [
              'name'              => "shared_files_settings[" . esc_attr( $args['field_name'] ) . "]",
              'selected'          => $val,
              'show_option_none'  => ' '
            ];
            ?>

            <?php wp_dropdown_pages( $pages_args ); ?>

            <div class="email-info">
              <?php echo esc_html__("The countdown timer is displayed on the page selected above. It is hooked to the theme's function the_content(), and displayed just before the actual content.", "shared-files") ?>
            </div>

          </div>

        <?php endif; ?>

      </div>

      <?php

    }
  }

  public function icon_set_render($args) {

    if ($args['field_name']) {
      $options = get_option('shared_files_settings');

      $val = '';

      if (isset($options[$args['field_name']])) {
        $val = sanitize_text_field( $options[$args['field_name']] );
      }
      ?>
      <select name="shared_files_settings[<?php echo esc_attr( $args['field_name'] ) ?>]">
        <option value="2020" <?php echo ($val == '2020' || $val == '') ? 'selected' : ''; ?>><?php echo esc_html__('Improved (SVG)', 'shared-files') ?></option>
        <option value="2019" <?php echo $val == '2019' ? 'selected' : ''; ?>><?php echo esc_html__('First set', 'shared-files') ?></option>
      </select>
      <?php

    }
  }

  public function sort_tags_by_render($args) {

    if ($field_name = $args['field_name']) {
      $options = get_option('shared_files_settings');

      $val = '';

      if (isset($options[$args['field_name']])) {
        $val = sanitize_text_field( $options[$args['field_name']] );
      }
      ?>

      <?php $free = 0 ?>
      <?php $free_class = '' ?>
      <?php $plan_required = 'All Plans' ?>

      <?php if (substr($field_name, 0, strlen('_FREE_')) === '_FREE_'): ?>
        <?php $free = 1 ?>
        <?php $free_class = 'shared-files-setting-container-free' ?>
      <?php endif; ?>

      <div class="shared-files-setting-container <?php echo esc_attr( $free_class ) ?>">

        <?php if ($free): ?>

          <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing">
            <div class="shared-files-settings-pro-feature-overlay"><div><?php echo esc_html( $plan_required ) ?></div></div>
          </a>

        <?php else: ?>

          <div class="shared-files-setting">

            <select name="shared_files_settings[<?php echo esc_attr( $args['field_name'] ) ?>]">
                <option value="" <?php echo ($val == '') ? 'selected' : ''; ?>>ID</option>
                <option value="name" <?php echo $val == 'name' ? 'selected' : ''; ?>><?php echo esc_html__('Name', 'shared-files'); ?></option>
            </select>

          </div>

        <?php endif; ?>

      </div>

      <?php

    }
  }

  public function file_sync_interval_render($args) {

    if ($field_name = $args['field_name']) {
      $options = get_option('shared_files_settings');

      $val = '';

      if (isset($options[$args['field_name']])) {
        $val = sanitize_text_field( $options[$args['field_name']] );
      }
      ?>

      <?php $free = 0 ?>
      <?php $free_class = '' ?>
      <?php $plan_required = 'Pro' ?>

      <?php if (substr($field_name, 0, strlen('_FREE_')) === '_FREE_'): ?>
        <?php $free = 1 ?>
        <?php $free_class = 'shared-files-setting-container-free' ?>
      <?php endif; ?>

      <div class="shared-files-setting-container <?php echo esc_attr( $free_class ) ?>">

        <?php if ($free): ?>

          <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing">
            <div class="shared-files-settings-pro-feature-overlay"><div><?php echo esc_html( $plan_required ) ?></div></div>
          </a>

        <?php else: ?>

          <div class="shared-files-setting">

            <select name="shared_files_settings[<?php echo esc_attr( $args['field_name'] ) ?>]">
              <option value="every_15_min" <?php echo ($val == 'every_15_min') ? 'selected' : ''; ?>><?php echo esc_html__('15 minutes', 'shared-files'); ?></option>
              <option value="shared_files_every_5_min" <?php echo $val == 'shared_files_every_5_min' ? 'selected' : ''; ?>><?php echo esc_html__('5 minutes', 'shared-files'); ?></option>
              <option value="every_min" <?php echo $val == 'every_min' ? 'selected' : ''; ?>><?php echo esc_html__('1 minute', 'shared-files'); ?></option>
            </select>

          </div>

        <?php endif; ?>

      </div>

      <?php

    }
  }

  public function tag_slug_render($args) {

    if ($field_name = $args['field_name']) {
      $options = get_option('shared_files_settings');

      $val = '';

      if (isset($options[$args['field_name']])) {
        $val = sanitize_text_field( $options[$args['field_name']] );
      }
      ?>

      <div class="shared-files-setting-container">

        <div class="shared-files-setting">

          <select name="shared_files_settings[<?php echo esc_attr( $args['field_name'] ) ?>]">
            <option value="post_tag" <?php echo $val == 'post_tag' || $val == '' ? 'selected' : ''; ?>><?php echo esc_html__('Same as posts have', 'shared-files'); ?></option>
            <option value="shared-file-tag" <?php echo ($val == 'shared-file-tag') ? 'selected' : ''; ?>><?php echo esc_html__('Custom taxonomy', 'shared-files'); ?></option>
          </select>

        </div>

      </div>

      <?php

    }
  }

  public function trigger_download_email_render($args) {

    if ($field_name = $args['field_name']) {
      $options = get_option('shared_files_settings');

      $val = '';

      if (isset($options[$args['field_name']])) {
        $val = sanitize_text_field( $options[$args['field_name']] );
      }
      ?>

      <?php $free = 0 ?>
      <?php $free_class = '' ?>
      <?php $plan_required = 'Pro' ?>

      <?php if (substr($field_name, 0, strlen('_FREE_')) === '_FREE_'): ?>
        <?php $free = 1 ?>
        <?php $free_class = 'shared-files-setting-container-free' ?>
      <?php endif; ?>

      <div class="shared-files-setting-container <?php echo esc_attr( $free_class ) ?>">

        <?php if ($free): ?>

          <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing">
            <div class="shared-files-settings-pro-feature-overlay"><div><?php echo esc_html( $plan_required ) ?></div></div>
          </a>

        <?php else: ?>

          <div class="shared-files-setting">

            <select name="shared_files_settings[<?php echo esc_attr( $args['field_name'] ) ?>]">
                <option value="" <?php echo ($val == '') ? 'selected' : ''; ?>><?php echo esc_html__('File title link, preview and download buttons', 'shared-files'); ?></option>
                <option value="download_button_only" <?php echo $val == 'download_button_only' ? 'selected' : ''; ?>><?php echo esc_html__('Download button only', 'shared-files'); ?></option>
            </select>

          </div>

        <?php endif; ?>

      </div>

      <?php

    }
  }

  public function sort_categories_by_render($args) {

    if ($field_name = $args['field_name']) {
      $options = get_option('shared_files_settings');

      $val = '';

      if (isset($options[$args['field_name']])) {
        $val = sanitize_text_field( $options[$args['field_name']] );
      }
      ?>

      <?php $free = 0 ?>
      <?php $free_class = '' ?>
      <?php $plan_required = 'All Plans' ?>

      <?php if (substr($field_name, 0, strlen('_FREE_')) === '_FREE_'): ?>
        <?php $free = 1 ?>
        <?php $free_class = 'shared-files-setting-container-free' ?>
      <?php endif; ?>

      <div class="shared-files-setting-container <?php echo esc_attr( $free_class ) ?>">

        <?php if ($free): ?>

          <a href="<?php echo esc_url( get_admin_url() ) ?>options-general.php?page=shared-files-pricing">
            <div class="shared-files-settings-pro-feature-overlay"><div><?php echo esc_html( $plan_required ) ?></div></div>
          </a>

        <?php else: ?>

          <div class="shared-files-setting">

            <select name="shared_files_settings[<?php echo esc_attr( $args['field_name'] ) ?>]">
                <option value="" <?php echo ($val == '') ? 'selected' : ''; ?>>ID</option>
                <option value="name" <?php echo $val == 'name' ? 'selected' : ''; ?>><?php echo esc_html__('Name', 'shared-files'); ?></option>
            </select>

          </div>

        <?php endif; ?>

      </div>

      <?php

    }
  }

  public function file_open_method_render($args) {

    if ($args['field_name']) {
      $options = get_option('shared_files_settings');

      $val = '';

      if (isset($options[$args['field_name']])) {
        $val = sanitize_text_field( $options[$args['field_name']] );
      }
      ?>
      <select name="shared_files_settings[<?php echo esc_attr( $args['field_name'] ) ?>]">
          <option value="" <?php echo $val == '' ? 'selected' : ''; ?>><?php echo esc_html__('Default', 'shared-files'); ?></option>
          <option value="redirect" <?php echo $val == 'redirect' ? 'selected' : ''; ?>><?php echo esc_html__('Redirect', 'shared-files'); ?></option>
      </select>

      <div class="email-info">
        <?php echo esc_html__('Default method means opening the files using the following url format:', 'shared-files') ?><br />
        <strong>/shared-files/123/this-is-a-file.pdf</strong><br /><br />
        <?php echo esc_html__('Redirect method means that while the file url is at first the same as it is using the default method, the user will be redirected to the actual location on server like so:', 'shared-files') ?><br />
        <strong>/wp-content/uploads/shared-files/this-is-a-file.pdf</strong>
        <br /><br />

        <strong>
        <?php
        $url = esc_url_raw( get_admin_url() . 'edit.php?post_type=shared_file&page=shared-files-restrict-access' );
        echo sprintf(
          wp_kses(
            /* translators: %s: link to the information page about access restriction */
            __('<a href="%s">Important information regarding file permissions &raquo;</a>', 'shared-files'),
            array('a' => array('href' => array(), 'target' => array()))
          ),
          esc_url($url)
        );
        ?>
        </strong>

      </div>

      <?php

    }
  }

  public function pagination_type_render($args) {

    if ($args['field_name']) {
      $options = get_option('shared_files_settings');

      $val = '';

      if (isset($options[$args['field_name']])) {
        $val = sanitize_text_field( $options[$args['field_name']] );
      }
      ?>
      <select name="shared_files_settings[<?php echo esc_attr( $args['field_name'] ) ?>]">
          <option value="" <?php echo $val == '' ? 'original' : ''; ?>><?php echo esc_html__('Original', 'shared-files'); ?></option>
          <option value="improved" <?php echo $val == 'improved' ? 'selected' : ''; ?>><?php echo esc_html__('Improved', 'shared-files'); ?></option>
      </select>

      <div class="email-info">
        <?php echo esc_html__('Original type means that the page links are in the following url format:', 'shared-files') ?><br />
        <strong>sample-page-name/page/1/, sample-page-name/page/2/, ...</strong><br /><br />
        <?php echo esc_html__('Improved type works via GET parameters:', 'shared-files') ?><br />
        <strong>sample-page-name/?_page=1, sample-page-name/?_page=2, ...</strong><br /><br />
        <?php echo esc_html__('Improved type must be used, if the shortcode is on the front page or various other types of pages of the site. If you are getting 404 from the page links, use the Improved type.', 'shared-files') ?><br />
      </div>

      <?php

    }
  }

  public function preview_service_render($args) {

    if ($args['field_name']) {
      $options = get_option('shared_files_settings');

      $val = '';

      if (isset($options[$args['field_name']])) {
        $val = sanitize_text_field( $options[$args['field_name']] );
      }
      ?>
      <select name="shared_files_settings[<?php echo esc_attr( $args['field_name'] ) ?>]">
          <option value="" <?php echo $val == '' ? 'selected' : ''; ?>><?php echo esc_html__('Google', 'shared-files'); ?></option>
          <option value="microsoft" <?php echo $val == 'microsoft' ? 'selected' : ''; ?>><?php echo esc_html__('Microsoft', 'shared-files'); ?></option>
      </select>

      <div class="email-info">
        <?php echo esc_html__('The preview is available for certain file types only and PDF is supported by Google only.', 'shared-files') ?>
      </div>

      <?php

    }
  }

  public function order_by_render($args) {

    if ($args['field_name']) {
      $options = get_option('shared_files_settings');
      $order_by = '';

      if (isset($options[$args['field_name']])) {
        $order_by = sanitize_text_field( $options[$args['field_name']] );
      }
      ?>
      <select name="shared_files_settings[<?php echo esc_attr( $args['field_name'] ) ?>]">
          <option value="post_date" <?php echo $order_by == 'post_date' ? 'selected' : ''; ?>><?php echo esc_html__('File publish date (post date)', 'shared-files'); ?></option>
          <option value="_sf_main_date" <?php echo $order_by == '_sf_main_date' ? 'selected' : ''; ?>><?php echo esc_html__('File date', 'shared-files'); ?></option>
          <option value="title" <?php echo $order_by == 'title' ? 'selected' : ''; ?>><?php echo esc_html__('File title', 'shared-files'); ?></option>
      </select>
      <?php

    }
  }

  public function expiration_date_render($args) {

    if ($args['field_name']) {
      $options = get_option('shared_files_settings');
      $val = '';

      if (isset($options[$args['field_name']])) {
        $val = sanitize_text_field( $options[$args['field_name']] );
      }
      ?>
      <select name="shared_files_settings[<?php echo esc_attr( $args['field_name'] ) ?>]">
        <option value="" <?php echo $val == 'post_date' ? 'selected' : ''; ?>><?php echo esc_html__('No expiration date', 'shared-files'); ?></option>
        <option value="1_week"    <?php echo $val == '1_week' ? 'selected' : ''; ?>   ><?php echo esc_html__('1 week', 'shared-files'); ?></option>
        <option value="2_weeks"   <?php echo $val == '2_weeks' ? 'selected' : ''; ?>  ><?php echo esc_html__('2 weeks', 'shared-files'); ?></option>
        <option value="3_weeks"   <?php echo $val == '3_weeks' ? 'selected' : ''; ?>  ><?php echo esc_html__('3 weeks', 'shared-files'); ?></option>
        <option value="4_weeks"   <?php echo $val == '4_weeks' ? 'selected' : ''; ?>  ><?php echo esc_html__('4 weeks', 'shared-files'); ?></option>
        <option value="30_days"   <?php echo $val == '30_days' ? 'selected' : ''; ?>  ><?php echo esc_html__('30 days', 'shared-files'); ?></option>
        <option value="1_months"  <?php echo $val == '1_months' ? 'selected' : ''; ?> ><?php echo esc_html__('1 month', 'shared-files'); ?></option>
        <option value="2_months"  <?php echo $val == '2_months' ? 'selected' : ''; ?> ><?php echo esc_html__('2 months', 'shared-files'); ?></option>
        <option value="3_months"  <?php echo $val == '3_months' ? 'selected' : ''; ?> ><?php echo esc_html__('3 months', 'shared-files'); ?></option>
        <option value="4_months"  <?php echo $val == '4_months' ? 'selected' : ''; ?> ><?php echo esc_html__('4 months', 'shared-files'); ?></option>
        <option value="5_months"  <?php echo $val == '5_months' ? 'selected' : ''; ?> ><?php echo esc_html__('5 months', 'shared-files'); ?></option>
        <option value="6_months"  <?php echo $val == '6_months' ? 'selected' : ''; ?> ><?php echo esc_html__('6 months', 'shared-files'); ?></option>
        <option value="7_months"  <?php echo $val == '7_months' ? 'selected' : ''; ?> ><?php echo esc_html__('7 months', 'shared-files'); ?></option>
        <option value="8_months"  <?php echo $val == '8_months' ? 'selected' : ''; ?> ><?php echo esc_html__('8 months', 'shared-files'); ?></option>
        <option value="9_months"  <?php echo $val == '9_months' ? 'selected' : ''; ?> ><?php echo esc_html__('9 months', 'shared-files'); ?></option>
        <option value="10_months" <?php echo $val == '10_months' ? 'selected' : ''; ?>><?php echo esc_html__('10 months', 'shared-files'); ?></option>
        <option value="11_months" <?php echo $val == '11_months' ? 'selected' : ''; ?>><?php echo esc_html__('11 months', 'shared-files'); ?></option>
        <option value="1_year" <?php echo $val == '1_year' ? 'selected' : ''; ?>><?php echo esc_html__('1 year', 'shared-files'); ?></option>
        <option value="2_years" <?php echo $val == '2_years' ? 'selected' : ''; ?>><?php echo esc_html__('2 years', 'shared-files'); ?></option>
        <option value="3_years" <?php echo $val == '3_years' ? 'selected' : ''; ?>><?php echo esc_html__('3 years', 'shared-files'); ?></option>
        <option value="4_years" <?php echo $val == '4_years' ? 'selected' : ''; ?>><?php echo esc_html__('4 years', 'shared-files'); ?></option>
        <option value="5_years" <?php echo $val == '5_years' ? 'selected' : ''; ?>><?php echo esc_html__('5 years', 'shared-files'); ?></option>
      </select>
      <?php

    }
  }

  public function order_by_category_list_render($args) {

    if ($args['field_name']) {
      $options = get_option('shared_files_settings');
      $order_by = '';

      if (isset($options[$args['field_name']])) {
        $order_by = sanitize_text_field( $options[$args['field_name']] );
      }
      ?>
      <select name="shared_files_settings[<?php echo esc_attr( $args['field_name'] ) ?>]">
          <option value=""><?php echo esc_html__('Description', 'shared-files'); ?></option>
          <option value="name" <?php echo $order_by == 'name' ? 'selected' : ''; ?>><?php echo esc_html__('Category name', 'shared-files'); ?></option>
      </select>
      <?php

    }
  }

  public function order_render($args) {

    if ($args['field_name']) {
      $options = get_option('shared_files_settings');
      $order = '';

      if (isset($options[$args['field_name']])) {
        $order = sanitize_text_field( $options[$args['field_name']] );
      }
      ?>
      <select name="shared_files_settings[<?php echo esc_attr( $args['field_name'] ) ?>]">
          <option value="DESC" <?php echo $order == 'DESC' ? 'selected' : ''; ?>><?php echo esc_html__('Descending', 'shared-files'); ?></option>
          <option value="ASC" <?php echo $order == 'ASC' ? 'selected' : ''; ?>><?php echo esc_html__('Ascending', 'shared-files'); ?></option>
      </select>
      <?php

    }
  }

  public function card_background_render($args) {

    if ($args['field_name']) {
      $options = get_option('shared_files_settings');
      $card_background = '';

      if (isset($options[$args['field_name']])) {
        $card_background = sanitize_text_field( $options[$args['field_name']] );
      }
      ?>
      <select name="shared_files_settings[<?php echo esc_attr( $args['field_name'] ) ?>]">
        <option value=""><?php echo esc_html__('Transparent', 'shared-files'); ?></option>
        <option value="white" <?php echo $card_background == 'white' ? 'selected' : ''; ?>><?php echo esc_html__('White', 'shared-files'); ?></option>
        <option value="light_gray" <?php echo $card_background == 'light_gray' ? 'selected' : ''; ?>><?php echo esc_html__('Light gray', 'shared-files'); ?></option>
        <option value="custom_color" <?php echo $card_background == 'custom_color' ? 'selected' : ''; ?>><?php echo esc_html__('Custom color', 'shared-files'); ?></option>
      </select>
      <?php

    }
  }

  public function card_font_render($args) {

    if ($args['field_name']) {
      $options = get_option('shared_files_settings');
      $card_font = '';

      if (isset($options[$args['field_name']])) {
        $card_font = sanitize_text_field( $options[$args['field_name']] );
      }
      ?>
      <select name="shared_files_settings[<?php echo esc_attr( $args['field_name'] ) ?>]">
        <option value=""><?php echo esc_html__('Default', 'shared-files'); ?></option>
        <option value="roboto" <?php echo $card_font == 'roboto' ? 'selected' : ''; ?>><?php echo esc_html__('Roboto', 'shared-files'); ?></option>
        <option value="ubuntu" <?php echo $card_font == 'ubuntu' ? 'selected' : ''; ?>><?php echo esc_html__('Ubuntu', 'shared-files'); ?></option>
      </select>
      <?php

    }
  }

  public function card_featured_image_align($args) {

    if ($args['field_name']) {
      $options = get_option('shared_files_settings');

      $val = '';

      if (isset($options[$args['field_name']])) {
        $val = sanitize_text_field( $options[$args['field_name']] );
      }
      ?>
      <select name="shared_files_settings[<?php echo esc_attr( $args['field_name'] ) ?>]">
        <option value=""><?php echo esc_html__('Right', 'shared-files'); ?></option>
        <option value="left" <?php echo $val == 'left' ? 'selected' : ''; ?>><?php echo esc_html__('Left', 'shared-files'); ?></option>
      </select>
      <?php

    }
  }

}