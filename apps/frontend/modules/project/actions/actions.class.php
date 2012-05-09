<?php

/**
 * project actions.
 *
 * @package    webideapp
 * @subpackage project
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class projectActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->ide_projects = Doctrine_Core::getTable('IdeProject')
            ->createQuery('a')
            ->where('a.ide_user_id = ?', $this->getUser()->getGuardUser()->getId())
            ->execute();
    $this->myname = $this->getUser()->getGuardUser()->getUsername();
    $this->subdomain = sfConfig::get('ideexec_subdomain');
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->ide_project = Doctrine_Core::getTable('IdeProject')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->ide_project);
    $db_obj = new IdeProject();
    $this->forward404Unless($db_obj->hasAccess($request->getParameter('id'), $this->getUser()->getGuardUser()->getId()));
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new FrontendIdeProjectForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new FrontendIdeProjectForm();

    $this->processForm($request, $this->form, "new");

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($ide_project = Doctrine_Core::getTable('IdeProject')->find(array($request->getParameter('id'))), sprintf('Object ide_project does not exist (%s).', $request->getParameter('id')));
    $this->form = new FrontendIdeProjectEditForm($ide_project);
    $db_obj = new IdeProject();
    $this->forward404Unless($db_obj->hasAccess($request->getParameter('id'), $this->getUser()->getGuardUser()->getId()));
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($ide_project = Doctrine_Core::getTable('IdeProject')->find(array($request->getParameter('id'))), sprintf('Object ide_project does not exist (%s).', $request->getParameter('id')));
    $db_obj = new IdeProject();
    $this->forward404Unless($db_obj->hasAccess($request->getParameter('id'), $this->getUser()->getGuardUser()->getId()));
    $this->form = new FrontendIdeProjectEditForm($ide_project);

    $this->processForm($request, $this->form, "edit");

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();
    $db_obj = new IdeProject();
    $this->forward404Unless($db_obj->hasAccess($request->getParameter('id'), $this->getUser()->getGuardUser()->getId()));
    $this->forward404Unless($ide_project = Doctrine_Core::getTable('IdeProject')->find(array($request->getParameter('id'))), sprintf('Object ide_project does not exist (%s).', $request->getParameter('id')));
    $ide_project->delete();

    $this->redirect('project/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form, $mode)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      if ("new" == $mode)
      {
        $db_obj = new IdeProject();
        if ($db_obj->isNameExist($form->getValue('name'), $this->getUser()->getGuardUser()->getId()))
        {
          return sfView::ERROR;
        }
        $pj_obj = new LibProject(array(
                    'is_mac' => sfConfig::get('ideexec_mac'),
                    'is_simulation_open' => sfConfig::get('ideexec_simulation_open'),
                    'is_simulation_write' => sfConfig::get('ideexec_simulation_write'),
                    'is_simulation_git' => sfConfig::get('ideexec_simulation_git'),
                    'is_simulation_user' => sfConfig::get('ideexec_simulation_user'),
                    'is_noexec_user' => sfConfig::get('ideexec_noexec_user'),
                    'default_user' => sfConfig::get('ideexec_defaultuser')
                ));

        $pj_obj->createRepositoryAtLocal($this->getUser()->getGuardUser()->getUsername(), $form->getValue('name'), false);

        $lang_obj = new IdeLanguage();

        if ('symfony14' == $lang_obj->getShortname($form->getValue('ide_language_id')))
        {
          $this->generateProjectSymfony($request, $form);
        }
        else
        {
          $this->generateProjectRoR($request, $form);
        }

        $mysql_obj = new LibProjectMysql(array(
                    'is_mac' => sfConfig::get('ideexec_mac'),
                    'is_simulation_open' => sfConfig::get('ideexec_simulation_open'),
                    'is_simulation_write' => sfConfig::get('ideexec_simulation_write'),
                    'is_simulation_git' => sfConfig::get('ideexec_simulation_git'),
                    'is_simulation_user' => sfConfig::get('ideexec_simulation_user'),
                    'is_noexec_user' => sfConfig::get('ideexec_noexec_user'),
                    'is_noexec_db' => sfConfig::get('ideexec_noexec_db'),
                    'default_user' => sfConfig::get('ideexec_defaultuser')
                ));

        $mysql_obj->init($this->getUser()->getGuardUser()->getUsername());
        $mysql_obj->createDb($this->getUser()->getGuardUser()->getUsername(), $form->getValue('name'), 0);
        //add to db
        $db_obj = new IdeProject();
        $ide_project = $db_obj->newProject($form, $this->getUser());
        if ('symfony14' == $lang_obj->getShortname($form->getValue('ide_language_id')))
        {
        }
        else
        {
          $ror_obj = new LibProjectRubyOnRails();
          $ror_obj->scheduleGenerate($ide_project->getId());
        }
      }
      else
      {
        $ide_project = $form->save();
      }


      $this->redirect('project/show?id=' . $ide_project->getId());
    }
  }

  protected function generateProjectSymfony(sfWebRequest $request, sfForm $form)
  {

    $sf_obj = new LibProjectSymfony(array(
                'is_mac' => sfConfig::get('ideexec_mac'),
                'is_simulation_open' => sfConfig::get('ideexec_simulation_open'),
                'is_simulation_write' => sfConfig::get('ideexec_simulation_write'),
                'is_simulation_git' => sfConfig::get('ideexec_simulation_git'),
                'is_simulation_user' => sfConfig::get('ideexec_simulation_user'),
                'is_noexec_user' => sfConfig::get('ideexec_noexec_user'),
                'default_user' => sfConfig::get('ideexec_defaultuser')
            ));
    $sf_obj->init($this->getUser()->getGuardUser()->getUsername(), $form->getValue('name'));
    $sf_obj->createProject($this->getUser()->getGuardUser()->getUsername(), $form->getValue('name'));
    $sf_obj->generateApp("frontend");
    $sf_obj->generateModule("frontend", "sandbox");
    $sf_obj->deployVirtualHost($this->getUser()->getGuardUser()->getUsername(), $form->getValue('name'), sfConfig::get('ideexec_subdomain'));
    $sf_obj->generateDBYml($this->getUser()->getGuardUser()->getUsername(), $form->getValue('name'), 0, $this->getUser()->getGuardUser()->getId());
  }

  protected function generateProjectRoR(sfWebRequest $request, sfForm $form)
  {

  }

}
