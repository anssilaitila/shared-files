<?php

class ShortcodeSharedFilesRestricted {
    private static $custom_fields_active = 0;

    private static $meta_query = [];

    private static $meta_query_file_permissions = [];

    private static $meta_query_final = [];

    private static function setFinalMetaQuery() {
        self::$meta_query_final = array(
            'relation' => 'AND',
        );
        self::$meta_query_final[] = self::$meta_query_file_permissions;
        self::$meta_query_final[] = self::$meta_query;
    }

    public static function setMetaQuery( $value ) {
        self::$meta_query = $value;
    }

    public static function addToMetaQuery( $value ) {
        self::$meta_query[] = $value;
    }

    public static function setFilePermissions( $value ) {
        self::$meta_query_file_permissions = $value;
    }

    public static function shared_files_restricted( $atts = [], $content = null, $tag = '' ) {
        $className = get_called_class();
        if ( SharedFilesHelpers::isPremium() == 0 ) {
            $html = SharedFilesPublicHelpers::proFeaturePublicMarkup();
            return $html;
        } elseif ( !is_user_logged_in() ) {
            $html = '<div style="background: #fff; border: 1px solid #bbb; color: #000; padding: 10px 20px; border-radius: 5px;">' . esc_html__( 'Only logged in users can list these files.', 'shared-files' ) . '</div>';
            return $html;
        } elseif ( !SharedFilesHelpers::isMin2Pr() ) {
            $html = '';
            return $html;
        }
    }

}
