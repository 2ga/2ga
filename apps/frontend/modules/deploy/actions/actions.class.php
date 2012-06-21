<?php

/**
 * deploy actions.
 *
 * @package    webideapp
 * @subpackage deploy
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class deployActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->project = $request->getParameter('project', 1);
    $this->ide_deploys = Doctrine_Core::getTable('IdeDeploy')
            ->createQuery('a')
            ->where('a.ide_project_id = ?', $this->project)
            ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->ide_deploy = Doctrine_Core::getTable('IdeDeploy')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->ide_deploy);
    $deploy_obj = new IdeDeploy();
    $this->forward404Unless($deploy_obj->hasAccess($request->getParameter('id'), $this->getUser()->getGuardUser()->getId()));
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new FrontendIdeDeployForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new FrontendIdeDeployForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($ide_deploy = Doctrine_Core::getTable('IdeDeploy')->find(array($request->getParameter('id'))), sprintf('Object ide_deploy does not exist (%s).', $request->getParameter('id')));
    $this->form = new FrontendIdeDeployEditForm($ide_deploy);
    $deploy_obj = new IdeDeploy();
    $this->forward404Unless($deploy_obj->hasAccess($request->getParameter('id'), $this->getUser()->getGuardUser()->getId()));
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($ide_deploy = Doctrine_Core::getTable('IdeDeploy')->find(array($request->getParameter('id'))), sprintf('Object ide_deploy does not exist (%s).', $request->getParameter('id')));
    $deploy_obj = new IdeDeploy();
    $this->forward404Unless($deploy_obj->hasAccess($request->getParameter('id'), $this->getUser()->getGuardUser()->getId()));
    $this->form = new FrontendIdeDeployEditForm($ide_deploy);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($ide_deploy = Doctrine_Core::getTable('IdeDeploy')->find(array($request->getParameter('id'))), sprintf('Object ide_deploy does not exist (%s).', $request->getParameter('id')));
    $deploy_obj = new IdeDeploy();
    $this->forward404Unless($deploy_obj->hasAccess($request->getParameter('id'), $this->getUser()->getGuardUser()->getId()));
    $ide_deploy->delete();

    $this->redirect('deploy/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $ide_deploy = $form->save();

      $this->redirect('deploy/edit?id=' . $ide_deploy->getId());
    }
  }

}
