<?php include_partial('commonJs', array('project_id' => $project_id, 'vcs' => 'git')) ?>

<?php include_partial('vcsJs', array('project_id' => $project_id,
                                     'vcs' => $pj_detail["IdeVcs"]["shortname"])) ?>
<?php include_partial('fwJs', array('project_id' => $project_id,
                                    'fw' => $pj_detail["IdeLanguage"]["shortname"])) ?>



<ul id="myMenu" class="contextMenu">
  <?php include_partial('vcsContextMenu', array('project_id' => $project_id,
                                                'vcs' => $pj_detail["IdeVcs"]["shortname"])) ?>
  <?php include_partial('fwContextMenu', array('project_id' => $project_id,
                                                'fw' =>$pj_detail["IdeLanguage"]["shortname"])) ?>
</ul>

<?php include_partial('vcsDialogs', array('project_id' => $project_id,
                                          'vcs' => $pj_detail["IdeVcs"]["shortname"])) ?>
<?php include_partial('fwDialogs', array('project_id' => $project_id,
                                         'fw' => $pj_detail["IdeLanguage"]["shortname"])) ?>





<div class="container">
  <div class='header column span-24 last'>
    <?php include_partial('menubar', array('project_id' => $project_id,
                                           'fw' => $pj_detail["IdeLanguage"]["shortname"])) ?>
  </div>
  <div class='main column span-24 last'>
    <div id="filetree" class='filetree column span-6'>
      file tree
      <?php echo $sf_data->getRaw('files') ?>
    </div>
    <div class='righttools column span-17 last' >
      <div class='editor column span-12'>
        <div id="dialog" title="editor">
          <fieldset class="editor">
            <div id='editor-tabs' >
              <ul></ul>
              <div class="tool-buttons">
              	<span class="save">save</span>
              </div>
            </div>

          </fieldset>
        </div>
        <p class="ui-state-default ui-corner-all">	
          <?php include_partial('buttons', array('project_id' => $project_id,
                                                 'fw' => $pj_detail["IdeLanguage"]["shortname"],
                                                  'vcs' => $pj_detail["IdeVcs"]["shortname"])) ?>
        </p>
      </div>

      <?php include_partial('classTree', array('project_id' => $project_id)) ?>

      <div class='console column span-17 last'>
        <?php include_partial('consoles', array('project_id' => $project_id)) ?>
      </div>
    </div>
  </div>


</div>
