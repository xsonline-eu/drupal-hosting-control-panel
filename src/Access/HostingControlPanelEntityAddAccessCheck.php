<?php

/**
 * @file
 * Contains \Drupal\hosting_control_panel\Access\HostingControlPanelEntityAddAccessCheck.
 */

namespace Drupal\hosting_control_panel\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\hosting_control_panel\HostingControlPanelEntityTypeInterface;

/**
 * Determines access to for Hosting control panel entity add pages.
 *
 * @ingroup hosting_control_panel_entity_access
 */
class HostingControlPanelEntityAddAccessCheck implements AccessInterface {

  /**
   * The entity manager.
   *
   * @var \Drupal\Core\Entity\EntityManagerInterface
   */
  protected $entityManager;

  /**
   * Constructs a EntityCreateAccessCheck object.
   *
   * @param \Drupal\Core\Entity\EntityManagerInterface $entity_manager
   *   The entity manager.
   */
  public function __construct(EntityManagerInterface $entity_manager) {
    $this->entityManager = $entity_manager;
  }

  /**
   * Checks access to the node add page for the node type.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The currently logged in account.
   * @param \Drupal\hosting_control_panel\HostingControlPanelEntityTypeInterface $hosting_entity_type
   *   (optional) The node type. If not specified, access is allowed if there
   *   exists at least one node type for which the user may create a node.
   *
   * @return string
   *   A \Drupal\Core\Access\AccessInterface constant value.
   */
  public function access(AccountInterface $account, HostingControlPanelEntityTypeInterface $hosting_entity_type = NULL) {
    $access_control_handler = $this->entityManager->getAccessControlHandler('hosting_control_panel_entity');
    // Checking whether a Hosting control panel entity of a particular type may be created.
    if ($hosting_entity_type) {
      return $access_control_handler->createAccess($hosting_entity_type->id(), $account, [], TRUE);
    }

    $types = $this->entityManager->getStorage('hosting_entity_type')->loadMultiple();
    foreach ($types as $node_type) {
      if (($access = $access_control_handler->createAccess($node_type->id(), $account, [], TRUE)) && $access->isAllowed()) {
        return $access;
      }
    }
    if ($types && $account->hasPermission('administer Hosting Control Panel Entity types')) {
      return AccessResult::allowed()->cachePerPermissions();
    }

    if (!$types) {
      return AccessResult::forbidden();
    }

    // No opinion.
    return AccessResult::neutral();
  }

}
