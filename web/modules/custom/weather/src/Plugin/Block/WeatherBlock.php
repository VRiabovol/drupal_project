<?php

namespace Drupal\weather\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use GuzzleHttp\Client;
use Drupal\Core\Cache\CacheBackendInterface;

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
   * For CacheBackendInterface object.
   *
   * @var object
   */
  protected $cacheBackend;

  /**
   * Construct dependency injections objects.
   *
   * Create GuzzleHttp\Client, Drupal\Core\Cache\CacheBackendInterface objects.
   */
  public function __construct($client, $cacheBackend) {
    $this->client = new Client();
    $this->cacheBackend = \Drupal::cache();
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $weather = $this->getWeather();
    $cachedWeather = $this->getCachedWeather();
    return [
      '#theme' => 'weather',
      '#name' => $cachedWeather["location"]["name"],
      '#temperature' => $cachedWeather["current"]["temp_c"],
      '#icon' => $cachedWeather["current"]["condition"]["icon"],
    ];
  }

  /**
   * Create request to API, decode from JSON to array.
   */
  public function getWeather() {

    $url = "http://api.weatherapi.com/v1/current.json?key=29af641fa57346f58ba132308221008&q={$this->getIP()}&aqi=no";
    $response = $this->client->request($this->method, $url);
    $code = $response->getStatusCode();
    $data = json_decode($response->getBody()->getContents(), TRUE);
    if ($code == 200) {
      return $data;
    }

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

  /**
   * Caches data.
   *
   * If data is not already in cache, computed it and add to the cache.
   * If data in cache, get it from the cache.
   */
  public function getCachedWeather() {
    $cid = 'weather_cached';
    $data = NULL;
    if ($cache = $this->cacheBackend->get($cid)) {
      $data = $cache->data;
    }
    else {
      $data = $this->getWeather();
      $expire = time() + 60;
      $this->cacheBackend->set($cid, $data, $expire);
    }
    return $data;
  }

}
