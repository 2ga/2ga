<?php

/**
 * auth actions.
 *
 * @package    webideapp
 * @subpackage auth
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class authActions extends sfActions
{

  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('auth', 'index');
  }

  public function executeLogin(sfWebRequest $request)
  {

    //if already loged in
    if ($this->getUser()->isAuthenticated() === TRUE)
    {
      $this->redirect('sfGuardUser/index');
    }

    //make login form and set session data.
    $this->form = new BackendLoginForm();
    $this->form->setUsersession($this->getUser());
    $this->form->setRequest($request);

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('login'));

      if ($this->form->isValid())
      {

        $this->redirect('sfGuardUser/index');
      }
    }
    return sfView::SUCCESS;
  }

  public function executeLogout(sfWebRequest $request)
  {
    $this->getUser()->setAuthenticated(FALSE);
    $this->getUser()->clearCredentials();
    $this->redirect('auth/login');
  }

}
