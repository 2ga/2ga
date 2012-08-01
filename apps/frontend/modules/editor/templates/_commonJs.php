<style>

  /*style for tab close button*/
  div#editor-tabs span.ui-icon-close {
    margin: 2px;
  }

  .CodeMirror-scroll {
    top: 60px;
  }

  span.ui-icon {
    margin: 0px;
  }
</style>
<script type="text/javascript">
  var curnode;
  
  $(function(){  
    function getContent (data){
      return data.substring(data.indexOf("<contents>")+10,data.indexOf("</contents>"));
    };
    $.fx.speeds._default = 1000;
    $('#dialog:ui-dialog').dialog("destroy");
    //GROUP:Common
    $( "#dialog" ).dialog({
      autoOpen: false,
      show: "blind",
      //hide: "explode",
      //modal: true,
      position: [ 100, 100 ], 
      width:1000
    });
    //GROUP:Common
    $("#openfile").click(function() {
                                
      $("#dialog").dialog("open");
      return false;
    });

    //GROUP:Common
    $("#makefile-dialog").dialog(
    { 
      position: 'center',
      autoOpen: false,
      title: 'New File',
      buttons: { "Ok": function() {
          $(this).dialog("close");
          var newname = $("#makefile-dialog input").val();
          $("#makefile-dialog input").val("");
          if (!curnode.data.isFolder) curnode=curnode.getParent();
          console.log(curnode.data.title);
          curnode.addChild({
            title:newname,
            isFolder:false,
            key:curnode.data.key+"/"+newname
          }) 
          bindContextMenu();
          //                                                    $("#filetree").dynatree("getTree").reload();
          console.log(curnode.data.key+"/"+newname);
                                                    
          $.ajax({
            type: 'POST',
            url: '<?php echo url_for('localfile/mkfile') ?>',
            data: {uri:curnode.data.key+"/"+newname},
            success: function(data) { }
          });
        }, 
        "Cancel": function() { $(this).dialog("close"); }}
    });

    //GROUP:Common
    $("#makedir-dialog").dialog(
    { 
      position: 'center',
      autoOpen: false,
      title: 'New Folder',
      buttons: { "Ok": function() {
          $(this).dialog("close");
          var newname = $("#makedir-dialog input").val();
          $("#makedir-dialog input").val("");
          if (!curnode.data.isFolder) curnode=curnode.getParent();
          console.log(curnode.data.title);
          curnode.addChild({
            title:newname,
            isFolder:true,
            key:curnode.data.key+"/"+newname
          }) 
          bindContextMenu();
          console.log(curnode.data.key+"/"+newname);
                                                    
          $.ajax({
            type: 'POST',
            url: '<?php echo url_for('localfile/mkdir') ?>',
            data: {uri:curnode.data.key+"/"+newname},
            success: function(data) { }
          });
        }, 
        "Cancel": function() { $(this).dialog("close"); }}
    });
    
    //GROUP:Common                    
    function bindContextMenu() {
      // Add context menu to all nodes:
      //                        $("a.dynatree-title")
      $("#filetree span.dynatree-node")
      .destroyContextMenu() // unbind first, to prevent duplicates                    
      .contextMenu({menu: "myMenu"}, function(action, el, pos) {
        curnode = el.parent().prop("dtnode");
        switch(action) {
          case "rename":
            $("#rename-dialog").dialog('open');
            break;
          case "delete": 
            $("#delete-dialog").dialog('open');
            break;
          case "makefile": 
            $("#makefile-dialog").dialog('open');
            break;
          case "makedir" : 
            $("#makedir-dialog").dialog('open');
            break;
          case "git" : 
            $("#git-dialog").dialog('open');
            break;
          case "add" : 
            $("#add-dialog").dialog('open');
            break;
          case "commit" : 
            $("#commit-dialog").dialog('open');
            break;
          case "pull" : 
            $("#pull-dialog").dialog('open');
            break;
          case "push" : 
            $("#push-dialog").dialog('open');
            break;
          case "easycommit" : 
            $("#easycommit-dialog").dialog('open');
            break;
          case "team" : 
            $("#team-dialog").dialog('open');
            break;
          case "local" : 
            $("#local-dialog").dialog('open');
            break;
          case "branch" : 
            $("#branch-dialog").dialog('open');
            break;
          case "remote" : 
            $("#remote-dialog").dialog('open');
            break;
          case "diff" : 
            $("#diff-dialog").dialog('open');
            break;
          case "create-branch" : 
            $("#create-branch-dialog").dialog('open');
            break;
          case "checkout-branch" : 
            $("#checkout-branch-dialog").dialog('open');
            break;
          case "check-branch" : 
            $("#check-branch-dialog").dialog('open');
            break;
          case "clone" : 
            $("#clone-dialog").dialog('open');
            break;
        }
      });
    };
    //GROUP:Common
    $(function(){
      $("#filetree").dynatree({
        //                        persist: true, 
        onExpand : function(){
          bindContextMenu();
        },
                        
        onClick : function(node) {
          //console.log(node.data.key);
          var filedir = node.data.key;
          fileid = filedir.split('/').join('');
          fileid = fileid.split('.').join('');
          var filecontent;
          var url = "<?php echo url_for('localfile/open') ?>?uri="+filedir;
          var urlsave = "<?php echo url_for('localfile/write') ?>?uri="+filedir;
                            
          if(node.data.isFolder) return;
                            
                            
                            
          if (!$("#dialog" ).dialog("isOpen")) 
            $( "#dialog" ).dialog("open");
                            
          
          if ($("#"+fileid).length != 0){ // file is already opened
            $tab.tabs('select', "#"+fileid);
            return;
          }

          // open file              
          $.ajax(
          {
            type:'GET',
            url:"<?php echo url_for('localfile/open') ?>?uri="+filedir,
            success: function(data){

              filecontent = getContent(data);
              var filename = node.data.title;
              o = $('<div id = "'+ fileid + '"><textarea id="' + fileid + 'editor">' + filecontent + '</textarea></div>');
              //console.log(o);
              $tab.append(o);
              var x = createEditor(fileid + "editor",filename,urlsave);	// suggestion.js
              $tab.tabs("add", "#"+fileid,filename);
              $tab.tabs('select', "#"+fileid);
            }
          }
        );
          $("div.tool-buttons span.save").innerHTML = "save";
          $("div.tool-buttons span.save").button("enable");
          $("div.tool-buttons span.save").show();       
        }
      });
           
      bindContextMenu();
    });
                    
    //GROUP:Common                 
    $('#tree').dynatree();
    $('#classtree').dynatree();

    // Tab's tool buttons
    $("div.tool-buttons span.save").button({
      icons: {
        primary: "ui-icon-disk"
      }
    });
    

    // editor tabs with close icon button
    $tab = $('#editor-tabs').tabs({
      tabTemplate: "<li><a href='#{href}'>#{label}</a> <span class='ui-icon ui-icon-close'></span></li>"
    });

    // close tab function
    $("#editor-tabs span.ui-icon-close").live( "click", function() {
      var index = $( "li", $tab ).index( $( this ).parent() );
      $tab.tabs( "remove", index );
      console.log("index: " + index);

      var remaning_tabs = $tab.tabs("length");
      if(remaning_tabs == 0) {
        $("div.tool-buttons span.save").innerHTML = " ";
        $("div.tool-buttons span.save").button("disable");
        $("div.tool-buttons span.save").hide();
      }
    });

    
    $('#console-tabs').tabs();
    //$tab.sortable();
                    
    $('#editor-tabs .ui-tabs-nav').sortable({ axis: "x" });
    $('ul.jd_menu').jdMenu({
      activateDelay: 750, 
      showDelay: 150,    
      hideDelay: 550,   
      onShow: null,
      onHideCheck: null,
      onHide: null,     
      onAnimate: null,  
      onClick: null,    
      offsetX: 4,       
      iframe: $.browser.msie			
    });

    //GROUP:Common
    function select(event, ui) {
      $("<div/>").text("Selected: " + ui.item.text()).appendTo("#log");
      if (ui.item.text() == 'Quit') {
      }
    }
	
    $("#bar3").menubar({
      position: {
        within: $("#demo-frame").add(window).first()
      },
      select: select,
      items: ".menubarItem",
      menuElement: ".menuElement"
    });
    
  });
</script>
