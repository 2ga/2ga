<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TogaSymfony14Command
 *
 * @author HirotoYahagi
 */
class TogaSymfony14Command
{

  static function generateProject($controller,$userName, $projectName)
  {
      try
    {
    exec ("cd " . TogaSettings::getDataDir() . "/users/" . $userName . "/projects/" . $projectName . "; " . TogaSettings::getAppDir() . "/lib/vendor/symfony/data/bin/symfony generate:project " . $projectName);
    exec("ln -s " . TogaSettings::getAppDir() . "/lib/vendor/symfony/data/web/sf " . TogaSettings::getDataDir() . "/users/" . $userName . "/projects/" . $projectName . "/web/sf");      
    }
    catch (Exception $e)
    {
      $controller->logMessage('{TOGA} ' . $e->getMessage(), 'err');
    }  
    
  }

  static function generateDBYml($controller,$userName, $projectName, $num, $user_id)
  {
    //find mysql

    $q = Doctrine_Query::create()
            ->select('a.*')
            ->from('SfGuardUserProfile a')
            ->where('a.user_id = ?', $user_id);

    $account = $q->fetchArray();

    //make yml
    $body = "# You can find more information about this file on the symfony website:\n";
    $body = "# http://www.symfony-project.org/reference/1_4/en/07-Databases\n\n";
    $body = "all:\n";
    $body .= "  doctrine:\n";
    $body .= "    class: sfDoctrineDatabase\n";
    $body .= "    param:\n";
    $body .= "      dsn:      mysql:host=localhost;dbname=" . $userName . "_" . $projectName . "_" . $num . "\n";
    $body .= "      username: " . $userName . "\n";
    $body .= "      password: " . $account[0]["mysqlpw"] . "\n";

    TogaFilesystem::writeFile($controller,TogaSettings::getDataDir() . "/users/" . $userName . "/projects/" . $projectName . "/config/databases.yml", $body);
  }

  static function generateApp($controller,$userName, $projectName, $controllerName)
  {
    try
    {
      exec("cd " . TogaSettings::getDataDir() . "/users/" . $userName . "/projects/" . $projectName . "; ./symfony generate:app $controllerName");
    }
    catch (Exception $e)
    {
      $controller->logMessage('{TOGA} ' . $e->getMessage(), 'err');
    }
  }

  static function generateModule($controller,$userName, $projectName, $controllerName, $moduleName)
  {
    try
    {
      exec("cd " . TogaSettings::getDataDir() . "/users/" . $userName . "/projects/" . $projectName . "; ./symfony generate:module $controllerName $moduleName");
    }
    catch (Exception $e)
    {
      $controller->logMessage('{TOGA} ' . $e->getMessage(), 'err');
    }
  }

  static function clearCache($controller,$userName, $projectName)
  {

    try
    {
      exec("cd " . TogaSettings::getDataDir() . "/users/" . $userName . "/projects/" . $projectName . "; ./symfony cc");
    }
    catch (Exception $e)
    {
      $controller->logMessage('{TOGA} ' . $e->getMessage(), 'err');
    }
  }

}
