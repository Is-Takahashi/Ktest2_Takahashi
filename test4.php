<?php
$filename='tekitou.txt';
if(is_readable($filename)){
    $contents = file_get_contents($filename);
    print nl2br($contents);
}else{
    print $filename . 'は読めませんでした……';
}