<?php

namespace Drupal\hosting_control_panel;

use Drupal\Core\Config\ConfigFactory;

//die('class HostingControlPanelEntityTypeConfigFactory');
class HostingControlPanelEntityTypeConfigFactory extends ConfigFactory {
    protected function doLoadMultiple(array $names, $immutable = TRUE) {
        $list = [];
        foreach ($names as $key => $name) {
//            die(print_r($name,true));
          $cache_key = $this
            ->getConfigCacheKey($name, $immutable);
          if (isset($this->cache[$cache_key])) {
            $list[$name] = $this->cache[$cache_key];
            unset($names[$key]);
          }
        }

        // Pre-load remaining configuration files.
        if (!empty($names)) {
//die(print_r($names,true));
//die($this->storage);
          // Initialise override information.
          $module_overrides = [];
          $storage_data = $this->storage
            ->readMultiple($names);
//            ->readMultiple(['external_entities.type.demoposts']);
//          die(print_r($storage_data,true));
          if ($immutable && !empty($storage_data)) {

            // Only get module overrides if we have configuration to override.
            $module_overrides = $this
              ->loadOverrides($names);
          }
          foreach ($storage_data as $name => $data) {
            $cache_key = $this
              ->getConfigCacheKey($name, $immutable);
            $this->cache[$cache_key] = $this
              ->createConfigObject($name, $immutable);
            $this->cache[$cache_key]
              ->initWithData($data);
            if ($immutable) {
              if (isset($module_overrides[$name])) {
                $this->cache[$cache_key]
                  ->setModuleOverride($module_overrides[$name]);
              }
              if (isset($GLOBALS['config'][$name])) {
                $this->cache[$cache_key]
                  ->setSettingsOverride($GLOBALS['config'][$name]);
              }
            }
            $this
              ->propagateConfigOverrideCacheability($cache_key, $name);
            $list[$name] = $this->cache[$cache_key];
          }
        }
        return $list;
    }
}