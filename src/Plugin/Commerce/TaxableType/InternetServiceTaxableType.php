<?php

namespace Drupal\hosting_control_panel\Plugin\TaxableType;
use Drupal\commerce_tax\TaxableType;

/**
 * Provides taxable types.
 */
final class InternetServiceTaxableType extends TaxableType {

  const INTERNET_SERVICES = 'internet_services';

  /**
   * Gets the labels.
   *
   * @return array
   *   An array of labels keyed by taxable type.
   */
  public static function getLabels() {
      return array_merge(
              parent::getLabels(),
              [
                  self::INTERNET_SERVICES => t('Internet Services'),
              ]
      );
      
  }

  /**
   * Gets the default value.
   *
   * @return string
   *   The default value.
   */
  public static function getDefault() {
    return self::INTERNET_SERVICES;
  }

}
