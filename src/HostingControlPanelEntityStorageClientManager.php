<?php

/**
 * @file
 * Contains \Drupal\hosting_control_panel\HostingControlPanelEntityStorageClientManager.
 */

namespace Drupal\hosting_control_panel;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * HostingControlPanelEntityStorageClient plugin manager.
 */
class HostingControlPanelEntityStorageClientManager extends DefaultPluginManager{ 
  /**
   * Constructs an HostingControlPanelEntityStorageClientManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations,
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct(
      'Plugin/HostingControlPanelEntityStorageClient',
      $namespaces,
      $module_handler,
      'Drupal\hosting_control_panel\HostingControlPanelEntityStorageClientInterface',
      'Drupal\hosting_control_panel\Annotation\HostingControlPanelEntityStorageClient'
    );
    $this->alterInfo('hosting_control_panel_entity_storage_client_info');
    $this->setCacheBackend($cache_backend, 'hosting_control_panel_entity_storage_client');
  }
}
