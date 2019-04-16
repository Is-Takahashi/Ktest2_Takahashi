<?php

//こちらのクラス内では、商品が売り切れるまでの間で変化するパラメータを操作する。
//また、商品の売上状況に影響を与える3つの条件をファンクションとして設定している。
//なお、4つ目のファンクションは、AとBの商品が両方完売したかを確認する処理である。

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
    public $hour;
    public $minute;
    public $date = 0;

    //check_aはaの条件を満たしたかどうかを判定する
    public function check_a()
    {
        if (($this->countA >= 0) && ($this->$countB >= 0)){
            //sellは、現時点での、商品が売れるまでの待機時間
            //basesellは、計算の元になる、本来の待機時間で、
            //aの条件を満たしている間は(このif文の条件を満たしている間)、10分短くなる
            $this->sellA -= $this->basesellA;
            $this->sellB -= $this->basesellB;
            $this->basesellA = 40;
            $this->basesellB = 80;
            $this->sellA += $this->basesellA;
            $this->sellB += $this->basesellB;
        }
    }
    
    //check_bの条件は、1日が終了する度に一度満たされるものなので、
    //function内で条件を満たしたかどうかを判定する必要がない(if文が不要)
    //翌日の営業が始まる前に、AとBの個数を増やす
    public function check_b()
    {
        $this->countA += 3;
        $this->countB += 2;
    }

    //check_cはcの条件を満たしたかどうかを判定する
    public function check_c()
    {
        //2時間(120分)が経過するたびに、商品が売れるまでの待機時間が15分加算される
        //その後、2時間を計るための変数count2hourをリセットする
        if ($this->count2hour >= 120){
            $this->sellA += 15;
            $this->sellB += 15;
            $this->count2hour = 0;   
        }
    }

    //check_completeは商品AとBが両方完売したかどうかを判定する
    public function check_complete()
    {
        if (($this->countA <= 0) && ($this->countB <= 0)){
            $this->hour = floor($this->time / 60);
            $this->minute = floor($this->time % 60);
            print "AとB、双方完売しました！完売までの時間は" . $this->date . "日" . $this->hour . "時間" . $this->minute . "分でした！<br>";
        }
    }
}
?>

<?php

 $chargeA = 0;
 $chargeB = 0;
 
 //インスタンスをつくる
 $checker = new Checker();

 //while文のループは商品AとBが両方完売するまで続ける
while (($checker->countA > 0) || ($checker->countB > 0)){
    print $checker->date + 1 . "日目開始！<br>";
    print "働き中.......";

    //営業開始前に商品が売れる時間間隔を設定
    $checker->sellA = $checker->basesellA;
    $checker->sellB = $checker->basesellB;
    //ただし商品が2個ともある場合はaの条件を満たすので、営業開始前に適用
    $checker->check_a();

    //for文は一日の勤務時間の間の時間の流れを再現する。timeは経過した分を示す。
    //for文が一周する毎に10分が経過する。600分経過するとその日の営業は終了し、for文のループも終了する。
    for ($checker->time=0; $checker->time<600; $checker->time = $checker->time+10){
        //商品が双方とも売り切れた時点で営業は終了するので、処理を中断
        if (($checker->countA <= 0) && ($checker->countB <= 0)){
            break;
        }
        
        //AとBの、売れるまでの待機時間に10分追加
        //さらに、2時間経過するとcの条件が満たされるので、2時間を計る変数にも10分追加
        $chargeA += 10;
        $chargeB += 10;
        $checker->count2hour += 10;

        //Aの商品が売れる時間になったら、Aが売れた時の処理を行う
        if ($chargeA >= $checker->sellA){
            //Aの個数を1減らす
            $checker->countA -= 1;
            //Aが売れるまでの残り時間をリセット
            $chargeA = 0;
            //商品が売れたので、aとcの条件を満たしているか再度確認
            $checker->check_a();
            $checker->check_c();
        }
        //Bの商品が売れる時間になったら、Bが売れた時の処理を行う
        if  ($chargeB >= $checker->sellB){
            //Bの個数を1減らす
            $checker->countB -= 1;
            //Bが売れるまでの残り時間をリセット
            $chargeB = 0;
            //商品が売れたので、aとcの条件を満たしているか再度確認
            $checker->check_a();
            $checker->check_c();
        }
        //商品が双方とも売り切れているかどうか確認
        $checker->check_complete();
    }
    //この日の営業は以上で終了。

    //営業終了時点で、商品が双方とも売り切れている場合、処理を中断
    if (($checker->countA <= 0) && ($checker->countB <= 0)){
        break;
    }
    //営業時間終了後にbの条件によって商品を補充する
    $checker->check_b();
    //dateは、丸一日働いた日が何日あるかを記録する。
    //その日の仕事が終了したので、働いた日を加算しておく
    $checker->date++;
    //その日の仕事の結果を表示。AとBの残り個数を報告する。
    print "...." . $checker->date . "日目終了！<br>";
    if ($checker->countA <= 0){
        print "Aは完売しました!<br>";
    }else if ($checker->countA > 0){
        print "Aの残り個数:" . $checker->countA . "個<br>";
    }
    if ($checker->countB <= 0){
        print "Bは完売しました!<br>";
    }else if ($checker->countB > 0){
        print "Bの残り個数:" . $checker->countB . "個<br>";
    }
    print "<br>";
}

