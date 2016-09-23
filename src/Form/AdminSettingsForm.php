<?php

/**
 * @file
 * Contains Drupal\module_sitemap\Form\AdminSettingsForm.
 */

namespace Drupal\module_sitemap\Form;

/**
 * TODO: class docs.
 */
class AdminSettingsForm {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'module_sitemap_adminsettingsform';
  }

  /**
   * Form constructor.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['element'] = array(
      '#type' => 'textfield',
      '#title' => t('Enter a value'),
      '#required' => TRUE,
    );

    return $form;
  }

  /**
   * Form submission handler.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

  }

}
