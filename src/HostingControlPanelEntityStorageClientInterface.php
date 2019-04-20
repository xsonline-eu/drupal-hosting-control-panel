<?php

/**
 * @file
 * Contains Drupal\hosting_control_panel\HostingControlPanelEntityStorageClientInterface.
 */

namespace Drupal\hosting_control_panel;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\hosting_control_panel\HostingControlPanelEntityInterface;

/**
 * Defines an interface for Hosting control panel entity storage client plugins.
 */
interface HostingControlPanelEntityStorageClientInterface extends PluginInspectionInterface {
  /**
   * Return the name of the Hosting control panel entity storage client.
   *
   * @return string
   *   The name of the Hosting control panel entity storage client.
   */
  public function getName();

  /**
   * Loads one entity.
   *
   * @param mixed $id
   *   The ID of the entity to load.
   *
   * @return \Drupal\hosting_control_panel\HostingControlPanelEntityInterface|null
   *   An Hosting control panel entity object. NULL if no matching entity is found.
   */
  public function load($id);

  /**
   * Saves the entity permanently.
   *
   * @param \Drupal\hosting_control_panel\HostingControlPanelEntityInterface $entity
   *   The entity to save.
   *
   * @return int
   *   SAVED_NEW or SAVED_UPDATED is returned depending on the operation
   *   performed.
   */
  public function save(HostingControlPanelEntityInterface $entity);

  /**
   * Deletes permanently saved entities.
   *
   * @param \Drupal\hosting_control_panel\HostingControlPanelEntityInterface $entity
   *   The Hosting control panel entity object to delete.
   */
  public function delete(HostingControlPanelEntityInterface $entity);

  /**
   * Query the external entities.
   *
   * @param array $parameters
   *   Key-value pairs of fields to query.
   */
  public function query(array $parameters);

  /**
   * Get HTTP headers to add.
   *
   * @return array
   *   Associative array of headers to add to the request.
   */
  public function getHttpHeaders();

}
