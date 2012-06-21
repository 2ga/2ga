<?php

/**
 * ShelfUser form.
 *
 * @package    anyshelf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FrontendIdeProjectForm extends BaseIdeProjectForm
{

  public function configure()
  {


    unset($this->validatorSchema['created_at']);
    unset($this['created_at']);
    unset($this->validatorSchema['updated_at']);
    unset($this['updated_at']);
    unset($this->validatorSchema['deleted_at']);
    unset($this['deleted_at']);
    unset($this->validatorSchema['ide_user_id']);
    unset($this['ide_user_id']);
    unset($this->validatorSchema['localdir']);
    unset($this['localdir']);

    $this->getWidget('ide_vcs_id')->setOption('add_empty', false);
    $this->getWidget('ide_language_id')->setOption('add_empty', false);
    $this->getWidget('ide_key_id')->setOption('add_empty', false);
    $this->getWidget('ide_vcsprotocol_id')->setOption('add_empty', false);
    $this->getValidator('description')->setOption('required', false);
    $this->getValidator('ide_language_id')->setOption('required', true);
    $this->getValidator('name')->setOption('required', true);
    $this->getValidator('ide_vcs_id')->setOption('required', true);
    $this->getValidator('ide_vcsprotocol_id')->setOption('required', true);
    $this->getValidator('port')->setOption('required', true);
    $this->getValidator('username')->setOption('required', true);
    //$this->getValidator('origin')->setOption('required', true);
    //for key
    $user = sfContext::getInstance()->getUser();
    $query = Doctrine_Query::create()
            ->from('IdeKey a')
            ->where('a.ide_user_id = ?', $user->getGuardUser()->getId());

    $this->widgetSchema['ide_key_id']->setOption('query', $query);
    $this->validatorSchema['ide_key_id']->setOption('query', $query);
    $this->getValidator('ide_key_id')->setOption('required', true);
    $this->getWidget('ide_key_id')->setOption('add_empty', false);

    //rebuild directory, uri
    unset($this['repdir']);
    unset($this['uri']);
    $this->setWidget('repdir', new sfWidgetFormInputText());
    $this->setWidget('uri', new sfWidgetFormInputText());
    $this->setValidator('repdir', new sfValidatorString(array('max_length' => 2027, 'required' => false)));
    $this->setValidator('uri', new sfValidatorString(array('max_length' => 2027, 'required' => false)));
    $this->getValidator('uri')->setOption('required', true);
    $this->getValidator('repdir')->setOption('required', true);
  }

}
