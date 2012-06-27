<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $ide_deploy->getId() ?></td>
    </tr>
    <tr>
      <th>Name:</th>
      <td><?php echo $ide_deploy->getName() ?></td>
    </tr>
    <tr>
      <th>Description:</th>
      <td><?php echo $ide_deploy->getDescription() ?></td>
    </tr>
    <tr>
      <th>Ide project:</th>
      <td><?php echo $ide_deploy->getIdeProjectId() ?></td>
    </tr>
    <tr>
      <th>Ide key:</th>
      <td><?php echo $ide_deploy->getIdeKeyId() ?></td>
    </tr>
    <tr>
      <th>Username:</th>
      <td><?php echo $ide_deploy->getUsername() ?></td>
    </tr>
    <tr>
      <th>Uri:</th>
      <td><?php echo $ide_deploy->getUri() ?></td>
    </tr>
    <tr>
      <th>Directory:</th>
      <td><?php echo $ide_deploy->getDirectory() ?></td>
    </tr>
    <tr>
      <th>Port:</th>
      <td><?php echo $ide_deploy->getPort() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $ide_deploy->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $ide_deploy->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('deploy/edit?id=' . $ide_deploy->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('deploy/index') ?>">List</a>
