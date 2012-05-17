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
  private static $dataDir = '%TOGA:DATADIR%';
  private static $appDir = '%TOGA:APPDIR%';
  private static $sqlPassword = '%TOGA:SQLPASSWORD%';
  private static $sqlUname = '%TOGA:SQLUNAME%';
  private static $serverIp = '%TOGA:SERVERIP%';
  private static $serverPort = '%TOGA:SERVERPORT%';
  private static $serverDomain = '%TOGA:SERVERDOMAIN%';
   
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
    return self::$sqlUname;
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