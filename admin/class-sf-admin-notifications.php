<?php

class SharedFilesAdminNotifications {

  public function notifications_html() {

  	$sf_rating_show_notice = get_option('shared_files_rating_show_notice');

  	$sf_rating_notice_option = get_option('shared_files_rating_notice');
  	$sf_rating_notice_waiting = get_transient('shared_files_rating_notice_waiting');

  	$should_show_rating_notice = ($sf_rating_show_notice && $sf_rating_notice_waiting !== 'waiting' && $sf_rating_notice_option !== 'dismissed');

  	if ($should_show_rating_notice && current_user_can('administrator')) {

  		$dismiss_url = add_query_arg('sf_ignore_rating_notice_notify', '1');
  		$later_url = add_query_arg('sf_ignore_rating_notice_notify', 'later');

  		echo "
        <div class='sf_notice sf_review_notice'>

          <img src='". SHARED_FILES_URI . 'img/sf-sunrise.jpg' ."' alt='" . esc_attr__('Shared Files', 'shared-files') . "'>
          <div class='shared-files-notice-text'>

            <p style='padding-top: 4px;'>" . sprintf( __( "It's great to see that you've been using the %sShared Files%s plugin for a while now. Hopefully you're happy with it!&nbsp; If so, would you consider leaving a positive review? It really helps to support the plugin and helps others to discover it too!" ), '<strong style=\'font-weight: 700;\'>', '</strong>' ) . "</p>

            <p class='links'>
                <a class='sf_notice_dismiss' href='https://wordpress.org/support/plugin/shared-files/reviews/#new-post' target='_blank'>" . esc_html__('Sure, I\'d love to!', 'shared-files') . "</a>
                &middot;
                <a class='sf_notice_dismiss' href='" . esc_url( $dismiss_url ) . "'>" . esc_html__('No thanks', 'shared-files') . "</a>
                &middot;
                <a class='sf_notice_dismiss' href='" . esc_url( $dismiss_url ) . "'>" . esc_html__('I\'ve already given a review', 'shared-files') . "</a>
                &middot;
                <a class='sf_notice_dismiss' href='" . esc_url( $later_url ) . "'>" . esc_html__('Ask Me Later', 'shared-files') . "</a>
            </p>

          </div>

          <a class='sf_notice_close' href='" . esc_url( $dismiss_url ) . "'>x</a>

        </div>";
  
    }

    $screen = get_current_screen();
    
