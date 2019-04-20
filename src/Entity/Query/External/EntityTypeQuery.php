<?php

/**
 * @file
 * Contains \Drupal\hosting_control_panel\Entity\Query\External\EntityTypeQuery.
 */

namespace Drupal\hosting_control_panel\Entity\Query\External;

use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\Query\QueryBase;
use Drupal\Core\Entity\Query\QueryException;
use Drupal\Core\Entity\Query\QueryInterface;
use Drupal\Component\Plugin\PluginManagerInterface;
use Drupal\hosting_control_panel\ResponseDecoderFactoryInterface;
use GuzzleHttp\ClientInterface;
use Drupal\hosting_control_panel\Entity\Query\External\Query;

class EntityTypeQuery
extends Query
//implements QueryInterface 
{
    /**
   * Prepares the basic query with proper metadata/tags and base fields.
   *
   * @throws \Drupal\Core\Entity\Query\QueryException
   *   Thrown if the base table does not exists.
   *
   * @return \Drupal\Core\Entity\Query\Sql\Query
   *   Returns the called object.
   */
  protected function prepare() {
    $this->checkConditions();
    return $this;
  }
  
    /**
   * Finish the query by adding fields, GROUP BY and range.
   *
   * @return \Drupal\Core\Entity\Query\Sql\Query
   *   Returns the called object.
   */
  protected function finish() {
//    $bundle_id = $this->getBundle();
//    die($this->entityType);
////    die($this->entityManager->getStorage($this->entityType));
////    die($bundle_id);
////    $bundle = $this->entityManager->getStorage('hosting_control_panel_entity')->load($bundle_id);
//    
//    $bundle = $this->entityManager->getStorage($this->entityType->getBundleEntityType())->load($bundle_id);
//    $pager_settings = $bundle->getPagerSettings();
//
//    $this->initializePager();
//
//    if (!empty($pager_settings['page_parameter']) && !empty($pager_settings['page_size_parameter'])) {
//      if ($this->range) {
//        $start = $this->range['start'];
//        $end = $this->range['length'];
//        if ($pager_settings['page_parameter_type'] === 'pagenum') {
//          $start = $this->range['start'] / $this->range['length'];
//        }
//        if ($pager_settings['page_size_parameter_type'] === 'enditem') {
//          $end = $this->range['start'] + $this->range['length'];
//        }
//        $this->setParameter($pager_settings['page_parameter'], $start);
//        $this->setParameter($pager_settings['page_size_parameter'], $end);
//      }
//    }
    return $this;
  }
  
  /**
   * Executes the query and returns the result.
   *
   * @return int|array
   *   Returns the query result as entity IDs.
   */
  protected function result() {
    if ($this->count) {
      return count($this->getStorageClient()->query($this->parameters));
    }
    // Return a keyed array of results. The key is either the revision_id or
    // the entity_id depending on whether the entity type supports revisions.
    // The value is always the entity id.
    // TODO.
//    die('test');
//    die($this->getStorageClient());
    $query_results = $this->getStorageClient()->query($this->parameters);
    $result = array();
    $bundle_id = $this->getBundle();
//    $bundle = $this->entityManager->getStorage($this->entityType->getBundleEntityType())->load($bundle_id);
    foreach ($query_results as $query_result) {
//      $id = $bundle_id . '-' . $query_result->{$bundle->getFieldMapping('id')};
//        die(print_r($query_result, true));
        $id = $query_result[0];
      $result[$id] = $id;
    }
//    die(print_r($result,true));
    return $result;
  }
  
  
  
}