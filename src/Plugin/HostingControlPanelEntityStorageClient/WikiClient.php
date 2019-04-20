<?php

/**
 * @file
 * Contains \Drupal\hosting_control_panel\Plugin\HostingControlPanelEntityStorageClient\WikiClient.
 */

namespace Drupal\hosting_control_panel\Plugin\HostingControlPanelEntityStorageClient;

use Drupal\hosting_control_panel\HostingControlPanelEntityStorageClientBase;

/**
 * Wiki implementation of an Hosting control panel entity storage client.
 *
 * @HostingControlPanelEntityStorageClient(
 *   id = "wiki_client",
 *   name = "Wiki"
 * )
 */
class WikiClient extends HostingControlPanelEntityStorageClientBase {

  /**
   * {@inheritdoc}
   */
  public function delete(\Drupal\hosting_control_panel\HostingControlPanelEntityInterface $entity) {
    $this->httpClient->delete(
      $this->configuration['endpoint'] . '/' . $entity->externalId(),
      ['headers' => $this->getHttpHeaders()]
    );
  }

  /**
   * {@inheritdoc}
   */
  public function load($id) {
    $options = [
      'headers' => $this->getHttpHeaders(),
      'query' => [
        'pageids' => $id,
      ],
    ];
    if ($this->configuration['parameters']['single']) {
      $options['query'] += $this->configuration['parameters']['single'];
    }
    $response = $this->httpClient->get(
      $this->configuration['endpoint'],
      $options
    );
    $result = $this->decoder->getDecoder($this->configuration['format'])->decode($response->getBody());
    return (object) $result['query']['pages'][$id];
  }

  /**
   * {@inheritdoc}
   */
  public function save(\Drupal\hosting_control_panel\HostingControlPanelEntityInterface $entity) {
    if ($entity->externalId()) {
      $response = $this->httpClient->put(
        $this->configuration['endpoint'] . '/' . $entity->externalId(),
        [
          'body' => (array) $entity->getMappedObject(),
          'headers' => $this->getHttpHeaders()
        ]
      );
      $result = SAVED_UPDATED;
    }
    else {
      $response = $this->httpClient->post(
        $this->configuration['endpoint'],
        [
          'body' => (array) $entity->getMappedObject(),
          'headers' => $this->getHttpHeaders()
        ]
      );
      $result = SAVED_NEW;
    }

    // @todo: is it standard REST to return the new entity?
    $object = (object) $this->decoder->getDecoder($this->configuration['format'])->decode($response->getBody());
    $entity->mapObject($object);
    return $result;
  }

  /**
   * {@inheritdoc}
   */
  public function query(array $parameters) {
    $response = $this->httpClient->get(
      $this->configuration['endpoint'],
      [
        'query' => $parameters + $this->configuration['parameters']['list'],
        'headers' => $this->getHttpHeaders()
      ]
    );
    $results = $this->decoder->getDecoder($this->configuration['format'])->decode($response->getBody());
    $results = $results['query']['categorymembers'];
    foreach ($results as &$result) {
      $result = ((object) $result);
    }
    return $results;
  }

}
