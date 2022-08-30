<?php

namespace Drupal\field_features\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * A widget bar.
 *
 * @FieldWidget(
 *   id = "field_features_taxonomy_color_picker",
 *   label = @Translation("Color picker widget"),
 *   field_types = {
 *     "string",
 *     "text"
 *   }
 * )
 */
class ColorPickerWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(
    FieldItemListInterface $items,
    $delta,
    array $element,
    array &$form,
    FormStateInterface $form_state) {
    $entity = $form_state->getFormObject()->getEntity();
    $field_name = $items->getName();
    $default_value = $entity->get($field_name)->value;
    $element['value'] = $element + [
      '#type' => 'color',
      '#title' => $this->t('Color'),
      '#default_value' => $default_value,
      '#description' => $this->t('Color, #type = color'),
    ];

    return $element;
  }

}
