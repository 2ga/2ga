<table>
  <tbody>
    <tr>
      <th>Name:</th>
      <td><?php echo $ide_project->getName() ?></td>
    </tr>
    <tr>
      <th>Description:</th>
      <td><?php echo $ide_project->getDescription() ?></td>
    </tr>
    <tr>
      <th>Ide language:</th>
      <td><?php echo $ide_project->getIdeLanguage()->getName() ?></td>
    </tr>
    <tr>
      <th>VCS:</th>
      <td><?php echo $ide_project->getIdeVcs()->getName() ?></td>
    </tr>
        <tr>
      <th>Protocol:</th>
      <td><?php echo $ide_project->getIdeVcsprotocol()->getName() ?></td>
    </tr>
    <tr>
      <th>Uri:</th>
      <td><?php echo $ide_project->getUri() ?></td>
    </tr>
        <tr>
      <th>Reodir:</th>
      <td><?php echo $ide_project->getRepdir() ?></td>
    </tr>
    <tr>
      <th>Port:</th>
      <td><?php echo $ide_project->getPort() ?></td>
    </tr>
        <tr>
      <th>Username:</th>
      <td><?php echo $ide_project->getUsername() ?></td>
    </tr>
    <tr>
      <th>Key:</th>
      <td><?php echo $ide_project->getIdeKey()->getName() ?></td>
    </tr>
    <tr>
      <th>Origin:</th>
      <td><?php echo $ide_project->getOrigin() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $ide_project->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $ide_project->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('project/edit?id='.$ide_project->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('project/index') ?>">List</a>
