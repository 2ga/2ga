<?php
require_once '%TOGA:APPDIR%/lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();
class ProjectConfiguration extends sfProjectConfiguration
{
public function setup()
 {
 $this->enablePlugins('sfDoctrinePlugin');
 $this->enablePlugins('sfDoctrineGuardPlugin');
 
 $this->enablePlugins('sfForkedDoctrineApplyPlugin');
 }
}