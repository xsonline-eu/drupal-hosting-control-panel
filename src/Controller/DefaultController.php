<?php

namespace Drupal\hosting_control_panel\Controller;

class DefaultController {
    public function index() {
        defined('YII_DEBUG') or define('YII_DEBUG', true);
        defined('YII_ENV') or define('YII_ENV', 'dev');

//        require(__DIR__ . '/../../../../../../vendor/autoload.php');
        require(__DIR__ . '/../../../../../../vendor/yiisoft/yii2/Yii.php');

        $config = $config = [
            'id' => 'basic',
            'basePath' => dirname(__DIR__ . '/../../../../../../vendor/xsonline/hosting-control-panel/config'),
            'bootstrap' => ['log'],
            'components' => [
                'request' => [
                    // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
                    'cookieValidationKey' => 'so-bLQoWlm1IIiChzihcjtzMZnsbSQ0M',
                ],
                'cache' => [
                    'class' => 'yii\caching\FileCache',
                ],
                'user' => [
                    'identityClass' => 'app\models\User',
                    'enableAutoLogin' => true,
                ],
                'errorHandler' => [
                    'errorAction' => 'site/error',
                ],
                'mailer' => [
                    'class' => 'yii\swiftmailer\Mailer',
                    // send all mails to a file by default. You have to set
                    // 'useFileTransport' to false and configure a transport
                    // for the mailer to send real emails.
                    'useFileTransport' => true,
                ],
                'log' => [
                    'traceLevel' => YII_DEBUG ? 3 : 0,
                    'targets' => [
                        [
                            'class' => 'yii\log\FileTarget',
                            'levels' => ['error', 'warning'],
                        ],
                    ],
                ],
                'db' => [
                    'class' => 'yii\db\Connection',
                    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
                    'username' => 'root',
                    'password' => '',
                    'charset' => 'utf8',
                ],
                /*
                'urlManager' => [
                    'enablePrettyUrl' => true,
                    'showScriptName' => false,
                    'rules' => [
                    ],
                ],
                */
            ],
        ];//require(__DIR__ . '/../config/web.php');

        (new \verbi\yii2Drupal8Application\Application($config))->run();

        
        
        return array(
                '#title' => 'Hosting',
                '#theme' => 'item_list',
                '#list_type' => 'ul',
                '#items' => ['item 1', 'item 2'],
                '#attributes' => ['class' => 'mylist'],
                '#wrapper_attributes' => ['class' => 'container'],
//                '#markup' => 'Here is some content.',
            );
    }
}