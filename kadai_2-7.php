<?php
    header('Content-Type: text/html; charset=utf-8');
    $link = mysql_connect('データベース名','ユーザー名','パスワード');
    if(!$link){
        echo '接続できません'.mysql_error();
    }else{
        echo '接続できました';
    }
?>