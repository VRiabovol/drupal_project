<?php

namespace Drupal\field_features\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\media\Plugin\Field\FieldFormatter\MediaThumbnailFormatter;

/**
 * Plugin implementation of the 'media_field_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "field_features_media_field_formatter",
 *   label = @Translation("Media field formatter"),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class MediaFieldFormatter extends MediaThumbnailFormatter {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = parent::viewElements($items, $langcode);
    return $elements[0] ?? [];
  }

}
