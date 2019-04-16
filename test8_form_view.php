<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>確認テスト2</title>
    </head>
    <body>

    <!-- ここから入力フォーム -->
    <div style="font-size:18px;">応用2問目_脅威!リボ払い!!</div>
        <form name="form1" method="POST" action="">
            利用額(円):
            <input type="text" name="riyo"><br>
            毎月の支払い額(円):
            <input type="text" name="harai"><br>
            <input type="submit" value="送信">
        </form>

    <!-- ここまで入力フォーム  -->

    <table border=1>

    <?php
    //以下、「送信」ボタンを押した後の処理
        if ($_POST['riyo'] != null) {
            $souhutan;
            $hutan;
            //入力された数値を受け取る
            $zandaka = $_POST["riyo"];
            //小数点は切り上げる
            $pay = ceil($_POST["harai"]);
            //int型になってもらう
            $pay = intval($pay);
        
            //月の支払い金額が0円とか、入力値が金額になってない不届きな人は全額一括で払ってもらう
            if ($pay == 0){
                print "ちゃんと払ってくださーい!<br><br>";
                $pay = $zandaka;
            }
        
            //支払い回数と、支払いスケジュールの計算
            $kai = ceil($zandaka / $pay);

            $timestamp = time();
            $now_year = date('Y' , $timestamp);
            $now_month = date('m' , $timestamp);

            //ここから画面に出力。まずは確認事項の表示。
            print "あなたの利用額: ";
            print number_format($zandaka) . "円<br>";
            print "あなたの月々の支払額: ";
            print number_format($pay) . "円<br>";
            print "リボ払いの手数料の割合: 18%<br>";
            print "支払い回数: " . $kai . "回<br>";

            //タイムスタンプから受け取ったままの値では「03月」という表示になるので1倍
            $now_month = $now_month * 1; 

            //ここからは表の出力。各項目の項目名。
            print "<tr>";
            print "<td>支払い月</td>";
            print "<td>各月の負担額</td>";
            print "<td>利用額残高</td>";
            print "</tr>";

            //毎月の負担額を計算。for文が一周するたび、一ヶ月分の項目が追加される
            for ($i=1; $i<=$kai; $i++){
                print "<tr>";
            
                $hutan = $pay + ceil($zandaka * 0.18 / 365 * 30);
                $souhutan += $hutan;
                print "<td>" . $now_year . "年" . $now_month . "月</td>";
                print "<td>" . number_format($hutan) ."円</td>";
                if ($i == $kai){
                    print "<td>返済終了！</td>";
                }else if ($i != $kai){
                    $zandaka -= $pay;
                    print "<td>". number_format($zandaka) ."円</td>";
                }
            
                $now_month++;
                if ($now_month > 12){
                    $now_year++;
                    $now_month = 1;
                }
                print "</tr>";
            }

        ?>
        </table>
        <?php
            //返済終了後に総負担額の表示
            print "<br>総負担額: " . number_format($souhutan) . "円<br>";

        }
   
    ?>
    </head>
</html>