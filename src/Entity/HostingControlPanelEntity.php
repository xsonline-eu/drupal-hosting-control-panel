<?php

namespace Drupal\hosting_control_panel\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\hosting_control_panel\HostingControlPanelEntityInterface;

/**
 * Defines the hosting control panel entity class.
 *
 * @ContentEntityType(
 *   id = "hosting_control_panel_entity",
 *   label = @Translation("Hosting control panel entity"),
 *   bundle_label = @Translation("Hosting Control Panel Entity type"),
 *   handlers = {
 *     "storage" = "Drupal\hosting_control_panel\HostingControlPanelEntityStorage",
 *     "storage_schema" = "Drupal\hosting_control_panel\HostingControlPanelEntityStorageSchema",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "access" = "Drupal\hosting_control_panel\HostingControlPanelEntityAccessControlHandler",
 *     "form" = {
 *       "default" = "Drupal\hosting_control_panel\HostingControlPanelEntityForm",
 *       "add" = "Drupal\hosting_control_panel\HostingControlPanelEntityForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *       "edit" = "Drupal\hosting_control_panel\HostingControlPanelEntityForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\hosting_control_panel\Entity\HostingControlPanelEntityRouteProvider",
 *     },
 *     "list_builder" = "Drupal\hosting_control_panel\HostingControlPanelEntityListBuilder",
 *   },
 *   translatable = FALSE,
 *   entity_keys = {
 *     "id" = "id",
 *     "bundle" = "type",
 *     "label" = "title",
 *     "uuid" = "uuid"
 *   },
 *   bundle_entity_type = "hosting_entity_type",
 *   field_ui_base_route = "entity.hosting_entity_type.edit_form",
 *   common_reference_target = TRUE,
 *   permission_granularity = "bundle",
 *   links = {
 *     "canonical" = "/hosting-control-panel-entity/{hosting_control_panel_entity}",
 *     "add-form" = "/hosting-control-panel-entity/{hosting_control_panel_entity}/add",
 *     "delete-form" = "/hosting-control-panel-entity/{hosting_control_panel_entity}/delete",
 *     "edit-form" = "/hosting-control-panel-entity/{hosting_control_panel_entity}/edit",
 *     "collection" = "/hosting-control-panel-entity",
 *   }
 * )
 */
class HostingControlPanelEntity extends ContentEntityBase implements HostingControlPanelEntityInterface {

  /**
   * {@inheritdoc}
   */
  public function id() {
    return $this->bundle() . '-' . parent::id();
  }

  /**
   * {@inheritdoc}
   */
  public function externalId() {
    return parent::id();
  }

  /**
   * {@inheritdoc}
   */
  public static function preDelete(EntityStorageInterface $storage, array $entities) {
    parent::preDelete($storage, $entities);
    if (method_exists($storage, 'preDelete')) {
      $storage->preDelete($entities);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage) {
    parent::preSave($storage);
    if (method_exists($storage, 'preSave')) {
      $storage->preSave($this);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getType() {
    return $this->bundle();
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields['id'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Hosting control panel entity ID'))
      ->setDescription(t('The Hosting control panel entity ID.'))
      ->setReadOnly(TRUE);

    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The Hosting control panel entity UUID.'))
      ->setReadOnly(TRUE);

    $fields['type'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Type'))
      ->setDescription(t('The Hosting Control Panel Entity type.'))
      ->setSetting('target_type', 'hosting_entity_type')
      ->setReadOnly(TRUE);

    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setRequired(TRUE)
      ->setTranslatable(FALSE)
      ->setRevisionable(FALSE)
      ->setDefaultValue('')
      ->setSetting('max_length', 255)
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -5,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -5,
      ))
      ->setDisplayConfigurable('form', TRUE);
    
    
    
    

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getMappedObject() {
    $bundle = $this->entityManager()->getStorage('hosting_entity_type')->load($this->bundle());
    $object = new \stdClass();
    foreach ($bundle->getFieldMappings() as $source => $destination) {
      $field_definition = $this->getFieldDefinition($source);
      $settings = $field_definition->getSettings();
      $property = $field_definition->getFieldStorageDefinition()->getMainPropertyName();

      $offset = 0;
      // Special case for references to external entities.
      if (isset($settings['target_type']) && $settings['target_type'] === 'hosting_control_panel_entity') {
        // Only 1 bundle is allowed.
        $target_bundle = reset($settings['handler_settings']['target_bundles']);
        $offset = strlen($target_bundle) + 1;
      }
      // If the field has many item we proccess each one.
      if ($this->get($source)->count() > 1) {
        $values = $this->get($source)->getValue();
        $object->{$destination} = [];
        foreach ($values as $value_row) {
          $object->{$destination}[] = substr($value_row[$property], $offset);
        }
      }
      else {
        $object->{$destination} = substr($this->get($source)->{$property}, $offset);
      }
    }
    return $object;
  }

  /**
   * {@inheritdoc}
   */
  public function mapObject(\stdClass $obj) {
    // Don't touch the original object.
    $object = clone $obj;
    $bundle = $this->entityManager()->getStorage('hosting_entity_type')->load($this->bundle());

    foreach ($bundle->getFieldMappings() as $destination => $source) {
      $field_definition = $this->getFieldDefinition($destination);
      // When there is no definition go to the next item.
      if (!$field_definition) {
        continue;
      }
      $settings = $field_definition->getSettings();
      $property = $field_definition->getFieldStorageDefinition()->getMainPropertyName();

      $value_prefix = '';
      // Special case for references to external entities.
      if (isset($settings['target_type']) && $settings['target_type'] === 'hosting_control_panel_entity') {
        // Only 1 bundle is allowed.
        $target_bundle = reset($settings['handler_settings']['target_bundles']);
        $value_prefix = $target_bundle . '-';
      }
      // Array of value for the entity.
      $destination_value = [];
      // Set at least an empty string for the destination.
      $object->{$source} = isset($object->{$source}) ? $object->{$source} : '';
      // Convert to array.
      if (!is_array($object->{$source})) {
        $object->{$source} = [$object->{$source}];
      }
      foreach ($object->{$source} as $value) {
        // For array cases we assume the property keys arrive from the client
        // correctly.
        if (is_array($value)) {
          $destination_value[] = $value;
        }
        else {
          $destination_value[] = [$property => $value_prefix . $value];
        }
      }
      $this->set($destination, $destination_value);
    }
    return $this;
  }

}
