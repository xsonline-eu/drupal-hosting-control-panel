<?php

/**
 * @file
 * Contains \Drupal\hosting_control_panel\Entity\Query\External\EntityTypeQueryFactory.
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
 * @see \Drupal\hosting_control_panel\Entity\Query\External\EntityTypeQuery
 */
class EntityTypeQueryFactory extends QueryFactory {
  /**
   * The current class name for the query
   * 
   * @var String
   */
  protected $queryClassName = 'EntityTypeQuery';
}