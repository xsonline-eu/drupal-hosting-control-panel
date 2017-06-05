<?php

namespace Drupal\hosting_control_panel\Controller;

class DefaultController {
    public function hello() {
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