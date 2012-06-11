<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TogaKeypair
 *
 * @author HirotoYahagi
 */
class TogaKeypair
{

  static function Generate($controller, $name, $email, $user)
  {

    try
    {
      $query = sprintf('ssh-keygen -t rsa -N \'\' -f /%s/users/%s/.ssh/id_rsa_%s -C %s', TogaSettings::getDataDir(), $user, $name, $email);
      exec($query);

      $path = TogaSettings::getDataDir() . '/users/' . $user . '/.ssh/id_rsa_' . $name;
      TogaFilesystem::chmod($controller, $path, '600');

      return TogaFilesystem::getContent($controller, $path . '.pub');
    }
    catch (Exception $e)
    {
      $controller->logMessage('{TOGA} ' . $e->getMessage(), 'err');
    }
  }

}
