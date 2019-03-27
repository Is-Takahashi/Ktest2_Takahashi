<table border="1">
<?php

/**データベース情報の読み込み。$SERVとか$DBNMの変数に情報を格納する */
require_once('test6_data/test6_db_data.php');

/**データベース接続 */
$s=new pdo("mysql:host=$SERV;dbname=$DBNM",$USER,$PASS);


$cardpool;
$memory;
$Adeck;
$Bdeck;
$Cdeck;
$Apoint = 0;
$Bpoint = 0;
$Cpoint = 0;
$gamecount;
$Acecard;
$Aselect;
$Aselectkey;
$Nsearch;
$derurituSYO;
$derurituTYU;
$derurituDAI;

for($i=1;$i<=13;$i++){
    for($j=1;$j<=4;$j++){
        $cardpool[] = $i;
        $memory[] = $i;
    }
}

//52枚だと3人で分割する時に1枚あまるので、最初に1枚除外
$remove = rand(0,51);
unset($cardpool[$remove]);
$cardpool = array_values($cardpool);
unset($memory[$remove]);
$memory = array_values($memory);
//var_dump($memory);

for($i=1; $i<=17; $i++){  //Aにカードを17枚渡す
    $set = rand(0,51-$i);

    $Adeck[]=$cardpool[$set];
    unset($cardpool[$set]);
    $cardpool=array_values($cardpool);
    unset($memory[$set]);
    $memory = array_values($memory);
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

sort($Adeck);  //Aの持つカードを昇順に並べ替え

for($i=0;$i<=16;$i++){
    $gamecount++;


    //ここからAのカードの出し方を考える

    $derurituSYO = 0;
    $derurituTYU = 0;
    $derurituDAI = 0;

    for($j=1;$j<=13;$j++){
        foreach($memory as $Nsearch){  //残りのカードのうち、「1~4」「5~9」「10~13」が一番多いか
            if($Nsearch == $j){
                if($Nsearch >= 1 && $Nsearch <=4){
                    $derurituSYO++;
                }elseif($Nsearch >= 5 && $Nsearch <=9){
                    $derurituTYU++;
                }else{
                    $derurituDAI++;
                }
            }
        }
    }

    //出てくる可能性のあるカードのうち、「小(1~4)」「中(5~9)」「大(10~13)」のどれが一番多いかによって、
    //自分が出したい数値を決定する
    if($derurituSYO > $derurituTYU && $derurituSYO > $derurituDAI) {
        $Acecard = 5;
    }elseif($derurituSYO == $derurituTYU && $derurituSYO > $derurituDAI) {
        $Acecard = 10;
    }elseif($derurituSYO == $derurituDAI && $derurituSYO > $derurituTYU) {
        $Acecard = 10;
    }elseif($derurituTYU > $derurituSYO && $derurituTYU > $derurituDAI) {
        $Acecard = 10;
    }elseif($derurituTYU == $derurituDAI && $derurituTYU > $derurituSYO) {
        $Acecard = 1;
    }elseif($derurituDAI > $derurituSYO && $derurituDAI > $derurituSYO) {
        $Acecard = 1;
    }else{
        $Acecard = 7;
    }

    $Aselectkey = array_search($Acecard,$Adeck);

    if($Aselectkey===false){
        while($Aselectkey===false){  //出したい数値が手札にない時、カードを手札のうちから選ぶため、出したい数値から1大きく設定する
            $Acecard++;
            $Aselectkey = array_search($Acecard,$Adeck);
            
            if($Acecard>13){  //出したい数値より小さいカードしか手札にない場合、手札の最小数値のカードを出す
                sort($Adeck);
                $Aselectkey = 0;
                break;
            }
        }
    }

    $Aselect = $Adeck[$Aselectkey];  //カード決定、手札から抜き出して場に伏せる
    unset($Adeck[$Aselectkey]);
    $Adeck = array_values($Adeck);


    //ここまでAのカードの出し方、ここから勝敗の判定と表への追記

    print "<tr>";
    print "<td>" . $gamecount . "回目</td>";
    print "<td>" . $Aselect . "</td>";
    print "<td>" . $Bdeck[$i] . "</td>";
    print "<td>" . $Cdeck[$i] . "</td>";

    if($Aselect == $Bdeck[$i] && $Bdeck[$i] == $Cdeck[$i]){
        print "<td>3人とも同じ値</td>";
        $Apoint++;
        $Bpoint++;
        $Cpoint++;
    }elseif($Aselect > $Bdeck[$i] && $Aselect > $Cdeck[$i]) {
        print "<td>Aが一人勝ち</td>";
        $Apoint += 3;
    }elseif($Aselect == $Bdeck[$i] && $Aselect > $Cdeck[$i]) {
        print "<td>AとBが勝ち</td>";
        $Apoint += 2;
        $Bpoint += 2;
    }elseif($Aselect == $Cdeck[$i] && $Aselect > $Bdeck[$i]) {
        print "<td>AとCが勝ち</td>";
        $Apoint += 2;
        $Cpoint += 2;
    }elseif($Bdeck[$i] > $Aselect && $Bdeck[$i] > $Cdeck[$i]) {
        print "<td>Bが一人勝ち</td>";
        $Bpoint += 3;
    }elseif($Bdeck[$i] == $Cdeck[$i] && $Bdeck[$i] > $Aselect) {
        print "<td>BとCが勝ち</td>";
        $Bpoint += 2;
        $Cpoint += 2;
    }elseif($Cdeck[$i] > $Aselect && $Cdeck[$i] > $Bdeck[$i]) {
        print "<td>Cが一人勝ち</td>";
        $Cpoint += 3;
    }

    $delBcard = array_search($Bdeck[$i],$memory);  //BとCの今使ったカードを、「まだ出ていないカード群」から除外
    unset($memory[$delBcard]);
    $delCcard = array_search($Cdeck[$i],$memory);
    unset($memory[$delCcard]);
    $memory = array_values($memory);
    rsort($memory);

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


//今回のゲームの最終獲得得点をDBに記録
//$s->query("insert into test10_point9(A_point,B_point,C_point)values('$Apoint','$Bpoint','$Cpoint')");
