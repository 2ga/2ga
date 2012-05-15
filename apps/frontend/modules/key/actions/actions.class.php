<?php

/**
 * key actions.
 *
 * @package    webideapp
 * @subpackage key
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class keyActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->ide_keys = Doctrine_Core::getTable('IdeKey')
            ->createQuery('a')
            ->where('a.ide_user_id = ?', $this->getUser()->getGuardUser()->getId())
            ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->ide_key = Doctrine_Core::getTable('IdeKey')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->ide_key);
    $db_obj= new IdeKey();
    $this->forward404Unless($db_obj->hasAccess($request->getParameter('id'),$this->getUser()->getGuardUser()->getId()));
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new FrontendIdeKeyForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new FrontendIdeKeyForm();

    $this->processForm($request, $this->form, "new");

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($ide_key = Doctrine_Core::getTable('IdeKey')->find(array($request->getParameter('id'))), sprintf('Object ide_key does not exist (%s).', $request->getParameter('id')));
    $this->form = new FrontendIdeKeyForm($ide_key);
  $db_obj= new IdeKey();
    $this->forward404Unless($db_obj->hasAccess($request->getParameter('id'),$this->getUser()->getGuardUser()->getId()));
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($ide_key = Doctrine_Core::getTable('IdeKey')->find(array($request->getParameter('id'))), sprintf('Object ide_key does not exist (%s).', $request->getParameter('id')));
  $db_obj= new IdeKey();
    $this->forward404Unless($db_obj->hasAccess($request->getParameter('id'),$this->getUser()->getGuardUser()->getId()));
    $this->form = new FrontendIdeKeyForm($ide_key);

    $this->processForm($request, $this->form,"edit");

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($ide_key = Doctrine_Core::getTable('IdeKey')->find(array($request->getParameter('id'))), sprintf('Object ide_key does not exist (%s).', $request->getParameter('id')));
  $db_obj= new IdeKey();
    $this->forward404Unless($db_obj->hasAccess($request->getParameter('id'),$this->getUser()->getGuardUser()->getId()));
    $ide_key->delete();

    $this->redirect('key/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form, $mode)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      if("new" == $mode){
      $db_obj= new IdeKey();
      if($db_obj->isNameExist($form->getValue('name'),$this->getUser()->getGuardUser()->getId())){ 
        return sfView::ERROR;
      }

      
      $pubkey=  TogaKeypair::Generate($this, $form->getValue('name'),  $this->getUser()->getGuardUser()->getEmailAddress(), $this->getUser()->getGuardUser()->getUsername());
      //$pubkey=$form->getValue('name');
      $ide_key= $db_obj->newKey($form,$this->getUser()->getGuardUser()->getId(),$pubkey);
      }else{
      $ide_key = $form->save();
      }

      $this->redirect('key/show?id='.$ide_key->getId());
    }
  }
}
