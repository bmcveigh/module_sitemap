<?php

/**
 * @file
 */

/**
 * Page callback for the module sitemap main page.
 */
function module_sitemap_page_content() {
  $build = [];

  global $user;

  $shouldDisplayFullUrl = variable_get('module_sitemap_display_full_url', FALSE);
  $shouldGroupByModule = variable_get('module_sitemap_group_by_module', TRUE);

  foreach (module_implements('menu') as $module) {
    $routing_data = call_user_func("{$module}_menu");
    $module_path = drupal_get_path('module', $module);
    $info = drupal_parse_info_format(file_get_contents(DRUPAL_ROOT . '/' . $module_path . '/' . $module . '.info'));
    if ($shouldGroupByModule) {
      $build[$module] = [
        '#type' => 'fieldset',
        '#title' => $info['name'],
        '#attributes' => [
          'class' => ['module-sitemap-group'],
        ],
      ];

      $routes = [];
      foreach ($routing_data as $path => $route) {
        $user_is_admin = in_array('administrator', $user->roles);

        if (isset($route['access arguments'][0])) {
          $user_has_permission = $user_is_admin || isset($route['access arguments'][0]) ?
            user_access($route['access arguments'][0]) : FALSE;
        }
        elseif (isset($route['access callback']) && function_exists($route['access callback'])) {
          $user_has_permission = call_user_func($route['access callback']);
        }
        else {
          $user_has_permission = TRUE;
        }

        // Do not include links that include '{' or '}' since these links
        // require a custom argument.
        if (isset($path)) {
          $exclude = preg_match('/\\{|\\}/', $path);
        }
        else {
          $exclude = TRUE;
        }

        // If link passes in arguments by the users (e.g. node/1) or they
        // do not have permission to view a particular page,
        // do not show the link.
        if ($exclude || !$user_has_permission) {
          continue;
        }

        $text_display = $path;

        if (isset($route['title'])) {
          if (!$shouldDisplayFullUrl) {
            $text_display = $route['title'];
          }

          $routes[] = l(check_plain($text_display), $path);
        }
      }

      if (empty($routes)) {
        unset($build[$module]);
      }

      $build[$module]['routes'] = [
        '#type' => 'markup',
        '#markup' => implode('<br />', $routes),
      ];
    }
  }

  return $build;
}
