<?php

/**
 * @file
 * Contains Drupal\module_sitemap\Form\AdminSettingsForm.
 */

namespace Drupal\module_sitemap\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * TODO: class docs.
 */
class AdminSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'module_sitemap_adminsettingsform';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'module_sitemap.settings',
    ];
  }

  /**
   * Form constructor.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('module_sitemap.settings');

    $form['show_links_with_no_title'] = array(
      '#type' => 'radios',
      '#title' => t('Show links with no title.'),
      '#default_value' => $config->get('show_links_with_no_title'),
      '#options' => array(
        0 => t('Yes'),
        1 => t('No'),
      ),
      '#required' => TRUE,
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * Form submission handler.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('module_sitemap.settings')
      ->set('data_directory', $form_state->getValue('data_directory'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}
