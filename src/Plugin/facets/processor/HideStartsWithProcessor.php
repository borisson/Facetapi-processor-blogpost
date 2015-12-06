<?php

namespace Drupal\hide_starts_with\Plugin\facets\processor;

use Drupal\Core\Form\FormStateInterface;
use Drupal\facets\FacetInterface;
use Drupal\facets\Processor\BuildProcessorInterface;
use Drupal\facets\Processor\ProcessorPluginBase;

/**
 * Provides a processor that hides results start with a configurable character.
 *
 * @FacetsProcessor(
 *   id = "hide_start_with",
 *   label = @Translation("Hide start with some letter"),
 *   description = @Translation("Hide all results that start with a configurable character"),
 *   stages = {
 *     "build" = 40
 *   }
 * )
 */
class HideStartsWithProcessor extends ProcessorPluginBase implements BuildProcessorInterface {

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state, FacetInterface $facet) {
    $processors = $facet->getProcessors();
    $config = isset($processors[$this->getPluginId()]) ? $processors[$this->getPluginId()] : null;

    $build['character'] = [
      '#title' => $this->t('Character to hide'),
      '#type' => 'textfield',
      '#default_value' => !is_null($config) ? $config->getConfiguration()['character'] : '',
      '#description' => $this->t("All results that start with this character will be hidden."),
    ];

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function build(FacetInterface $facet, array $results) {

    $processors = $facet->getProcessors();
    $config = $processors[$this->getPluginId()];

    $char = $config->getConfiguration()['character'];

    /** @var \Drupal\facets\Result\ResultInterface $result */
    foreach ($results as $id => $result) {
      if (strpos(strtolower($result->getDisplayValue()), $char) === 0) {
        unset($results[$id]);
      }
    }
    return $results;
  }

}
