<ul class="pannel">
  <li id="http://conf1.toga-test.com/key/index">

<h1>Keys List</h1>

<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Description</th>
      <th>Created at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($ide_keys as $ide_key): ?>
      <tr>
        <td><a href="<?php echo url_for('key/show?id=' . $ide_key->getId()) ?>"><?php echo $ide_key->getName() ?></a></td>
        <td><?php echo $ide_key->getDescription() ?></td>
        <td><?php echo $ide_key->getCreatedAt() ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
  <a href="<?php echo url_for('key/new') ?>">New</a>
  
  </li>
</ul>
