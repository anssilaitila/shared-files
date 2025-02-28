<?php

class SharedFilesSettingsTab3Content {

  public function init() {

    $tabs = new SharedFilesSettingsTabs();
    $field_render = new SharedFilesSettingsFieldRender();

    $only_pro = '_FREE_';

    $s = get_option('shared_files_settings');

    $tab = 3;

    add_settings_section(
      'shared-files_tab_' . $tab,
      '',
      array($tabs, 'shared_files_settings_tab_' . $tab . '_callback'),
      'shared-files'
    );

    add_settings_field(
      'shared-files-layout',
      sanitize_text_field( __('Layout', 'shared-files') ),
      array($field_render, 'layout_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-layout', 'field_name' => 'layout')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'card_align_elements_vertically',
      sanitize_text_field( __('Align elements vertically and centered (inside file card)', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'card_align_elements_vertically', 'field_name' => $only_pro . 'card_align_elements_vertically')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'remove_link_from_file_title',
      sanitize_text_field( __('Remove link from file title', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'remove_link_from_file_title', 'field_name' => $only_pro . 'remove_link_from_file_title')
    );

    add_settings_field(
      'shared-files-show_download_button',
      sanitize_text_field( __('Show download button', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-show_download_button', 'field_name' => 'show_download_button')
    );

    add_settings_field(
      'shared-files-hide_preview_button',
      sanitize_text_field( __('Hide preview button', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-hide_preview_button', 'field_name' => 'hide_preview_button')
    );

    add_settings_field(
      'shared-files-hide_date_from_card',
      sanitize_text_field( __('Hide file date / publish date from card', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-hide_date_from_card', 'field_name' => 'hide_date_from_card')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'hide_category_name_from_card',
      sanitize_text_field( __('Hide category name(s) from file card', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'hide_category_name_from_card', 'field_name' => $only_pro . 'hide_category_name_from_card')
    );

    add_settings_field(
      'shared-files-card_font',
      sanitize_text_field( __('Card font', 'shared-files') ),
      array($field_render, 'card_font_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-card_font', 'field_name' => 'card_font')
    );

    add_settings_field(
      'shared-files-card_small_font_size',
      sanitize_text_field( __('Small font size on card', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-card_small_font_size', 'field_name' => 'card_small_font_size')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'hide_tags',
      sanitize_text_field( __('Hide tags from the file card', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'hide_tags', 'field_name' => $only_pro . 'hide_tags')
    );

    add_settings_field(
      'shared-files-hide_file_size_from_card',
      sanitize_text_field( __('Hide file size from card', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-hide_file_size_from_card', 'field_name' => 'hide_file_size_from_card')
    );

    add_settings_field(
      'shared-files-hide_file_type_icon_from_card',
      sanitize_text_field( __('Hide file type icon from card', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-hide_file_type_icon_from_card', 'field_name' => 'hide_file_type_icon_from_card')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'show_tags_on_search_results',
      sanitize_text_field( __('Show tags on search results cards', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'show_tags_on_search_results', 'field_name' => $only_pro . 'show_tags_on_search_results')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'file_type_icon_width_default',
      sanitize_text_field( __('File type icon width, default file card (px)', 'shared-files') ),
      array($field_render, 'input_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'file_type_icon_width_default', 'field_name' => $only_pro . 'file_type_icon_width_default', 'placeholder' => 48)
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'file_type_icon_height_vertical',
      sanitize_text_field( __('File type icon height, vertical view (px)', 'shared-files') ),
      array($field_render, 'input_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'file_type_icon_height_vertical', 'field_name' => $only_pro . 'file_type_icon_height_vertical', 'placeholder' => 70)
    );

    add_settings_field(
      'shared-files-card_featured_image_as_extra',
      sanitize_text_field( __('Show featured image in addition to file type icon', 'shared-files') ) . '<div style="font-weight: 400; font-style: italic; font-size: 12px; margin-top: 3px;">' . sanitize_text_field( __('Featured image will be displayed next to file description.', 'shared-files') ) . '<br />' .
      sanitize_text_field( __('Normally it is displayed instead of file type icon.', 'shared-files') ) .
      '</div>',
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-card_featured_image_as_extra', 'field_name' => 'card_featured_image_as_extra')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'larger_featured_image',
      sanitize_text_field( __('Use a larger, non-cropped version of the featured image', 'shared-files') ) . '<div style="font-weight: 400; font-style: italic; font-size: 12px; margin-top: 3px;">' . sanitize_text_field( __('"Show featured image in addition to file type icon" must also be checked.', 'shared-files') ) .
      '</div>',
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'larger_featured_image', 'field_name' => $only_pro . 'larger_featured_image')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'featured_image_container_width',
      sanitize_text_field( __('Featured image container width (px)', 'shared-files') ),
      array($field_render, 'input_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'featured_image_container_width', 'field_name' => $only_pro . 'featured_image_container_width', 'placeholder' => '150')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'featured_image_container_height',
      sanitize_text_field( __('Featured image container height (px)', 'shared-files') ),
      array($field_render, 'input_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'featured_image_container_height', 'field_name' => $only_pro . 'featured_image_container_height', 'placeholder' => '')
    );

    add_settings_field(
      'shared-files-' . $only_pro . 'show_featured_image_for_password_protected_files',
      sanitize_text_field( __('Show featured image for password protected files', 'shared-files') ),
      array($field_render, 'checkbox_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-' . $only_pro . 'show_featured_image_for_password_protected_files', 'field_name' => $only_pro . 'show_featured_image_for_password_protected_files')
    );

    add_settings_field(
      'shared-files-card_featured_image_align',
      sanitize_text_field( __('Align featured image', 'shared-files') ),
      array($field_render, 'card_featured_image_align'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-card_featured_image_align', 'field_name' => 'card_featured_image_align')
    );

    add_settings_field(
      'shared-files-card_height',
      sanitize_text_field( __('Minimum card height in pixels', 'shared-files') ),
      array($field_render, 'input_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-card_height', 'field_name' => 'card_height', 'placeholder' => '280')
    );

    add_settings_field(
      'shared-files-card_background',
      sanitize_text_field( __('Card background', 'shared-files') ),
      array($field_render, 'card_background_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-card_background', 'field_name' => 'card_background')
    );

    add_settings_field(
      'shared-files-card_background_custom_color',
      sanitize_text_field( __('Card background, custom color (HEX code)', 'shared-files') ) . '<div style="font-weight: 400; font-style: italic; font-size: 12px; margin-top: 3px;">' . sanitize_text_field( __('See', 'shared-files') ) . ' <a href="https://htmlcolorcodes.com/" target="_blank">htmlcolorcodes.com</a></div>',
      array($field_render, 'input_render'),
      'shared-files',
      'shared-files_tab_' . $tab,
      array('label_for' => 'shared-files-card_background_custom_color', 'field_name' => 'card_background_custom_color', 'placeholder' => '')
    );

  }

}