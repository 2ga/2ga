<?php

/**
 * symfony actions.
 *
 * @package    webideapp
 * @subpackage symfony
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class symfonyActions extends sfActions
{

  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }

  public function executeDeploy(sfWebRequest $request)
  {
    $db_obj = new IdeProject();
    $this->forward404Unless($db_obj->hasAccess($request->getParameter('project'), $this->getUser()->getGuardUser()->getId()));
    $this->ide_project = Doctrine_Core::getTable('IdeProject')->find(array($request->getParameter('project')));
    $sf_obj = new LibProjectSymfony(
                    array(
                        'is_mac' => sfConfig::get('ideexec_mac'),
                        'is_simulation_open' => sfConfig::get('ideexec_simulation_open'),
                        'is_simulation_write' => sfConfig::get('ideexec_simulation_write'),
                        'is_simulation_git' => sfConfig::get('ideexec_simulation_git'),
                        'is_simulation_user' => sfConfig::get('ideexec_simulation_user'),
                        'default_user' => sfConfig::get('ideexec_defaultuser')
            ));
    $sf_obj->init($this->getUser()->getGuardUser()->getUsername(), $this->ide_project->getLocaldir());
    $sf_obj->deploy();
    $this->data = "OK";
  }

  public function executeAddmod(sfWebRequest $request)
  {
    $db_obj = new IdeProject();
    $this->forward404Unless($db_obj->hasAccess($request->getParameter('project'), $this->getUser()->getGuardUser()->getId()));
    $comment = $request->getParameter('comment', '');
    if ('' == $comment)
    {
      $this->msg = "please input module name";
      return sfView::ERROR;
    }
    $this->ide_project = Doctrine_Core::getTable('IdeProject')->find(array($request->getParameter('project')));
    $sf_obj = new LibProjectSymfony(array(
                'is_mac' => sfConfig::get('ideexec_mac'),
                'is_simulation_open' => sfConfig::get('ideexec_simulation_open'),
                'is_simulation_write' => sfConfig::get('ideexec_simulation_write'),
                'is_simulation_git' => sfConfig::get('ideexec_simulation_git'),
                'is_simulation_user' => sfConfig::get('ideexec_simulation_user'),
                'is_noexec_user' => sfConfig::get('ideexec_noexec_user'),
                'default_user' => sfConfig::get('ideexec_defaultuser')
            ));

    $sf_obj->init($this->getUser()->getGuardUser()->getUsername(), $this->ide_project->getName());
    $sf_obj->generateModule('frontend', escapeshellcmd($comment));
    $this->data = "OK";
  }

}
