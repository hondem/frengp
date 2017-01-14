<?php

$dir = $_GET['dir'];
$scan = scandir($dir);
$files = [];

foreach($scan as $file){
    if(is_file($dir . $file)){
        $files[] = $file;
    }
}

$outputstring = "";
foreach($files as $file){
    $outputstring .= "<p><a title='" . $file . "' href='" . $dir . $file . "'>" . $file . "</a></p>";
}

print_r(htmlspecialchars($outputstring));
?>
