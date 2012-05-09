<?php

/**
 * sfApply actions.
 *
 * @package    5seven5
 * @subpackage sfApply
 * @author     Tom Boutell, tom@punkave.com
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */

require_once dirname(__FILE__).'/../lib/BasesfApplyActions.class.php';
class sfApplyActions extends BasesfApplyActions
{
     public function executeApply(sfRequest $request)
  {
    //If user is logged in, we're forwarding him to settings page from apply
    $this->forwardIf($this->getUser()->isAuthenticated(), 'sfApply', 'settings');

    // we're getting default or customized applyForm for the task
    if( !( ($this->form = $this->newForm( 'applyForm' ) ) instanceof sfGuardUserProfileForm) )
    {
      // if the form isn't instance of sfApplyApplyForm, we don't accept it
      throw new InvalidArgumentException(
          'The custom apply form should be instance of sfApplyApplyForm' );
    }

    //Code below is used when user is sending his application!
    if( $request->isMethod('post') )
    {
      //gathering form request in one array
      $formValues = $request->getParameter( $this->form->getName() );
      if(sfConfig::get('app_recaptcha_enabled') )
      {
        $captcha = array(
          'recaptcha_challenge_field' => $request->getParameter('recaptcha_challenge_field'),
          'recaptcha_response_field'  => $request->getParameter('recaptcha_response_field'),
        );
        //Adding captcha to form array
        $formValues = array_merge( $formValues, array('captcha' => $captcha)  );
      }
        //binding request form parameters with form
      $this->form->bind( $formValues, $request->getFiles( $this->form->getName() ) );
      if ($this->form->isValid())
      {
        $guid = "n" . self::createGuid();
        $this->form->getObject()->setValidate( $guid );
        $date = new DateTime();
        $this->form->getObject()->setValidateAt( $date->format( 'Y-m-d H:i:s' ) );
        //adduser here

                      $libuser_obj=new LibUser(array(
        'is_mac' => sfConfig::get('ideexec_mac'),
        'is_simulation_open' => sfConfig::get('ideexec_simulation_open'),
        'is_simulation_write' => sfConfig::get('ideexec_simulation_write'),
        'is_simulation_git' => sfConfig::get('ideexec_simulation_git'),
        'is_simulation_user' => sfConfig::get('ideexec_simulation_user'),
        'is_noexec_user' => sfConfig::get('ideexec_noexec_user'),
        'default_user' => sfConfig::get('ideexec_defaultuser')
    ));
        $libuser_obj->addUser($this->form->getValue('username'));  
        
      //add SQL user here
         $mysql_obj= new LibProjectMySql(array(
        'is_mac' => sfConfig::get('ideexec_mac'),
        'is_simulation_open' => sfConfig::get('ideexec_simulation_open'),
        'is_simulation_write' => sfConfig::get('ideexec_simulation_write'),
        'is_simulation_git' => sfConfig::get('ideexec_simulation_git'),
        'is_simulation_user' => sfConfig::get('ideexec_simulation_user'),
        'is_noexec_user' => sfConfig::get('ideexec_noexec_user'),
        'is_noexec_db' => sfConfig::get('ideexec_noexec_db'),
        'default_user' => sfConfig::get('ideexec_defaultuser')
    ));
         $sCharList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
         mt_srand();
         $mkey = "";
         for ($i = 0; $i < 8; $i++)
        $mkey .= $sCharList{mt_rand(0, strlen($sCharList) - 1)};
        $mysql_obj->init($this->form->getValue('username'));
        $mysql_obj->createUser($this->form->getValue('username'),$mkey);
        
        //add to db
        $this->form->save();
        
        //add key here
        $key_db_obj= new IdeKey();
        $libuser_obj->init($this->form->getValue('username'));
        $pubkey=$libuser_obj->generatePubKey("Default");
        $ide_key= $key_db_obj->newDefaultKey($this->form->getValue('username'), $pubkey);

        //update user to add mysql pw
        $mysql_pw= $key_db_obj->newMysqlDB($this->form->getValue('username'), $mkey);
        
        $confirmation = sfConfig::get( 'app_sfForkedApply_confirmation' );
        if( $confirmation['apply'] )
        {
          try
          {
            //Extracting object and sending creating verification mail
            $profile = $this->form->getObject();
            $this->sendVerificationMail($profile);
            return 'After';
          }
          catch (Exception $e)
          {
            //Cleaning after possible exception thrown in ::sendVerificationMail() method
            $profile = $this->form->getObject();
            $user = $profile->getUser();
            $user->delete();
            //We rethrow exception for the dev environment. This catch
            //catches other than mailer exception, i18n as well. So developer
            //now knows what he's up to.
            if( sfContext::getInstance()->getConfiguration()->getEnvironment() === 'dev' )
            {
              throw $e;
            }
            return 'MailerError';
          }
        }
        else
        {
          $this->activateUser( $this->form->getObject()->getUser() );
          return $this->redirect( '@homepage' );
        }
      }
    }
  }

}