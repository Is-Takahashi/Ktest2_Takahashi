<?php

//データベース情報の読み込み。$SERVとか$DBNMの変数に情報を格納する
require_once("test6_data/test6_db_data.php");

//データベース接続
$s=new pdo("mysql:host=$SERV;dbname=$DBNM",$USER,$PASS);

//sql文の実行。DB内のデータを日付順で表示。
$re=$s->query("select * from test6 order by nitiji desc limit 100");

//表示内容をcsvファイルとしてダウンロードするため、ファイルの形式や名前を指定
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=\"test6resultfile.csv\"");

//文字コードをSJISに変更しつつ、sql文で取得したDB内の情報を表示
//このファイル内のprintやechoの出力先は、先ほど名前を決めたファイルの中になる
while ($kekka=$re->fetch()) {
    //SJISに文字コードを変更しつつ出力
    echo mb_convert_encoding($kekka[0], "SJIS", "auto");
    echo ':';
    echo mb_convert_encoding($kekka[1], "SJIS", "auto");
    echo "\r";
}

exit;

?>