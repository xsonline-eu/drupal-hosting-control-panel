<?php
/**
 * @file
 * Contains \Drupal\hosting_control_panel\Routing\HostingControlPanelEntityRoutes.
 */

namespace Drupal\hosting_control_panel\Routing;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Drupal\Core\Entity\EntityManagerInterface;

/**
 * Defines dynamic routes.
 */
class HostingControlPanelEntityRoutes {

  /**
   * The entity storage handler.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $entityStorage;

  /**
   * Creates an HostingControlPanelEntityRoutes object.
   *
   * @param \Drupal\Core\Entity\EntityManagerInterface $entity_manager
   *   The entity manager.
   */
  public function __construct(EntityManagerInterface $entity_manager) {
    $this->entityStorage = $entity_manager->getStorage('hosting_entity_type');
  }

  /**
   * {@inheritdoc}
   */
  public function routes() {
    $route_collection = new RouteCollection();
    $first = TRUE;
    foreach ($this->entityStorage->loadMultiple() as $type) {
      if ($first) {
        $first = FALSE;
        $route = new Route(
          '/hosting-control-panel-entities',
          [
            '_controller' => '\Drupal\hosting_control_panel\Entity\Controller\HostingControlPanelEntityListController::listing',
            'entity_type' => 'hosting_control_panel_entity',
            'bundle' => $type->id(),
            '_title' => $type->label() . ' hosting control panel entities',
          ],
          [
            '_permission' => 'view Hosting control panel entity list page',
          ]
        );
        $route_collection->add('entity.hosting_control_panel_entity.collection', $route);
      }
      $route = new Route(
        '/hosting-control-panel-entities/' . $type->id(),
        [
          '_controller' => '\Drupal\hosting_control_panel\Entity\Controller\HostingControlPanelEntityListController::listing',
          'entity_type' => 'hosting_control_panel_entity',
          'bundle' => $type->id(),
          '_title' => $type->label() . ' external entities',
        ],
        [
          '_permission' => 'view Hosting control panel entity list page',
        ]
      );
      $route_collection->add('entity.hosting_control_panel_entity.' . $type->id(), $route);
    }
    return $route_collection;
  }
}
