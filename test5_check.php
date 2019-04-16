<!DOCTYPE html>
<html lang='ja'>
    <head>
        <title>確認テスト2の5問目！</title>
    </head>
    <body>
        <?php
            //読み込むファイルの置き場所
            $file_dir = 'test5_jusin/';
            $file_path = $file_dir . $_FILES['uploadfile']['name'];
            $searchW;
            //アップロードされたファイルが有効か確認
            if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file_path)){
                $contents = file_get_contents($file_path);
                //文字エンコードの変更
                $contents = mb_convert_encoding($contents, 'UTF-8', 'auto');
                //特殊な文字の無効化
                $contents = htmlspecialchars($contents);
                //改行しつつ画面に出力
                print nl2br($contents);

                //検索する文字をsearchWに格納
                $searchW = $_POST['search'];
                //文字エンコードの変更
                $searchW = mb_convert_encoding($searchW, 'UTF-8', 'auto');
                //特殊な文字の無効化
                $searchW = htmlspecialchars($searchW);
                //検索したい文字の出現回数を数える
                $counts = mb_substr_count($contents, $searchW);
                ?>
                <br><br>
                <!--検索結果の表示 -->
                指定された文字列は「<?=$searchW?>」ですー<br>
                このファイル内では「<?=$counts?>」回使われていますよー<br>
                <br>
                <?php
                //使用したファイルの削除
                unlink($file_path);
            } else if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file_path) == false){
                ?>
                上手くアップロードできませんでした……<br>
                <?php
            }
        ?>
    </body>
</html>
