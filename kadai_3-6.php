<script type="text/javascript">
function submitChk(){
    var flag = confirm("この投稿の変更を加えてもよろしいですか？");
    return flag;
}
function check(){
    var flag = 0;
    if(document.form1.name.value == ""){
        flag = 1;
    }else if(document.form1.password.value == ""){
        flag = 1;
    }else if(document.form1.confpass.value == ""){
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
function exiterror(){
    alert("そのIDは既に使われています。");
}

</script>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset = "utf-8">
<title>新規登録</title>
</head>
<body>
<h1>新規アカウント登録</h1>
<form type = "kadai_3-6.php" method = "post" name="form1" onsubmit = "return check()">
ID      :<input type = "text" name = "name"><br>
PASS:<input type = "text" name = "password"><br>
PASS(確認用):<input type = "text" name = "confpass"><br>
<input type = "submit" value = "決定"><br><br>
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
            $checkflag = false;
            if(!empty($_POST['name']) && !empty($_POST['password'])){
                if(checkpass()){
                    if(CheckID()){
                        print "<script type=text/javascript>exiterror()</script>";
                    }else{
                        $checkflag = true;
                    }
                }else{
                    print "<script type=text/javascript>passerror()</script>";
                }
            }
            if($checkflag){
                if(Savedata()){
                    }else{
                    }
            }
            
            
        }catch(PDOException $e){
            print "エラー: " . $e->getMessage() . "<br/>";
            die();
        }
        
        function checkpass(){
            if($_POST['password'] == $_POST['confpass']){
                return true;
            }else{
                return false;
            }
        }
        function CheckID(){
            $dbh = new PDO('データベース名', 'ユーザー名', 'パスワード');
            $data = 'SELECT * FROM LOGINDATA';
            $res = $dbh->query($data);
            $flag = false;
            if($res){
                while($row = $res->fetch(PDO::FETCH_ASSOC)) {
                    if($_POST["name"] == $row["name"]){
                        $flag = true;
                        break;
                    }
                }
            }else{
            }
            return $flag;
        }
        function Savedata(){
            $dbh = new PDO('データベース名', 'ユーザー名', 'パスワード');
            $t = getdate();
            $data = "INSERT INTO LOGINDATA (id,name,password,create_datetime)VALUES('','".$_POST['name']."','".$_POST['password']."','".$t['year']."/".$t['mon']."/".$t['mday']."/".$t['hours'].":".$t['minutes'].":".$t['seconds']."')";
            if($dbh->query($data)){
                return true;
            }else{
                return false;
            }
        }

        
    ?>