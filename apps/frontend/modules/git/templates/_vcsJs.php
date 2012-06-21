<script type="text/javascript">
  $(function(){
    //console.log("xxx");
    //GROUP:VCS
    $("#easycommit").click(function() {
      console.log("clicked");
      $("#easycommit-dialog").dialog("open");
      return false;
    });
		
    //GROUP:VCS                    
    $("#commit").click(function() {
      console.log("clicked");
      $("#commit-dialog").dialog("open");
      return false;
    });
                        
    //GROUP:VCS                    
    $( "#pull" ).click(function() {
      if(confirm('Pull ?'))
        $.ajax({
          type: 'POST',
          url: '<?php echo url_for('git/pull') ?>',
          data: {project:"<?php echo $project_id ?>"},
          success: function(data) {alert(getContent(data))}
        });
    });
    
    //GROUP:VCS
    $("#add").click(function() {
      if(confirm('Add ?'))  
        $.ajax({
          type: 'POST',
          url: '<?php echo url_for('git/add') ?>',
          data: {project:"<?php echo $project_id ?>"},
          success: function(data) {alert(getContent(data))}
        });
    });
    
    //GROUP:VCS                    
    $("#push").click(function() {
      if(confirm('Push ?'))
        $.ajax({
          type: 'POST',
          url: '<?php echo url_for('git/push') ?>',
          data: {project:"<?php echo $project_id ?>"},
          success: function(data) {alert(getContent(data))}
        });
    });
    
    //GROUP:VCS 
    $( "#team" ).click(function() {
      $("#team-dialog").dialog( "open" );
      return false;
    });

    //GROUP:VCS
    $("#commit-dialog").dialog(
    { 
      position: 'center',
      autoOpen: false,
      title: 'Commit',
      widht:800,
      height:300,
      buttons: { "Ok": function() {
          var curproject = "<?php echo $project_id ?>"; 
          $(this).dialog("close");
          var comment = $("#commit-dialog textarea").val();
          $("#commit-dialog textarea").val("");
          console.log(curproject);
          $.ajax({
            type: 'POST',
            url: '<?php echo url_for('git/commit') ?>',
            data: {project:curproject,comment:comment},
            success: function(data) {alert(getContent(data))}
          });
        }, 
        "Cancel": function() { $(this).dialog("close"); }}
    });
    
    //GROUP:VCS  
    $("#easycommit-dialog").dialog(
    { 
      position: 'center',
      autoOpen: false,
      title: 'Easy Commit',
      widht:800,
      height:300,
      buttons: { "Ok": function() {
          var curproject = "<?php echo $project_id ?>"; 
          $(this).dialog("close");
          var comment = $("#easycommit-dialog textarea").val();
          $("#easycommit-dialog textarea").val("");
          console.log(curproject);
          $.ajax({
            type: 'POST',
            url: '<?php echo url_for('git/easycommit') ?>',
            data: {project:curproject,comment:comment},
            success: function(data) {alert(getContent(data))}
          });
        }, 
        "Cancel": function() { $(this).dialog("close"); }}
    });
    
    //GROUP:VCS 
    $("#team-dialog").dialog(
    { 
      position: 'center',
      autoOpen: false,
      title: "Team",
      widht:800,
      height:300,
      buttons: { 
        "Close": function() { $(this).dialog("close"); }}
    });
   
    //GROUP:VCS 
    $("#rename-dialog").dialog(
    { 
      position: 'center',
      autoOpen: false,
      title: 'Rename',
      buttons: { "Ok": function() {
          $(this).dialog("close");
          var newname = $("#rename-dialog input").val();
          $("#rename-dialog input").val("");
          var oldname = curnode.data.key;
          curnode.data.key = curnode.data.key.substring(0,curnode.data.key.length-curnode.data.title.length)+newname;
          console.log(curnode.data.key)
          curnode.data.title = newname;
          curnode.render();
                                                      
          $.ajax({
            type: 'POST',
            url: '<?php echo url_for('localfile/move') ?>',
            data: {from:oldname,to:curnode.data.key  },
            success: function(data) { }
          });
        }, 
        "Cancel": function() { $(this).dialog("close"); }}
    });
    
    //GROUP:VCS 
    $("#delete-dialog").dialog(
    { 
      position: 'center',
      autoOpen: false,
      title: 'Delete',
      buttons: { "Ok": function() {
          $(this).dialog("close");
          var del;
          var uri = curnode.data.key;
          if (curnode.data.isFolder) {
            curnode.removeChildren();
            del = "dir";
          }else del = "file";
          curnode.remove();
          $.ajax({
            type: 'POST',
            url: '<?php echo url_for('localfile/remove') ?>',
            data: {type:del,uri:uri},
            success: function(data) { }
          });
        }, 
        "Cancel": function() { $(this).dialog("close"); }}
    });
    
  });
</script>
