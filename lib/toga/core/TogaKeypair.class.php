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

  static function Generate($controller,$name, $email, $user)
  {

    try
    {
      $query = sprintf('ssh-keygen -t rsa -N \'\' -f /%s/%s/.ssh/id_rsa_%s -C %s', TogaSettings::getDataDir(), $user, $name, $email);
      exec($query);

      $fs_obj = new TogaFilesystem();
      $path = TogaSettings::getDataDir() . '/' . $user . '/.ssh/id_rsa_' . $name;
      $fs_obj->chmod($path, '600');

      return $fs_obj->getContents($path . '.pub');
    }
    catch (Exception $e)
    {
      $controller->logMessage('{TOGA} ' . $e->getMessage(), 'err');
    }
  }

}
