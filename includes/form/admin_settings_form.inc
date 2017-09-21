<?php

/**
 * @file
 * Configuration form for the Module Sitemap module.
 */

function module_sitemap_admin_settings_form($form, &$form_state) {
  $form['module_sitemap_display_full_url'] = [
    '#type' => 'checkbox',
    '#title' => t('Display full URL?'),
    '#default_value' => variable_get('module_sitemap_display_full_url', FALSE),
  ];

  $form['module_sitemap_group_by_module'] = [
    '#type' => 'checkbox',
    '#title' => t('Group by module?'),
    '#description' => t('If checked, the links for each module will be grouped. If unchecked, the links will be one list.'),
    '#default_value' => variable_get('module_sitemap_group_by_module', TRUE),
  ];

  return system_settings_form($form);
}
