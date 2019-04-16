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
$ariaS;
$ariaM;
$ariaB;

//1~13のカードを4枚ずつ配列に加えて、トランプを構成する
for ($i=1; $i<=13; $i++){
    for ($j=1; $j<=4; $j++){
        $cardpool[] = $i;
        $memory[] = $i;
    }
}

//トランプの束をシャッフル
shuffle($cardpool);

//束の上からカードを17枚とって、Aに渡す
for ($i=1; $i<=17; $i++){
    $Adeck[]=array_shift($cardpool);
    $cardpool=array_values($cardpool);

    //Aの手札に加わったカードを、「まだ出ていないカード群」から除外
    $delAcard = array_search(end($Adeck),$memory);
    
    unset($memory[$delAcard]);
    $memory = array_values($memory);
    rsort($memory);
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

//Aの持つカードを昇順に並べ替え
sort($Adeck);

for ($i=0; $i<=16; $i++){
    $gamecount++;

    //ここからAのカードの出し方を考える

    //ariaSは1~4の流通量
    $ariaS = 0;
    //ariaMは5~9の流通量
    $ariaM = 0;
    //ariaCは1~4の流通量
    $ariaB = 0;

    for ($j=1; $j<=13; $j++){
        //出る可能性のあるカードを、「1~4」「5~9」「10~13」の3つの群に分ける
        foreach ($memory as $Nsearch){
            if ($Nsearch == $j){
                if ($Nsearch >= 1 && $Nsearch <=4){
                    $ariaS++;
                }else if($Nsearch >= 5 && $Nsearch <=9){
                    $ariaM++;
                }else if($Nsearch >= 10){
                    $ariaB++;
                }
            }
        }
    }

    //出る可能性のあるカードのうち「S(1~4)」「M(5~9)」「B(10~13)」のどの群が一番多いかによって、
    //自分が出したい数値を決定する
    if ($ariaS > $ariaM && $ariaS > $ariaB) {
        $Acecard = 5;
    }else if($ariaS == $ariaM && $ariaS > $ariaB) {
        $Acecard = 10;
    }else if($ariaS == $ariaB && $ariaS > $ariaM) {
        $Acecard = 10;
    }else if($ariaM > $ariaS && $ariaM > $ariaB) {
        $Acecard = 10;
    }else if($ariaM == $ariaB && $ariaM > $ariaS) {
        $Acecard = 1;
    }else if($ariaB > $ariaS && $ariaB > $ariaS) {
        $Acecard = 1;
    }else if($ariaS == $ariaM && $ariaS == $ariaB){
        $Acecard = 7;
    }

    $Aselectkey = array_search($Acecard,$Adeck);

    if ($Aselectkey === false){
        //出したい数値が手札にない時、カードを手札のうちから選ぶため、出したい数値から1大きく設定する
        while ($Aselectkey === false){
            $Acecard++;
            $Aselectkey = array_search($Acecard,$Adeck);
            
            //出したい数値より小さいカードしか手札にない場合は手札の最小数値のカードを出す
            if ($Acecard > 13){
                sort($Adeck);
                $Aselectkey = 0;
                break;
            }
        }
    }

    //カード決定、手札から抜き出して場に伏せる
    $Aselect = $Adeck[$Aselectkey];
    unset($Adeck[$Aselectkey]);
    $Adeck = array_values($Adeck);

    //ここまでAのカードの出し方

    //BとCは配られた順のままカードを出すので、$Bdeck[$i]と$Cdeck[$i]で今回のカードが分かる
    //ここから勝敗の判定と表への追記

    print "<tr>";
    print "<td>" . $gamecount . "回目</td>";
    print "<td>" . $Aselect . "</td>";
    print "<td>" . $Bdeck[$i] . "</td>";
    print "<td>" . $Cdeck[$i] . "</td>";

    if ($Aselect == $Bdeck[$i] && $Bdeck[$i] == $Cdeck[$i]){
        print "<td>3人とも同じ値</td>";
        $Apoint++;
        $Bpoint++;
        $Cpoint++;
    }else if($Aselect > $Bdeck[$i] && $Aselect > $Cdeck[$i]) {
        print "<td>Aが一人勝ち</td>";
        $Apoint += 3;
    }else if($Aselect == $Bdeck[$i] && $Aselect > $Cdeck[$i]) {
        print "<td>AとBが勝ち</td>";
        $Apoint += 2;
        $Bpoint += 2;
    }else if($Aselect == $Cdeck[$i] && $Aselect > $Bdeck[$i]) {
        print "<td>AとCが勝ち</td>";
        $Apoint += 2;
        $Cpoint += 2;
    }else if($Bdeck[$i] > $Aselect && $Bdeck[$i] > $Cdeck[$i]) {
        print "<td>Bが一人勝ち</td>";
        $Bpoint += 3;
    }else if($Bdeck[$i] == $Cdeck[$i] && $Bdeck[$i] > $Aselect) {
        print "<td>BとCが勝ち</td>";
        $Bpoint += 2;
        $Cpoint += 2;
    }else if($Cdeck[$i] > $Aselect && $Cdeck[$i] > $Bdeck[$i]) {
        print "<td>Cが一人勝ち</td>";
        $Cpoint += 3;
    }

    //BとCの今使ったカードを、「まだ出ていないカード群」から除外
    $delBcard = array_search($Bdeck[$i],$memory);
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
//最後に総得点を表の下に表示
print "<br>";
print "Aの総得点:" . $Apoint . "点<br>";
print "Bの総得点:" . $Bpoint . "点<br>";
print "Cの総得点:" . $Cpoint . "点<br>";


//今回のゲームの最終獲得得点をDBに記録
//$s->query("insert into test10_point9(A_point,B_point,C_point)values('$Apoint','$Bpoint','$Cpoint')");
