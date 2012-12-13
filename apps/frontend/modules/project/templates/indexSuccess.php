<ul class="pannel">
  <li id="http://conf1.toga-test.com/project/index">

    <h1>Projects List</h1>

    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Description</th>
          <th>Ide language</th>
          <th>VCS</th>
          <th>Created at</th>
          <th>Updated at</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($ide_projects as $ide_project): ?>
        <?php if(!$ide_project->deleted_at):?>
          <tr>
            <td><a href="<?php echo url_for('project/show?id=' . $ide_project->getId()) ?>"><?php echo $ide_project->getName() ?></a></td>
            <td><?php echo $ide_project->getDescription() ?></td>
            <td><?php echo $ide_project->getIdeLanguage()->getName() ?></td>
            <td><?php echo $ide_project->getIdeVcs()->getName() ?></td>
            <td><?php echo $ide_project->getCreatedAt() ?></td>
            <td><?php echo $ide_project->getUpdatedAt() ?></td>
            <td><a href="<?php echo url_for('deploy/index?project=' . $ide_project->getId()) ?>">Deploy</a></td>
            <td><a href="<?php echo url_for('editor/index?project=' . $ide_project->getId()) ?>">Edit</a></td>
            <td><a href="<?php echo url_for("http://" . $ide_project->getName() . "." . $myname . "." . TogaSettings::getServerDomain()) ?>">Demo</a></td>
            <td><a href="<?php echo url_for("http://" . $ide_project->getName() . "." . $myname . "." . TogaSettings::getServerDomain()) . "/frontend_dev.php" ?>">Debug</a></td>
            <td><?php echo link_to('Delete', 'project/delete?id=' . $ide_project->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?></td>
        <?php endif;?>
        <?php endforeach; ?>
      </tbody>
    </table>
    <a href="<?php echo url_for('project/new') ?>">New</a>

  </li>
</ul>
