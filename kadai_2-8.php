<?php
    header('Content-Type: text/html; charset=utf-8');
    $link = mysql_connect('データベース名','ユーザー名','パスワード');
    if(!$link){
        echo '接続できません。<br>'.mysql_error();
    }else{
        echo '接続できました。<br>';
    }
    $table= 'CREATE TABLE board (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30),
    comment VARCHAR(300),
    create_datetime DATETIME,
    password VARCHAR(30)
    ) engine=innodb default charset=utf8';
    if(mysql_query($table,$link)){
        echo "テーブルの作成に成功しました。\n";
    }else{
        echo "テーブルは存在しています。\n";
    }
?>
