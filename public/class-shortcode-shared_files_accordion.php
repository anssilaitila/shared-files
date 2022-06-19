<?php

class ShortcodeSharedFilesAccordion
{
    public static function shared_files_accordion( $atts = array(), $content = null, $tag = '' )
    {
        
        if ( SharedFilesHelpers::isPremium() == 0 ) {
            $html = SharedFilesPublicHelpers::proFeaturePublicMarkup();
            return $html;
        } elseif ( isset( $atts['restricted'] ) && $atts['restricted'] && !is_user_logged_in() ) {
            $html = '<div style="background: #fff; border: 1px solid #bbb; color: #000; padding: 10px 20px; border-radius: 5px;">' . esc_html__( 'Only logged in users can list these files.', 'shared-files' ) . '</div>';
            return $html;
        }
    
    }

}