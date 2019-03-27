<table border="1">
<?php
$a = 0;
$b = 0;
$x = array('A','B','C','D','E','F','G','H','I');
$base1 = array('A','B','C','D','E','F','G','H','I');
$base2 = array('A','B','C','D','E','F','G','H','I');
$base3 = array('A','B','C','D','E','F','G','H','I');
$num1 = array(0,1,2,3,4,5,6,7,8);
$num2 = array(0,1,2,3,4,5,6,7,8);
$num3 = array(0,1,2,3,4,5,6,7,8);
$record1;
$record2;

for($a; $a <= 9; $a++){
    echo '<tr>';
    if($a == 0){
        for($b; $b <= 9; $b++){
            if($b == 0){
                echo '<td>  </td>';
            }else{
                echo '<td>'.$x[$b-1].'</td>';
            }
        }
        
    }else{
        for($b = 0;$b <= 9; $b++){
            if($b == 0){
                echo '<td width="30">'.$x[$a-1].'</td>';
            }else{
                if($a >= $b){
                    echo '<td width="30" bgcolor="gray">  </td>';
                }else{
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

for($c = 0; $c <= 7; $c++){
    $vs1 = rand(0,8-$c);

    $match1[]=$base1[$vs1];
    unset($base1[$vs1]);
    $base1=array_values($base1);
    unset($num1[$vs1]);
    $num1=array_values($num1);
    
}

print '1回戦';
print '<br>';

for($game = 0;$game <= 3;$game++){
    $record1[] = $match1[$game * 2];
    $record1[] = $match1[$game * 2 + 1];
    print $match1[$game * 2].'×'.$match1[$game * 2 + 1];
    print '<br>';
}

$record1[] = $base1[0];  //不戦勝チームをrecord1に入れておく(後でrecord1内で探すことになるので)


//2回戦目

//まず、1回戦で不戦勝だったチームを参加させる

$match2[]=$base1[0];
unset($base2[$num1[0]]);
$base2=array_values($base2);
unset($num2[$num1[0]]);
$num2=array_values($num2);


for($d = 0; $d <= 6; $d++){  //2チーム目以降の参加チームを埋めていく
    foreach($match2 as $mae){
        $vs2 = rand(0,7-$d);
        if($d % 2 == 0){
            $checkR1 = array_search($base2[$vs2],$record1);  //今追加しようとしてるチームの、一回戦でのキー
            $checkR2 = array_search($match2[$d],$record1);  //直前に追加したチームの、一回戦でのキー
            //echo $mae;
            if($checkR1 == 1 || $checkR1 % 2 == 1){
                if($checkR1-$checkR2!=1){   //もし一回戦で戦った相手の場合、式の答えが1になる
                    break;
                } 
            }
            elseif($checkR1 % 2 == 0) {
                if($checkR2-$checkR1!=1){  //もし一回戦で戦った相手の場合、式の答えが1になる
                    break;
                } 
            }
        }
    }
    
    $match2[]=$base2[$vs2];
    unset($base2[$vs2]);
    $base2=array_values($base2);
    unset($num2[$vs2]);
    $num2=array_values($num2);
}


print '2回戦';
print '<br>';

for($game = 0;$game <= 3;$game++){
    $record2[] = $match2[$game * 2];
    $record2[] = $match2[$game * 2 + 1];
    print $match2[$game * 2].'×'.$match2[$game * 2 + 1];
    print '<br>';
}

$record2[] = $base2[0];  //不戦勝チームをrecord2に入れておく(後でrecord2内で探すことになるので)

//3回戦目

//まず、1回戦で不戦勝だったチームを参加させる

$match3[]=$base1[0];
unset($base3[$num1[0]]);

unset($num3[$num1[0]]);


//つぎに、2回戦で不戦勝だったチームを参加させる

$match3[]=$base2[0];
unset($base3[$num2[0]]);
$base3=array_values($base3);
unset($num3[$num2[0]]);
$num3=array_values($num3);

for($d = 0; $d <= 5; $d++){  //3チーム目以降の参加チームを埋めていく
    foreach($match3 as $mae){
        $vs3 = rand(0,6-$d);

        if($d == 1 || $d % 2 == 1){
            $checkR1 = array_search($base3[$vs3],$record1);  //今追加しようとしてるチームの、一回戦でのキー
            $checkR2 = array_search($match3[$d+1],$record1);   //直前に追加したチームの、一回戦でのキー
            $checkR3 = array_search($base3[$vs3],$record2);  //今追加しようとしてるチームの、二回戦でのキー
            $checkR4 = array_search($match3[$d+1],$record2);  //直前に追加したチームの、二回戦でのキー
            //echo $mae;


            if($checkR1 == 1 || $checkR1 % 2 == 1){
                if($checkR1-$checkR2!=1){            //もし一回戦で戦った相手の場合、式の答えが1になる
                    if($checkR3 == 1 || $checkR3 % 2 == 1){
                        if($checkR3-$checkR4!=1){  //もし二回戦で戦った相手の場合、式の答えが1になる
                            break;
                        } 
                    }
                    elseif($checkR3 % 2 == 0) {
                        if($checkR4-$checkR3!=1){  //もし二回戦で戦った相手の場合、式の答えが1になる
                            break;
                        } 
                    }
                }
            }
            elseif($checkR1 % 2 == 0) {
                if($checkR2-$checkR1!=1){   //もし一回戦で戦った相手の場合、式の答えが1になる
                    if($checkR3 == 1 || $checkR3 % 2 == 1){
                        if($checkR3-$checkR4!=1){  //もし二回戦で戦った相手の場合、式の答えが1になる
                            break;
                        } 
                    }
                    elseif($checkR3 % 2 == 0) {
                        if($checkR4-$checkR3!=1){  //もし二回戦で戦った相手の場合、式の答えが1になる
                            break;
                        } 
                    }
                }   
            }   
        }
    }
    
    $match3[]=$base3[$vs3];
    unset($base3[$vs3]);
    $base3=array_values($base3);
    unset($num3[$vs3]);
    $num3=array_values($num3);
}

print '3回戦';
print '<br>';

for($game = 0;$game <= 3;$game++){
    print $match3[$game * 2].'×'.$match3[$game * 2 + 1];
    print '<br>';
}

