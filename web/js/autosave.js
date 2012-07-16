function saveCache(url, editor) {
  var text;
  if(!editor){ //undefined => true
    text = " ";
  }else{
    text = editor.getValue();
  }
  
  $.ajax({
    type: 'POST',
    url: url + ".cache",
    data: {
      body: text
    },
    success: function(data) {
      if(!text){
        console.log("clearcache");
      }else{
        console.log("savecache.");
      }
    }
  });
}

function saveLocalStorage(url, editor) {
  if (!window.localStorage) {
    return;
  }
  doSave(url, editor);
}
function doSave(url, editor) {
  console.log(editor.getValue());
  var data = {
    text: editor.getValue()
  }
  window.localStorage.setItem(url, JSON.stringify(data));
  console.log("save to local storage.");
}

function loadData(key) {
  var data = JSON.parse(window.localStorage.getItem(key));
  var value = data.text;
  console.log("load from local storage.");
  return value;
}
