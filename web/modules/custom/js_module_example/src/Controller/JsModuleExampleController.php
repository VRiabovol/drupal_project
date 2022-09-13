<?php

namespace Drupal\js_module_example\Controller;

use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Returns responses for js module example routes.
 */
class JsModuleExampleController {

  use StringTranslationTrait;

  /**
   * Accordion page implementation.
   *
   * We're allowing a twig template to define our content in this case,
   * which isn't normally how things work, but it's easier to demonstrate
   * the JavaScript this way.
   *
   * @return array
   *   A renderable array.
   */
  public function getJsAccordionImplementation(): array {
    $title = $this->t('Click sections to expand or collapse:');
    // Build using our theme. This gives us content, which is not a good
    // practice, but which allows us to demonstrate adding JavaScript here.
    $build['myelement'] = [
      '#theme' => 'js_accordion',
      '#title' => $title,
    ];
    // Add our script. It is tiny, but this demonstrates how to add it. We pass
    // our module name followed by the internal library name declared in
    // libraries yml file.
    $build['myelement']['#attached']['library'][] = 'js_module_example/js_example.accordion';
    // Return the renderable array.
    return $build;
  }

}
