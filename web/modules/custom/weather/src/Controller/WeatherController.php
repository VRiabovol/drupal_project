<?php

namespace Drupal\weather\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
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
      'City',
      'User',
    ];

    foreach ($entries as $entry) {
      $row['city']['data'] = $entry['city'] ?? '';
      $row['name']['data'] = [
        '#type' => 'link',
        '#title' => $entry['name'] ?? '',
        '#url' => Url::fromRoute('entity.user.canonical', ['user' => $entry['uid'] ?? '']),
      ];
      $rows[] = $row;
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

    $headers_total = ['Total users'];
    $users_counter = count($rows) ?? '';
    $rows_total[] = ['Total users' => $users_counter];

    $content['table_total'] = [
      '#type' => 'table',
      '#header' => $headers_total,
      '#rows' => $rows_total,
      '#empty' => 'No entries available',
    ];
    return $content;
  }

}
