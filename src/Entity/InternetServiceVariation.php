<?php
namespace Drupal\hosting_control_panel\Entity;
use Drupal\commerce_product\Entity\ProductVariation;

/**
 * Defines the internet service variation entity class.
 *
 * @ContentEntityType(
 *   id = "internet_service_variation",
 *   label = @Translation("Internet Service variation"),
 *   label_collection = @Translation("Internet Service variations"),
 *   label_singular = @Translation("Internet Service variation"),
 *   label_plural = @Translation("Internet Service variations"),
 *   label_count = @PluralTranslation(
 *     singular = "@count Internet Service variation",
 *     plural = "@count Internet Service variations",
 *   ),
 *   bundle_label = @Translation("Internet Service variation type"),
 *   handlers = {
 *     "event" = "Drupal\commerce_product\Event\ProductVariationEvent",
 *     "storage" = "Drupal\commerce_product\ProductVariationStorage",
 *     "access" = "Drupal\commerce_product\ProductVariationAccessControlHandler",
 *     "permission_provider" = "Drupal\commerce_product\ProductVariationPermissionProvider",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\commerce_product\ProductVariationListBuilder",
 *     "views_data" = "Drupal\commerce\CommerceEntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\commerce_product\Form\ProductVariationForm",
 *       "edit" = "Drupal\commerce_product\Form\ProductVariationForm",
 *       "duplicate" = "Drupal\commerce_product\Form\ProductVariationForm",
 *       "delete" = "Drupal\commerce_product\Form\ProductVariationDeleteForm",
 *     },
 *     "route_provider" = {
 *       "default" = "Drupal\commerce_product\ProductVariationRouteProvider",
 *     },
 *     "inline_form" = "Drupal\commerce_product\Form\ProductVariationInlineForm",
 *     "translation" = "Drupal\content_translation\ContentTranslationHandler"
 *   },
 *   admin_permission = "administer commerce_product",
 *   translatable = TRUE,
 *   translation = {
 *     "content_translation" = {
 *       "access_callback" = "content_translation_translate_access"
 *     },
 *   },
 *   base_table = "internet_service_variation",
 *   data_table = "internet_service_variation_field_data",
 *   entity_keys = {
 *     "id" = "variation_id",
 *     "bundle" = "type",
 *     "langcode" = "langcode",
 *     "uuid" = "uuid",
 *     "label" = "title",
 *     "published" = "status",
 *     "owner" = "uid",
 *     "uid" = "uid",
 *   },
 *   links = {
 *     "add-form" = "/product/{commerce_product}/variations/add",
 *     "edit-form" = "/product/{commerce_product}/variations/{commerce_product_variation}/edit",
 *     "duplicate-form" = "/product/{commerce_product}/variations/{commerce_product_variation}/duplicate",
 *     "delete-form" = "/product/{commerce_product}/variations/{commerce_product_variation}/delete",
 *     "collection" = "/product/{commerce_product}/variations",
 *     "drupal:content-translation-overview" = "/product/{commerce_product}/variations/{commerce_product_variation}/translations",
 *     "drupal:content-translation-add" = "/product/{commerce_product}/variations/{commerce_product_variation}/translations/add/{source}/{target}",
 *     "drupal:content-translation-edit" = "/product/{commerce_product}/variations/{commerce_product_variation}/translations/edit/{language}",
 *     "drupal:content-translation-delete" = "/product/{commerce_product}/variations/{commerce_product_variation}/translations/delete/{language}",
 *   },
 *   bundle_entity_type = "commerce_product_variation_type",
 *   field_ui_base_route = "entity.commerce_product_variation_type.edit_form",
 * )
 */
class InternetServiceVariation extends ProductVariation {
    
}