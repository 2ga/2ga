<ul class="pannel">
  <li id="http://conf1.toga-test.com/project/index">

    <h1>Trash</h1>

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
        <?php if($ide_project->deleted_at):?>
          <tr>
            <td><a href="<?php echo url_for('project/show?id=' . $ide_project->getId()) ?>"><?php echo $ide_project->getName() ?></a></td>
            <td><?php echo $ide_project->getDescription() ?></td>
            <td><?php echo $ide_project->getIdeLanguage()->getName() ?></td>
            <td><?php echo $ide_project->getIdeVcs()->getName() ?></td>
            <td><?php echo $ide_project->getCreatedAt() ?></td>
            <td><?php echo $ide_project->getUpdatedAt() ?></td>
            <td><?php echo $ide_project->getDeletedAt() ?></td>
           <td><?php echo link_to('Delete', 'project/hardDelete?id=' . $ide_project->getId(), array('method' => 'delete', 'confirm' => 'Delete permanently?')) ?></td>
        <td><?php echo link_to('Restore', 'project/restore?id=' . $ide_project->getId(), array('method' => 'put')) ?></td>
        <?php endif?>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php echo link_to('Empty Trash', 'project/emptyTrash', array('method' => 'delete', 'confirm' => 'Empty trash?')) ?>

  </li>
</ul>
