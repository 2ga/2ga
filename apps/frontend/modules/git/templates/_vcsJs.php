<script type="text/javascript">
  $(function(){
      function getContent (data){
	return data.substring(data.indexOf("<contents>")+10,data.indexOf("</contents>"));
      };
    //console.log("xxx");
    //GROUP:VCS
    
    $(".easycommit").click(function() {
      console.log("clicked");
      $("#easycommit-dialog").dialog("open");
      return false;
    });
		
    //GROUP:VCS   
    
    $(".commit").click(function() {
      console.log("clicked");
      $("#commit-dialog").dialog("open");
      return false;
    });
    
    $(".clone").click(function() {
      console.log("clicked");
      $("#clone-dialog").dialog("open");
      return false;
    });
                        
    //GROUP:VCS                    
    $( ".pull" ).click(function() {
      //console.log("clicked");
      if(confirm('Pull ?'))
        $.ajax({
          type: 'POST',
          url: '<?php echo url_for('git/pull') ?>',
          data: {project:"<?php echo $project_id ?>"},
          success: function(data) {alert(getContent(data))}
        });
    });
    
    //GROUP:VCS
    $(".add").click(function() {
      if(confirm('Add ?'))
        var result = document.getElementById("console"); 
        var add;
          var uri = curnode.data.key;
          if (curnode.data.isFolder) {
            add = "dir";
          }else add = "file";
        $.ajax({
          type: 'POST',
          url: '<?php echo url_for('git/add')?>',
          data: {project:"<?php echo $project_id ?>",uri:uri},
          success: function(data) {
            //alert(getContent(data))
            result.innerHTML = getContent(data);
          }
        });
    });
    
    //GROUP:VCS  
    
    $(".push").click(function() {
      if(confirm('Push ?'))
        $.ajax({
          type: 'POST',
          url: '<?php echo url_for('git/push') ?>',
          data: {project:"<?php echo $project_id ?>"},
          success: function(data) {alert(getContent(data))}
        });
    });
    
    $(".diff").click(function() {
      if(confirm('Diff ?'))
        $.ajax({
          type: 'POST',
          url: '<?php echo url_for('git/diff') ?>',
          data: {project:"<?php echo $project_id ?>"},
          success: function(data) {alert(getContent(data))}
        });
    });
    /*$(".clone").click(function() {
      if(confirm('clone ?'))
        $.ajax({
          type: 'POST',
          url: '<?php echo url_for('git/clone') ?>',
          data: {project:"<?php echo $project_id ?>"},
          success: function(data) {alert(getContent(data))}
        });
    });*/
    
    //GROUP:VCS 
    
    $( ".team" ).click(function() {
      $("#team-dialog").dialog( "open" );
      return false;
    });
    
    $( ".local" ).click(function() {
      $("#local-dialog").dialog( "open" );
      $("#git-dialog").dialog("close" );
      return false;
    });
    
    $( ".branch" ).click(function() {
      $("#branch-dialog").dialog( "open" );
      $("#git-dialog").dialog("close" );
      return false;
    });
    
    $( ".remote" ).click(function() {
      $("#remote-dialog").dialog( "open" );
      $("#git-dialog").dialog("close" );
      return false;
    });
    
    $( ".create_branch" ).click(function() {
      $("#create-branch-dialog").dialog( "open" );
      $("#local-dialog").dialog("close" );
      return false;
    });
    
    $( ".checkout_branch" ).click(function() {
      $("#checkout-branch-dialog").dialog( "open" );
      $("#local-dialog").dialog("close" );
      return false;
    });
    
    
    //git
    $("#git-dialog").dialog(
    { 
      position: 'center',
      autoOpen: false,
      title: 'Git',
      widht:800,
      height:300,
      buttons: { "Ok": function() {
          if(confirm('Git ?')){  
              $.ajax({
                type: 'POST',
                url: '<?php echo url_for('git/') ?>',
                data: {project:"<?php echo $project_id ?>"},
                success: function(data) {alert(getContent(data)/*"add clicked"*/)}
                //success: function(){alert()}
              });
              $(this).dialog("close");
            }else{
              return false;
            }
        }, 
        "Cancel": function() { $(this).dialog("close"); }}
    });
    
    //add
    $("#add-dialog").dialog(
    { 
      position: 'center',
      autoOpen: false,
      title: 'Add',
      widht:800,
      height:300,
      buttons: { "Ok": function() {
          if(confirm('Add ?')){  
              $.ajax({
                type: 'POST',
                url: 'addSuccess.php',
                data: {project:"<?php echo $project_id ?>"},
                success: function(data) {
                  alert("OK");
                },
                error:function(){
                  alert("error");
                }
              });
              $(this).dialog("close");
            }else{
              return false;
            }
        }, 
        "Cancel": function() { $(this).dialog("close"); }}
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
          var result = document.getElementById("console"); 
          $.ajax({
            type: 'POST',
            url: '<?php echo url_for('git/commit') ?>',
            data: {project:curproject,comment:comment},
            success: function(data) {
              //alert(getContent(data))
              result.innerHTML = getContent(data);
            }
          });
        }, 
        "Cancel": function() { $(this).dialog("close"); }}
    });
    
    
    $("#pull-dialog").dialog(
    { 
      position: 'center',
      autoOpen: false,
      title: 'Pull',
      widht:800,
      height:300,
      buttons: { "Ok": function() {
          if(confirm('Pull ?'))
            $.ajax({
              type: 'POST',
              url: '<?php echo url_for('git/pull') ?>',
              data: {project:"<?php echo $project_id ?>"},
              success: function(data) {
                alert(getContent(data))
              }
            });
            $(this).dialog("close");
        }, 
        "Cancel": function() { $(this).dialog("close"); }}
    });
    
    
    $("#push-dialog").dialog(
    { 
      position: 'center',
      autoOpen: false,
      title: 'Push',
      widht:800,
      height:300,
      buttons: { "Ok": function() {
          if(confirm('Push ?'))
            var result = document.getElementById("console");
            $.ajax({
              type: 'POST',
              url: '<?php echo url_for('git/push') ?>',
              data: {project:"<?php echo $project_id ?>"},
              success: function(data) {
                alert(getContent(data))
                //result.innerHTML = getContent(data);
              }
            });
            $(this).dialog("close");
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
          var result = document.getElementById("console"); 
          $.ajax({
            type: 'POST',
            url: '<?php echo url_for('git/easycommit') ?>',
            data: {project:curproject,comment:comment},
            success: function(data) {
              //alert(getContent(data))
              result.innerHTML = getContent(data);
            }
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
    
    
    $("#local-dialog").dialog(
    { 
      position: 'center',
      autoOpen: false,
      title: "Local",
      widht:800,
      height:300,
      buttons: { 
        "Close": function() { $(this).dialog("close"); }}
    });
    
    $("#branch-dialog").dialog(
    { 
      position: 'center',
      autoOpen: false,
      title: "Branch",
      widht:800,
      height:300,
      buttons: { 
        "Close": function() { $(this).dialog("close"); }}
    });
    
    $("#remote-dialog").dialog(
    { 
      position: 'center',
      autoOpen: false,
      title: "Remote",
      widht:800,
      height:300,
      buttons: { 
        "Close": function() { $(this).dialog("close"); }}
    });
    
    $("#create-branch-dialog").dialog(
    { 
      position: 'center',
      autoOpen: false,
      title: 'create branch',
      buttons: { "Ok": function() {
          $(this).dialog("close");
          var curproject = "<?php echo $project_id ?>"; 
          var newname = $("#create-branch-dialog input").val();
          $("#create-branch-dialog input").val(""); 
          console.log(newname);
          var result = document.getElementById("console"); 
          $.ajax({
            type: 'POST',
            url: '<?php echo url_for('git/createbranch') ?>',
            data: {project:curproject,newname:newname },
            success: function(data) { 
              //alert(getContent(data))
              //alert("newbranch created : " + newname);
              result.innerHTML = getContent(data);
            }
          });
        }, 
        "Cancel": function() { $(this).dialog("close"); }}
    });
    $("#checkout-branch-dialog").dialog(
    { 
      position: 'center',
      autoOpen: false,
      title: 'checkout branch',
      buttons: { "Ok": function() {
          $(this).dialog("close");
          var curproject = "<?php echo $project_id ?>"; 
          var branchname = $("#checkout-branch-dialog input").val();
          $("#checkout-branch-dialog input").val(""); 
          console.log(branchname);
          var result = document.getElementById("console"); 
          $.ajax({
            type: 'POST',
            url: '<?php echo url_for('git/checkoutbranch') ?>',
            data: {project:curproject,branchname:branchname },
            success: function(data) { 
              //alert(getContent(data))
              result.innerHTML = getContent(data);
            }
          });
        }, 
        "Cancel": function() { $(this).dialog("close"); }}
    });
    $("#check_branch-dialog").dialog(
    { 
      position: 'center',
      autoOpen: false,
      title: 'check branch',
      buttons: { "Ok": function() {
          $(this).dialog("close");
          var curproject = "<?php echo $project_id ?>";     
          var result = document.getElementById("console"); 
          $.ajax({
            type: 'POST',
            url: '<?php echo url_for('git/checkbranch') ?>',
            data: {project:curproject },
            success: function(data) { 
              //alert(getContent(data))
              result.innerHTML = getContent(data);
            }
          });
        }, 
        "Cancel": function() { $(this).dialog("close"); }}
    });
    
    $(".check_branch").click(function() {
      if(confirm('check branch ?'))
        var result = document.getElementById("console"); 
        $.ajax({
          type: 'POST',
          url: '<?php echo url_for('git/checkbranch')?>',
          data: {project:"<?php echo $project_id ?>"},
          success: function(data) {
            //alert(getContent(data))
            result.innerHTML = getContent(data);
          }
        });
    });
    
    
    $("#clone-dialog").dialog(
    { 
      position: 'center',
      autoOpen: false,
      title: 'Clone',
      widht:800,
      height:300,
      buttons: { "Ok": function() {
          if(confirm('Clone ?')){  
          var curproject = "<?php echo $project_id ?>"; 
          $(this).dialog("close");
          var uri = $("#clone-dialog textarea").val();
          $("#clone-dialog textarea").val("");
          console.log(curproject);
          console.log(uri);
          $.ajax({
            type: 'POST',
            url: '<?php echo url_for('git/clone') ?>',
            data: {project:"<?php echo $project_id ?>",uri:uri},
            success: function(data) {alert(getContent(data))}
          });
          }
        }, 
        "Cancel": function() { $(this).dialog("close"); }}
    });
  });
</script>
