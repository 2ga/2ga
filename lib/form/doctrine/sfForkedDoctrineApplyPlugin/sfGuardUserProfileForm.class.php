<?php

/**
 * sfGuardUserProfile form.
 *
 * @package    webideapp
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardUserProfileForm extends PluginsfGuardUserProfileForm
{
  public function configure()
  {
    unset($this->validatorSchema['mysqlpw']);
    unset($this['mysqlpw']);
  }
}
