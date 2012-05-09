<script type="text/javascript">
  $(function(){
   
    //GROUP:FRAMEWORK
    $( "#addmodule" ).click(function() {
      $("#addmodule-dialog").dialog( "open" );
      return false;
    });
    
    //GROUP:FRAMEWORK
    $("#addmodule-dialog").dialog(
    { 
      position: 'center',
      autoOpen: false,
      title: 'Add module',
                                
      buttons: { "Ok": function() {
          var curproject = "<?php echo $project_id ?>"; 
          $(this).dialog("close");
          var name = $("#addmodule-dialog input").val();
          $("#addmodule-dialog input").val("");
          console.log(name);
          $.ajax({
            type: 'POST',
            url: '<?php echo url_for('symfony/addmod') ?>',
            data: {project:curproject,comment:name},
            success: function(data) {alert(getContent(data))}
          });
        }, 
        "Cancel": function() { $(this).dialog("close"); }}
    });
		    
  });
</script>