<?php

/**
 * @file
 * Contains \Drupal\hosting_control_panel\Entity\HostingControlPanelEntityRouteProvider.
 */

namespace Drupal\hosting_control_panel\Entity;

use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\Routing\EntityRouteProviderInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Provides routes for nodes.
 */
class HostingControlPanelEntityRouteProvider implements EntityRouteProviderInterface {

  /**
   * {@inheritdoc}
   */
  public function getRoutes( EntityTypeInterface $entity_type) {
    $route_collection = new RouteCollection();
    $route = (new Route('/hosting-control-panel-entity/{hosting_control_panel_entity}'))
      ->addDefaults([
        '_entity_view' => 'hosting_control_panel_entity.full',
        '_title' => 'View Hosting control panel entity',
      ])
      ->setRequirement('_entity_access', 'hosting_control_panel_entity.view');
    $route_collection->add('entity.hosting_control_panel_entity.canonical', $route);

    $route = (new Route('/hosting-control-panel-entity/{hosting_control_panel_entity}/delete'))
      ->addDefaults([
        '_entity_form' => 'hosting_control_panel_entity.delete',
        '_title' => 'Delete',
      ])
      ->setRequirement('_entity_access', 'hosting_control_panel_entity.delete')
      ->setOption('_hosting_control_panel_entity_operation_route', TRUE);
    $route_collection->add('entity.hosting_control_panel_entity.delete_form', $route);

    $route = (new Route('/hosting-control-panel-entity/{hosting_control_panel_entity}/edit'))
      ->setDefault('_entity_form', 'hosting_control_panel_entity.edit')
      ->setRequirement('_entity_access', 'hosting_control_panel_entity.update')
      ->setOption('_hosting_control_panel_entity_operation_route', TRUE);
    $route_collection->add('entity.hosting_control_panel_entity.edit_form', $route);

    return $route_collection;
  }

}
