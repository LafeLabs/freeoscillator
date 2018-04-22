<?php
/*
scrolls2index.php
convert all the scrolls other than main, notes, and replicator into their own directories
get all the files in scrolls/ directory.  for each file that is NOT main, notes or repicator, test to see if /scrolls/[filename-.txt] exists. if not, mkdir that directory.
splice scroll into index.html template, write to /scrolls/[dir]/index.html


*/

$indexfull = file_get_contents("html/index.txt");
$indextop = explode("<!--main.txt-->",$indexfull)[0];
$indexbottom = explode("<!--main.txt-->",$indexfull)[1];

$files = scandir(getcwd()."/scrolls/");

foreach($files as $value){
    if($value != "." && $value != ".."){
        if(substr($value,-4) == ".txt"){
            if($value != "main.txt" && $value != "replicator.txt" && $value != "notes.txt"){
                $newdirname =  substr($value,0,-4);
                mkdir(getcwd()."/scrolls/".$newdirname);    
                $scrolldata = file_get_contents(getcwd()."/scrolls/".$value);
                $localindex = $indextop.$scrolldata.$indexbottom;
                $file = fopen(getcwd()."/scrolls/".$newdirname."/index.html","w");// create new file with this name
                fwrite($file,$localindex); //write data to file
                fclose($file);  //close file
            }
        }
    }
}

//echo $outstring;

?>
<a href = "editor.php" style = "font-size:4em;">editor.php</a>