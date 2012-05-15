<?php

/**
 * editor actions.
 *
 * @package    webideapp
 * @subpackage editor
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class editorActions extends sfActions
{

  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    $db_obj= new IdeProject();
    $this->forward404Unless($db_obj->hasAccess($request->getParameter('project'),$this->getUser()->getGuardUser()->getId()));
    
    $this->pj_detail=$db_obj->getDetail($request->getParameter('project'));
    $this->project_id=escapeshellcmd($request->getParameter('project'));
    $this->ide_project = Doctrine_Core::getTable('IdeProject')->find(array($request->getParameter('project')));
    $user= $this->getUser()->getGuardUser()->getUsername();
    $mes = '<ul id="treeData" style="display:none;">';
    $mes = $mes . $this->getFileTree(TogaSettings::getDataDir() . '/users/' . $user . '/projects/' . $this->ide_project->getName());
    $mes = $mes . "</ul>";
   

    $this->files=$mes;
    //echo '/home/' . $user . '/IDEProject/' . $this->ide_project->getName();
    //exit;
  }

    public function executeRaw(sfWebRequest $request)
  {
    //$this->forward('default', 'module');
    $mes = '<ul id="treeData" style="display:none;">';
    $mes = $mes . $this->getFileTree('/Users/thangtranduc/Documents/RoRProject/dp');
    $mes = $mes . "</ul>";
   
    $this->files=$mes;
    echo $this->files;
    exit;
  }


  
 

        public function executeTest(sfWebRequest $request)
  {
           
    //$test_obj= new myUser();
    //$mes=$test_obj->testConfig();
  

          
}
  
  public function getFileTree($path)
  {
    $mes = "";
    
    //echo "start<br>";
    if (is_file($path))
    {
      //echo 'Path is ' . $path;
      $mes = $mes .  '<li id="' . $path  .'">' . basename($path) . "</li>";
      return $mes;
    }
    elseif (is_dir($path))
    {
      $basename = basename($path);
      if ($basename == '.' || $basename == '..')
      {
        return $mes;
      }

      if (is_link($path))
      {
      $mes = $mes .  '<li class="folder" id="' . $path  .'">' . basename($path) . "</li>";
      return $mes;
      }
      
      $mes = $mes . '<li class="folder" id="' . $path  .'">' . basename($path) . "<ul>";
      $file_list = scandir($path);

      foreach ($file_list as $file)
      {
        //$mes = $mes . "<ul>";
        $mes = $mes . $this->getFileTree($path . '/' . $file);
        //$mes = $mes . "</ul>";
      }
      $mes = $mes . "</ul></li>";
      return $mes;
    }
    else
    {
      return $mes;
    }
    
    
  }
  

}
