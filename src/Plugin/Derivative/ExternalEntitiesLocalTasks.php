<?php

/**
 * @file
 * Contains \Drupal\hosting_control_panel\Plugin\Derivative\ExternalEntitiesLocalTasks.
 */

namespace Drupal\hosting_control_panel\Plugin\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityStorageInterface;

/**
 * Provides dynamic local tasks for external entities.
 */
class ExternalEntitiesLocalTasks extends DeriverBase implements ContainerDeriverInterface {

  /**
   * The base plugin ID.
   *
   * @var string
   */
  protected $basePluginId;

  /**
   * The storage handler.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface.
   */
  protected $storage;

  /**
   * Constructs a new ConfigTranslationLocalTasks.
   *
   * @param string $base_plugin_id
   *   The base plugin ID.
   * @param \Drupal\Core\Entity\EntityStorageInterface $storage
   *   The storage handler.
   */
  public function __construct($base_plugin_id, EntityStorageInterface $storage) {
    $this->basePluginId = $base_plugin_id;
    $this->storage = $storage;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, $base_plugin_id) {
    return new static(
      $base_plugin_id,
      $container->get('entity.manager')->getStorage('hosting_entity_type')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition) {
    $base_route = FALSE;
    foreach ($this->storage->loadMultiple() as $type) {
      $route_name = 'entity.hosting_control_panel_entity.' . $type->id();
      $this->derivatives[$route_name] = $base_plugin_definition;
      $this->derivatives[$route_name]['title'] = $type->label() . ' external entities';
      $this->derivatives[$route_name]['route_name'] = $route_name;
      if (!$base_route) {
        $base_route = $route_name;
      }
      $this->derivatives[$route_name]['base_route'] = $base_route;
    }
    return parent::getDerivativeDefinitions($base_plugin_definition);
  }

}
