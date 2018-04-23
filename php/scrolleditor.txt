 <!doctype html>
<html>
<head>
    <title>Watershed Latex Hyperscroll Editor</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.6/ace.js" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.0/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
<script>
	MathJax.Hub.Config({
		tex2jax: {
		inlineMath: [['$','$'], ['\\(','\\)']],
		processEscapes: true,
		processClass: "mathjax",
        ignoreClass: "no-mathjax"
		}
	});//			MathJax.Hub.Typeset();//tell Mathjax to update the math
</script>
</head>
<body class = "no-mathjax">
    
<div id = "scrolldisplay" class = "mathjax"></div>    
<div id = "linkscroll">
    <a href = "index.html" id = "indexlink">index.html</a>
    <a href = "editor.php">editor.php</a>
    <a href = "main2index.php">main2index.php</a>    
    <a href = "scrolls2index.php">scrolls2index.php</a>
    <div class = "button">FIGURE</div>
    <div class = "button">HTML2TEX</div>

</div>
<div id = "namediv"></div>
<div id="maineditor" contenteditable="true" spellcheck="true"></div>
<div id = "filescroll">
    <div class = "scrolls file">scrolls/replicator.txt</div>
    <div class = "scrolls file">scrolls/main.txt</div>
    <div class = "scrolls file">scrolls/notes.txt</div>
    <div class = "scrolls file">scrolls/mbk.txt</div>
    <div class = "scrolls file">scrolls/vibrotron.txt</div>
    <div class = "scrolls file">scrolls/chaosotron.txt</div>
    <div class = "scrolls file">scrolls/ambrosia.txt</div>
    <div class = "scrolls file">scrolls/book.txt</div>
    <div class = "scrolls file">scrolls/webpage.txt</div>

</div>
<textarea id = "texbox"></textarea>

<script>
texmode = true;
currentFile = "scrolls/main.txt";
fileBase = currentFile.split("/")[1].split(".")[0];

var httpc = new XMLHttpRequest();
httpc.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        filedata = this.responseText;
        editor.setValue(filedata);
        document.getElementById("scrolldisplay").innerHTML = filedata;
                if(texmode){
                    MathJax.Hub.Typeset();//tell Mathjax to update the math                    
                }
    }
};
httpc.open("GET", "fileloader.php?filename=" + currentFile, true);
httpc.send();
files = document.getElementById("filescroll").getElementsByClassName("file");
for(var index = 0;index < files.length;index++){
    files[index].onclick = function(){
        currentFile = this.innerHTML;
        fileBase = currentFile.split("/")[1].split(".")[0];

        //use php script to load current file;
        var httpc = new XMLHttpRequest();
        httpc.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                filedata = this.responseText;
                editor.setValue(filedata);
                var fileType = currentFile.split("/")[0]; 
                var fileName = currentFile.split("/")[1];
                if(fileType == "scrolls"){
                    document.getElementById("scrolldisplay").innerHTML = editor.getSession().getValue();
                }
            }
        };
        httpc.open("GET", "fileloader.php?filename=" + currentFile, true);
        httpc.send();
        if(this.classList[0] == "css"){
            editor.getSession().setMode("ace/mode/css");
            document.getElementById("namediv").style.color = "yellow";
            document.getElementById("namediv").style.borderColor = "yellow";
        }
        if(this.classList[0] == "html"){
            editor.getSession().setMode("ace/mode/html");
            document.getElementById("namediv").style.color = "#0000ff";
            document.getElementById("namediv").style.borderColor = "#0000ff";
        }
        if(this.classList[0] == "scrolls"){
            editor.getSession().setMode("ace/mode/html");
            document.getElementById("namediv").style.color = "#87CEEB";
            document.getElementById("namediv").style.borderColor = "#87CEEB";
        }
        if(this.classList[0] == "javascript"){
            editor.getSession().setMode("ace/mode/javascript");
            document.getElementById("namediv").style.color = "#ff0000";
            document.getElementById("namediv").style.borderColor = "#ff0000";
        }
        if(this.classList[0] == "bytecode"){
            editor.getSession().setMode("ace/mode/text");
            document.getElementById("namediv").style.color = "#654321";
            document.getElementById("namediv").style.borderColor = "#654321";
        }
        if(this.classList[0] == "php"){
            editor.getSession().setMode("ace/mode/php");
            document.getElementById("namediv").style.color = "#800080";
            document.getElementById("namediv").style.borderColor = "#800080";
        }
        if(this.classList[0] == "json"){
            editor.getSession().setMode("ace/mode/json");
            document.getElementById("namediv").style.color = "orange";
            document.getElementById("namediv").style.borderColor = "orange";
        }

        document.getElementById("namediv").innerHTML = currentFile;
    }
}
document.getElementById("namediv").innerHTML = currentFile;
document.getElementById("namediv").style.color = "#0000ff";
document.getElementById("namediv").style.borderColor = "#0000ff";

editor = ace.edit("maineditor");
editor.setTheme("ace/theme/cobalt");
editor.getSession().setMode("ace/mode/html");
editor.getSession().setUseWrapMode(true);
editor.$blockScrolling = Infinity;

