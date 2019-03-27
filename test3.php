<?php

$pasttime = $_COOKIE['past'];
$nowtime = time();
setcookie('past',$nowtime,time()+60*60*24);
$access = $nowtime - $pasttime;
$sec = $access % 60;   //秒を計算
$min = ($access-$sec)/60;  //分を計算(ただしこの時点では60分以上でもそのまま表示してしまうので132分とか出ちゃう)
$hou = floor(($access - $min - $sec)/3600);  //一旦「分」は置いといて時間を計算。分と秒をあわせた数字を引いた後、1時間=3600秒で割る。小数点以下は不要なので切り捨てる。
if($min>=60){
    $min= $min % 60;  //分を1時間以内に収めるために剰余を求める。
}

?>
<!DOCTYPE html>
<html lang='ja'>
<head>
<meta charset='UTF-8'>
<title>確認テスト3</title>
</head>
<body>
前回このページにアクセスしたのがどのくらい前なのかわかりますよー<br>
<br>
<?php
if($pasttime==0){
    ?>
    えっと……はじめてのアクセスですね！<br>
    <?php
}else{
    ?>
    えーっと……前回のアクセスは<?=$hou?>時間<?=$min?>分<?=$sec?>秒前でしたよ！
    <?php
}
?>

</body>
</html>