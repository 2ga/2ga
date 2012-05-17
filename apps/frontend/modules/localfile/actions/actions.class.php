<?php

/**
 * localfile actions.
 *
 * @package    webideapp
 * @subpackage localfile
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class localfileActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }
  
        public function executeOpen(sfWebRequest $request)
  {
        $path=$request->getParameter('uri','');
        $msg = $this->checkPath($path);
    if (null != $msg)
    {
      $this->msg = $msg;
          return sfView::ERROR;
        }
        $this->data= file_get_contents(escapeshellcmd($path));
  }
  
      public function executeWrite(sfWebRequest $request)
  {
          if (!($request->isMethod('post')))
    {
          $this->msg="you must send via post";
          return sfView::ERROR;
    }
    
        $path=$request->getParameter('uri','');   
        $body=$request->getParameter('body','');
        if(''==$body){
          $this->msg="cannot make brankfile to" . $path;
          return sfView::ERROR;
        }
        
        $msg=  $this->checkPath($path);
        if(null != $msg){
          $this->msg=$msg;
          return sfView::ERROR;
        }

        TogaFilesystem::writeFile($this, escapeshellcmd($path), $body);
        
        $this->data= "OK";
 }

    public function executeRemove(sfWebRequest $request)
  {
    
        $path=$request->getParameter('uri','');   
        $type=$request->getParameter('type',''); 
        
        $this->data= $path;
        $msg=  $this->checkPath($path);
        if(null != $msg){
          $this->msg=$msg;
          return sfView::ERROR;
        }
        
if('dir' == $type){
  TogaFilesystem::rmDir($this, escapeshellcmd($path));
}else{
  TogaFilesystem::rm($this, escapeshellcmd($path));
}
        $this->data= "OK";
 }
 
 
     public function executeMkfile(sfWebRequest $request)
  {

        $path=$request->getParameter('uri','');   
        
        $msg=  $this->checkPath($path);
        if(null != $msg){
          $this->msg=$msg;
          return sfView::ERROR;
        }
        
        TogaFilesystem::writeFile($this, $path);
        
        $this->data= "OK";
 }

      public function executeMkdir(sfWebRequest $request)
  {

        $path=$request->getParameter('uri','');   
        
        $msg=  $this->checkPath($path);
        if(null != $msg){
          $this->msg=$msg;
          return sfView::ERROR;
        }
        
        TogaFilesystem::mkDir($this, escapeshellcmd($path));

        $this->data= "OK";
 }
 
      public function executeMove(sfWebRequest $request)
  {

        $from=$request->getParameter('from','');   
        $to=$request->getParameter('to','');   
        
        $msg=  $this->checkPath($from);
        if(null != $msg){
          $this->msg=$msg . "(From path)";
          return sfView::ERROR;
        }
        
        $msg=  $this->checkPath($to);
        if(null != $msg){
          $this->msg=$msg . "(To path)";
          return sfView::ERROR;
        }
        

         
        TogaFilesystem::mv($this, escapeshellcmd($from), escapeshellcmd($to));
        
        $this->data= "OK";
 }

       public function checkPath($path){
        $pathparts=explode ("/" ,$path);
        if(2>count($pathparts)){
          return "too short path";
        }
        if(''!=$pathparts[0]){
          return "You must start from /";
        }
        if(!preg_match('{' . TogaSettings::getDataDir() . '/*}', $path)){
          return $path . "is not in home";
        }
        if(0!=  preg_match('{/[.]{2,}?/}', $path)){
          return "You cannot go up";
        }

        return null;
    }
}
