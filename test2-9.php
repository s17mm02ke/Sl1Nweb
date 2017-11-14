<?php
header('Content-Type: text/html; charset=utf-8');
    try {
        $dbh = new PDO('データベース名', 'ユーザー名', 'パスワード');
        foreach($dbh->query('SHOW TABLES FROM co_352_it_3919_com') as $row)
           {
            echo "Table: {$row[0]}<br>";
           }
        $dbh = null;
        } catch (PDOException $e)
  {
   print "エラー: " . $e->getMessage() . "<br/>";
   die();
  }
?>