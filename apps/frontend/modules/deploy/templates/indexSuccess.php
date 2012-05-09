<h1>Deploys List</h1>

<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Description</th>
      <th>Ide key</th>
      <th>Username</th>
      <th>Uri</th>
      <th>Directory</th>
      <th>Port</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($ide_deploys as $ide_deploy): ?>
    <tr>
      <td><a href="<?php echo url_for('deploy/show?id='.$ide_deploy->getId()) ?>"><?php echo $ide_deploy->getName() ?></a></td>
      <td><?php echo $ide_deploy->getDescription() ?></td>
      <td><?php echo $ide_deploy->getIdeKeyId() ?></td>
      <td><?php echo $ide_deploy->getUsername() ?></td>
      <td><?php echo $ide_deploy->getUri() ?></td>
      <td><?php echo $ide_deploy->getDirectory() ?></td>
      <td><?php echo $ide_deploy->getPort() ?></td>
      <td><?php echo $ide_deploy->getCreatedAt() ?></td>
      <td><?php echo $ide_deploy->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<a href="<?php echo url_for('deploy/new?project=' . $project) ?>">New</a>
