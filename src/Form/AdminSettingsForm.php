<?php

namespace Drupal\module_sitemap\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Html;

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
      '#type' => 'radios',
      '#title' => $this->t('Display full URL?'),
      '#default_value' => $config->get('display_full_url'),
      '#options' => array(
        'yes' => $this->t('Yes'),
        'no' => $this->t('No'),
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
      ->set('show_links_with_no_title', Html::escape($form_state->getValue('show_links_with_no_title')))
      ->set('display_full_url', Html::escape($form_state->getValue('display_full_url')))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
