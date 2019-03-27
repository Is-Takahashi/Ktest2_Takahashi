<!DOCTYPE html>
<html lang="ja">
<head>
<title>確認テスト2の2問目</title>
</head>
<body>

<?php
//URLのGETパラメータから値を受け取るので、このファイルをブラウザ上で見るときは、p1とp2の値をURLで指定すること。
//つまり、URLの後ろに「?p1=1&p2=2」のように書き加える。
print 'p1が' . $_GET['p1'] . 'で、p2が' . $_GET['p2'] . '<br>';
$sum= $_GET['p1'] + $_GET['p2'];
print 'あわせて' . $sum ;
?>

</body>
</html>