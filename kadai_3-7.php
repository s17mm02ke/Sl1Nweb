<script type="text/javascript">
function submitChk(){
    var flag = confirm("この投稿変更しますか？");
    return flag;
}
function check(){
    var flag = 0;
    
    if(document.form1.name.value == ""){
        flag = 1;
    }else if(document.form1.password.value == ""){
        flag = 1;
    }
    if(flag){
        alert("必須項目に未入力がありました。");
        return false;
    }else{
        return true;
    }
}
function passerror(){
    alert("パスワードが正しく入力されていません。");
}
function iderror(){
    alert("IDが正しく入力されていません。");
}
</script>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset = "utf-8">
<title>ログイン</title>
</head>
<body>
<h1>ログイン</h1>
<form type = "kadai_3-7.php" method = "post" name="form1" onsubmit = "return check()">
ID      :<input type = "text" name = "name" ><br>
パスワード:<input type = "text" name = "password" ><br>
<input type = "submit" value = "ログイン"><br><br>
<a href="http://co-352.99sv-coco.com/kadai_3-9.php">新規アカウント登録</a>
</form>
</body>
</html>
    <?php
        header('Content-Type: text/html; charset=utf-8');
        try {
            $dbh = new PDO('データベース名', 'ユーザー名', 'パスワード');
            $table= 'CREATE TABLE LOGINDATA (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(30),
            password VARCHAR(30),
            create_datetime DATETIME
            ) engine=innodb default charset=utf8';
            
            if($dbh->query($table)){
            }else{
                }
            if(!empty($_POST['name']) && !empty($_POST['password'])){
                $f = CheckID($dbh);
                
                if($f == 0){
                    print "<script type=text/javascript>iderror()</script>";
                }else if($f == 1){
                    print "<script type=text/javascript>passerror()</script>";}else{
                    session_start();
                    $_SESSION['id'] = $_POST['name'];
                    $_SESSION['pass'] = $_POST['password'];
                    header("location: kadai_3-8_829.php");
                }
            }
            
            
        }catch(PDOException $e){
            print "エラー: " . $e->getMessage() . "<br/>";
            die();
        }
        
        
        function CheckID($dbh){
            //$dbh = new PDO('データベース名', 'ユーザー名', 'パスワード');
            $data = 'SELECT * FROM LOGINDATA';
            $res = $dbh->query($data);
            $flag = 0;
            if($res){
                while($row = $res->fetch(PDO::FETCH_ASSOC)) {
                    if($_POST['name'] == $row['name']){
                        if($row['registration'] == "true"){
                            $flag = Checkpass($row['id'],$dbh);
                        }else{
                            if($_GET['uid'] == $row['uniqueid']){
                                $flag = Checkpass($row['id'],$dbh);
                                $sql = "UPDATE LOGINDATA SET registration ='true' WHERE id=".$row['id'];
                                $dbh->query($sql);
                                
                            }
                        }
                        break;
                    }
                }
            }else{
            }
            return $flag;
        }
        function Checkpass($id,$dbh){
            //$dbh = new PDO('データベース名', 'ユーザー名', 'パスワード');
            $data = 'SELECT * FROM LOGINDATA WHERE id='.$id;
            $res = $dbh->query($data);
            $flag = 1;
            if($res){
                $row = $res->fetch(PDO::FETCH_ASSOC);
                if($_POST['password'] == $row['password']){
                    $flag = 2;
                }
            }else{
            }
            return $flag;
        }
        
    ?>
