<?php

namespace Drupal\hosting_control_panel\Plugin\rest\resource;

use Drupal\rest\ResourceResponse;

/**
 * Provides a product collection resource for current session.
 *
 * @RestResource(
 *   id = "commerce_product_collection",
 *   label = @Translation("Product collection"),
 *   uri_paths = {
 *     "canonical" = "/api/product"
 *   }
 * )
 */
class ProductCollectionResource extends ProductResourceBase {

  /**
   * GET a collection of the current user's product.
   *
   * @return \Drupal\rest\ResourceResponse
   *   The resource response.
   */
  public function get() {
    $carts = $this->productProvider->getProducts();

    $response = new ResourceResponse(array_values($carts), 200);
    /** @var \Drupal\commerce_order\Entity\OrderInterface $cart */
    foreach ($carts as $cart) {
      $response->addCacheableDependency($cart);
    }
    $response->getCacheableMetadata()->addCacheContexts([
      'store',
      'cart',
    ]);
    return $response;
  }

}