document.getElementById("maineditor").onkeyup = function(){
    data = encodeURIComponent(editor.getSession().getValue());
    var httpc = new XMLHttpRequest();
    var url = "filesaver.php";        
    httpc.open("POST", url, true);
    httpc.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8");
    httpc.send("data="+data+"&filename="+currentFile);//send text to filesaver.php
    var fileType = currentFile.split("/")[0]; 
    var fileName = currentFile.split("/")[1];
    if(fileType == "scrolls"){
        document.getElementById("scrolldisplay").innerHTML = editor.getSession().getValue();
        if(texmode){
            MathJax.Hub.Typeset();//tell Mathjax to update the math   
        }
    }
}


buttons = document.getElementsByClassName("button");

buttons[0].onclick = function(){
    var figtext = "<figure>\n<img src = \"\"/><!--img-->\n<figcaption>Figure x. </figcaption>\n</figure>\n";
        var cursorPosition = editor.getCursorPosition();
        editor.getSession().insert(cursorPosition,figtext);
}

buttons[1].onclick = function(){
    html2tex();    
    //save this file to latex subdirectory
    
    data = encodeURIComponent(document.getElementById("texbox").value);
    var httpc = new XMLHttpRequest();
    var url = "filesaver.php";        
    httpc.open("POST", url, true);
    httpc.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8");
    httpc.send("data="+data+"&filename="+"latex/" + fileBase + ".tex");//send text to filesaver.php
    
}
function html2tex(){
        var textin = editor.getSession().getValue();
    textout = "\n\\documentclass[11pt]{article}\n\\usepackage{graphicx}\n\\begin{document}\n";
    textout += textin;
    textout = textout.replace(/<p>/g,"\n\n");
    textout = textout.replace(/<\/p>/g,"");
    textout = textout.replace(/<h2>/g,"\n\\section{\n");
    textout = textout.replace(/<\/h2>/g,"}");
    textout = textout.replace(/<figure>/g,"\n\\begin{figure}");
    textout = textout.replace(/<\/figure>/g,"\\end{figure}\n");
    textout = textout.replace(/<figcaption>/g,"\\caption{");
    textout = textout.replace(/<\/figcaption>/g,"\}");
    textout = textout.replace(/<img src = "/g,"\n\\includegraphics[width=\\linewidth]{../");
    textout = textout.replace(/"\/><!--img-->/g,"\}\n");
    
    textout+= "\n\\end{document}\n";
    document.getElementById("texbox").value = textout;
}
</script>
<style>
#texbox{
    position:absolute;
    top:32%;
    right:0%;
    height:5%;
    width:23%;
    font-family:courier;
    font-size:18px;
    display:block;
}
#namediv{
    position:absolute;
    top:5px;
    left:20%;
    font-family:courier;
    padding:0.5em 0.5em 0.5em 0.5em;
    border:solid;
    background-color:#101010;

}
a{
    color:white;
    display:block;
    margin-bottom:0.5em;
    margin-left:0.5em;
}
body{
    background-color:#404040;
}
.html{
    color:#0000ff;
}
.css{
    color:yellow;
}
.php{
    color:#800080;
}
.javascript{
    color:#ff0000;
}
.bytecode{
    color:#654321;
}
.json{
    color:orange;
}
.scrolls{
    color:#87ceeb;
}

.file{
    cursor:pointer;
    border-radius:0.25em;
    border:solid;
    padding:0.25em 0.25em 0.25em 0.25em;
}
.files:hover{
    background-color:green;
}
.files:active{
    background-color:yellow;
}
#filescroll{
    position:absolute;
    overflow:scroll;
    top:50%;
    bottom:0%;
    right:0%;
    left:77%;
    border:solid;
    border-radius:5px;
    border-width:3px;
    background-color:#101010;
    font-family:courier;
    font-size:18px;
}
#linkscroll{
    position:absolute;
    overflow:scroll;
    top:0%;
    bottom:70%;
    right:0%;
    left:77%;
    border:solid;
    border-radius:5px;
    border-width:3px;
    background-color:#101010;
    font-family:courier;
    font-size:18px;
}
#maineditor{
    position:absolute;
    left:41%;
    top:5em;
    bottom:10px;
    right:25%;
}
#scrolldisplay{
    position:absolute;
    background-color:white;
    overflow:scroll;
    color:black;
    left:10px;
    bottom:10px;
    right:60%;
    top:5em;
    border:solid;
    border-width:3px;
    border-radius:0.5em;
    padding:1.5em 1.5em 1.5em 1.5em;
}
#scrolldisplay p,li,pre{
    width:80%;
    display:block;
    margin:auto;
    text-align:justify;    
    margin-bottom:1em;
}
#scrolldisplay h1,h2,h3{
    text-align:center;
}
#scrolldisplay a{
    color:blue;
    display:inline;

}

figure img{
    width:100%;
}
figure{
    width:80%;
}
figure figcaption{
    width:100%;
}
.button{
    color:yellow;
    cursor:pointer;
    padding:0.5em 0.5em 0.5em 0.5em;
    border:solid;
    border-color:yellow;
    border-radius:0.5em;
    margin-bottom:1em;
    margin-left:0.5em;
    margin-top:1em;
    display:block;
    margin:auto;
    text-align:center;
    width:80%;
}
.button:hover{
    background-color:#003000;
}   
.button:active{
    background-color:#304000;
}


</style>

</body>
</html>