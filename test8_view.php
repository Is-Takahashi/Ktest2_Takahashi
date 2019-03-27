<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>確認テスト2</title>
    </head>
    <body>

    <table border=1>

    <?php
        $zandaka = $_POST["riyo"];
        $souhutan;
        $hutan;
        $kai = ceil($_POST["riyo"] / $_POST["harai"]);

        $timestamp = time();
        $now_year = date('Y',$timestamp);
        $now_month = date('m',$timestamp);

        print "あなたの利用額: ";
        print $_POST["riyo"]."円<br>";
        print "あなたの月々の支払額: ";
        print $_POST["harai"]."円<br>";
        print "リボ払いの手数料の割合: 18%<br>";
        print "支払い回数: ".$kai."回<br>";

        $now_month = $now_month * 1;  //タイムスタンプから受け取ったままの値では「03月」という表示になるので

        print "<tr>";
        print "<td>支払い月</td>";
        print "<td>各月の負担額</td>";
        print "<td>利用額残高</td>";
        print "</tr>";        

        for($i=1;$i<=$kai;$i++){
            print "<tr>";
            
            $hutan =$_POST["harai"] + ceil($zandaka * 0.18 / 365 * 30);
            $souhutan += $hutan;
            print "<td>" . $now_year . "年" . $now_month . "月</td>";
            print "<td>" . $hutan ."円</td>";
            if($i==$kai){
                print "<td>返済終了！</td>";
            }else{
                $zandaka -= $_POST["harai"];
                print "<td>". $zandaka ."円</td>";
            }
            
            $now_month++;
            if($now_month>12){
                $now_year++;
                $now_month = 1;
            }
            print "</tr>";
        }


    ?>
    </table>
    <?php
        print "<br>総負担額: " . $souhutan . "円<br>";
    ?>
    </head>
</html>