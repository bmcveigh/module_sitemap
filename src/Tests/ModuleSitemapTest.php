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
   * for this module. They should not be able to access
   * both pages.
   */
  protected function testUnauthorizedUser() {
    // Log in as an authenticated drupal user so we can test the admin page.
    $this->drupalLogin($this->drupalCreateUser());

    // Test Sitemap functionality.
    $this->drupalGet('module-sitemap');
    $this->assertResponse('403');

    // Make sure the configuration page exists. User should be denied access.
    $this->drupalGet('admin/config/development/module-sitemap');
    $this->assertResponse('403');
  }

  /**
   * Log in as a user with the 'access module sitemap' permission. They should
   * be able to access the module sitemap page but not administer the module.
   */
  protected function testAuthorizedUser() {
    $this->drupalLogin($this->drupalCreateUser(['access module sitemap']));

    // Test Sitemap functionality.
    $this->drupalGet('module-sitemap');
    $this->assertResponse('200');

    // Make sure the configuration page exists. User should be denied access.
    $this->drupalGet('admin/config/development/module-sitemap');
    $this->assertResponse('403');
  }

  /**
   * Log in as a user with the 'administer module sitemap' permission.
   * They should be able to access the module sitemap page AND administer
   * this module.
   */
  protected function testAdminUser() {
    $this->drupalLogin($this->drupalCreateUser(['access module sitemap', 'administer module sitemap']));

    // Test Sitemap functionality.
    $this->drupalGet('module-sitemap');
    $this->assertResponse('200');

    // Make sure the configuration page exists. User should be granted access.
    $this->drupalGet('admin/config/development/module-sitemap');
    $this->assertResponse('403');
  }

}
