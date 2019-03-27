<?php

/**データベース情報の読み込み。$SERVとか$DBNMの変数に情報を格納する */
require_once('test6_data/test6_db_data.php');

/**データベース接続 */
$s=new pdo("mysql:host=$SERV;dbname=$DBNM",$USER,$PASS);

$moji_d=$_POST['moji'];
$s->query("insert into test6 values ('$moji_d',now())");
$re=$s->query('select * from test6 order by nitiji desc limit 100');

while ($kekka=$re->fetch()) {
    print $kekka[0];
    print ':';
    print $kekka[1];
    print '<br>';
}
?>