<?php use_helper('I18N') ?>
<div class="sf_guard_signin">
  <h1><?php echo __('Signin', null, 'sf_guard') ?></h1>
  <?php echo get_partial('sfGuardAuth/signin_form', array('form' => $form)) ?>
</div>