<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TogaGitFilesystem
 *
 * @author
 */
class TogaGitFilesystem extends TogaFilesystem
{
  
  public function gitAdd($path)
  {
    $output = array();
    $status = NULL;
    exec("git add $path",$output,$status);
    return $output."\n";
  }
  
  public function gitCommit($comment)
  {
    $output = array();
    $status = NULL;
    exec("git commit -m '$comment'",$output,$status);
    return $output."\n";
  }
  
  public function gitEasycommit($comment)
  {
    $output = array();
    $status = NULL;
    exec("git add /*");
    exec("git commit -m '$comment'",$output,$status);
    return $output."\n";
  }
  
  public function gitPull()
  {
    $output = array();
    $status = NULL;
    exec("git pull",$output,$status);
    return $output."\n";
  }
  
  public function gitPush()
  {
    $output = array();
    $status = NULL;
    exec("git push origin master",$output,$status);
    return $output."\n";
  }
  
  public function gitCheckbranch()
  {
    $output = array();
    $status = NULL;
    exec("git branch",$output,$status);
    return $output;
  }
  
  public function gitCreatebranch($branchname)
  {
    $output = array();
    $status = NULL;
    exec("git branch $branchname",$output,$status);
    return $output;
  }
  
  public function gitCheckoutbranch($branchname)
  {
    $output = array();
    $status = NULL;
    exec("git checkout $branchname",$output,$status);
    return $output;
  }
  
}

