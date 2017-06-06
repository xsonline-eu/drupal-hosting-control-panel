<?php

/**
 * @file
 * Contains \Drupal\example\Routing\ExampleRoutes.
 */
namespace Drupal\hosting_control_panel\Routing;

use Symfony\Component\Routing\Route;

/**
 * Defines dynamic routes.
 */
class Routes {

  /**
   * {@inheritdoc}
   */
  public function routes() {
    $routes = array();
    // Declares a single route under the name 'example.content'.
    // Returns an array of Route objects. 
    $routes['hosting_control_panel.default'] = new Route(
      // Path to attach this route to:
      '/hosting',
      // Route defaults:
      array(
        '_controller' => '\Drupal\hosting_control_panel\Controller\DefaultController::index',
        '_title' => 'Index'
      ),
      // Route requirements:
      array(
        '_permission'  => 'access content',
      )
    );
    return $routes;
  }

}
