<?php

/**
 * @file
 * Contains \Drupal\hosting_control_panel\Controller\HostingControlPanelEntityViewController.
 */

namespace Drupal\hosting_control_panel\Controller;

use Drupal\Component\Utility\SafeMarkup;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\Controller\EntityViewController;

/**
 * Defines a controller to render a single Hosting control panel entity.
 */
class HostingControlPanelEntityViewController extends EntityViewController {

  /**
   * {@inheritdoc}
   */
  public function view(EntityInterface $entity, $view_mode = 'full', $langcode = NULL) {
    $build = array('hosting_control_panel_entities' => parent::view($entity));

    $build['#title'] = $build['hosting_control_panel_entities']['#title'];
    unset($build['hosting_control_panel_entities']['#title']);

    foreach ($entity->uriRelationships() as $rel) {
      // Set the node path as the canonical URL to prevent duplicate content.
      $build['#attached']['html_head_link'][] = array(
        array(
          'rel' => $rel,
          'href' => $entity->url($rel),
        ),
        TRUE,
      );

      if ($rel == 'canonical') {
        // Set the non-aliased canonical path as a default shortlink.
        $build['#attached']['html_head_link'][] = array(
          array(
            'rel' => 'shortlink',
            'href' => $entity->url($rel, array('alias' => TRUE)),
          ),
          TRUE,
        );
      }
    }

    return $build;
  }

  /**
   * The _title_callback for the page that renders a single Hosting control panel entity.
   *
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   The current Hosting control panel entity.
   *
   * @return string
   *   The page title.
   */
  public function title(EntityInterface $entity) {
    return SafeMarkup::checkPlain($this->entityManager->getTranslationFromContext($entity)->label());
  }

}
