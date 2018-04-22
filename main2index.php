<?php
$blankindex = file_get_contents("html/index.txt");
$maintext = file_get_contents("scrolls/main.txt");
$indextop = explode("<!--main.txt-->",$blankindex)[0];
$indexbottom = explode("<!--main.txt-->",$blankindex)[1];
$fullindex = $indextop.$maintext.$indexbottom;
$data = $fullindex;

$filename = "index.html";
$file = fopen($filename,"w");// create new file with this name
fwrite($file,$data); //write data to file
fclose($file);  //close file

?><a style = "font-size:10em;" href = "index.html">index.html</a>