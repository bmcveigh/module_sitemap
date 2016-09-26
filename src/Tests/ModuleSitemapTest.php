<?php

namespace Drupal\module_sitemap\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Tests block HTML ID validity.
 *
 * @group module_sitemap
 */
class ModuleSitemapTest extends WebTestBase {

  /**
   * Modules to install.
   *
   * @var array
   */
  public static $modules = array('module_sitemap');

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
  }

  /**
   * Test the admin page as well as the sitemap page
   * for this module.
   */
  protected function testIfPagesExist() {
    // Log in as a root drupal user so we can test the admin page.
    $this->drupalLogin($this->rootUser);

    // Test Sitemap functionality.
    $this->drupalGet('module-sitemap');

    // Make sure the configuration page exists.
    $this->drupalGet('admin/config/development/module-sitemap');
  }

}
