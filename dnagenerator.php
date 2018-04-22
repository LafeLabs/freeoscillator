<?php

$files = scandir(getcwd());

$outstring = "[\n";

foreach($files as $value){
    if($value != "." && $value != ".."){
        if(is_dir($value)){
            $subfiles = scandir(getcwd()."/".$value);
            foreach($subfiles as $subvalue){
                    if(substr($subvalue,-4) == ".txt"){
                        $outstring .= "\"".$value."/".$subvalue."\",\n";
                    }
            }
        }
    }
}
$outstring = substr($outstring,0,-2);
$outstring .= "\n]";

echo $outstring;

$file = fopen("json/dna.txt","w");// create new file with this name
fwrite($file,$outstring); //write data to file
fclose($file);  //close file

?>
<a href = "editor.php">editor.php</a>