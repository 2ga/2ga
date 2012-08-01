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
    //$git_obj = new LibGit($this->getUser()->getGuardUser()->getUsername(), $this->ide_project->getLocaldir(),
    //                array(
    //                  'is_mac' => sfConfig::get('ideexec_mac'),
    //                    'is_simulation_open' => sfConfig::get('ideexec_simulation_open'),
    //                    'is_simulation_write' => sfConfig::get('ideexec_simulation_write'),
    //                    'is_simulation_git' => sfConfig::get('ideexec_simulation_git'),
    //                    'is_simulation_user' => sfConfig::get('ideexec_simulation_user'),
    //                    'default_user' => sfConfig::get('ideexec_defaultuser')
    //        ));
    //$git_obj->git_add();
    //$this->data = "OK";
    $temp_user = $this->getUser()->getGuardUser()->getUsername();
    $uri = $request->getParameter('uri', '');
    $exec = new TogaGitFilesystem();
    $exec->gitAdd($uri);   
    $this->data = $temp_user." add ".$uri;
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
    /*$git_obj = new LibGit($this->getUser()->getGuardUser()->getUsername(), $this->ide_project->getLocaldir(),
                    array(
                        'is_mac' => sfConfig::get('ideexec_mac'),
                        'is_simulation_open' => sfConfig::get('ideexec_simulation_open'),
                        'is_simulation_write' => sfConfig::get('ideexec_simulation_write'),
                        'is_simulation_git' => sfConfig::get('ideexec_simulation_git'),
                        'is_simulation_user' => sfConfig::get('ideexec_simulation_user'),
                        'default_user' => sfConfig::get('ideexec_defaultuser')
            ));
    $git_obj->git_commit(escapeshellcmd($comment));
    $this->data = "OK";*/
    //exec("git commit -m '$comment'");
    $exec = new TogaGitFilesystem();
    $exec->gitCommit($comment);
    $this->data = $this->getUser()->getGuardUser()->getUsername()." commit. (comment:".$comment.")";  
  }

  public function executePull(sfWebRequest $request)
  {
    $db_obj = new IdeProject();
    $this->forward404Unless($db_obj->hasAccess($request->getParameter('project'), $this->getUser()->getGuardUser()->getId()));
    $this->ide_project = Doctrine_Core::getTable('IdeProject')->find(array($request->getParameter('project')));
    /*$git_obj = new LibGit($this->getUser()->getGuardUser()->getUsername(), $this->ide_project->getLocaldir(),
                    array(
                        'is_mac' => sfConfig::get('ideexec_mac'),
                        'is_simulation_open' => sfConfig::get('ideexec_simulation_open'),
                        'is_simulation_write' => sfConfig::get('ideexec_simulation_write'),
                        'is_simulation_git' => sfConfig::get('ideexec_simulation_git'),
                        'is_simulation_user' => sfConfig::get('ideexec_simulation_user'),
                        'default_user' => sfConfig::get('ideexec_defaultuser')
            ));
    $git_obj->git_pull();
    $this->data = "OK";*/
    $exec = new TogaGitFilesystem();
    $exec->gitPull();
    $this->data = $this->getUser()->getGuardUser()->getUsername()." pull done.";
  }

  public function executePush(sfWebRequest $request)
  {
    $db_obj = new IdeProject();
    $this->forward404Unless($db_obj->hasAccess($request->getParameter('project'), $this->getUser()->getGuardUser()->getId()));
    $this->ide_project = Doctrine_Core::getTable('IdeProject')->find(array($request->getParameter('project')));
    /*$git_obj = new LibGit($this->getUser()->getGuardUser()->getUsername(), $this->ide_project->getLocaldir(),
                    array(
                        'is_mac' => sfConfig::get('ideexec_mac'),
                        'is_simulation_open' => sfConfig::get('ideexec_simulation_open'),
                        'is_simulation_write' => sfConfig::get('ideexec_simulation_write'),
                        'is_simulation_git' => sfConfig::get('ideexec_simulation_git'),
                        'is_simulation_user' => sfConfig::get('ideexec_simulation_user'),
                        'default_user' => sfConfig::get('ideexec_defaultuser')
            ));
    $git_obj->git_push();
    $this->data = "OK";*/
    //exec("git push origin master");
    //$this->data = $this->getUser()->getGuardUser()->getUsername()." git push origin master.";
    $exec = new TogaGitFilesystem();
    $exec->gitPush(); 
    $this->data = $this->getUser()->getGuardUser()->getUsername()." push origin master.";
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
    /*$git_obj = new LibGit($this->getUser()->getGuardUser()->getUsername(), $this->ide_project->getLocaldir(),
                    array(
                        'is_mac' => sfConfig::get('ideexec_mac'),
                        'is_simulation_open' => sfConfig::get('ideexec_simulation_open'),
                        'is_simulation_write' => sfConfig::get('ideexec_simulation_write'),
                        'is_simulation_git' => sfConfig::get('ideexec_simulation_git'),
                        'is_simulation_user' => sfConfig::get('ideexec_simulation_user'),
                        'default_user' => sfConfig::get('ideexec_defaultuser')
            ));
    $git_obj->git_easyCommit(escapeshellcmd($comment));
    $this->data = "OK";*/
    $exec = new TogaGitFilesystem();
    $exec->gitEasycommit($comment);
    $this->data = $this->getUser()->getGuardUser()->getUsername()." add all and commit. (comment:".$comment.")";
  }
  
  public function executeClone(sfWebRequest $request)
  {
    $db_obj = new IdeProject();
    $this->forward404Unless($db_obj->hasAccess($request->getParameter('project'), $this->getUser()->getGuardUser()->getId()));
    $uri = $request->getParameter('uri', '');
    if ('' == $uri)
    {
      $this->msg = "please input url";
      return sfView::ERROR;
    }
    $this->ide_project = Doctrine_Core::getTable('IdeProject')->find(array($request->getParameter('project')));
    $this->ide_key = Doctrine_Core::getTable('IdeKey')->find(array($request->getParameter('id')));
    exec("git clone $uri -key: '$this->ide_key'");
    $this->data = $uri." clone done";
  }
  
  public function executeCheckbranch(sfWebRequest $request)
  {
    $db_obj = new IdeProject();
    $this->forward404Unless($db_obj->hasAccess($request->getParameter('project'), $this->getUser()->getGuardUser()->getId()));
    $this->ide_project = Doctrine_Core::getTable('IdeProject')->find(array($request->getParameter('project')));
    $exec = new TogaGitFilesystem();
    $b= $exec->gitCheckbranch();
    echo("<root><contents>");
    foreach ($b as $this->data)
    {
      echo "$this->data\n";
    }
    echo("</contents></root>");
  }
  
  public function executeCreatebranch(sfWebRequest $request)
  {
    $db_obj = new IdeProject();
    $this->forward404Unless($db_obj->hasAccess($request->getParameter('project'), $this->getUser()->getGuardUser()->getId()));
    $this->ide_project = Doctrine_Core::getTable('IdeProject')->find(array($request->getParameter('project')));
    $newname = $request->getParameter('newname', '');
    if ('' == $newname)
    {
      $this->msg = "please input new branch name";
      return sfView::ERROR;
    }
    $exec = new TogaGitFilesystem();
    $b= $exec->gitCreatebranch($newname);
    echo("<root><contents>");
    foreach ($b as $this->data)
    {
      echo "$this->data\n";
    }
    echo("</contents></root>");
  }
  public function executeCheckoutbranch(sfWebRequest $request)
  {
    $db_obj = new IdeProject();
    $this->forward404Unless($db_obj->hasAccess($request->getParameter('project'), $this->getUser()->getGuardUser()->getId()));
    $this->ide_project = Doctrine_Core::getTable('IdeProject')->find(array($request->getParameter('project')));
    $branchname = $request->getParameter('branchname', '');
    if ('' == $branchname)
    {
      $this->msg = "please input branch name";
      return sfView::ERROR;
    }
    //exec("git checkout $branchname");
    //$this->data = "checkout branch: ".$branchname;
    $exec = new TogaGitFilesystem();
    $b= $exec->gitCheckoutbranch($branhcname);
    echo("<root><contents>");
    foreach ($b as $this->data)
    {
      echo "$this->data\n";
    }
    echo("</contents></root>");  
  }
}
