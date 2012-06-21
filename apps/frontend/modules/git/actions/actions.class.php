<?php

/**
 * git actions.
 *
 * @package    webideapp
 * @subpackage git
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class gitActions extends sfActions
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

  public function executeAdd(sfWebRequest $request)
  {
    $db_obj = new IdeProject();
    $this->forward404Unless($db_obj->hasAccess($request->getParameter('project'), $this->getUser()->getGuardUser()->getId()));
    $this->ide_project = Doctrine_Core::getTable('IdeProject')->find(array($request->getParameter('project')));
    $git_obj = new LibGit($this->getUser()->getGuardUser()->getUsername(), $this->ide_project->getLocaldir(),
                    array(
                        'is_mac' => sfConfig::get('ideexec_mac'),
                        'is_simulation_open' => sfConfig::get('ideexec_simulation_open'),
                        'is_simulation_write' => sfConfig::get('ideexec_simulation_write'),
                        'is_simulation_git' => sfConfig::get('ideexec_simulation_git'),
                        'is_simulation_user' => sfConfig::get('ideexec_simulation_user'),
                        'default_user' => sfConfig::get('ideexec_defaultuser')
            ));
    $git_obj->git_add();
    $this->data = "OK";
  }

  public function executeCommit(sfWebRequest $request)
  {
    $db_obj = new IdeProject();
    $this->forward404Unless($db_obj->hasAccess($request->getParameter('project'), $this->getUser()->getGuardUser()->getId()));
    $comment = $request->getParameter('comment', '');
    if ('' == $comment)
    {
      $this->msg = "please input comment";
      return sfView::ERROR;
    }
    $this->ide_project = Doctrine_Core::getTable('IdeProject')->find(array($request->getParameter('project')));
    $git_obj = new LibGit($this->getUser()->getGuardUser()->getUsername(), $this->ide_project->getLocaldir(),
                    array(
                        'is_mac' => sfConfig::get('ideexec_mac'),
                        'is_simulation_open' => sfConfig::get('ideexec_simulation_open'),
                        'is_simulation_write' => sfConfig::get('ideexec_simulation_write'),
                        'is_simulation_git' => sfConfig::get('ideexec_simulation_git'),
                        'is_simulation_user' => sfConfig::get('ideexec_simulation_user'),
                        'default_user' => sfConfig::get('ideexec_defaultuser')
            ));
    $git_obj->git_commit(escapeshellcmd($comment));
    $this->data = "OK";
  }

  public function executePull(sfWebRequest $request)
  {
    $db_obj = new IdeProject();
    $this->forward404Unless($db_obj->hasAccess($request->getParameter('project'), $this->getUser()->getGuardUser()->getId()));
    $this->ide_project = Doctrine_Core::getTable('IdeProject')->find(array($request->getParameter('project')));
    $git_obj = new LibGit($this->getUser()->getGuardUser()->getUsername(), $this->ide_project->getLocaldir(),
                    array(
                        'is_mac' => sfConfig::get('ideexec_mac'),
                        'is_simulation_open' => sfConfig::get('ideexec_simulation_open'),
                        'is_simulation_write' => sfConfig::get('ideexec_simulation_write'),
                        'is_simulation_git' => sfConfig::get('ideexec_simulation_git'),
                        'is_simulation_user' => sfConfig::get('ideexec_simulation_user'),
                        'default_user' => sfConfig::get('ideexec_defaultuser')
            ));
    $git_obj->git_pull();
    $this->data = "OK";
  }

  public function executePush(sfWebRequest $request)
  {
    $db_obj = new IdeProject();
    $this->forward404Unless($db_obj->hasAccess($request->getParameter('project'), $this->getUser()->getGuardUser()->getId()));
    $this->ide_project = Doctrine_Core::getTable('IdeProject')->find(array($request->getParameter('project')));
    $git_obj = new LibGit($this->getUser()->getGuardUser()->getUsername(), $this->ide_project->getLocaldir(),
                    array(
                        'is_mac' => sfConfig::get('ideexec_mac'),
                        'is_simulation_open' => sfConfig::get('ideexec_simulation_open'),
                        'is_simulation_write' => sfConfig::get('ideexec_simulation_write'),
                        'is_simulation_git' => sfConfig::get('ideexec_simulation_git'),
                        'is_simulation_user' => sfConfig::get('ideexec_simulation_user'),
                        'default_user' => sfConfig::get('ideexec_defaultuser')
            ));
    $git_obj->git_push();
    $this->data = "OK";
  }

  public function executeEasycommit(sfWebRequest $request)
  {
    $db_obj = new IdeProject();
    $this->forward404Unless($db_obj->hasAccess($request->getParameter('project'), $this->getUser()->getGuardUser()->getId()));
    $comment = $request->getParameter('comment', '');
    if ('' == $comment)
    {
      $this->msg = "please input comment";
      return sfView::ERROR;
    }
    $this->ide_project = Doctrine_Core::getTable('IdeProject')->find(array($request->getParameter('project')));
    $git_obj = new LibGit($this->getUser()->getGuardUser()->getUsername(), $this->ide_project->getLocaldir(),
                    array(
                        'is_mac' => sfConfig::get('ideexec_mac'),
                        'is_simulation_open' => sfConfig::get('ideexec_simulation_open'),
                        'is_simulation_write' => sfConfig::get('ideexec_simulation_write'),
                        'is_simulation_git' => sfConfig::get('ideexec_simulation_git'),
                        'is_simulation_user' => sfConfig::get('ideexec_simulation_user'),
                        'default_user' => sfConfig::get('ideexec_defaultuser')
            ));
    $git_obj->git_easyCommit(escapeshellcmd($comment));
    $this->data = "OK";
  }

}
