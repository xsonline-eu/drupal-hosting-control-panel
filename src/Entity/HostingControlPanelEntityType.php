<?php

/**
 * @file
 * Contains \Drupal\hosting_control_panel\Entity\HostingControlPanelEntityType.
 */

namespace Drupal\hosting_control_panel\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;
use Drupal\hosting_control_panel\HostingControlPanelEntityTypeInterface;

// *     "storage" = "Drupal\hosting_control_panel\HostingControlPanelEntityTypeStorage",
// *     "storage_schema" = "Drupal\hosting_control_panel\HostingControlPanelEntityTypeStorageSchema",
// *   bundle_entity_type = "external_entity_type",


/**
 * Defines the Hosting Control Panel Entity type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "hosting_entity_type",
 *   label = @Translation("Hosting Control Panel Entity type"),
 *   handlers = {
 *     "storage" = "Drupal\hosting_control_panel\HostingControlPanelEntityTypeStorage",
 *     "access" = "Drupal\Core\Entity\EntityAccessControlHandler",
 *     "form" = {
 *       "add" = "Drupal\hosting_control_panel\HostingControlPanelEntityTypeForm",
 *       "edit" = "Drupal\hosting_control_panel\HostingControlPanelEntityTypeForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm"
 *     },
 *     "list_builder" = "Drupal\hosting_control_panel\HostingControlPanelEntityTypeListBuilder",
 *   },
 *   admin_permission = "administer Hosting Control Panel Entity types",
 *   config_prefix = "type",
 *   bundle_of = "hosting_control_panel_entity",
 *   entity_keys = {
 *     "id" = "type",
 *     "label" = "label"
 *   },
 *   links = {
 *     "edit-form" = "/admin/structure/hosting-control-panel-entity-types/manage/{hosting_entity_type}",
 *     "delete-form" = "/admin/structure/hosting-control-panel-entity-types/manage/{hosting_entity_type}/delete",
 *     "collection" = "/admin/structure/hosting-control-panel-entity-types",
 *   },
 *   config_export = {
 *     "label",
 *     "type",
 *     "description",
 *     "read_only",
 *     "field_mappings",
 *     "endpoint",
 *     "client",
 *     "format",
 *     "pager_settings",
 *     "api_key_settings",
 *     "parameters",
 *   }
 * )
 */
class HostingControlPanelEntityType extends ConfigEntityBundleBase implements HostingControlPanelEntityTypeInterface {

  /**
   * The machine name of this Hosting Control Panel Entity type.
   *
   * @var string
   */
  protected $type;

  /**
   * The human-readable name of the Hosting Control Panel Entity type.
   *
   * @var string
   */
  protected $label;

  /**
   * A brief description of this Hosting Control Panel Entity type.
   *
   * @var string
   */
  protected $description;

  /**
   * Whether or not entity types of this Hosting Control Panel Entity type are read only.
   *
   * @var boolean
   */
  protected $read_only;

  /**
   * The field mappings for this Hosting Control Panel Entity type.
   *
   * @var array
   */
  protected $field_mappings = array();

  /**
   * The endpoint of this Hosting Control Panel Entity type.
   *
   * @var string
   */
  protected $endpoint;

  /**
   * The Hosting control panel entity storage client id.
   *
   * @var string
   */
  protected $client = 'rest_client';

  /**
   * The format in which to make the requests for this externa entity type.
   *
   * For example: 'json'.
   *
   * @var string
   */
  protected $format = 'json';

  /**
   * An array with the pager settings.
   *
   * The array must contain following keys:
   *   - 'default_limit': default number of items per page.
   *   - 'page_parameter': The name of the page parameter.
   *   - 'page_size_parameter': The name of the page size parameter.
   *   - 'page_parameter_type': Either 'pagenum' or 'startitem'. Use 'pagenum'
   *     when the pager uses page numbers to determine the item to start at, use
   *     'startitem' when the pager uses the item number to start at.
   *   - 'page_size_parameter_type': Either 'pagesize' or 'enditem'. Use
   *     'pagesize' when the pager uses this parameter to determine the amount
   *     of items on each page, use 'enditem' when the pager uses this parameter
   *     to determine the number of the last item on the page.
   *
   * @var array
   */
  protected $pager_settings = [];

  /**
   * API key settings.
   *
   * An array with following keys:
   *   - 'header_name': The HTTP header name for the API key.
   *   - 'key': The value for the API key.
   *
   * @var array
   */
  protected $api_key_settings = [];

  /**
   * The parameters for this Hosting Control Panel Entity type.
   *
   * @var array
   */
  protected $parameters = [];


  /**
   * {@inheritdoc}
   */
  public function __construct(array $values, $entity_type) {
    parent::__construct($values, $entity_type);
    $this->pager_settings += array(
      'default_limit' => 10,
      'page_parameter' => 'page',
      'page_size_parameter' => 'pagesize',
      'page_parameter_type' => 'pagenum',
      'page_size_parameter_type' => 'pagesize',
    );
    $this->api_key_settings += array(
      'header_name' => '',
      'key' => '',
    );
    $this->parameters += array(
      'list' => [],
      'single' => [],
    );
  }
  /**
   * {@inheritdoc}
   */
  public function id() {
    return $this->type;
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * {@inheritdoc}
   */
  public function isReadOnly() {
    return $this->read_only;
  }

  /**
   * {@inheritdoc}
   */
  public function getFieldMappings() {
    return $this->field_mappings;
  }

  /**
   * {@inheritdoc}
   */
  public function getFieldMapping($field_name) {
    return isset($this->field_mappings[$field_name]) ? $this->field_mappings[$field_name] : FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function getEndpoint() {
    return $this->endpoint;
  }

  /**
   * {@inheritdoc}
   */
  public function getClient() {
    return $this->client;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormat() {
    return $this->format;
  }

  /**
   * {@inheritdoc}
   */
  public function getPagerSettings() {
    return $this->pager_settings;
  }

  /**
   * {@inheritdoc}
   */
  public function getApiKeySettings() {
    return $this->api_key_settings;
  }

  /**
   * {@inheritdoc}
   */
  public function getParameters() {
    return $this->parameters;
  }

  /**
   * {@inheritdoc}
   */
  public function getTypeParameters($type) {
    return isset($this->parameters[$type]) ? $this->parameters[$type] : [];
  }

}
