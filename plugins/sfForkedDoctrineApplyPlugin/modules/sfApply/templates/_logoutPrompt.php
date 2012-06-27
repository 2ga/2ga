<?php use_helper('I18N') ?>
<div id="sf_apply_logged_in_as">
  <img src="/images/top_icon.png" alt="to/ga">
  <div>
    <p class="logged_in_as_name">
      <span class="ui-icon ui-icon-person"></span>
      Logged in as <?php echo __("%1%", array("%1%" => $sf_user->getGuardUser()->getUsername()), 'sfForkedApply')
      ?>
    </p>
    <p>
      <?php echo link_to(__('Log Out', array(), 'sfForkedApply'), '@sf_guard_signout', array("id" => 'logout'))
      ?>
      <?php echo link_to(__('Settings', array(), 'sfForkedApply'), 'sfApply/settings', array("id" => 'settings'))
      ?>
    </p>
  </div>
</div>

