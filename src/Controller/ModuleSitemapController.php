<?php

/**
 * @file
 * Contains Drupal\module_sitemap\Controller\ModuleSitemapController.
 */

namespace Drupal\module_sitemap\Controller;
use Drupal\Core\Link;
use Symfony\Component\Yaml\Yaml;

/**
 * Page callback to get the list of modules and their paths.
 */
class ModuleSitemapController {
  public function content() {
    $build = array();

    $moduleHandler = \Drupal::moduleHandler();
    $modules = $moduleHandler->getModuleList();
    $user = \Drupal::currentUser();

    foreach ($modules as $module => $data) {
      $module_path = drupal_get_path('module', $module);
      $routing_path = $module_path . '/' . $module . '.routing.yml';

      $info = Yaml::parse(file_get_contents($data->getPathname()));

      if (file_exists($routing_path)) {
        $yml = file_get_contents($routing_path);
        $routing_data = Yaml::parse($yml);

        $build[$module] = array(
          '#type' => 'fieldset',
          '#title' => $info['name'],
        );

        $routes = array();
        foreach ($routing_data as $route_name => $route) {
          $user_is_admin = in_array('administrator', $user->getRoles());
          $user_has_permission = $user_is_admin || isset($route['requirements']['_permission']) ?
            $user->hasPermission($route['requirements']['_permission']) : FALSE;

          // Do not include links that include '{' or '}' since these links
          // require a custom argument.
          $exclude = preg_match('/\\{|\\}/', $route['path']);

          if ($exclude) {
            continue;
          }

          if (isset($route['defaults']['_title']) && $user_has_permission) {
            $link = Link::createFromRoute($route['defaults']['_title'], $route_name);
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
