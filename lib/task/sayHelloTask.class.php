<?php

class sayHelloTask extends sfBaseTask
{

  public function configure()
  {
    $this->namespace = 'ideInit';
    $this->name = 'ror3';
  }

  public function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);
    $q = Doctrine_Query::create()
            ->select('p.*, u.*, l.*')
            ->from('IdeProject p, p.sfGuardUser u, p.IdeLanguage l')
            ->where('p.prepare = ?', 1)
            ->andWhere('l.shortname = ?', 'ror3');
    $projects = $q->fetchArray();
    echo count($projects) . "project(s)\n";
    $ror_obj = new LibProjectRubyOnRails(array(
                'is_mac' => sfConfig::get('ideexec_mac'),
                'is_simulation_open' => sfConfig::get('ideexec_simulation_open'),
                'is_simulation_write' => sfConfig::get('ideexec_simulation_write'),
                'is_simulation_git' => sfConfig::get('ideexec_simulation_git'),
                'is_simulation_user' => sfConfig::get('ideexec_simulation_user'),
                'is_noexec_user' => sfConfig::get('ideexec_noexec_user'),
                'default_user' => sfConfig::get('ideexec_defaultuser')
            ));
    
    foreach ($projects as $project)
    {

      echo "user: " . $project["sfGuardUser"]["username"] . " ";
      echo "prpject: " . $project["name"] . " ";

      $ror_obj->init($project["sfGuardUser"]["username"], $project["name"]);
      $ror_obj->createProject($project["sfGuardUser"]["username"], $project["name"]);

      $q = Doctrine_Query::create()
              ->update('IdeProject a');
      $q->set('a.prepare', '?', 0);
      $q->where('a.id=?', $project["id"]);
      $q->execute();
      echo "done\n";
    }
  }

}