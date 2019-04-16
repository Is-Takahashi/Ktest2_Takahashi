<?php
//読み込むファイルの指定
$filename='tekitou.txt';
if(is_readable($filename)){
    //ファイルの読み込み
    $contents = file_get_contents($filename);
    //文字エンコードの変更
    $contents = mb_convert_encoding($contents,'UTF-8','auto');
    //<>とか""とかの特殊な文字の無効化
    $contents = htmlspecialchars($contents);
    //改行を含めつつ画面に出力
    print nl2br($contents);
}else if(is_readable($filename) == false){
    print $filename . 'は読めませんでした……';
}