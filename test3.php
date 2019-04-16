<?php

//前回ログインした時間のタイムスタンプをpasttimeに格納
$pasttime = $_COOKIE['past'];
//今の時間のタイムスタンプをnowtimeに格納
$nowtime = time();
//ついでに今の時間のタイムスタンプをcookieに記録しておく(次回アクセス時に参考にするため)
setcookie('past',$nowtime,time()+60*60*24);
//タイムスタンプが整数であるか確認。
//改ざんされて整数でなくなった場合、時間切れでcookieからデータが消えた場合は0に設定する
if (ctype_digit($pasttime) == false){
    print '前回のログイン時間を忘れちゃいました……0に変更します<br>';
    $pasttime = 0;
}
//前回と今回のアクセスの時間差がaccessに格納される
$access = $nowtime - $pasttime;
//秒を計算
$sec = $access % 60;
//分を計算
//(ただしこの時点では60分以上でもそのまま表示してしまうので132分とか出てしまう)
$min = ($access-$sec) / 60;
//一旦「分」は置いといて時間を計算。
//分と秒をあわせた数字を引いた後、1時間=3600秒で割る。
//小数点以下は不要なので切り捨てる。
$hou = floor(($access - $min - $sec) / 3600);
//分を1時間以内に収めるために剰余を求める。
if ($min >= 60){
    $min = $min % 60;
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
if ($pasttime == 0){
    ?>
    えっと……はじめてのアクセスですね！<br>
    <?php
} else if($pasttime != 0){
    ?>
    えーっと……前回のアクセスは<?=$hou?>時間<?=$min?>分<?=$sec?>秒前でしたよ！
    <?php
}
?>

</body>
</html>