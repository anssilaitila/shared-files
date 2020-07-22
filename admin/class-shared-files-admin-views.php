<?php

class SharedFilesAdminViews {

  public static function sfProFeatureMarkup() {
  
      $html = '';
    
      $html .= '<div class="pro-feature">';
      $html .= '<span>' . __('This feature is available in the Pro version.', 'contact-list') . '</span>';
      $html .= '<a href="' . get_admin_url() . 'options-general.php?page=shared-files-pricing">' . __('Upgrade here', 'contact-list') . '</a>';
      $html .= '</div>';
      
      return $html;
    
  }
  
  public static function sfProMoreFeaturesMarkup() {
  
      $html = '';
    
      $html .= '<div class="pro-feature">';
      $html .= '<span>' . __('More features available in the Pro version.', 'contact-list') . '</span>';
      $html .= '<a href="' . get_admin_url() . 'options-general.php?page=shared-files-pricing">' . __('Upgrade here', 'contact-list') . '</a>';
      $html .= '</div>';
      
      return $html;
    
  }
  
  public static function sfProFeatureSettingsMarkup() {
  
      $html = '';
    
      $html .= '<div class="pro-feature">';
      $html .= '<span>' . __('More settings available in the Pro version.', 'contact-list') . '</span>';
      $html .= '<a href="' . get_admin_url() . 'options-general.php?page=shared-files-pricing">' . __('Upgrade here', 'contact-list') . '</a>';
      $html .= '</div>';
      
      return $html;
    
  }

}
