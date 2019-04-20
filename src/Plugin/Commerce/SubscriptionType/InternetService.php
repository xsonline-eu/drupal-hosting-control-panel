<?php

namespace Drupal\hosting_control_panel\Plugin\Commerce\SubscriptionType;
use Drupal\commerce_recurring\Plugin\Commerce\SubscriptionType\SubscriptionTypeBase;

/**
 * Provides the product variation subscription type.
 *
 * @CommerceSubscriptionType(
 *   id = "internet_service",
 *   label = @Translation("Internet Service"),
 *   purchasable_entity_type = "commerce_product_variation",
 * )
 */
class InternetService extends SubscriptionTypeBase {}
