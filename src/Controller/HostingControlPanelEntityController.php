<?php

/**
 * @file
 * Contains \Drupal\hosting_control_panel\Controller\HostingControlPanelEntityController.
 */

namespace Drupal\hosting_control_panel\Controller;

use Drupal\Component\Utility\SafeMarkup;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\Core\Url;
use Drupal\hosting_control_panel\HostingControlPanelEntityTypeInterface;
use Drupal\hosting_control_panel\HostingControlPanelEntityInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for Node routes.
 */
class HostingControlPanelEntityController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * The renderer service.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * Constructs a HostingControlPanelEntityController object.
   *
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The renderer service.
   */
  public function __construct(RendererInterface $renderer) {
    $this->renderer = $renderer;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('renderer')
    );
  }


  /**
   * Displays add Hosting control panel entity links for available types.
   *
   * Redirects to hosting-control-panel-entity/add/[type] if only one type is available.
   *
   * @return array
   *   A render array for a list of the Hosting Control Panel Entity types that can be added;
   *   however, if there is only one type defined for the site, the function
   *   redirects to the add page for that one type and does not return at all.
   *
   * @see node_menu()
   */
  public function addPage() {
    $content = array();

    // Only use node types the user has access to.
    foreach ($this->entityManager()->getStorage('hosting_entity_type')->loadMultiple() as $type) {
      if ($this->entityManager()->getAccessControlHandler('hosting_control_panel_entity')->createAccess($type->id())) {
        $content[$type->id()] = $type;
      }
    }

    // Bypass the node/add listing if only one content type is available.
    if (count($content) == 1) {
      $type = array_shift($content);
      return $this->redirect('hosting_control_panel_entity.add', array('hosting_entity_type' => $type->id()));
    }

    return array(
      '#theme' => 'hosting_control_panel_entities_add_list',
      '#content' => $content,
    );
  }

  /**
   * Provides the node submission form.
   *
   * @param \Drupal\hosting_control_panel\HostingControlPanelEntityTypeInterface $hosting_entity_type
   *   The external type entity for the Hosting control panel entity.
   *
   * @return array
   *   An Hosting control panel entity submission form.
   */
  public function add(HostingControlPanelEntityTypeInterface $hosting_entity_type) {
    $entity = $this->entityManager()->getStorage('hosting_control_panel_entity')->create(array(
      'type' => $hosting_entity_type->id(),
    ));

    $form = $this->entityFormBuilder()->getForm($entity);

    return $form;
  }

  /**
   * The _title_callback for the hosting_control_panel_entity.add route.
   *
   * @param \Drupal\hosting_control_panel\HostingControlPanelEntityTypeInterface $hosting_entity_type
   *   The current Hosting control panel entity.
   *
   * @return string
   *   The page title.
   */
  public function addPageTitle(HostingControlPanelEntityTypeInterface $hosting_entity_type) {
    return $this->t('Create @name', array('@name' => $hosting_entity_type->label()));
  }

}
