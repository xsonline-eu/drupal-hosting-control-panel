<?php

/**
 * @file
 * Contains Drupal\hosting_control_panel\ExternalEntitiesServiceProvider.
 */

namespace Drupal\hosting_control_panel;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;

/**
 * Modifies the serialization services.
 */
class ExternalEntitiesServiceProvider extends ServiceProviderBase {

  /**
   * {@inheritdoc}
   */
  public function alter(ContainerBuilder $container) {
    $container->getDefinition('serialization.json')->addTag('hosting_control_panel_entity_response_decoder');
    $container->getDefinition('serialization.phpserialize')->addTag('hosting_control_panel_entity_response_decoder');
    $container->getDefinition('serialization.yaml')->addTag('hosting_control_panel_entity_response_decoder');
  }
}
