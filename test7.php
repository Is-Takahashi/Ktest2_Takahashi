<table border="1">
<?php
$a = 0;
$b = 0;
$x = array('A','B','C','D','E','F','G','H','I');
$base1 = array('A','B','C','D','E','F','G','H','I');

//以下、対戦表の表
//まずは表の外枠を作成
for ($a; $a <= 9; $a++){
    echo '<tr>';
    if ($a == 0){
        for ($b; $b <= 9; $b++){
            if ($b == 0) {
                echo '<td>  </td>';
            } else if ($b != 0) {
                echo '<td>'.$x[$b-1].'</td>';
            }
        }
        
    //次に表内部の、各項目に書く対戦カード、あるいは対戦しない事を示す灰色の表示
    }else if ($a != 0){
        for ($b = 0; $b <= 9; $b++){
            if ($b == 0){
                echo '<td width="30">'.$x[$a-1].'</td>';
            }else if ($b != 0){
                if ($a >= $b){
                    echo '<td width="30" bgcolor="gray">  </td>';
                }else if ($a < $b){
                    echo '<td>'.$x[$a-1].'×'.$x[$b-1].'</td>';
                }
            }
        }
    }
    echo '</tr>';
}


?>
</table>

<?php
//1回戦目

print '1回戦';
print '<br>';

//1回戦はランダムにチーム名を配列に入れて、2チームずつ取り出して対戦してもらう
for ($c = 0; $c <= 8; $c++){
    $vs1 = rand(0,8-$c);
    $match1[]=$base1[$vs1];
    unset($base1[$vs1]);
    $base1=array_values($base1);
}

//2チームずつ表示して対戦カードの発表
for ($game = 0; $game <= 3; $game++){
    print $match1[$game * 2].'×'.$match1[$game * 2 + 1];
    print '<br>';
}


//2回戦目

print '<br>';
print '2回戦';
print '<br>';

//2回戦では、まず1回戦で不戦勝だったチーム(つまり配列の最後尾)を取り出して、
//2回戦の配列の一番最初に加える
$match2[] = array_pop($match1);

$teamcount = count($match1);
//2チーム目以降は1回戦で使った配列の順に取り出して、2回戦の配列に加えていく
//(1チーム先に入れたことで対戦カードはズレるので、対戦相手は被らない)

//i=0からi=9まで、合計8回ループして、残りのチームを配列に加える
for ($i = 0; $i < $teamcount; $i++){
    $match2[] = array_shift($match1);
}

//2チームずつ表示して対戦カードの発表
for ($game = 0;$game <= 3;$game++){
    print $match2[$game * 2].'×'.$match2[$game * 2 + 1];
    print '<br>';
}


//3回戦目

print '<br>';
print '3回戦';
print '<br>';

//まず2回戦で不戦勝だったチームを配列に加える
$match3[] = array_pop($match2);

$teamcount = count($match2);
$halfteamcount = ceil($teamcount / 2);
//2回戦目と同じ方法でチームを並べると、3回戦の対戦カードが1回戦とほぼ同じになってしまう
//なので、3回戦では、まず2回戦の配列の0、2、4、6のキーに該当するチームを取り出す
for ($i = 0; $i < $halfteamcount; $i++){
    $match3[] = $match2[$i*2];
    unset($match2[$i*2]);
}
$match2=array_values($match2);

//その後、2回戦の配列の1、3、5のキーに該当するチームを取り出す
$teamcount = count($match2);
for ($i = 0; $i < $teamcount; $i++){
    $match3[] = array_shift($match2);
}

//2チームずつ表示して対戦カードの発表
for ($game = 0;$game <= 3;$game++){
    print $match3[$game * 2].'×'.$match3[$game * 2 + 1];
    print '<br>';
}
