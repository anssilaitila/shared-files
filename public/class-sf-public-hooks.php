<?php

class SharedFilesPublicHooks {

  public static function get_action_content( $shared_files_action ) {

    $shared_files_action = sanitize_title( $shared_files_action );

    // buffer the output
    ob_start();
    do_action( $shared_files_action );
    return ob_get_clean();

  }

}
