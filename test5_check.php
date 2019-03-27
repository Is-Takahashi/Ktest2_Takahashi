<!DOCTYPE html>
<html lang='ja'>
    <head>
        <title>確認テスト2の5問目！</title>
    </head>
    <body>
        <?php
            $file_dir = '/var/www/html/0307_Ktest2/test5_jusin/';
            $file_path = $file_dir . $_FILES['uploadfile']['name'];
            if(move_uploaded_file($_FILES['uploadfile']['tmp_name'],$file_path)){
                $contents = file_get_contents($file_path);
                $counts = mb_substr_count($contents,$_POST['search']);
                print nl2br($contents);
                ?>
                <br><br>
                指定された文字列は「<?=$_POST['search']?>」ですー<br>
                このファイル内では「<?=$counts?>」回使われていますよー<br>
                <br>
                <?php
            }else{
                ?>
                上手くアップロードできませんでした……<br>
                <?php
            }
        ?>
    </body>
</html>
