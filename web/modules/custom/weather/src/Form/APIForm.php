<?php

namespace Drupal\weather\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides API key form.
 */
class APIForm extends FormBase {

  /**
   * Rewrite method from interface.
   *
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'api_key_form';
  }

  /**
   * Rewrite method from interface.
   *
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City and country name'),
    ];
    $form['key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API key'),
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    return $form;
  }

  /**
   * Rewrite method from interface.
   *
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (strlen($form_state->getValue('name')) < 1) {
      $form_state->setErrorByName('name', $this->t('City and country should have any symbols.'));
    }
    elseif (strlen($form_state->getValue('key')) < 1) {
      $form_state->setErrorByName('key', $this->t('API key should be not empty.'));
    }
    elseif ($this->haveDigitValidation($form_state)) {
      $form_state->setErrorByName('name', $this->t('City and country should not have any digits.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addStatus($this->t('Your API key is @number',
      ['@number' => $form_state->getValue('API key')]));
  }

  /**
   * Validation have a string digits.
   */
  public function haveDigitValidation(FormStateInterface $form_state) {
    $name = $form_state->getValue('name');
    $result = FALSE;
    for ($i = 0; strlen($name) >= $i; $i++) {
      if (is_numeric($name[$i])) {
        $result = TRUE;
      }
    }
    return $result;
  }

}
