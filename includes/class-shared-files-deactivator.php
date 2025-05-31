<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://anssilaitila.fi
 * @since      1.0.0
 *
 * @package    Shared_Files
 * @subpackage Shared_Files/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Shared_Files
 * @subpackage Shared_Files/includes
 * @author     Anssi Laitila <anssi.laitila@gmail.com>
 */
class Shared_Files_Deactivator {

  /**
   * @since    1.0.0
   */
  public static function deactivate() {

    shared_files_fs()->add_action('after_uninstall', 'shared_files_fs_uninstall_cleanup');

  }

}
