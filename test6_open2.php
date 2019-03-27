<?php

/**データベース情報の読み込み。$SERVとか$DBNMの変数に情報を格納する */
require_once("test6_data/test6_db_data.php");

/**データベース接続 */
$s=new pdo("mysql:host=$SERV;dbname=$DBNM",$USER,$PASS);

$re=$s->query("select * from test6 order by nitiji desc limit 100 into outfile '/var/www/html/0307_Ktest2/0319exporttest2.csv'");

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"0319exporttest2.csv\"");
header("Content-Length: " . filesize("/var/www/html/0307_Ktest2/0319exporttest2.csv"));
readfile("/var/www/html/0307_Ktest2/0319exporttest2.csv");
exit;

while ($kekka=$re->fetch()) {
    print $kekka[0];
    print ':';
    print $kekka[1];
    print '<br>';
}
?>