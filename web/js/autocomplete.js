(function () {
  // Minimal event-handling wrapper.
  function stopEvent() {
    if (this.preventDefault) {
      this.preventDefault();
      this.stopPropagation();
    }
    else {
      this.returnValue = false;
      this.cancelBubble = true;
    }
  }
  function addStop(event) {
    if (!event.stop) event.stop = stopEvent;
    return event;
  }
  function connect(node, type, handler) {
    function wrapHandler(event) {
      handler(addStop(event || window.event));
    }
    if (typeof node.addEventListener == "function")
      node.addEventListener(type, wrapHandler, false);
    else
      node.attachEvent("on" + type, wrapHandler);
  }

  var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
    lineNumbers: true,
    theme: "night",
    onKeyEvent: function(i, e) {
      if (!done) {
        var complete = document.getElementById("complete");
        var complete_comment = document.getElementById("complete_comment")
        done = true;
        complete.parentNode.removeChild(complete);
        complete_comment.parentNode.removeChild(complete_comment);
      }
      // Hook into ctrl-space
      if (e.keyCode == 32 && (e.ctrlKey || e.metaKey) && !e.altKey) {
        e.stop();
        return startComplete();
      }
    }
  });
  
var allVar = [];
var allCom = {};
var allClass = [];
  
var selecttheme = document.getElementById("select");
  selecttheme.onchange = function selectTheme() {
    var theme = this.options[this.selectedIndex].innerHTML;
    editor.setOption("theme", theme);
  }
  
  function hasVal(arr,val){
    for(var i=0;i<arr.length;i++){
      if (arr[i] == val) return true;
    }
    return false;
  }
  
  function getAllVar(curline){
    var startNote = false;
    var variables = [];
    for (var i=0;i<=curline;i++){
      var linestring = editor.getLine(i);
      if (linestring.indexOf("=begin")>=0){
        startNote = true;
      }
      else if (linestring.indexOf("=end")>=0){
        startNote = false;
      }
      if (startNote) continue;
      if (linestring.indexOf("#")>=0) linestring = linestring.substring(0,linestring.indexOf("#"));
      var n = linestring.indexOf("=");
      if (n>=0){
        linestring = linestring.substring(0,n).replace(/,/g," ");
        var v = linestring.split(" ");
        for(var j = 0;j<v.length;j++){
          if ((x=v[j])!= ""){
            if (!hasVal(variables,x)) {
              x = x + " " + "Variables";
              variables.push(x);
            //allCom[x] = "Variables";
            }
          }
        }
      }
      else {
        n = linestring.indexOf("class");
        if (n>=0){
          var v = linestring.split(" ");
          var x = v[1];
          if (!hasVal(variables,x)) {
            x = x + " " + "Class";
            variables.push(x);
          }
        //allCom[x] = "Class";
        }
        else {
          n = linestring.indexOf("def");
          if (n>=0){
            linestring = linestring.replace(/def|\(|,|\)/g," ");
            var v = linestring.split(" ");
            var func = true;
            for (var j=0;j<v.length;j++){
              if ((x=v[j])!=""){
                if (!hasVal(variables,x)) variables.push(x);
                if (func){
                  x = x + " " + "Function";
                  //								  allCom[x] = "Function";
                  func = false;
                }
                else {
                  //allCom[x] = "Variables";
                  x = x + " " + "Variables";
                }
              }
            }
          }
        }
      }
    }
    return variables;
  }
  
  function getAllClass(){
    var n = editor.lineCount();
    for (var i = 0;i<n;i++){
      var linestring = editor.getLine(i);
      var p = linestring.indexOf("class");
      if (p>=0){
        var v = linestring.replace(/:|</g," ").split(" ");
        var x = v[1];
        allClass.push(x);
      }
    }
  }
  
  var done = true;
  function startComplete() {
    allClass = [];  
    getAllClass();
    console.log(allClass);
    // We want a single cursor position.
    if (editor.somethingSelected()) return;
    // Find the token at the cursor
    var cur = editor.getCursor(false)
    var curline = cur.line;
    var token = editor.getTokenAt(cur), tprop = token;
    
    allCom = {};
    allVar = getAllVar(curline);
   
    // If it's not a 'word-style' token, ignore the token.
    if (!/^[\w$_]*$/.test(token.string)) {
      token = tprop = {
        start: cur.ch, 
        end: cur.ch, 
        string: "", 
        state: token.state,
        className: token.string == "." ? "property" : null
        };
    }
    // If it is a property, find out what it is a property of.
    while (tprop.className == "property") {
      tprop = editor.getTokenAt({
        line: cur.line, 
        ch: tprop.start
        });
      if (tprop.string != ".") return;
      tprop = editor.getTokenAt({
        line: cur.line, 
        ch: tprop.start
        });
    }
    var completions = getCompletions(token);
    if (!completions.length) return;
    function insert(str) {
      editor.replaceRange(str, {
        line: cur.line, 
        ch: token.start
        }, {
        line: cur.line, 
        ch: token.end
        });
    }
    // When there is only one completion, use it directly.
    //if (completions.length == 1) {insert(completions[0]); return true;}

    // Build the select widget
    var complete = document.createElement("div");
    complete.className = "completions";
    var complete_comment = document.createElement("div");
    complete_comment.className = "comment";
    
    complete.id = "complete";
    complete_comment.id = "complete_comment";
    var sel = complete.appendChild(document.createElement("select"));
    textarea = document.createElement("textarea");
    textarea.className = "textarea";
    textarea.readOnly=true;
    complete_comment.appendChild(textarea);
    // Opera doesn't move the selection when pressing up/down in a
    // multi-select, but it does properly support the size property on
    // single-selects, so no multi-select is necessary.
    if (!window.opera) sel.multiple = true;
    for (var i = 0; i < completions.length; ++i) {
      var opt = sel.appendChild(document.createElement("option"));
      opt.appendChild(document.createTextNode(completions[i]));
    }
    sel.firstChild.selected = true;
    sel.size = Math.min(10, completions.length);
    var pos = editor.cursorCoords();
    var posx = pos.x;
    var posy = pos.yBot;
    complete.style.left = posx + "px";
    complete.style.top = posy + "px";
    document.body.appendChild(complete);
    // Hack to hide the scrollbar.
    if (completions.length <= 10){
      complete.style.width = (sel.clientWidth - 1) + "px";
    }  
    complete_comment.style.left = posx + sel.clientWidth + 1.5 + "px";
    var linesize = sel.clientHeight/sel.size;
    complete_comment.style.top = posy + linesize * sel.selectedIndex + "px";
    showcomment();
    document.body.appendChild(complete_comment);
    sel.onchange = function(){
      showcomment();
    };
    done = false;
    function close() {
      if (done) return;
      done = true;
      complete.parentNode.removeChild(complete);
      complete_comment.parentNode.removeChild(complete_comment);
    }
    function pick() {
      insert(sel.options[sel.selectedIndex].text);
      close();
      setTimeout(function(){
        editor.focus();
      }, 50);
    }
    function showcomment(){
      var com1 = rb_comment[sel.options[sel.selectedIndex].text];
      if(com1!=undefined) textarea.value = com1;
      else {
        var com2 = allCom[sel.options[sel.selectedIndex].text];
        if (com2!=undefined)
          textarea.value = com2;
        else console.log(allCom);
      }
    }
    
    connect(sel, "blue", close);
    connect(sel, "keydown", function(event) {
      var code = event.keyCode;
      // Enter and space
      if (code == 13 || code == 32) {
        event.stop();
        pick();
      }
      // Escape, backspace, left, right
      else if (code == 8 || code == 37 || code == 39 || code == 27) {
        event.stop();
        close();
        editor.focus();
      }
      else if (code == 40 && sel.selectedIndex == completions.length-1) {
        close();
        editor.focus();
        setTimeout(startComplete, 0);
      }
      else if (code != 38 && code != 40) {
        close();
        editor.focus();
        setTimeout(startComplete, 50);
      }
    });
    connect(sel, "dblclick", pick);

    sel.focus();
    // Opera sometimes ignores focusing a freshly created node
    if (window.opera) setTimeout(function(){
      if (!done) sel.focus();
    }, 100);
    return true;   
  }
              
  function getCompletions(token) {
    var found = [], start = token.string;
    if (start.length == 0) stopEvent();
    else {
      var kw = rb_keywords.concat(rb_builtinfunction,rb_functionfornumbers,rb_functionforfloat,rb_functionformath).sort();
      kw = allVar.concat(kw);
      var length = kw.length;
      for (var i=0;i<length;i++){
        if(kw[i].toLowerCase().indexOf(start.toLowerCase())==0){
          found.push(kw[i]);
        }
      }
    }
    return found;
  }
})();
