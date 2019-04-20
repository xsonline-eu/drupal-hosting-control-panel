<?php

namespace Drupal\hosting_control_panel\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
//use Drupal\my_api\MyClient;

/**
 * Class DefaultController.
 *
 * @package Drupal\hosting_control_panel\Controller
 */
class DefaultController extends ControllerBase {

    /**
     * Drupal\my_api\MyClient definition.
     *
     * @var \Drupal\my_api\MyClient
     */
    protected $myClient;
    
//   /**
//    * {@inheritdoc}
//    */
//   public function __construct(MyClient $my_client) {
//     $this->myClient = $my_client;
//   }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container) {
        return new static(
          $container->get('my_api.client')
        );
    }

    /**
     * Content.
     *
     * @return array
     *   Return array.
     */
    public function content() {
      $this->myClient->request();
      return [];
    }
    
    public function index() {
        defined('YII_DEBUG') or define('YII_DEBUG', true);
        defined('YII_ENV') or define('YII_ENV', 'dev');

//        require(__DIR__ . '/../../../../../../vendor/autoload.php');
        require(__DIR__ . '/../../../../../../vendor/yiisoft/yii2/Yii.php');

        $config = $config = [
            'id' => 'basic',
            'basePath' => dirname(__DIR__ . '/../../../../../../vendor/xsonline/hosting-control-panel/config'),
            'vendorPath' => realpath(__DIR__ . '/../../../../../../vendor'),
            'aliases' => [
                '@bower' => '@vendor/bower-asset',
                '@npm' => '@vendor/npm-asset',
            ],
        ]; //require(__DIR__ . '/../config/web.php');

        $response = (new \verbi\yii2Drupal8Application\Application($config))->run();

//        die($response->data);

        return array(
            '#title' => 'Hosting',
//            '#theme' => 'item_list',
//            '#list_type' => 'ul',
//            '#items' => ['item 1', 'item 2'],
//            '#attributes' => ['class' => 'mylist'],
//            '#wrapper_attributes' => ['class' => 'container'],
            '#markup' => $response->data,
        );
    }

}
