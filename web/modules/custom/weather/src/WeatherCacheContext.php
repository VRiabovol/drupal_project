<?php

namespace Drupal\weather;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Cache\Context\CacheContextInterface;

/**
 * Create cache context for city name.
 */
class WeatherCacheContext implements CacheContextInterface {
  /**
   * Drupal\weather\WeatherGetData instance.
   *
   * @var \Drupal\weather\WeatherGetData
   */
  protected $getWeatherData;

  /**
   * Construct Drupal\weather\WeatherGetData.
   *
   * @param \Drupal\weather\WeatherGetData $data
   *   Drupal\weather\WeatherGetData object.
   */
  public function __construct(WeatherGetData $data) {
    $this->getWeatherData = $data;
  }

  /**
   * {@inheritdoc}
   */
  public static function getLabel() {
    return 'weather city name';
  }

  /**
   * {@inheritdoc}
   */
  public function getContext() {
    $location = $this->getWeatherData->getWeather();
    if (!empty($location)) {
      return $location['location']['name'] ?? '';
    }
    else {
      return '';
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheableMetadata() {
    return new CacheableMetadata();
  }

}
