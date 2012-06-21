<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('deploy/' . ($form->getObject()->isNew() ? 'create' : 'update') . (!$form->getObject()->isNew() ? '?id=' . $form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <?php if (!$form->getObject()->isNew()): ?>
    <input type="hidden" name="sf_method" value="put" />
  <?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('deploy/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'deploy/delete?id=' . $form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['name']->renderLabel() ?></th>
        <td>
          <?php echo $form['name']->renderError() ?>
          <?php echo $form['name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['description']->renderLabel() ?></th>
        <td>
          <?php echo $form['description']->renderError() ?>
          <?php echo $form['description'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['ide_key_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['ide_key_id']->renderError() ?>
          <?php echo $form['ide_key_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['username']->renderLabel() ?></th>
        <td>
          <?php echo $form['username']->renderError() ?>
          <?php echo $form['username'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['uri']->renderLabel() ?></th>
        <td>
          <?php echo $form['uri']->renderError() ?>
          <?php echo $form['uri'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['directory']->renderLabel() ?></th>
        <td>
          <?php echo $form['directory']->renderError() ?>
          <?php echo $form['directory'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['port']->renderLabel() ?></th>
        <td>
          <?php echo $form['port']->renderError() ?>
          <?php echo $form['port'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
