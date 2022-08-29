<?php

namespace Drupal\field_features\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\media\Plugin\Field\FieldFormatter\MediaThumbnailFormatter;

/**
 * Plugin reset number of field values to 1.
 *
 * @FieldFormatter(
 *   id = "field_features_reset_number_of_values",
 *   label = @Translation("Reset number of values"),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class ResetNumberOfValuesFormatter extends MediaThumbnailFormatter {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = parent::viewElements($items, $langcode);
    return $elements[0] ?? [];
  }

}
