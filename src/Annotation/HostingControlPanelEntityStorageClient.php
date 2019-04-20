<?php

/**
 * @file
 * Contains \Drupal\hosting_control_panel\Annotation\HostingControlPanelEntityStorageClient.
 */

namespace Drupal\hosting_control_panel\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines an Hosting control panel entity storage client annotation object
 *
 * @see \Drupal\hosting_control_panel\HostingControlPanelEntityStorageClientManager
 * @see plugin_api
 *
 * @Annotation
 */
class HostingControlPanelEntityStorageClient extends Plugin {
  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The name of the storage client.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $name;

}
