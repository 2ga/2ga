<?php
echo $form->renderFormTag(url_for(array(
            'module' => 'auth',
            'action' => 'login'
        )));
?>
  <?php if ($form->hasErrors()): ?>
  <div class="error">
  <?php echo __('There are something wrong in the form.'); ?>
  <?php echo $form->renderGlobalErrors() ?>
  </div>
<?php endif; ?>

<div class="column span-8 push-8 last">


  <table>
<?php echo $form["passwd"]->renderRow(); ?>
<?php echo $form->renderHiddenFields(); ?>

    <tr>
      <td colspan="2">
        <input type="submit" value="<?php echo __('login'); ?>" />
      </td>
    </tr>
  </table>

</div>
</form>

