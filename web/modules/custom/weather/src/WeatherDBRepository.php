<?php

namespace Drupal\weather;

use Drupal\Core\Database\Connection;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Messenger\MessengerTrait;

/**
 * Repository for database-related methods for weather module.
 */
class WeatherDBRepository {

  use MessengerTrait;

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  /**
   * Construct a repository object.
   *
   * @param \Drupal\Core\Database\Connection $connection
   *   The database connection.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   Messenger interface.
   */
  public function __construct(Connection $connection, MessengerInterface $messenger) {
    $this->connection = $connection;
    $this->setMessenger($messenger);
  }

  /**
   * Save an entry in the database.
   *
   * @param array $entry
   *   An array containing all the fields of the database record.
   *
   * @return int
   *   The number of updated rows.
   *
   * @throws \Exception
   *   When the database insert fails.
   */
  public function insert(array $entry) {
    try {
      $return_value = $this->connection->insert('weather_statistics')
        ->fields($entry)
        ->execute();
    }
    catch (\Exception $e) {
      $this->messenger()->addMessage($e);
    }
    return $return_value ?? NULL;
  }

  /**
   * Load statistics from the database using join.
   */
  public function loadStatistics() {
    $select = $this->connection->select('weather_statistics', 'e');
    $select->join('users_field_data', 'u', 'e.uid = u.uid');
    $select->addField('e', 'city');
    $select->addField('u', 'name');
    $select->distinct('name');
    $entries = $select->execute()->fetchAll(\PDO::FETCH_ASSOC);
    return $entries;
  }

}
