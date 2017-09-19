<?php

namespace Drupal\Tests\module_sitemap\Functional;


use Drupal\Tests\BrowserTestBase;

/**
 * Base class
 *
 * @package Drupal\Tests\module_sitemap\Functional
 */
class FunctionalTestBase extends BrowserTestBase {

  public static $modules = ['module_sitemap'];

  protected $authenticatedUser;

  protected function setUp() {
    parent::setUp();

    $this->authenticatedUser = $this->drupalCreateUser(['access module sitemap']);
    $this->drupalLogin($this->authenticatedUser);
  }

}
