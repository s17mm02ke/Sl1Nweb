<?php
        
        try{
            $dbh = new PDO('データベース名', 'ユーザー名', 'パスワード');
            
            $data = 'SELECT * FROM LOGINDATA';
                if($res = $dbh->query($data)){
                    $stack = array();
                    while($row = $res->fetch(PDO::FETCH_ASSOC)) {
                        if(strtotime(date("Y-m-d H:i:s")) > strtotime('$row["create_datetime"]') && $row["registration"] == "false"){
                            array_push($stack,$row["id"]);
                        }
                    }
                    for($i=0;$i<count($stack);$i++){
                        $sql = 'DELETE FROM LOGINDATA WHERE id='.$stack[$i];
                        $res = $dbh->prepare($sql);
                        $res -> execute();
                    }
                }
                else{
                }
        }catch(PDOException $e){
            print "エラー: " . $e->getMessage() . "<br/>";
            die();
        }
    ?>
