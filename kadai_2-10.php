<?php
    header('Content-Type: text/html; charset=utf-8');
    $link = mysql_connect('データベース名','ユーザー名','パスワード');
    if(!$link){
        echo "接続できません。<br>".mysql_error();
    }else{
        echo "接続できました。<br>";
    }
    $db_selected = mysql_select_db('co_352_it_3919_com',$link);
    if(!$db_selected){
        echo "can't use.<br>";
    }else{
        echo "can use.<br>";
    }
    $result = mysql_query('SHOW COLUMNS FROM Board',$link);
    if (!$result) {
        echo 'Could not run query: ' . mysql_error();
        exit;
    }
    if (mysql_num_rows($result) > 0) {
        echo "<br>";
        while ($row = mysql_fetch_assoc($result)) {
            print_r($row);
            echo "<br>";
        }
    }
?>
