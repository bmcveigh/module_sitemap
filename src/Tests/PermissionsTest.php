<?php

namespace Drupal\module_sitemap\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Tests module_sitemap access control.
 *
 * @group module_sitemap
 */
class PermissionsTest extends WebTestBase {

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
   * Test the admin page as well as the sitemap page.
   */
  protected function testUnauthorizedUser() {
    // Log in as an authenticated drupal user so we can test the admin page.
    $this->drupalLogin($this->drupalCreateUser());

    // Test Sitemap functionality.
    $this->drupalGet('module-sitemap');
    $this->assertResponse(403);

    // Make sure the configuration page exists. User should be denied access.
    $this->drupalGet('admin/config/development/module-sitemap');
    $this->assertResponse(403);
  }

  /**
   * Log in as a user with the 'access module sitemap' permission.
   */
  protected function testAuthorizedUser() {
    // Users with the 'access module sitemap' permission should be able to
    // access the module sitemap page but not administer the module.
    $this->drupalLogin($this->drupalCreateUser(['access module sitemap']));

    // Test Sitemap functionality.
    $this->drupalGet('module-sitemap');
    $this->assertResponse(200);

    // Make sure that this user cannot see any admin links. If they can, fail
    // the test.
    $this->assertTextHelper('Administer', 'Found the word Administer on the page. This is a security issue and should be addressed.', 'Other', TRUE);

    // Make sure the configuration page exists. User should be denied access.
    $this->drupalGet('admin/config/development/module-sitemap');
    $this->assertResponse(403);
  }

  /**
   * Log in as a user with the 'administer module sitemap' permission.
   */
  protected function testAdminUser() {
    $this->drupalLogin($this->drupalCreateUser(['access module sitemap', 'administer module sitemap']));

    // Test Sitemap functionality.
    $this->drupalGet('module-sitemap');
    $this->assertResponse(200);

    // Make sure the configuration page exists. User should be granted access.
    $this->drupalGet('admin/config/development/module-sitemap');
    $this->assertResponse(200);
  }

}
