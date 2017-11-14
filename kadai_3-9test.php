     <script type="text/javascript">
    function submitChk(){
        var flag = confirm("この投稿を変更しますか？");
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
        }else if(document.form1.mail.value == ""){
            flag = 1;
        }
        if(flag){
            alert("未入力のものがあります。");
            return false;
        }else{
            return true;
        }
    }

    function passerror(){
        alert("パスワードが間違っています。");
    }

    function exiterror(){
        alert("そのIDは既に使用されています。");
    }
    </script>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset = "utf-8">
        <title>課題3-9</title>
    </head>
    <body>
        <h1>新規アカウント登録</h1>
        <hr>
        <div align="center">
            <table border="0">
                <form type = "kadai_3-9.php" method = "post" name="form1" onsubmit = "return check()">
                    <tr>
                        <th align="right">
                            ID:
                        </th>
                        <td>
                            <input type = "text" name = "name">
                        </td>
                    </tr>
                    <tr>
                        <th align="right">
                            パスワード:
                        </th>
                        <td>
                            <input type = "text" name = "password">
                        </td>
                    </tr>
                    <tr>
                        <th align="right">
                            PASS(確認用):
                        </th>
                        <td>
                            <input type = "text" name = "confpass">
                        </td>
                    </tr>
                    <tr>
                        <th align="right">
                            メールアドレス:
                        </th>
                        <td>
                            <input type = "text" name = "mail">
                        </td>
                    </tr>
                    <tr>
                        <th>
                        </th>
                        <td>
                            <input type = "submit" value = "決定">
                        </td>
                    </tr>
                </form>
            </table>
            <br>
            <a href="http://co-352.99sv-coco.com/kadai_3-7.php">登録済みの方はこちら-ログイン-</a>
        </div>
    </body>
</html>

    <?php
        header('Content-Type: text/html; charset=utf-8');
        try {
            $dbh = new PDO('データベース', 'ユーザー名', 'パスワード');
            $table= 'CREATE TABLE LOGINDATA (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(30),
            password VARCHAR(30),
            create_datetime DATETIME,
            uniqueid VARCHAR(255),
            registration VARCHAR(10)
            ) engine=innodb default charset=utf8';
            
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
            
        }catch(PDOException $e){
            print "エラー　<br>" . $e->getMessage();
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
        function CreateUniqueid($idlength){
            $str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z"'));
            for ($i = 0; $i < $idlength; $i++) {
                $id_str .= $str[rand(0, count($str)-1)];
            }
            return $id_str;
        }
        function Savedata(){
            $dbh = new PDO('データベース名', 'ユーザー名', 'パスワード');

            $t = getdate();
            $uid = CreateUniqueid(15);
            $regiflag = "false";
            $data = "INSERT INTO LOGINDATA (id,name,password,create_datetime,uniqueid,registration)VALUES('','".$_POST['name']."','".$_POST['password']."','".date("Y-m-d H:i:s",strtotime("+1 hour"))."','".$uid."','".$regiflag."')";
            if($dbh->query($data)){
                Sendconfmail($uid);
                return true;
            }else{
                return false;
            }
        }

        function Sendconfmail($uid){
            mb_language("Japanese");
            mb_internal_encoding("UTF-8");
            $title = "掲示板登録の認証メールです";
            $to = $_POST['mail'];
            $content = "ログインする場合はこのURLからログインをお願いします。http://co-352.99sv-coco.com/kadai_3-7.php?uid=".$uid;
            if(mb_send_mail($to, $title, $content)){
                echo "メールを送信しました。認証するまでログインできません。";
            } else {
                echo "メールの送信に失敗しました";
            }
        }
        
    ?>
