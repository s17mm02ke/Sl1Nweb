<?php
    header('Content-Type: text/html; charset=utf-8');
    try {
        $dbh = new PDO('�f�[�^�x�[�X��', '���[�U�[��', '�p�X���[�h');
        foreach($dbh->query('SHOW TABLES FROM co_352_it_3919_com') as $row) {
            echo "Table: {$row[0]}<br>";
        }
        $dbh = null;
    } catch (PDOException $e) {
        print "�G���[�ł��B" . $e->getMessage() . "<br/>";
        die();
    }
?>
