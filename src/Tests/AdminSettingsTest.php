<?php

namespace Drupal\module_sitemap\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Tests configuration for the admin settings form.
 *
 * @group module_sitemap
 */
class AdminSettingsTest extends WebTestBase {

  /**
   * Modules to install.
   *
   * @var array
   */
  public static $modules = ['module_sitemap'];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

  }

  /**
   * Test the configuration to make sure the variables get installed.
   */
  protected function testSettings() {
    $config = $this->config('module_sitemap.settings');
    $this->assertNotNull($config->get('display_full_url'), '"display_full_url" variable exists.');
    $this->assertNotNull($config->get('group_by_module'), '"group_by_module" variable exists.');
  }

}
