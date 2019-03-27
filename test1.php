<?php
$tw=[];
$th=[];
$ohfs=[];
for($i=1;$i<=10000;$i++){
    if($i%12==0){
        $tw[]=$i;
    }
    if($i%13==0){
        $th[]=$i;
    }
    if($i%156==0){
        $ohfs[]=$i;
    }
}
print '1~10000の間にある<br>';
print '12の倍数: ';

for($j=0;$j<count($tw);$j++){
    print $tw[$j] . ',';
    if(($j+1)%10==0){
        print '<br>';
    }
}

print '<br>13の倍数: ';

for($k=0;$k<count($th);$k++){
    print $th[$k] . ',';
    if(($k+1)%10==0){
        print '<br>';
    }
}

print '<br>156の倍数: ';

for($l=0;$l<count($ohfs);$l++){
    print $ohfs[$l] . ',';
    if(($l+1)%10==0){
        print '<br>';
    }
}