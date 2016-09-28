<?php

namespace Drupal\module_sitemap\Controller;

use Drupal\Core\Link;
use Symfony\Component\Yaml\Yaml;

/**
 * Page callback to get the list of modules and their paths.
 */
class ModuleSitemapController {

  /**
   * Page callback for /module-sitemap.
   */
  public function content() {
    $build = array();

    $moduleHandler = \Drupal::moduleHandler();
    $modules = $moduleHandler->getModuleList();
    $user = \Drupal::currentUser();

    $config = \Drupal::config('module_sitemap.settings');
    $shouldDisplayFullUrl = $config->get('display_full_url');
    $shouldGroupByModule = $config->get('group_by_module');

    foreach ($modules as $module => $data) {
      $module_path = drupal_get_path('module', $module);
      $routing_path = $module_path . '/' . $module . '.routing.yml';

      $info = Yaml::parse(file_get_contents($data->getPathname()));

      if (file_exists($routing_path)) {
        $yml = file_get_contents($routing_path);
        $routing_data = Yaml::parse($yml);
        if ($shouldGroupByModule) {
          $build[$module] = array(
            '#type' => 'fieldset',
            '#title' => $info['name'],
            '#attributes' => array(
              'class' => array('module-sitemap-group'),
            ),
          );
        }

        $routes = array();
        foreach ($routing_data as $route_name => $route) {
          $user_is_admin = in_array('administrator', $user->getRoles());
          $user_has_permission = $user_is_admin || isset($route['requirements']['_permission']) ?
            $user->hasPermission($route['requirements']['_permission']) : FALSE;

          // Do not include links that include '{' or '}' since these links
          // require a custom argument.
          $exclude = preg_match('/\\{|\\}/', $route['path']);

          if ($exclude || !$user_has_permission) {
            continue;
          }

          $text_display = $route['path'];

          if (isset($route['defaults']['_title'])) {
            if (!$shouldDisplayFullUrl) {
              $text_display = $route['defaults']['_title'];
            }

            $link = Link::createFromRoute($text_display, $route_name);
            $routes[] = $link->toString();
          }
        }

        if (empty($routes)) {
          unset($build[$module]);
        }

        $build[$module]['routes'] = array(
          '#type' => 'markup',
          '#markup' => implode('<br />', $routes),
        );
      }
    }

    return $build;
  }

}
