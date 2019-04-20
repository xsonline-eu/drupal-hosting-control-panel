<?php

/**
 * @file
 * Contains Drupal\hosting_control_panel\HostingControlPanelEntityStorageClientBase.
 */

namespace Drupal\hosting_control_panel;

use Drupal\Component\Plugin\PluginBase;

/**
 * Base class for Hosting control panel entity storage clients.
 */
abstract class HostingControlPanelEntityStorageClientBase extends PluginBase implements HostingControlPanelEntityStorageClientInterface {

  /**
   * The HTTP client to fetch the data with.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  /**
   * The decoder to decode the data.
   *
   * @var \Drupal\hosting_control_panel\ResponseDecoderFactoryInterface
   */
  protected $decoder;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->httpClient = $this->configuration['http_client'];
    $this->decoder = $this->configuration['decoder'];
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->pluginDefinition['name'];
  }

  /**
   * {@inheritdoc}
   */
  public function getHttpHeaders() {
    return isset($this->configuration['http_headers']) ? $this->configuration['http_headers'] : [];
  }
}
