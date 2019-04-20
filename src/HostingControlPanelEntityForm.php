<?php

/**
 * @file
 * Definition of Drupal\hosting_control_panel\HostingControlPanelEntityForm.
 */

namespace Drupal\hosting_control_panel;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the node edit forms.
 */
class HostingControlPanelEntityForm extends ContentEntityForm {

   /**
    * {@inheritdoc}
    */
   public function buildForm(array $form, FormStateInterface $form_state) {
//     die('HostingControlPanelEntityForm::buildForm');
     /* @var $entity \Drupal\hosting_control_panel\Entity\HostingControlPanelEntity */
     $form = parent::buildForm($form, $form_state);
     
//     $entity = $this->entity;
//     $form['langcode'] = array(
//       '#title' => $this->t('Language'),
//       '#type' => 'language_select',
//       '#default_value' => $entity->getUntranslated()->language()->getId(),
//       '#languages' => Language::STATE_ALL,
//     );
     
     /*$entity = $this->entity;
       $form['langcode'] = array(
       '#title' => $this->t('Language'),
       '#type' => 'language_select',
       '#default_value' => $entity->getUntranslated()->language()->getId(),
       '#languages' => Language::STATE_ALL,
     );*/
     return $form;
   }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    if ($this->operation == 'edit') {
      $form['#title'] = $this->t('<em>Edit @type</em> @title', array('@type' => $this->entityManager->getStorage($this->entity->getEntityType()->getBundleEntityType())->load($this->entity->bundle())->label(), '@title' => $this->entity->label()));
    }
    return parent::form($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    parent::save($form, $form_state);
    $hosting_control_panel_entity = $this->entity;
    if ($hosting_control_panel_entity->access('view')) {
      $form_state->setRedirect(
        'entity.hosting_control_panel_entity.canonical',
        array('hosting_control_panel_entity' => $hosting_control_panel_entity->id())
      );
    }
    else {
      $form_state->setRedirect('<front>');
    }
  }

}
