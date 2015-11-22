<?php

namespace Drupal\hide_starts_with\Plugin\facetapi\processor;

use Drupal\facetapi\FacetInterface;
use Drupal\facetapi\Processor\BuildProcessorInterface;
use Drupal\facetapi\Processor\ProcessorPluginBase;

/**
 * Provides a processor that hides results start with a configurable character.
 *
 * @FacetApiProcessor(
 *   id = "hide_start_with",
 *   label = @Translation("Hide start with some letter"),
 *   description = @Translation("Hide all results that start with a configurable character"),
 *   stages = {
 *     "build" = 40
 *   }
 * )
 */
class HideStartsWithProcessor extends ProcessorPluginBase implements BuildProcessorInterface {
  public function build(FacetInterface $facet, array $results) {

    /** @var \Drupal\facetapi\Result\ResultInterface $result */
    foreach ($results as $id => $result) {
      if (strpos(strtolower($result->getDisplayValue()), 'a') === 0) {
        unset($results[$id]);
      }
    }
    return $results;
  }

}
