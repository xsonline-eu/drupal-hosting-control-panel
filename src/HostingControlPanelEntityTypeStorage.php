<?php

/**
 * @file
 * Contains \Drupal\hosting_control_panel\HostingControlPanelEntityTypeStorage.
 */

namespace Drupal\hosting_control_panel;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityStorageException;
use Drupal\Component\Plugin\PluginManagerInterface;
use Drupal\hosting_control_panel\ResponseDecoderFactoryInterface;
use GuzzleHttp\ClientInterface;
use Drupal\Core\Config\Entity\ConfigEntityStorage;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Cache\CacheableMetadata;

use Drupal\Component\Uuid\Php;
use Drupal\language\ConfigurableLanguageManager;
use Drupal\Core\Cache\MemoryCache\MemoryCache;
use Drupal\Core\Entity\EntityInterface;

/**
 * Defines the controller class for nodes.
 *
 * This extends the base storage class, adding required special handling for
 * node entities.
 */
class HostingControlPanelEntityTypeStorage extends ConfigEntityStorage {

  /**
   * The external storage client manager.
   *
   * @var \Drupal\Component\Plugin\PluginManagerInterface
   */
  protected $storageClientManager;

  /**
   * Storage client instances.
   *
   * @var \Drupal\hosting_control_panel\HostingControlPanelEntityStorageClientInterface[]
   */
  protected $storageClients = [];

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
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
//    die(\Drupal::entityTypeManager()
//      ->getStorage('hosting_control_panel_entity_type.storage_client.config_factory'));

//    die($entity_type);

//    die($container);
    $return = new static(
      $entity_type,
//      $container->get('config.factory'),
            $container->get('hosting_control_panel_entity_type.storage_client.config_factory'),
      $container->get('uuid'),
      $container->get('language_manager'),
      $container->get('entity.memory_cache'),
            $container->get('plugin.manager.hosting_control_panel_entity_storage_client'),
      $container->get('hosting_control_panel_entity.storage_client.response_decoder_factory'),
      $container->get('http_client')
    );
//    die($return);
    return $return;
  }

  /**
   * Constructs a new HostingControlPanelEntityTypeStorage object.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type definition.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The config facttory.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache
   *   The cache backend to be used.
   * @param \Drupal\Component\Plugin\PluginManagerInterface $storage_client_manager
   *   The storage client manager.
   */
  public function __construct(
          EntityTypeInterface $entity_type,
//          EntityManagerInterface $entity_manager,
          ConfigFactoryInterface $configFactory,
//          CacheBackendInterface $cache,
          Php $uuid,
          ConfigurableLanguageManager $languageManager,
          MemoryCache $memoryCache,
          PluginManagerInterface $storage_client_manager,
          ResponseDecoderFactoryInterface $decoder,
          ClientInterface $http_client
          ) {
//      die($configFactory);
    parent::__construct($entity_type, $configFactory, $uuid, $languageManager, $memoryCache);
    $this->storageClientManager = $storage_client_manager;
    $this->decoder = $decoder;
    $this->httpClient = $http_client;
  }

  /**
   * Get the storage client for a bundle.
   *
   * @param string $bundle_id
   *   The bundle to get the storage client for.
   *
   * @return \Drupal\hosting_control_panel\HostingControlPanelEntityStorageClientInterface
   *   The Hosting control panel entity storage client.
   */
  protected function getStorageClient($bundle_id) {
      if (!$this->storageClient) {
 
//die($this->storageClientManager);

//      $bundle = $this->entityManager->getStorage($this->entityType->getBundleEntityType())->load($this->getBundle());

      $config = [
        'http_client' => $this->httpClient,
        'decoder' => $this->decoder,
//          
//        'endpoint' => $bundle->getEndpoint(),
//        'format' => $bundle->getFormat(),
        'http_headers' => [],
//        'parameters' => $bundle->getParameters(),
      ];
//      $api_key_settings = $bundle->getApiKeySettings();
//      if (!empty($api_key_settings['header_name']) && !empty($api_key_settings['key'])) {
//        $config['http_headers'][$api_key_settings['header_name']] = $api_key_settings['key'];
//      }

//      die($this->storageClientManager);
//      die('te');
      $this->storageClient = $this->storageClientManager->createInstance(
//        $bundle->getClient(),
        'rest_client',
        $config
      );
//      die('test2');
    }
    return $this->storageClient;
//    if (!isset($this->storageClients[$bundle_id])) {
//      $bundle = $this->entityManager->getStorage('hosting_entity_type')->load($bundle_id);
//      $config = [
//        'http_client' => $this->httpClient,
//        'decoder' => $this->decoder,
//        'endpoint' => $bundle->getEndpoint(),
//        'format' => $bundle->getFormat(),
//        'http_headers' => [],
//        'parameters' => $bundle->getParameters(),
//      ];
//      $api_key_settings = $bundle->getApiKeySettings();
//      if (!empty($api_key_settings['header_name']) && !empty($api_key_settings['key'])) {
//        $config['http_headers'][$api_key_settings['header_name']] = $api_key_settings['key'];
//      }
//      $this->storageClients[$bundle_id] = $this->storageClientManager->createInstance(
//        $bundle->getClient(),
//        $config
//      );
//    }
//    return $this->storageClients[$bundle_id];
  }

  /**
   * Acts on entities before they are deleted and before hooks are invoked.
   *
   * Used before the entities are deleted and before invoking the delete hook.
   *
   * @param \Drupal\Core\Entity\EntityInterface[] $entities
   *   An array of entities.
   *
   * @throws EntityStorageException
   */
  public function preDelete(array $entities) {
    foreach ($entities as $entity) {
      $bundle = $this->entityManager->getStorage('hosting_entity_type')->load($entity->bundle());
      if ($bundle && $bundle->isReadOnly()) {
        throw new EntityStorageException($this->t('Can not delete read-only external entities.'));
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  protected function doDelete($entities) {
    // Do the actual delete.
    foreach ($entities as $entity) {
      $this->getStorageClient($entity->bundle())->delete($entity);
    }
  }

  /**
   * {@inheritdoc}
   */
  protected function doLoadMultiple2(array $ids = NULL) {
    $result = parent::doLoadMultiple($ids);
//    die(print_r($result, true));
    return $result;

    $entities = array();
//    die($this->entityClass);

    foreach ($ids as $id) {
      $entities[$id] = 
              $this->create([
                  'id'=>$id,
              ])
//              ->mapObject($this->getStorageClient())
              ->enforceIsNew(FALSE)
              ;


//      $entities[$id] = $this->mapFromStorageRecords($records, $configs);




      /*
      if (strpos($id, '-')) {
        list($bundle, $external_id) = explode('-', $id);
        if ($external_id) {
          $entities[$id] = $this->create([$this->entityType->getKey('bundle') => $bundle])->mapObject($this->getStorageClient($bundle)->load($external_id))->enforceIsNew(FALSE);
        }
      }
      */
    }
//    die(print_r($entities, true));
    return $entities;
  }

    protected function doLoadMultiple(array $ids = NULL) {
      $prefix = $this
        ->getPrefix();

      // Get the names of the configuration entities we are going to load.
      if ($ids === NULL) {
        $names = array_keys($this->configFactory
          ->listAll($prefix));
      }
      else {
        $names = array();
        foreach ($ids as $id) {

          // Add the prefix to the ID to serve as the configuration object name.
          $names[] = $prefix . $id;
        }
      }
//die(print_r($names,true));
      // Load all of the configuration entities.

//      die(print_r($this->configFactory,true));

//      die($this->configFactory);

//      die('names: ' . print_r($names, true));
      
//      $names = ['external_entity.demoposts'];

      /** @var \Drupal\Core\Config\Config[] $configs */
      $configs = [];
      $records = [];
      foreach ($this->configFactory
        ->loadMultiple($names) as $config) {
        $id = $config
          ->get($this->idKey);
        $records[$id] = $this->overrideFree ? $config
          ->getOriginal(NULL, FALSE) : $config
          ->get();
        $configs[$id] = $config;
      }

//      die('records: ' . ((string)sizeof($records)));

      $entities = $this
        ->mapFromStorageRecords($records, $configs);

      // Config entities wrap config objects, and therefore they need to inherit
      // the cacheability metadata of config objects (to ensure e.g. additional
      // cacheability metadata added by config overrides is not lost).
      foreach ($entities as $id => $entity) {

        // But rather than simply inheriting all cacheability metadata of config
        // objects, we need to make sure the self-referring cache tag that is
        // present on Config objects is not added to the Config entity. It must be
        // removed for 3 reasons:
        // 1. When renaming/duplicating a Config entity, the cache tag of the
        //    original config object would remain present, which would be wrong.
        // 2. Some Config entities choose to not use the cache tag that the under-
        //    lying Config object provides by default (For performance and
        //    cacheability reasons it may not make sense to have a unique cache
        //    tag for every Config entity. The DateFormat Config entity specifies
        //    the 'rendered' cache tag for example, because A) date formats are
        //    changed extremely rarely, so invalidating all render cache items is
        //    fine, B) it means fewer cache tags per page.).
        // 3. Fewer cache tags is better for performance.
        $self_referring_cache_tag = [
          'config:' . $configs[$id]
            ->getName(),
        ];
        $config_cacheability = CacheableMetadata::createFromObject($configs[$id]);
        $config_cacheability
          ->setCacheTags(array_diff($config_cacheability
          ->getCacheTags(), $self_referring_cache_tag));
        $entity
          ->addCacheableDependency($config_cacheability);
      }
//      die('entities: ' . ((string) sizeof($entities)));
      return $entities;
    }


  /**
   * {@inheritdoc}
   */
  protected function mapToStorageRecord(EntityInterface $entity) {
//    die(get_class($entity).'-ok');
    return $entity
      ->toArray();
  }


  /**
   * Acts on an entity before the presave hook is invoked.
   *
   * Used before the entity is saved and before invoking the presave hook.
   *
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   The entity object.
   *
   * @throws EntityStorageException
   */
  public function preSave(\Drupal\Core\Entity\EntityInterface $entity) {
    $bundle = $this->entityManager->getStorage('hosting_entity_type')->load($entity->bundle());
    if ($bundle && $bundle->isReadOnly()) {
      throw new EntityStorageException($this->t('Can not save read-only external entities.'));
    }
  }
  /**
   * {@inheritdoc}
   */
  protected function doSave($id, \Drupal\Core\Entity\EntityInterface $entity) {
    return $this->getStorageClient($entity->bundle())->save($entity);
  }

  /**
   * {@inheritdoc}
   */
  protected function getQueryServiceName() {
    return 'entity_type.query.external';
  }

  /**
   * {@inheritdoc}
   */
  protected function has($id, \Drupal\Core\Entity\EntityInterface $entity) {
    return !$entity->isNew();
  }

  /**
   * {@inheritdoc}
   */
  protected function doDeleteFieldItems($entities) {
  }

  /**
   * {@inheritdoc}
   */
  protected function doDeleteRevisionFieldItems(ContentEntityInterface $revision) {
  }

  /**
   * {@inheritdoc}
   */
  protected function doLoadRevisionFieldItems($revision_id) {
  }

  /**
   * {@inheritdoc}
   */
  protected function doSaveFieldItems(ContentEntityInterface $entity, array $names = array()) {
  }

  /**
   * {@inheritdoc}
   */
  protected function readFieldItemsToPurge(FieldDefinitionInterface $field_definition, $batch_size) {
    return array();
  }

  /**
   * {@inheritdoc}
   */
  protected function purgeFieldItems(ContentEntityInterface $entity, FieldDefinitionInterface $field_definition) {
  }

  /**
   * {@inheritdoc}
   */
  public function countFieldData($storage_definition, $as_bool = FALSE) {
    return $as_bool ? 0 : FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function hasData() {
    return FALSE;
  }

}
