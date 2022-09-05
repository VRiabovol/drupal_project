<?php

namespace Drupal\weather;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining an weather entity type.
 */
interface WeatherEntityInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
