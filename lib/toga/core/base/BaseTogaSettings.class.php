<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseTogaSettings
 *
 * @author yahagi
 */
class BaseTogaSettings
{
  private static $dataDir = '/Users/yahagi/toga_data';
  private static $appDir = '/Users/yahagi/toga';
  private static $sqlPassword = 'himitsu';
  private static $sqlUname = 'ide-admin';
  private static $serverIp = '133.27.175.215';
  private static $serverPort = '80';
  private static $serverDomain = 'ide1.2ga.net';
  
    static function getDataDir()
  {
    return self::$dataDir;
  }

      static function getAppDir()
  {
    return self::$appDir;
  }
  
    static function getSqlPassword()
  {
    return self::$sqlPassword;
  }  
  
    static function getSqlUname()
  {
    return self::$ssqlUname;
  }  
  
      static function getServerIp()
  {
    return self::$serverIp;
  }  
  
        static function getServerPort()
  {
    return self::$serverPort;
  }  
  
          static function getServerDomain()
  {
    return self::$serverDomain;
  }  
  
}

?>
