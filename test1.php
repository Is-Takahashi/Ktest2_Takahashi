<?php
$tw = [];
$th = [];
$ohfs = [];
$num = 0;
$i = 0;

//12の倍数で10000以下のものを配列に格納
while ($num <= 10000){
    $i++;
    $num = 12 * $i;
    if ($num >= 10000){
        break;
    }
    $tw[] = $num;
}

$i = 0;
$num = 0;

//13の倍数で10000以下のものを配列に格納
while ($num <= 10000){
    $i++;
    $num = 13 * $i;
    if ($num >= 10000){
        break;
    }
    $th[] = $num;
}

//12の倍数と13の倍数のうち、両方に属するものは156の倍数
foreach ($tw as $check12){
    foreach ($th as $check13){
        if ($check12 == $check13){
            $ohfs[] = $check12;
        }
    }
}

print '1~10000の間にある<br>';
print '12の倍数: ';


//12の倍数を1行に10個ずつ表示
for ($j=0; $j<count($tw); $j++){
    print $tw[$j] . ',';
    if (($j+1)%10==0){
        print '<br>';
    }
}

print '<br>13の倍数: ';

//13の倍数を1行に10個ずつ表示
for ($j=0; $j<count($th); $j++){
    print $th[$j] . ',';
    if (($j+1)%10==0){
        print '<br>';
    }
}

print '<br>156の倍数: ';

//156の倍数を1行に10個ずつ表示
for ($l=0; $l<count($ohfs); $l++){
    print $ohfs[$l] . ',';
    if (($l+1)%10 == 0){
        print '<br>';
    }
}
