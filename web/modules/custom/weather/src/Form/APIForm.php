<?php

namespace Drupal\weather\Form;

use Drupal\Core\Form\FormStateInterface;
use GuzzleHttp\Client;
use Drupal\Core\Form\ConfigFormBase;

/**
 * Provides API key form.
 */
class APIForm extends ConfigFormBase {
  /**
   * For GuzzleHttp object.
   *
   * @var object
   */
  protected $client;

  /**
   * Construct GuzzleHttp\Client object.
   */
  public function __construct() {
    $this->client = new Client();
  }

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
  public function getEditableConfigNames() {
    return [
      'weather.admin_settings',
    ];
  }

  /**
   * Rewrite method from interface.
   *
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('weather.admin_settings');
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City and country name'),
      '#default_value' => $config->get('name'),
    ];
    $form['key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API key'),
      '#default_value' => $config->get('key'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * Rewrite method from interface.
   *
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (empty($form_state->getValue('name'))) {
      $form_state->setErrorByName('name', $this->t('City and country should have any symbols.'));
    }
    elseif (empty($form_state->getValue('key'))) {
      $form_state->setErrorByName('key', $this->t('API key should be not empty.'));
    }
    elseif ($this->haveDigitValidation($form_state)) {
      $form_state->setErrorByName('name', $this->t('City and country should not have any digits.'));
    }
    elseif ($this->keyNameValidation($form_state)) {
      $form_state->setErrorByName('key_verification', $this->t('Wrong API key.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addStatus($this->t('Your API key API key successfully added.'));
    $this->config('weather.admin_settings')
      ->set('name', $form_state->getValue('name'))
      ->set('key', $form_state->getValue('key'))
      ->save();
    parent::submitForm($form, $form_state);
  }

  /**
   * Validation have a string digits.
   */
  public function haveDigitValidation(FormStateInterface $form_state) {
    $name = $form_state->getValue('name');
    $result = FALSE;
    if (preg_match('~[0-9]+~', $name)) {
      return $result = TRUE;
    }
    return $result;
  }

  /**
   * Validation for API key and name verification on https://www.weatherapi.com.
   */
  public function keyNameValidation($form_state) {

    $key = $form_state->getValue('key');
    $name = $form_state->getValue('name');
    $url = "http://api.weatherapi.com/v1/current.json?key=$key&q=$name&aqi=no";
    $response = $this->client->get($url, ['http_errors' => FALSE]);
    $code = $response->getStatusCode();
    if ($code == 200) {
      return FALSE;
    }
    else {
      return TRUE;
    }
  }

}
