<?php

namespace Drupal\weather\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use GuzzleHttp\Client;
use Drupal\Core\Cache\CacheBackendInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\weather\WeatherDBRepository;
use Drupal\Core\Session\AccountProxyInterface;

/**
 * Provides an example block.
 *
 * @Block(
 *   id = "weather",
 *   admin_label = @Translation("weather"),
 *   category = @Translation("weather")
 * )
 */
class WeatherBlock extends BlockBase implements ContainerFactoryPluginInterface {
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
   * CacheBackendInterface instance.
   *
   * @var object
   */
  protected $cacheBackend;

  /**
   * The repository for specialized queries.
   *
   * @var \Drupal\weather\WeatherDBRepository
   */
  protected $repository;

  /**
   * Users id.
   *
   * @var \Drupal\user\Entity\User
   */
  protected $user;

  /**
   * {@inheritdoc}
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    CacheBackendInterface $cache,
    Client $http_client,
    WeatherDBRepository $repository,
    AccountProxyInterface $user
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->client = $http_client;
    $this->cacheBackend = $cache;
    $this->repository = $repository;
    $this->user = $user;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('cache.default'),
      $container->get('http_client'),
      $container->get('weather.repository'),
      $container->get('current_user')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $cachedWeather = $this->getCachedWeather();
    return [
      '#theme' => 'weather',
      '#name' => $cachedWeather["location"]["name"] ?? '',
      '#temperature' => $cachedWeather["current"]["temp_c"] ?? '',
      '#icon' => $cachedWeather["current"]["condition"]["icon"] ?? '',
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
    else {
      return FALSE;
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
