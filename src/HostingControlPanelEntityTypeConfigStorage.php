<?php
namespace Drupal\hosting_control_panel;

use Drupal\Core\Config\CachedStorage;

class HostingControlPanelEntityTypeConfigStorage extends CachedStorage {
    
    
    public function readMultiple(array $names) {
        $data_to_return = array();
        $cache_keys_map = $this
          ->getCacheKeys($names);
        $cache_keys = array_values($cache_keys_map);
        $cached_list = $this->cache
          ->getMultiple($cache_keys);
        if (!empty($cache_keys)) {

          // $cache_keys_map contains the full $name => $cache_key map, while
          // $cache_keys contains just the $cache_key values that weren't found in
          // the cache.
          // @see \Drupal\Core\Cache\CacheBackendInterface::getMultiple()
          $names_to_get = array_keys(array_intersect($cache_keys_map, $cache_keys));
//          die(print_r($names_to_get,true));
          $list = $this->storage
            ->readMultiple($names_to_get);
//            ->readMultiple(['external_entities.type.demoposts']);
//          die(print_r($list,true));
          // Cache configuration objects that were loaded from the storage, cache
          // missing configuration objects as an explicit FALSE.
          $items = array();
          foreach ($names_to_get as $name) {
            $data = isset($list[$name]) ? $list[$name] : FALSE;
            $data_to_return[$name] = $data;
            $items[$cache_keys_map[$name]] = array(
              'data' => $data,
            );
          }
          $this->cache
            ->setMultiple($items);
        }

        // Add the configuration objects from the cache to the list.
        $cache_keys_inverse_map = array_flip($cache_keys_map);
        foreach ($cached_list as $cache_key => $cache) {
          $name = $cache_keys_inverse_map[$cache_key];
          $data_to_return[$name] = $cache->data;
        }
//        die(print_r($cache_keys_inverse_map,true));
//die(print_r(array_filter($data_to_return),true));
        // Ensure that only existing configuration objects are returned, filter out
        // cached information about missing objects.
        return array_filter($data_to_return);
    }
}