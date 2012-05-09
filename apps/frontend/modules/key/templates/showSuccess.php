<table>
  <tbody>
    <tr>
      <th>Name:</th>
      <td><?php echo $ide_key->getName() ?></td>
    </tr>
    <tr>
      <th>Description:</th>
      <td><?php echo $ide_key->getDescription() ?></td>
    </tr>
    <tr>
      <th>Pubkey:</th>
      <td><?php echo $ide_key->getPubkey() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $ide_key->getCreatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('key/edit?id='.$ide_key->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('key/index') ?>">List</a>
