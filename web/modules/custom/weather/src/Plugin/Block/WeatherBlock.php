<?php

namespace Drupal\weather\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use GuzzleHttp\Client;

/**
 * Provides an example block.
 *
 * @Block(
 *   id = "weather",
 *   admin_label = @Translation("weather"),
 *   category = @Translation("weather")
 * )
 */
class WeatherBlock extends BlockBase {
  /**
   * Current locaction.
   *
   * @var string
   */
  public $location = "Ukraine Lutsk";
  /**
   * Request method.
   *
   * @var string
   */
  public $method = "GET";
  /**
   * For GuzzleHttp object.
   *
   * @var object
   */
  protected $client;

  /**
   * Construct GuzzleHttp\Client object.
   */
  public function __construct($client) {
    $this->client = new Client();
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $weather = $this->getWeather();
    return [
      '#theme' => 'weather',
      '#name' => $weather['name'],
      '#temperature' => $weather['temperature'],
      '#icon' => $weather['icon'],
    ];
  }

  /**
   * Create request to API, decode from JSON to array.
   */
  public function getWeather() {

    $url = "http://api.weatherapi.com/v1/current.json?key=29af641fa57346f58ba132308221008&q={$this->getIP()}&aqi=no";
    $response = $this->client->request($this->method, $url);
    $code = $response->getStatusCode();
    $result = [];
    if ($code == 200) {
      $data = json_decode($response->getBody()->getContents(), TRUE);
      foreach ($data as $key => $value) {
        if ($key == "location") {
          $result['name'] = $data["location"]["name"];
        }
        elseif ($key == "current") {
          $result['temperature'] = $data["current"]["temp_c"];
          $result['icon'] = $data["current"]["condition"]["icon"];
        }
      }

    }
    return $result;
  }

  /**
   * Returns local ip.
   *
   * @todo return local ip, realize to get global ip address.
   */
  public function getIp() {
    // $client_ip = \Drupal::request()->getClientIp();
    // $current_ip = "176.241.140.177";
    return $this->location;
  }

}
