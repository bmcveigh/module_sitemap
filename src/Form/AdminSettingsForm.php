<?php

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

    $form['display_full_url'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Display full URL?'),
      '#default_value' => $config->get('display_full_url'),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * Form submission handler.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('module_sitemap.settings')
      ->set('display_full_url', $form_state->getValue('display_full_url') ? TRUE : FALSE)
      ->save();

    parent::submitForm($form, $form_state);
  }

}
