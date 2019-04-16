<!DOCTYPE html>

<html lang='ja'>
    <head>
        <meta charset='UTF-8'>
        <title>確認テスト2の6問目</title>
    </head>
    <body>
        <!-- ここから入力フォーム -->
        <div style='font-size:14px'>確認テスト2の6問目</div>
        <form name='form1' method='POST' action='' enctype='multipart/form-data'>
            
            文字列入力: <input type='text' name='moji'><br>
            <input type='submit' value='DBへ入力'>
        </form>

        <br>

        <form name='form2' method='POST' action='test6_download.php' enctype='multipart/form-data'>
            <input type='submit' value='履歴をダウンロード'>
        </form>
        <!-- ここまで入力フォーム -->

        <?php

        //データベース情報の読み込み。$SERVとか$DBNMの変数に情報を格納する
        require_once('test6_data/test6_db_data.php');
         //データベース接続
         $s=new pdo("mysql:host=$SERV;dbname=$DBNM",$USER,$PASS);

         //ここから「DBへ入力」ボタンの処理
         //(「履歴をダウンロード」の処理はtest6_download.phpに記述)

         //name=='moji'のデータがPOSTで送信される時、以下の処理が行われる
         //(つまり入力欄に文字が入力された状態で「DBへ入力」ボタンが押された時)
        if ($_POST['moji'] != null) {

            //POSTで入力された文字列を取得
            $moji_d = $_POST['moji'];
            //htmlで利用できる特殊文字を無効化
            $moji_d = htmlspecialchars($moji_d);
            //シングルクォートはsql文の妨げになるので変更
            $moji_d = str_replace("'", "\"", $moji_d);
            //セミコロンは削除
            $moji_d = str_replace(';', '', $moji_d);
            //sql文の実行
            $s->query("insert into test6 values ('$moji_d',now())");
            $re=$s->query('select * from test6 order by nitiji desc limit 100');

            //sql文で表示したテーブルの出力
            while ($kekka=$re->fetch()) {

                print $kekka[0];
                print ':';
                print $kekka[1];
                print '<br>';
            }

        }
            ?>

        
    </body>
</html>