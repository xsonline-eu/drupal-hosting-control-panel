<?php

/**
 * @file
 * Contains \Drupal\hosting_control_panel\Entity\Query\External\QueryFactory.
 */

namespace Drupal\hosting_control_panel\Entity\Query\External;

use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\Query\QueryBase;
use Drupal\Core\Entity\Query\QueryFactoryInterface;
use Drupal\Component\Plugin\PluginManagerInterface;
use Drupal\hosting_control_panel\ResponseDecoderFactoryInterface;
use GuzzleHttp\ClientInterface;

/**
 * Factory class creating entity query objects for the external backend.
 *
 * @see \Drupal\hosting_control_panel\Entity\Query\External\Query
 */
class QueryFactory implements QueryFactoryInterface {

  /**
   * The namespace of this class, the parent class etc.
   *
   * @var array
   */
  protected $namespaces;

  /**
   * The external storage client manager.
   *
   * @var \Drupal\Component\Plugin\PluginManagerInterface
   */
  protected $storageClientManager;

  /**
   * The decoder.
   *
   * @var \Drupal\hosting_control_panel\ResponseDecoderFactoryInterface
   */
  protected $decoder;

  /**
   * The HTTP client to fetch the data with.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  /**
   * Stores the entity manager used by the query.
   *
   * @var \Drupal\Core\Entity\EntityManagerInterface
   */
  protected $entityManager;
  
  /**
   * The current class name for the query
   * 
   * @var String
   */
  protected $queryClassName = 'Query';

  /**
   * Constructs a QueryFactory object.
   */
  public function __construct(PluginManagerInterface $storage_client_manager, ResponseDecoderFactoryInterface $decoder, ClientInterface $http_client, EntityManagerInterface $entity_manager) {
    $this->namespaces = QueryBase::getNamespaces($this);
    $this->storageClientManager = $storage_client_manager;
    $this->decoder = $decoder;
    $this->httpClient = $http_client;
    $this->entityManager = $entity_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function get(EntityTypeInterface $entity_type, $conjunction) {
    if ($conjunction == 'OR') {
      throw new QueryException("Hosting control panel entity queries do not support OR conditions.");
    }
    $class = QueryBase::getClass($this->namespaces, $this->queryClassName);
    return new $class($entity_type, $conjunction, $this->namespaces, $this->storageClientManager, $this->decoder, $this->httpClient, $this->entityManager);
  }

  /**
   * {@inheritdoc}
   */
  public function getAggregate(EntityTypeInterface $entity_type, $conjunction) {
    throw new QueryException("Hosting control panel entity queries do not support aggragate queries.");
  }

}