    if ( isset($screen->id) && $screen->id == 'edit-shared_file' ) {

      $how_to_show_notice = get_option('shared_files_how_to_show_notice');

      if ( $how_to_show_notice ) {

        $dismiss_how_to_url = add_query_arg('shared_files_ignore_how_to_notify', '1');

        echo '<div class="shared-files-notice-how-to-get-started">';
  
        echo '<div class="shared-files-notice-how-to-get-started-title">';
        echo '<h2>' . esc_html__('How to get started', 'shared-files') . '</h2>';

        echo "<a class='shared-files-notice-how-to-get-dismiss' href='" . esc_url( $dismiss_how_to_url ) . "'>&#10005;</a>";
        
        echo '</div>';
  
        echo '<div class="shared-files-notice-how-to-get-started-content">';
  
        echo '<ol>';
  
        echo '<li>' . esc_html__('Add some files from the file management below (click the Add New button)', 'shared-files') . '</li>';
  
        echo '<li>';
  
        echo esc_html__('Insert one of these shortcodes to any page or post on your site', 'shared-files');
  
        echo '<ul>';
        echo '<li>';
  
        echo '<h3>' . esc_html__('List of all files', 'shared-files') . '</h3>';
  
        echo '<span class="shared-files-shortcode-admin-list shared-files-shortcode-admin-list-file shared-files-shortcode-info-1" title="[shared_files]">[shared_files]</span>';
        
        echo '<button class="shared-files-copy shared-files-copy-for-all shared-files-copy-admin-list" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-info-1">' . esc_html__('Copy', 'shared-files') . '</button>';
  
        echo '</li>';
        echo '<li>';
  
        echo '<h3>' . esc_html__('List of all files, simpler view', 'shared-files') . '</h3>';
  
        echo '<span class="shared-files-shortcode-admin-list shared-files-shortcode-admin-list-file shared-files-shortcode-info-2" title="[shared_files_simple]">[shared_files_simple]</span>';
        
        echo '<button class="shared-files-copy shared-files-copy-for-all shared-files-copy-admin-list" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-info-2">' . esc_html__('Copy', 'shared-files') . '</button>';
  
        echo '</li>';
        echo '<li>';
  
        echo '<h3>' . esc_html__('Front end file uploader', 'shared-files') . '</h3>';
  
        echo '<span class="shared-files-shortcode-admin-list shared-files-shortcode-admin-list-file shared-files-shortcode-info-3" title="[shared_files file_upload=1]">[shared_files file_upload=1]</span>';
        
        echo '<button class="shared-files-copy shared-files-copy-for-all shared-files-copy-admin-list" data-clipboard-action="copy" data-clipboard-target=".shared-files-shortcode-info-3">' . esc_html__('Copy', 'shared-files') . '</button>';
  
        echo '</li>';
        echo '</ul>';
        
        echo '</li>';      

        echo '<li>';
        
        $url = esc_url_raw( get_admin_url() . 'options-general.php?page=shared-files' );
        echo sprintf(
          wp_kses(
            /* translators: %s: link to the plugin settings */
            __('Check the <a href="%s">plugin settings</a> for some customization options', 'shared-files'),
            array('a' => array('href' => array(), 'target' => array()))
          ),
          esc_url($url) 
        );
  
        echo '</li>';

        echo '<li>';
        
        $url = esc_url_raw( get_admin_url() . 'edit.php?post_type=shared_file&page=shared-files-shortcodes' );
        echo sprintf(
          wp_kses(
            /* translators: %s: link to the shortcodes page */
            __('List of all available shortcodes <a href="%s">here</a>', 'shared-files'),
            array('a' => array('href' => array(), 'target' => array()))
          ),
          esc_url($url) 
        );
        
        echo '</li>';
  
        echo '</ol>';
  
        echo '</div>';
        
        echo '</div>';
        
      }
        
    }

  }

  public function process_notifications() {

    /*
    if (0) {
      delete_transient('shared_files_rating_notice_waiting');
  		delete_option('shared_files_rating_notice');
  		delete_option('shared_files_rating_notice_date');
  		delete_option('shared_files_rating_show_notice');
    }
    */
    
  	global $current_user;
  	$user_id = $current_user->ID;
  	$sf_statuses_option = get_option('sf_statuses', array());

    // Rating notice

    /*
    
    if (!get_option('shared_files_rating_notice_date')) {

      $dt = new DateTime('+8 weeks');

      if ($dt !== false && !array_sum($dt::getLastErrors())) {
        $notify_date = $dt;
        update_option('shared_files_rating_notice_date', $notify_date, false);
      }

    } else {

      $notify_date = get_option('shared_files_rating_notice_date');

      if ($notify_date instanceof DateTime) {
        $dt_now = new DateTime('now');
        
        if ($notify_date <= $dt_now) {
          update_option('shared_files_rating_show_notice', 1, false);
        }

      }
      
    }
    
    */
  
  	if (isset($_GET['sf_ignore_rating_notice_notify'])) {
    	
  		if ((int) $_GET['sf_ignore_rating_notice_notify'] === 1) {
    		
  			update_option('shared_files_rating_notice', 'dismissed', false);
  			$sf_statuses_option['rating_notice_dismissed'] = $this->sf_get_current_time();
  			update_option('sf_statuses', $sf_statuses_option, false);
  
  		} elseif ($_GET['sf_ignore_rating_notice_notify'] === 'later') {

  			set_transient('shared_files_rating_notice_waiting', 'waiting', 2 * WEEK_IN_SECONDS);
  			update_option('shared_files_rating_notice', 'pending', false);

  		}
  
  	} elseif ( isset($_GET['shared_files_ignore_how_to_notify']) ) {
      
      update_option('shared_files_how_to_show_notice', 0, false);
      
    }
    
    
    
  }

  public function sf_get_current_time() {

  	$current_time = time();
  
  	// $current_time = strtotime( 'November 25, 2022' ) + 1;
  
  	return $current_time;

  }

}
