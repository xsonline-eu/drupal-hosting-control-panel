<?php

/**
 * @file
 * Contains \Drupal\hosting_control_panel\HostingControlPanelEntityPermissions.
 */

namespace Drupal\hosting_control_panel;

use Drupal\Core\Routing\UrlGeneratorTrait;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\hosting_control_panel\Entity\HostingControlPanelEntityType;

/**
 * Defines a class containing permission callbacks.
 */
class HostingControlPanelEntityPermissions {

  use StringTranslationTrait;
  use UrlGeneratorTrait;

  /**
   * Gets an array of Hosting Control Panel Entity type permissions.
   *
   * @return array
   *   The Hosting Control Panel Entity type permissions.
   *   @see \Drupal\user\PermissionHandlerInterface::getPermissions()
   */
  public function HostingControlPanelEntityTypePermissions() {
    $perms = array();
    // Generate node permissions for all node types.
    foreach (HostingControlPanelEntityType::loadMultiple() as $type) {
      $perms += $this->buildPermissions($type);
    }

    return $perms;
  }

  /**
   * Builds a standard list of Hosting control panel entity permissions for a given type.
   *
   * @param \Drupal\hosting_control_panel\Entity\HostingControlPanelEntityType $type
   *   The machine name of the Hosting Control Panel Entity type.
   *
   * @return array
   *   An array of permission names and descriptions.
   */
  protected function buildPermissions(HostingControlPanelEntityType $type) {
    $type_id = $type->id();
    $type_params = array('%type_name' => $type->label());

    return array(
      "view $type_id Hosting control panel entity" => array(
        'title' => $this->t('%type_name: View any Hosting control panel entity', $type_params),
      ),
      "create $type_id Hosting control panel entity" => array(
        'title' => $this->t('%type_name: Create new Hosting control panel entity', $type_params),
      ),
      "edit $type_id Hosting control panel entity" => array(
        'title' => $this->t('%type_name: Edit any Hosting control panel entity', $type_params),
      ),
      "delete $type_id Hosting control panel entity" => array(
        'title' => $this->t('%type_name: Delete any Hosting control panel entity', $type_params),
      ),
    );
  }

}
