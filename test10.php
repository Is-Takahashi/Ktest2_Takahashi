<table border="1">
<?php

/**データベース情報の読み込み。$SERVとか$DBNMの変数に情報を格納する */
require_once('test6_data/test6_db_data.php');

/**データベース接続 */
$s=new pdo("mysql:host=$SERV;dbname=$DBNM",$USER,$PASS);

$cardpool;
$Adeck;
$Bdeck;
$Cdeck;
$Apoint = 0;
$Bpoint = 0;
$Cpoint = 0;
$gamecount;

//1~13のカードを4枚ずつ配列に加えて、トランプを構成する
for ($i=1; $i<=13; $i++){
    for($j=1; $j<=4; $j++){
        $cardpool[] = $i;
    }
}

//トランプの束をシャッフル
shuffle($cardpool);
//束の上からカードを17枚とって、Aに渡す
for ($i=1; $i<=17; $i++){
    $Adeck[]=array_shift($cardpool);
    $cardpool=array_values($cardpool);
}
//束の上からカードを17枚とって、Bに渡す
for ($i=1; $i<=17; $i++){
    $Bdeck[]=array_shift($cardpool);
    $cardpool=array_values($cardpool);
}
//束の上からカードを17枚とって、Cに渡す
for ($i=1; $i<=17; $i++){
    $Cdeck[]=array_shift($cardpool);
    $cardpool=array_values($cardpool);
}


//ここまでカードの分配。ここからゲームスタート

print "<tr>";
print "<td>回数</td>";
print "<td>Aのカード</td>";
print "<td>Bのカード</td>";
print "<td>Cのカード</td>";
print "<td>勝敗</td>";
print "<td>Aの得点</td>";
print "<td>Bの得点</td>";
print "<td>Cの得点</td>";
print "</tr>";

//配られた順にカードを出すので、それぞれのプレイヤーのカードが収められている配列を
//順番に確認していく
for ($i=0; $i<=16; $i++){
    $gamecount++;

    print "<tr>";
    print "<td>" . $gamecount . "回目</td>";
    print "<td>" . $Adeck[$i] . "</td>";
    print "<td>" . $Bdeck[$i] . "</td>";
    print "<td>" . $Cdeck[$i] . "</td>";

    //勝敗の判定と表への追記
    if ($Adeck[$i] == $Bdeck[$i] && $Bdeck[$i] == $Cdeck[$i]){
        print "<td>3人とも同じ値</td>";
        $Apoint++;
        $Bpoint++;
        $Cpoint++;
    }else if($Adeck[$i] > $Bdeck[$i] && $Adeck[$i] > $Cdeck[$i]) {
        print "<td>Aが一人勝ち</td>";
        $Apoint += 3;
    }else if($Adeck[$i] == $Bdeck[$i] && $Adeck[$i] > $Cdeck[$i]) {
        print "<td>AとBが勝ち</td>";
        $Apoint += 2;
        $Bpoint += 2;
    }else if($Adeck[$i] == $Cdeck[$i] && $Adeck[$i] > $Bdeck[$i]) {
        print "<td>AとCが勝ち</td>";
        $Apoint += 2;
        $Cpoint += 2;
    }else if($Bdeck[$i] > $Adeck[$i] && $Bdeck[$i] > $Cdeck[$i]) {
        print "<td>Bが一人勝ち</td>";
        $Bpoint += 3;
    }else if($Bdeck[$i] == $Cdeck[$i] && $Bdeck[$i] > $Adeck[$i]) {
        print "<td>BとCが勝ち</td>";
        $Bpoint += 2;
        $Cpoint += 2;
    }else if($Cdeck[$i] > $Adeck[$i] && $Cdeck[$i] > $Bdeck[$i]) {
        print "<td>Cが一人勝ち</td>";
        $Cpoint += 3;
    }

    print "<td>" . $Apoint . "</td>";
    print "<td>" . $Bpoint . "</td>";
    print "<td>" . $Cpoint . "</td>";
    print "</tr>";
    
}

?>
</table>

<?php
//最後に総得点を表の下に表示
print "<br>";
print "Aの総得点:" . $Apoint . "点<br>";
print "Bの総得点:" . $Bpoint . "点<br>";
print "Cの総得点:" . $Cpoint . "点<br>";

//今回の最終獲得得点をDBに記録
//$s->query("insert into test10_point4(A_point,B_point,C_point)values('$Apoint','$Bpoint','$Cpoint')");