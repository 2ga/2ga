function savefile(url, editor) {
  // var socket = io.connect('vm15.tom.sfc.keio.ac.jp:3000');
  // var content = editor.getValue();
  // socket.emit('content', { filename: filename, content:content });
  // console.log(editor.getValue());
  // console.log("<?php echo url_for('editor/open')?>?uri=");
  var newurl = url + "&body=" + editor.getValue();
  console.log(newurl);

  $.ajax({
    type: 'POST',
    url: url,
    data: {
      body: editor.getValue()
    },
    success: function(data) {
    }
  });
  
  window.localStorage.removeItem(url); // delete cached data in local storage
  saveCache(url, ""); // delete cache file on the server

  if ($("#editor-tabs li.ui-tabs-selected a")[0].firstChild.className == "unsaved") {
    // console.log("removed span.unsaved");
    $("#editor-tabs li.ui-tabs-selected span.unsaved").remove();
  }

  // var X= new XMLHttpRequest;
  // X.open('POST', newurl, true);
  // X.onreadystatechange = function() {//Call a function when the state
  // changes.
  // console.log(X.readyState);
  // if(X.readyState == 4) {
  // alert(X.responseText);
  // }
  // }
}