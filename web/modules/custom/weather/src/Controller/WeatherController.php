<?php

namespace Drupal\weather\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\weather\WeatherDBRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller for weather.
 */
class WeatherController extends ControllerBase {
  /**
   * The repository for specialized queries.
   *
   * @var \Drupal\weather\WeatherDBRepository
   */
  protected $repository;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('weather.repository'),
    );
  }

  /**
   * Construct a new controller.
   *
   * @param \Drupal\weather\WeatherDBRepository $repository
   *   The repository service.
   */
  public function __construct(WeatherDBRepository $repository) {
    $this->repository = $repository;
  }

  /**
   * Load data from the database and render into table.
   */
  public function statisticsList() {
    $entries = $this->repository->loadStatistics();

    $content = [];
    $rows = [];
    $headers = [
      'city',
      'user',
    ];

    foreach ($entries as $entry) {
      $rows[] = $entry;
    }

    $content['message'] = [
      '#markup' => 'List of users using current location weather.',
    ];

    $content['table'] = [
      '#type' => 'table',
      '#header' => $headers,
      '#rows' => $rows,
      '#empty' => 'No entries available.',
    ];
    return $content;
  }

}
