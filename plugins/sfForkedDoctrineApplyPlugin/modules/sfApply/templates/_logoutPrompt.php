<?php use_helper('I18N') ?>
<div id="sf_apply_logged_in_as">
  <a href="http://conf1.toga-test.com/project"><img src="/images/toga_header_icon_1.png" alt="to/ga"></a>
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

