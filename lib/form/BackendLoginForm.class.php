<?php

class BackendLoginForm extends BaseForm
{

  public function configure()
  {
    $this->setWidgets(array(
        'passwd' => new sfWidgetFormInputPassword(),
    ));

    $this->widgetSchema->setNameFormat('login[%s]');

    $this->setValidators(array(
        'passwd' => new sfValidatorString(array('max_length' => 255, 'min_length' => 1), array(
            'required' => 'Please provide your password.',
            'invalid' => 'Please provide a valied password.')),
    ));

    $this->addCSRFProtection('e0f71510d6227cc032352ece53e3a35ce8986b1c');


    $this->validatorSchema->setPostValidator(new sfValidatorCallback(
                    array(
                        'callback' => array($this, 'validateLogin'),
                    ),
                    array(
                        'invalid' => 'login data invalid',
                    )
    ));
  }

  public function validateLogin(sfValidatorBase $validator, $values)
  {


    if (sfConfig::get('app_password') !== sha1($values['passwd']))
    {
      //login failed
      throw new sfValidatorError($validator, 'invalid');
    }
    else
    {
      //login success
      //clear old credentials (user)
      $this->usersession->clearCredentials();

      //set credentials
      $this->usersession->addCredential('admin');
      $this->usersession->setAuthenticated(TRUE);
    }

    return $values;
  }

  public function setUsersession($user)
  {
    $this->usersession = $user;
  }

  public function setRequest($request)
  {
    $this->request = $request;
  }

}