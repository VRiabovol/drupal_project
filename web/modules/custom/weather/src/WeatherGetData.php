<?php

namespace Drupal\weather;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Session\AccountProxyInterface;
use GuzzleHttp\Client;

/**
 * Service for get weather data from API.
 */
class WeatherGetData {
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
   * Guzzle\Client instance.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $client;

  /**
   * The repository for specialized queries.
   *
   * @var \Drupal\weather\WeatherDBRepository
   */
  protected $repository;

  /**
   * CacheBackendInterface instance.
   *
   * @var object
   */
  protected $cacheBackend;

  /**
   * Users id.
   *
   * @var \Drupal\user\Entity\User
   */
  protected $user;

  /**
   * Configuration weather API.
   *
   * @var \Drupal\Core\Config\ConfigFactory
   */
  protected $config;

  /**
   * Construct services.
   *
   * @param \GuzzleHttp\Client $http_client
   *   GuzzleHttp\Client object.
   * @param \Drupal\weather\WeatherDBRepository $repository
   *   Drupal\weather\WeatherDBRepository object.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache
   *   Drupal\Core\Cache\CacheBackendInterface object.
   * @param \Drupal\Core\Session\AccountProxyInterface $user
   *   Drupal\Core\Session\AccountProxyInterface object.
   * @param \Drupal\Core\Config\ConfigFactory $config
   *   Drupal\Core\Config\ConfigFactory object.
   */
  public function __construct(
    Client $http_client,
    WeatherDBRepository $repository,
    CacheBackendInterface $cache,
    AccountProxyInterface $user,
    ConfigFactory $config
  ) {
    $this->client = $http_client;
    $this->repository = $repository;
    $this->cacheBackend = $cache;
    $this->user = $user;
    $this->config = $config->get('weather.admin_settings');
  }

  /**
   * Returns $current ip if Anonimus else return $this->location.
   *
   * @todo return local ip, realize to get global ip address.
   */
  public function getIp() {
    $current_ip = "176.241.140.177";
    // $client_ip = \Drupal::request()->getClientIp();
    if ($this->user->isAnonymous()) {
      return $current_ip;
    }
    else {
      $config_location = $this->config->get('name');
      if (!empty($config_location)) {
        return $config_location;
      }
      return $this->location;
    }
  }

  /**
   * Create request to API, decode from JSON to array.
   */
  public function getWeather() {
    $api_token = $this->config->get('key');
    $url = "http://api.weatherapi.com/v1/current.json?key={$api_token}&q={$this->getIP()}&aqi=no";
    $response = $this->client->request($this->method, $url);
    $code = $response->getStatusCode();
    $data = json_decode($response->getBody()->getContents(), TRUE);
    if ($code == 200) {
      $this->entryToDatabase($data);
      return $data;
    }
    else {
      return FALSE;
    }

  }

  /**
   * Create request to API, decode from JSON to array.
   */
  public function getWeatherEntity($location) {
    if (empty($location)) {
      return FALSE;
    }
    else {
      $api_token = $this->config->get('key');
      $get_location = $location[0]['value'] ?? "";
      $url = "http://api.weatherapi.com/v1/current.json?key={$api_token}&q={$get_location}&aqi=no";
      $response = $this->client->request($this->method, $url);
      $data = json_decode($response->getBody()->getContents(), TRUE);
      return $data;
    }

  }

  /**
   * Caches data, make entry to database.
   *
   * If data is not already in cache, computed it and add to the cache.
   * If data in cache, get it from the cache.
   */
  public function getCachedWeather() {
    $cid = 'weather_cached';
    $data = NULL;
    if ($cache = $this->cacheBackend->get($cid)) {
      $data = $cache->data;
      $this->entryToDatabase($data);
    }
    else {
      if ($data = $this->getWeather()) {
        $expire = time() + 10800;
        $this->cacheBackend->set($cid, $data, $expire);
        $this->entryToDatabase($data);
      }
      else {
        return FALSE;
      }
    }
    return $data;
  }

  /**
   * Get weather data, parse it and makes entry to the database.
   */
  public function entryToDatabase($data) {
    if (!empty($data)) {
      $entry = [
        'city' => $data["location"]["name"] ?? NULL,
        'uid' => $this->user->id(),
      ];
      return $this->repository->insert($entry);
    }
    else {
      return FALSE;
    }
  }

}
