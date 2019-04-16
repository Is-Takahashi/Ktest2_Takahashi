<!DOCTYPE html>
<html lang="ja">
<head>
<title>確認テスト2の2問目</title>
</head>
<body>

<?php
//URLのGETパラメータから値を受け取るので、このファイルをブラウザ上で見るときは、p1とp2の値をURLで指定すること。
//つまり、URLの後ろに「?p1=1&p2=2」のように書き加える。

//まずはGETで受け取った値を変数に格納
$par1 = $_GET['p1'];
$par2 = $_GET['p2'];

//GETで受けとった値が整数の形式かどうか確認
if (ctype_digit($par1) == false){
    print 'p1は整数じゃないみたいです……0に変更します<br>';
    $par1 = 0;
}
if (ctype_digit($par2) == false){
    print 'p2は整数じゃないみたいです……0に変更します<br>';
    $par2 = 0;
}

//GETで受け取った値をint型に変換
$par1 = intval($par1);
$par2 = intval($par2);

//受け取った値を足し合わせて表示
print 'p1が' . $par1 . 'で、p2が' . $par2 . '<br>';
$sum = $par1 + $par2;
print 'あわせて' . $sum ;
?>

</body>
</html>