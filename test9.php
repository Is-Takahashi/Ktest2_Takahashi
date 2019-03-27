<?php



class Checker
{

    public $countA = 100;
    public $countB = 50;
    public $basesellA = 50;
    public $basesellB = 90;
    public $sellA = 0;
    public $sellB = 0;
    public $count2hour = 0;
    public $time = 0;
    public $jikan1;
    public $jikan2;
    public $date = 0;


    public function check_a()
    {
        if(($this->countA >= 0) && ($this->$countB >= 0)){
            $this->sellA -= $this->basesellA;
            $this->sellB -= $this->basesellB;
            $this->basesellA = 40;
            $this->basesellB = 80;
            $this->sellA += $this->basesellA;
            $this->sellB += $this->basesellB;
        }
    }
    
    public function check_b()
    {
        $this->countA += 3;
        $this->countB += 2;
    }

    public function check_c()
    {
        if($this->count2hour >= 120){
            $this->sellA += 15;
            $this->sellB += 15;
            $this->count2hour = 0;   
        }
    }
    public function check_complete()
    {
        if(($this->countA <= 0) && ($this->$countB <= 0)){
            $this->jikan1 = floor($this->time / 60);
            $this->jikan2 = floor($this->time % 60);
            print "AとB、双方完売しました！完売までの時間は" . $this->date . "日" . $this->jikan1 . "時間" . $this->jikan2 . "分でした！<br>";
        }
    }
}
?>

<?php

 $chargeA = 0;
 $chargeB = 0;
 $ichinichi = 600;
 
 $checker = new Checker();

while(($checker->countA > 0) || ($checker->countB > 0)){
    print $checker->date + 1 . "日目開始！<br>";
    print "働き中.......";

    
    $checker->sellA = $checker->basesellA;
    $checker->sellB = $checker->basesellB;
    $checker->check_a();
    for($checker->time=0;$checker->time<600;$checker->time=$checker->time+10){
        if(($checker->countA <= 0) && ($checker->$countB <= 0)){
            break;
        }
        
        $chargeA += 10;
        $chargeB += 10;
        $checker->count2hour += 10;

        if($chargeA>=$checker->sellA){
            $checker->countA -= 1;
            $chargeA = 0;
            $checker->check_a();
            $checker->check_c();
        }
        if($chargeB>=$checker->sellB){
            $checker->countB -= 1;
            $chargeB = 0;
            $checker->check_a();
            $checker->check_c();
        }
        $checker->check_complete();
    }
    if(($checker->countA <= 0) && ($checker->$countB <= 0)){
        break;
    }
    $checker->check_b();
    $checker->date++;
    print $checker->date . "日目終了！<br>";
    if($checker->countA <= 0){
        print "Aは完売しました!<br>";
    }else{
        print $checker->date . "Aの個数:" . $checker->countA . "個<br>";
    }
    if($checker->countB <= 0){
        print "Bは完売しました!<br>";
    }else{
        print $checker->date . "Bの個数:" . $checker->countB . "個<br>";
    }
    print "<br>";
}

?>




