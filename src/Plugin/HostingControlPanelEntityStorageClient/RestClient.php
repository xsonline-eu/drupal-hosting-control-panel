<?php

/**
 * @file
 * Contains \Drupal\hosting_control_panel\Plugin\HostingControlPanelEntityStorageClient\RestClient.
 */

namespace Drupal\hosting_control_panel\Plugin\HostingControlPanelEntityStorageClient;

use Drupal\hosting_control_panel\HostingControlPanelEntityStorageClientBase;

/**
 * REST implementation of an Hosting control panel entity storage client.
 *
 * @HostingControlPanelEntityStorageClient(
 *   id = "rest_client",
 *   name = "REST"
 * )
 */
class RestClient extends HostingControlPanelEntityStorageClientBase {

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
    $response = $this->httpClient->get(
      $this->configuration['endpoint'] . '/' . $id,
      ['headers' => $this->getHttpHeaders()]
    );
    return (object) $this->decoder->getDecoder($this->configuration['format'])->decode($response->getBody());
  }

  /**
   * {@inheritdoc}
   */
  public function save(\Drupal\hosting_control_panel\HostingControlPanelEntityInterface $entity) {
    if ($entity->externalId()) {
      $response = $this->httpClient->put(
        $this->configuration['endpoint'] . '/' . $entity->externalId(),
        [
          'form_params' => (array) $entity->getMappedObject(),
          'headers' => $this->getHttpHeaders()
        ]
      );
      $result = SAVED_UPDATED;
    }
    else {
      $response = $this->httpClient->post(
        $this->configuration['endpoint'],
        [
          'form_params' => (array) $entity->getMappedObject(),
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
      return [
        ['test'],
        ['test2'],
    ];
      $this->configuration['format']='json';
//      die($this->configuration['format']);
    $response = $this->httpClient->get(
//      $this->configuration['endpoint'],
            'https://www.google.be/',
      [
        'query' => $parameters,
        'headers' => $this->getHttpHeaders()
      ]
    );
    $results = $this->decoder->getDecoder($this->configuration['format'])->decode($response->getBody());
    if(is_array($results) || $results instanceof \Traversable) {
        foreach ($results as &$result) {
          $result = ((object) $result);
        }
    
        return $results;
    }
    return [
        ['test'],
        ['test2'],
    ];
  }

}
