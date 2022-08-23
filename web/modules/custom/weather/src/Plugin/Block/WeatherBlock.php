<?php

namespace Drupal\weather\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\weather\WeatherGetData;

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
   * Get data from Drupal\weather\WeatherGetData service.
   *
   * @var array
   */
  protected $weatherData;

  /**
   * {@inheritdoc}
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    WeatherGetData $data
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->weatherData = $data;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('weather.get_data'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $cachedWeather = $this->weatherData->getWeather();
    return [
      '#theme' => 'weather',
      '#name' => $cachedWeather["location"]["name"] ?? '',
      '#temperature' => $cachedWeather["current"]["temp_c"] ?? '',
      '#icon' => $cachedWeather["current"]["condition"]["icon"] ?? '',
      '#cache' => [
        'contexts' => ['weather_city_name'],
        'max-age' => 10800,
      ],
    ];
  }

}
