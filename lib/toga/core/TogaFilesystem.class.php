<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TogaFilesystem
 *
 * @author HirotoYahagi
 */
class TogaFilesystem
{

  static function makeDir($controller,$path)
  {

    try
    {
      if (!self::isValidPath($path))
      {
        $e = 'Arg(s) invalid:' . $path . $permission;
        throw new Exception($e);
      }

      exec("mkdir $path");
    }
    catch (Exception $e)
    {
      $controller->logMessage('{TOGA} ' . $e->getMessage(), 'err');
    }
  }

  //rm -Rf
  static function rmDir($controller,$path)
  {
    try
    {
      if (!self::isValidPath($path))
      {
        $e = 'Arg(s) invalid:' . $path . $permission;
        throw new Exception($e);
      }
      exec("rm -rf $path");
    }
    catch (Exception $e)
    {
      $controller->logMessage('{TOGA} ' . $e->getMessage(), 'err');
    }
  }

  static function writeFile($controller,$path, $body = '')
  {
    try
    {
      if (!self::isValidPath($path))
      {
        $e = 'Arg(s) invalid:' . $path . $permission;
        throw new Exception($e);
      }

      return file_put_contents($path, $body, LOCK_EX);
    }
    catch (Exception $e)
    {
      $controller->logMessage('{TOGA} ' . $e->getMessage(), 'err');
    }
  }

  // rm
  static function rm($controller,$path)
  {

    try
    {
      if (!self::isValidPath($path))
      {
        $e = 'Arg(s) invalid:' . $path . $permission;
        throw new Exception($e);
      }
      return unlink($path);
    }
    catch (Exception $e)
    {
      $controller->logMessage('{TOGA} ' . $e->getMessage(), 'err');
    }
  }

  static function mv($controller,$from, $to)
  {

    try
    {
      if (!self::isValidPath($from) || !self::isValidPath($to))
      {
        $e = 'Arg(s) invalid:' . $from . $to;
        throw new Exception($e);
      }
      return rename($from, $to);
    }
    catch (Exception $e)
    {
      $controller->logMessage('{TOGA} ' . $e->getMessage(), 'err');
    }
  }

  static function chmod($controller,$path, $permission, $recursive = false)
  {
    try
    {
      if (!self::isValidPath($path))
      {
        $e = 'Arg(s) invalid:' . $path . $permission;
        throw new Exception($e);
      }

      if (true === $recursive)
      {
        $query = 'chmod -R ' . $permission . ' ' . $path;
      }
      else
      {
        $query = 'chmod ' . $permission . ' ' . $path;
      }
      exec($query);
    }
    catch (Exception $e)
    {
      $controller->logMessage('{TOGA} ' . $e->getMessage(), 'err');
    }
  }

  static function getContent($controller,$path)
  {
    try
    {
      if (!self::checkPath($path))
      {
        $e = 'Arg(s) invalid:' . $path;
        throw new Exception($e);
      }

      return file_get_contents($path);
    }
    catch (Exception $e)
    {
      $controller->logMessage('{TOGA} ' . $e->getMessage(), 'err');
    }
  }

  static function createProject($controller,$userName, $projectName)
  {


    try
    {
      if (!self::checkName($projectName) ||
              !self::checkName($userName))
      {
        $e = "invalid project name";
        throw new Exception($e);
      }
    }
    catch (Exception $e)
    {
      $controller->logMessage('{TOGA} ' . $e->getMessage(), 'err');
    }


    $path = TogaSettings::getDataDir() . "/users/" . $userName . "/projects/" . $projectName;
    self::mkdir($path);
  }

  static function checkName($string)
  {
    $pattern = '/^[0-9a-zA-z]+$/';
    return preg_match($pattern, $string);
  }

  static function checkPath($string)
  {
    $pattern1 = '/^(\/[0-9a-zA-z-_\.]+)+$/';
    $pattern2 = '{/[.]{2,}?/}';
    return preg_match($pattern1, $string) && !preg_match($pattern2, $string);
  }

}
