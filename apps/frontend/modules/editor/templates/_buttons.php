<?php if ('git' == $vcs): ?>
  <div class="jquery-ui-button">
    <div id="openfile"><button id="openfile">open<br><span class="ui-icon ui-icon-document" id="openfile" title="new"></span></button></div>
    <div id="easycommit"><button class="easycommit">Easy Commit<br><span class="ui-icon ui-icon-circle-arrow-n" title="upload"></span></button></div>
    <div id="pull"><button class="pull">Pull<br><span class="ui-icon ui-icon-circle-arrow-s" title="download"></span></button></div>
    <div id="team"><button class="team">Team<br><span class="ui-icon ui-icon-wrench" title="team"></span></button></div>
    <div id="addmodule"><button id="addmodule">Add Module<br><span class="ui-icon ui-icon-wrench" title="tools"></span></button></div>
    <div style="clear:both;"></div>
  </div>
<?php else: ?>
  <div class="jquery-ui-button">
    <div id="openfile"><button id="openfile">open<br><span class="ui-icon ui-icon-document" id="openfile" title="new"></span></button></div>
    <div id="addmodule"><button id="addmodule">Add Module<br><span class="ui-icon ui-icon-wrench" title="tools"></span></button></div>
    <div style="clear:both;"></div>
  </div>
<?php endif; ?>
