<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TogaSymfony14Apache
 *
 * @author HirotoYahagi
 */
class TogaSymfony14Apache
{
   static function deployVirtualHost($controller,$userName, $projectName)
  {


    try
    {
      $body = "<VirtualHost " . TogaSettings::getServerIp() .  ":" . TogaSettings::getServerPort() . ">\n";
      $body .= "  ServerName $projectName.$userName." . TogaSettings::getServerDomain()  . "\n";
      $body .= "  DocumentRoot " . TogaSettings::getDataDir() . "/users/" . $userName . "/projects/" . $projectName . "/web\n";
      $body .= "  <Directory " . TogaSettings::getDataDir() . "/users/" . $userName . "/projects/" . $projectName . "/web>\n";
      $body .= "    AllowOverride All\n";
      $body .= "    Order allow,deny\n";
      $body .= "    Allow from all\n";
      $body .= "  </Directory>\n";
      $body .= "</VirtualHost>";

      TogaFilesystem::writeFile($controller,TogaSettings::getDataDir() . "/tmp/conf/$userName$projectName.conf", $body);
      exec("mv " . TogaSettings::getDataDir() . "/tmp/conf/$userName$projectName.conf " . TogaSettings::getDataDir() . "/settings/sites-available/$userName$projectName.conf");
      //exec("chown root:root " .  TogaSettings::getDataDir() . "/settings/sites-available/$userName$projectName.conf");
      exec("chmod 644 " . TogaSettings::getDataDir() . "/settings/sites-available/$userName$projectName.conf");
      exec("ln -s " .  TogaSettings::getDataDir() . "/settings/sites-available/$userName$projectName.conf " .  TogaSettings::getDataDir() . "/settings/sites-enabled/");
      exec("sudo /etc/init.d/httpd graceful");
    }
    catch (Exception $e)
    {
      $controller->logMessage('{TOGA} ' . $e->getMessage(), 'err');
    }
  }

}

