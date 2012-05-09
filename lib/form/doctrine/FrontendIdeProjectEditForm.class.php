<?php

/**
 * ShelfUser form.
 *
 * @package    anyshelf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FrontendIdeProjectEditForm extends BaseIdeProjectForm
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
    //unset($this->validatorSchema['ide_key_id']);
    unset($this['ide_key_id']);
    //unset($this->validatorSchema['ide_vcsprotocol_id']);
    unset($this['ide_vcsprotocol_id']);
    unset($this->validatorSchema['localdir']);
    unset($this['localdir']);
    unset($this->validatorSchema['origin']);
    unset($this['origin']);
    unset($this->validatorSchema['uri']);
    unset($this['uri']);
    unset($this->validatorSchema['port']);
    unset($this['port']);
    unset($this->validatorSchema['repdir']);
    unset($this['repdir']);
    unset($this->validatorSchema['username']);
    unset($this['username']);
    //unset($this->validatorSchema['ide_vcs_id']);
    unset($this['ide_vcs_id']);
    //unset($this->validatorSchema['ide_language_id']);
    unset($this['ide_language_id']);
    $this->getValidator('name')->setOption('required', true);
    $this->getValidator('description')->setOption('required', false);
  }

}
