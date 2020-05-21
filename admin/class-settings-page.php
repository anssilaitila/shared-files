<?php

class Shared_Files_Settings
{
    public function shared_files_add_admin_menu()
    {
        add_options_page(
            'Shared Files Settings',
            'Shared Files',
            'manage_options',
            'shared-files',
            array( $this, 'settings_page' )
        );
    }
    
    public function shared_files_settings_init()
    {
        register_setting( 'shared-files', 'shared_files_settings' );
        add_settings_section(
            'shared-files_section_general',
            __( 'General settings', 'shared-files' ),
            array( $this, 'shared_files_settings_general_section_callback' ),
            'shared-files'
        );
        // ...
        add_settings_field(
            'shared-files-layout',
            __( 'Layout', 'shared-files' ),
            array( $this, 'layout_render' ),
            'shared-files',
            'shared-files_section_general',
            array(
            'label_for'  => 'shared-files-layout',
            'field_name' => 'layout',
        )
        );
        add_settings_field(
            'shared-files-card_height',
            __( 'Card height in pixels', 'shared-files' ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_section_general',
            array(
            'label_for'   => 'shared-files-card_height',
            'field_name'  => 'card_height',
            'placeholder' => '380',
        )
        );
        add_settings_field(
            'shared-files-card_background',
            __( 'Card background', 'shared-files' ),
            array( $this, 'card_background_render' ),
            'shared-files',
            'shared-files_section_general',
            array(
            'label_for'  => 'shared-files-card_background',
            'field_name' => 'card_background',
        )
        );
        add_settings_field(
            'shared-files-card_font',
            __( 'Card font', 'shared-files' ),
            array( $this, 'card_font_render' ),
            'shared-files',
            'shared-files_section_general',
            array(
            'label_for'  => 'shared-files-card_font',
            'field_name' => 'card_font',
        )
        );
        add_settings_field(
            'shared-files-card_small_font_size',
            __( 'Small font size on card', 'shared-files' ),
            array( $this, 'checkbox_render' ),
            'shared-files',
            'shared-files_section_general',
            array(
            'label_for'  => 'shared-files-card_small_font_size',
            'field_name' => 'card_small_font_size',
        )
        );
        add_settings_field(
            'shared-files-wp_location',
            __( 'WordPress location', 'shared-files' ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_section_general',
            array(
            'label_for'   => 'shared-files-wp_location',
            'field_name'  => 'wp_location',
            'placeholder' => '/some-dir/',
        )
        );
        add_settings_section(
            'shared-files_section_file_icons',
            __( 'Change default file icons', 'shared-files' ),
            array( $this, 'shared_files_settings_file_icons_section_callback' ),
            'shared-files'
        );
        add_settings_field(
            'shared-files-icon_image',
            __( 'File type: Image', 'shared-files' ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_section_file_icons',
            array(
            'label_for'   => 'shared-files-icon_for_image',
            'field_name'  => 'icon_for_image',
            'placeholder' => '',
            'wide'        => 1,
        )
        );
        add_settings_field(
            'shared-files-icon_pdf',
            __( 'File type: PDF', 'shared-files' ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_section_file_icons',
            array(
            'label_for'   => 'shared-files-icon_for_pdf',
            'field_name'  => 'icon_for_pdf',
            'placeholder' => '',
            'wide'        => 1,
        )
        );
        add_settings_field(
            'shared-files-icon_ai',
            __( 'File type: AI', 'shared-files' ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_section_file_icons',
            array(
            'label_for'   => 'shared-files-icon_for_ai',
            'field_name'  => 'icon_for_ai',
            'placeholder' => '',
            'wide'        => 1,
        )
        );
        add_settings_field(
            'shared-files-icon_doc',
            __( 'File type: Doc', 'shared-files' ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_section_file_icons',
            array(
            'label_for'   => 'shared-files-icon_for_doc',
            'field_name'  => 'icon_for_doc',
            'placeholder' => '',
            'wide'        => 1,
        )
        );
        add_settings_field(
            'shared-files-icon_font',
            __( 'File type: Font', 'shared-files' ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_section_file_icons',
            array(
            'label_for'   => 'shared-files-icon_for_font',
            'field_name'  => 'icon_for_font',
            'placeholder' => '',
            'wide'        => 1,
        )
        );
        add_settings_field(
            'shared-files-icon_html',
            __( 'File type: HTML', 'shared-files' ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_section_file_icons',
            array(
            'label_for'   => 'shared-files-icon_for_html',
            'field_name'  => 'icon_for_html',
            'placeholder' => '',
            'wide'        => 1,
        )
        );
        add_settings_field(
            'shared-files-icon_mp3',
            __( 'File type: MP3', 'shared-files' ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_section_file_icons',
            array(
            'label_for'   => 'shared-files-icon_for_mp3',
            'field_name'  => 'icon_for_mp3',
            'placeholder' => '',
            'wide'        => 1,
        )
        );
        add_settings_field(
            'shared-files-icon_video',
            __( 'File type: Video', 'shared-files' ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_section_file_icons',
            array(
            'label_for'   => 'shared-files-icon_for_video',
            'field_name'  => 'icon_for_video',
            'placeholder' => '',
            'wide'        => 1,
        )
        );
        add_settings_field(
            'shared-files-icon_xlsx',
            __( 'File type: XLSX', 'shared-files' ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_section_file_icons',
            array(
            'label_for'   => 'shared-files-icon_for_xlsx',
            'field_name'  => 'icon_for_xlsx',
            'placeholder' => '',
            'wide'        => 1,
        )
        );
        add_settings_field(
            'shared-files-icon_pptx',
            __( 'File type: PPT(X)', 'shared-files' ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_section_file_icons',
            array(
            'label_for'   => 'shared-files-icon_for_pptx',
            'field_name'  => 'icon_for_pptx',
            'placeholder' => '',
            'wide'        => 1,
        )
        );
        add_settings_field(
            'shared-files-icon_zip',
            __( 'File type: ZIP', 'shared-files' ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_section_file_icons',
            array(
            'label_for'   => 'shared-files-icon_for_zip',
            'field_name'  => 'icon_for_zip',
            'placeholder' => '',
            'wide'        => 1,
        )
        );
        add_settings_field(
            'shared-files-icon_indd',
            __( 'File type: INDD', 'shared-files' ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_section_file_icons',
            array(
            'label_for'   => 'shared-files-icon_for_indd',
            'field_name'  => 'icon_for_indd',
            'placeholder' => '',
            'wide'        => 1,
        )
        );
        add_settings_field(
            'shared-files-icon_psd',
            __( 'File type: PSD', 'shared-files' ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_section_file_icons',
            array(
            'label_for'   => 'shared-files-icon_for_psd',
            'field_name'  => 'icon_for_psd',
            'placeholder' => '',
            'wide'        => 1,
        )
        );
        add_settings_field(
            'shared-files-icon_svg',
            __( 'File type: SVG', 'shared-files' ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_section_file_icons',
            array(
            'label_for'   => 'shared-files-icon_for_svg',
            'field_name'  => 'icon_for_svg',
            'placeholder' => '',
            'wide'        => 1,
        )
        );
        add_settings_field(
            'shared-files-icon_other',
            __( 'File type: Other files', 'shared-files' ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_section_file_icons',
            array(
            'label_for'   => 'shared-files-icon_for_other',
            'field_name'  => 'icon_for_other',
            'placeholder' => '',
            'wide'        => 1,
        )
        );
        add_settings_field(
            'shared-files-icon_youtube',
            __( 'YouTube-link (External URL)', 'shared-files' ),
            array( $this, 'input_render' ),
            'shared-files',
            'shared-files_section_file_icons',
            array(
            'label_for'   => 'shared-files-icon_for_youtube',
            'field_name'  => 'icon_for_youtube',
            'placeholder' => '',
            'wide'        => 1,
        )
        );
    }
    
    public function checkbox_render( $args )
    {
        
        if ( $args['field_name'] ) {
            $options = get_option( 'shared_files_settings' );
            ?>    
      <input type="checkbox" id="shared-files-<?php 
            echo  $args['field_name'] ;
            ?>" name="shared_files_settings[<?php 
            echo  $args['field_name'] ;
            ?>]" <?php 
            echo  ( isset( $options[$args['field_name']] ) ? 'checked="checked"' : '' ) ;
            ?>>      

      <?php 
        }
    
    }
    
    public function input_render( $args )
    {
        
        if ( $args['field_name'] ) {
            $options = get_option( 'shared_files_settings' );
            ?>    
      <input type="text" class="input-field <?php 
            echo  ( isset( $args['wide'] ) ? 'input-field-wide' : '' ) ;
            ?>" id="shared-files-<?php 
            echo  $args['field_name'] ;
            ?>" name="shared_files_settings[<?php 
            echo  $args['field_name'] ;
            ?>]" value="<?php 
            echo  ( isset( $options[$args['field_name']] ) ? $options[$args['field_name']] : '' ) ;
            ?>" placeholder="<?php 
            echo  ( $args['placeholder'] ? $args['placeholder'] : '' ) ;
            ?>">

      <?php 
            
            if ( $args['field_name'] == 'wp_location' ) {
                ?>
        <div class="email-info">
          <?php 
                echo  __( 'If you\'re getting 404 from file URLs, it may be necessary to set this to the same directory that your WordPress is installed to. If this is set, the file URLs are formatted like so:<br /><b>/some-dir/shared-files/123/this-is-a-file.pdf</b>', 'shared-files' ) ;
                ?>
        </div>
      <?php 
            } elseif ( $args['field_name'] == 'icon_for_image' ) {
                ?>
        <p><?php 
                echo  __( 'e.g. /wp-content/uploads/2019/12/some-fancy-icon.png', 'shared-files' ) ;
                ?></p>
      <?php 
            }
            
            ?>

      <?php 
        }
    
    }
    
    public function shared_files_settings_general_section_callback()
    {
        echo  SharedFilesAdminViews::sfProFeatureSettingsMarkup() ;
    }
    
    public function shared_files_settings_admin_list_section_callback()
    {
        echo  SharedFilesAdminViews::sfProFeatureSettingsMarkup() ;
    }
    
    public function shared_files_settings_file_icons_section_callback()
    {
        echo  '<p>' . __( 'Define alternative icons here. You may add the files to the media library and then copy the URL to the appropriate field below.', 'shared-files' ) . '</p>' ;
    }
    
    public function settings_page()
    {
        ?>
    <div class="shared-files-settings-container">
      <form action="options.php" method="post">
  
        <h1><?php 
        echo  __( 'Shared Files Settings', 'shared-files' ) ;
        ?></h1>
  
        <?php 
        settings_fields( 'shared-files' );
        do_settings_sections( 'shared-files' );
        submit_button();
        ?>
  
      </form>
    </div>
    <?php 
    }
    
    public function layout_render( $args )
    {
        
        if ( $args['field_name'] ) {
            $options = get_option( 'shared_files_settings' );
            $layout = '';
            if ( isset( $options[$args['field_name']] ) ) {
                $layout = $options[$args['field_name']];
            }
            ?>    
      <select name="shared_files_settings[<?php 
            echo  $args['field_name'] ;
            ?>]">
          <option value=""><?php 
            echo  __( 'Default list', 'shared-files' ) ;
            ?></option>
          <option value="2-cards-on-the-same-row" <?php 
            echo  ( $layout == '2-cards-on-the-same-row' ? 'selected' : '' ) ;
            ?>><?php 
            echo  __( '2 cards on the same row', 'shared-files' ) ;
            ?></option>
          <option value="3-cards-on-the-same-row" <?php 
            echo  ( $layout == '3-cards-on-the-same-row' ? 'selected' : '' ) ;
            ?>><?php 
            echo  __( '3 cards on the same row', 'shared-files' ) ;
            ?></option>
          <option value="4-cards-on-the-same-row" <?php 
            echo  ( $layout == '4-cards-on-the-same-row' ? 'selected' : '' ) ;
            ?>><?php 
            echo  __( '4 cards on the same row', 'shared-files' ) ;
            ?></option>
      </select>
      <?php 
        }
    
    }
    
    public function card_background_render( $args )
    {
        
        if ( $args['field_name'] ) {
            $options = get_option( 'shared_files_settings' );
            $card_background = '';
            if ( isset( $options[$args['field_name']] ) ) {
                $card_background = $options[$args['field_name']];
            }
            ?>    
      <select name="shared_files_settings[<?php 
            echo  $args['field_name'] ;
            ?>]">
        <option value=""><?php 
            echo  __( 'Transparent', 'shared-files' ) ;
            ?></option>
        <option value="white" <?php 
            echo  ( $card_background == 'white' ? 'selected' : '' ) ;
            ?>><?php 
            echo  __( 'White', 'shared-files' ) ;
            ?></option>
        <option value="light_gray" <?php 
            echo  ( $card_background == 'light_gray' ? 'selected' : '' ) ;
            ?>><?php 
            echo  __( 'Light gray', 'shared-files' ) ;
            ?></option>
      </select>
      <?php 
        }
    
    }
    
    public function card_font_render( $args )
    {
        
        if ( $args['field_name'] ) {
            $options = get_option( 'shared_files_settings' );
            $card_font = '';
            if ( isset( $options[$args['field_name']] ) ) {
                $card_font = $options[$args['field_name']];
            }
            ?>    
      <select name="shared_files_settings[<?php 
            echo  $args['field_name'] ;
            ?>]">
        <option value=""><?php 
            echo  __( 'Default', 'shared-files' ) ;
            ?></option>
        <option value="roboto" <?php 
            echo  ( $card_font == 'roboto' ? 'selected' : '' ) ;
            ?>><?php 
            echo  __( 'Roboto', 'shared-files' ) ;
            ?></option>
        <option value="ubuntu" <?php 
            echo  ( $card_font == 'ubuntu' ? 'selected' : '' ) ;
            ?>><?php 
            echo  __( 'Ubuntu', 'shared-files' ) ;
            ?></option>
      </select>
      <?php 
        }
    
    }

}