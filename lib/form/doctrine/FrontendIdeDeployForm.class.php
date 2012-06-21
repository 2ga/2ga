<?php

/**
 * ShelfUser form.
 *
 * @package    anyshelf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FrontendIdeDeployForm extends BaseIdeDeployForm
{

  public function configure()
  {


    unset($this->validatorSchema['created_at']);
    unset($this['created_at']);
    unset($this->validatorSchema['updated_at']);
    unset($this['updated_at']);
    unset($this->validatorSchema['ide_project_id']);
    unset($this['ide_project_id']);
    $user = sfContext::getInstance()->getUser();
    $query = Doctrine_Query::create()
            ->from('IdeKey a')
            ->where('a.ide_user_id = ?', $user->getGuardUser()->getId());

    $this->widgetSchema['ide_key_id']->setOption('query', $query);
    $this->validatorSchema['ide_key_id']->setOption('query', $query);

    //project hidden
    $this->setWidget('ide_project_id', new sfWidgetFormInputHidden(array('default' => sfContext::getInstance()->getRequest()->getParameter('project', 1))));
    $query = Doctrine_Query::create()
            ->from('IdeProject a')
            ->where('a.ide_user_id = ?', $user->getGuardUser()->getId());
    $this->setValidator('ide_project_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('IdeProject'), 'required' => false)));
    $this->validatorSchema['ide_project_id']->setOption('query', $query);

    //rebuild directory, uri
    unset($this['directory']);
    unset($this['uri']);
    $this->setWidget('directory', new sfWidgetFormInputText());
    $this->setWidget('uri', new sfWidgetFormInputText());
    $this->setValidator('directory', new sfValidatorString(array('max_length' => 2027, 'required' => false)));
    $this->setValidator('uri', new sfValidatorString(array('max_length' => 2027, 'required' => false)));

    $this->getWidget('ide_key_id')->setOption('add_empty', false);
    $this->getValidator('name')->setOption('required', true);
    $this->getValidator('description')->setOption('required', false);
    $this->getValidator('ide_key_id')->setOption('required', true);
    $this->getValidator('ide_project_id')->setOption('required', true);
    $this->getValidator('username')->setOption('required', true);
    $this->getValidator('uri')->setOption('required', true);
    $this->getValidator('directory')->setOption('required', true);
    $this->getValidator('port')->setOption('required', true);
  }

}
