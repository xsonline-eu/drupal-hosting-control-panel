<?php

/**
 * @file
 * Contains \Drupal\hosting_control_panel\HostingControlPanelEntityInterface.
 */

namespace Drupal\hosting_control_panel;

use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Provides an interface defining a node entity.
 */
interface HostingControlPanelEntityInterface extends ContentEntityInterface {

  /**
   * Gets the Hosting Control Panel Entity type.
   *
   * @return string
   *   The Hosting Control Panel Entity type.
   */
  public function getType();

  /**
   * Gets the external identifier.
   *
   * @return string|int|null
   *   The Hosting control panel entity identifier, or NULL if the object does not yet have
   *   an external identifier.
   */
  public function externalId();

  /**
   * Map this entity to a \stdClass object.
   *
   * @return \stdClass
   *   The mapped object.
   */
  public function getMappedObject();

  /**
   * Map a \stdClass object to this entity.
   *
   * @return $this
   */
  public function mapObject(\stdClass $object);

}
