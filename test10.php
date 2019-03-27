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


for($i=1;$i<=13;$i++){
    for($j=1;$j<=4;$j++){
        $cardpool[] = $i;
    }
}

//52枚だと3人で分割する時に1枚あまるので、最初に1枚除外
$remove = rand(0,51);
unset($cardpool[$remove]);
$cardpool = array_values($cardpool);

for($i=1; $i<=17; $i++){  //Aにカードを17枚渡す
    $set = rand(0,51-$i);

    $Adeck[]=$cardpool[$set];
    unset($cardpool[$set]);
    $cardpool=array_values($cardpool);
}

for($i=1; $i<=17; $i++){  //Bにカードを17枚渡す
    $set = rand(0,34-$i);

    $Bdeck[]=$cardpool[$set];
    unset($cardpool[$set]);
    $cardpool=array_values($cardpool);
}

for($i=1; $i<=17; $i++){   //Cにカードを17枚渡す
    $set = rand(0,17-$i);

    $Cdeck[]=$cardpool[$set];
    unset($cardpool[$set]);
    $cardpool=array_values($cardpool);
}

$s->query("delete from test10");

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


for($i=0;$i<=16;$i++){ //配られた順にカードを出すので、配列を順番に確認していく
    $gamecount++;

    print "<tr>";
    print "<td>" . $gamecount . "回目</td>";
    print "<td>" . $Adeck[$i] . "</td>";
    print "<td>" . $Bdeck[$i] . "</td>";
    print "<td>" . $Cdeck[$i] . "</td>";

    if($Adeck[$i] == $Bdeck[$i] && $Bdeck[$i] == $Cdeck[$i]){   //勝敗の判定と表への追記
        print "<td>3人とも同じ値</td>";
        $Apoint++;
        $Bpoint++;
        $Cpoint++;
    }elseif($Adeck[$i] > $Bdeck[$i] && $Adeck[$i] > $Cdeck[$i]) {
        print "<td>Aが一人勝ち</td>";
        $Apoint += 3;
    }elseif($Adeck[$i] == $Bdeck[$i] && $Adeck[$i] > $Cdeck[$i]) {
        print "<td>AとBが勝ち</td>";
        $Apoint += 2;
        $Bpoint += 2;
    }elseif($Adeck[$i] == $Cdeck[$i] && $Adeck[$i] > $Bdeck[$i]) {
        print "<td>AとCが勝ち</td>";
        $Apoint += 2;
        $Cpoint += 2;
    }elseif($Bdeck[$i] > $Adeck[$i] && $Bdeck[$i] > $Cdeck[$i]) {
        print "<td>Bが一人勝ち</td>";
        $Bpoint += 3;
    }elseif($Bdeck[$i] == $Cdeck[$i] && $Bdeck[$i] > $Adeck[$i]) {
        print "<td>BとCが勝ち</td>";
        $Bpoint += 2;
        $Cpoint += 2;
    }elseif($Cdeck[$i] > $Adeck[$i] && $Cdeck[$i] > $Bdeck[$i]) {
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
print "<br>";
print "Aの総得点:" . $Apoint . "点<br>";
print "Bの総得点:" . $Bpoint . "点<br>";
print "Cの総得点:" . $Cpoint . "点<br>";

//今回の最終獲得得点をDBに記録
//$s->query("insert into test10_point4(A_point,B_point,C_point)values('$Apoint','$Bpoint','$Cpoint')");