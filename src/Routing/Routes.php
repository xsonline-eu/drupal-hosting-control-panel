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
    $routes['hosting_control_panel.hello'] = new Route(
      // Path to attach this route to:
      '/hello',
      // Route defaults:
      array(
        '_controller' => '\Drupal\hosting_control_panel\Controller\DefaultController::hello',
        '_title' => 'Hello'
      ),
      // Route requirements:
      array(
        '_permission'  => 'access content',
      )
    );
    return $routes;
  }

}
