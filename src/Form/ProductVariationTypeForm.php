<?php

namespace Drupal\hosting_control_panel\Form;

use Drupal\commerce\EntityHelper;
use Drupal\commerce\EntityTraitManagerInterface;
use Drupal\commerce\Form\CommerceBundleEntityFormBase;
use Drupal\commerce_product\ProductAttributeFieldManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\language\Entity\ContentLanguageSettings;
use Symfony\Component\DependencyInjection\ContainerInterface;


class ProductVariationTypeForm extends \Drupal\commerce_product\Form\ProductVariationTypeForm {
  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);
    $variation_type = $this->entity;
    if ($this->moduleHandler->moduleExists('commerce_order')) {
      // Prepare a list of order item types used to purchase product variations.
      $order_item_type_storage = $this->entityTypeManager->getStorage('commerce_order_item_type');
      $order_item_types = $order_item_type_storage->loadMultiple();
      $order_item_types = array_filter($order_item_types, function ($order_item_type) {
        return $order_item_type->getPurchasableEntityTypeId() == 'commerce_product_variation'
                || $order_item_type->getPurchasableEntityTypeId() == 'intenet_service_variation'
                ;
      });

      $form['orderItemType'] = [
        '#type' => 'select',
        '#title' => $this->t('Order item type'),
        '#default_value' => $variation_type->getOrderItemTypeId(),
        '#options' => EntityHelper::extractLabels($order_item_types),
        '#empty_value' => '',
        '#required' => TRUE,
      ];
    }

    return $form;
  }
}