<?php

class SharedFilesPublicHooks {

  public static function get_action_content( $action ) {

    $action = sanitize_title( $action );

    // buffer the output
    ob_start();
    do_action( $action );
    return ob_get_clean();

  }

}