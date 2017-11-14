<script type="text/javascript">
function submitChk(){
  var flag = confirm("この投稿の変更を加えてもいいですか？");
  return flag;
}
function check(){
  var flag = 0;
  
  if(document.form1.name.value == ""){
    flag = 1;
  }else if(document.form1.comment.value == ""){
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
    alert("パスワードが間違っています。");
}
function exiterror(){
    alert("その投稿は削除されています。");
}

</script>
    <?php
        if(isset($_POST['edit'])){
            try {
                $dbh = new PDO('データベース名', 'ユーザー名', 'パスワード');
                $data = 'SELECT * FROM Board WHERE id='.$_POST['edit'];
                $res = $dbh->query($data);
                if($res){
                    $row = $res->fetch(PDO::FETCH_ASSOC);
                    if(empty($row['password'])){
                        $editname = $row['name'];
                        $editcomment = $row['comment'];
                        $editcode = $_POST['edit'];
                        $editpass = "変更できません。";
                    }else{
                        if($_POST['pass'] == $row['password']){
                            $editname = $row['name'];
                            $editcomment = $row['comment'];
                            $editcode = $_POST['edit'];
                            $editpass = "変更できません。";
                        }else{
                            print "<script type=text/javascript>passerror()</script>";
                        }
                    }
                }else{
                    print "<script type=text/javascript>exiterror()</script>";}
                $dbh = null;
            } catch (PDOException $e) {
                print "エラー: " . $e->getMessage() . "<br/>";
                die();
            }
     /*
  $fp = fopen("kadai_2-6.txt",'a+');
  $arry_file = file('kadai_2-6.txt');
  $i=0;
  while($arry_file[$i] != null){
    $arry_file[$i] = mb_convert_encoding($arry_file[$i],"utf-8","euc-jp");
    if($i == ($_POST['edit']-1)){
      $cell = explode("<>",$arry_file[$i]);
      if(!empty($cell[1])){
      if(empty($cell[4])){
        $editname = $cell[1];
        $editcomment = $cell[3];
        $editcode = $_POST['edit'];
        $editpass = "変更できません。";
        }else{
          if(str_replace(array("\r", "\n"), '', $cell[4]) == $_POST['pass']){
             $editname = $cell[1];
             $editcomment = $cell[3];
             $editcode = $_POST['edit'];
             $editpass = "変更できません。";
          }else{
              print "<script type=text/javascript>passerror()</script>";
          }
        }
      }else{
        print "<script type=text/javascript>exiterror()</script>";
      }
    }
    $i++;
  }*/
        }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset = "utf-8">
<title>掲示板</title>
</head>
<body>
<h1>掲示板</h1>
<form type = "kadai_2-15.php" method = "post" name="form1" onsubmit = "return check()">
名前:<input type = "text" name = "name" value = "<?php echo $editname; ?>"><br>
<input type = "hidden" name = "editcode" value = "<?php echo $editcode; ?>">
pass:<input type = "text" name = "pass" value = "<?php echo $editpass; ?>"><br>
コメント:<br>
<textarea cols = "70" rows="7" name = "comment"><?php echo $editcomment; ?></textarea><br>
<input type = "submit" value = "投稿"><br><br>
</form>
<form type = "kadai_2-15.php" method = "post" name="form2" onsubmit = "return submitChk()">
投稿編集:<input type = "text" name = "edit">
パスワード:<input type ="text" name = "pass">
<input type ="submit" value ="送信"><br>
</form>
<form type = "kadai_2-15.php" method = "post" name="form3" onsubmit = "return submitChk()">
投稿削除:<input type ="text" name = "delete">
パスワード:<input type ="text" name = "pass">
<input type ="submit" value = "送信"><br><br>
</form>

<?php
    header('Content-Type: text/html; charset=utf-8');
    try {
        $dbh = new PDO('データベース名', 'ユーザー名', 'パスワード');
        $table= 'CREATE TABLE Board (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30),
        comment VARCHAR(300),
        create_datetime DATETIME,
        password VARCHAR(30)
        ) engine=innodb default charset=utf8';
        
        if($dbh->query($table)){
        }else{
        }
        
        if(!empty($_POST['delete'])){
           $data = 'SELECT * FROM Board WHERE id='.$_POST['delete'];
            $res = $dbh->query($data);
            $row = $res->fetch(PDO::FETCH_ASSOC);
            if($_POST['pass'] == $row['password']){
                    
                $data = 'DELETE FROM Board WHERE id= '.$_POST['delete'];
                $res = $dbh->prepare($data);
                $res -> execute();
            }else{
                print "<script type=text/javascript>passerror()</script>";
            }
        }else if($_POST['editcode'] >= 1){
            $t = getdate();
            $data = "UPDATE Board SET comment = '".$_POST['comment']."',create_datetime = "."'".$t['year']."/".$t['mon']."/".$t['mday']."/".$t['hours'].":".$t['minutes'].":".$t['seconds']."'" ."WHERE id=".$_POST['editcode'];
            $res = $dbh->prepare($data);
            $res -> execute();
            $editcode = 0;
        }else if(!empty($_POST['name'])&&!empty($_POST['comment'])){
            $t = getdate();
            $data = "INSERT INTO Board (id,name,comment,create_datetime,password)VALUES('','".$_POST['name']."','".$_POST['comment']."','".$t['year']."/".$t['mon']."/".$t['mday']."/".$t['hours'].":".$t['minutes'].":".$t['seconds']."','".$_POST['pass']."')";
            $dbh->query($data);
        }
        
        $data = 'SELECT * FROM Board';
        $res = $dbh->query($data);
        $i = 1;
        while($row = $res->fetch(PDO::FETCH_ASSOC)) {
            $i = $row["id"];
            echo $row["id"] .":名前:". $row["name"] .":投稿日時".$row["create_datetime"] ."<br>". $row["comment"] . "<br>";
        }
        /*if(!empty($_POST['name'])&&!empty($_POST['comment'])&&empty($_POST['editcode'])){
      
             $t = getdate();
            $data = "INSERT INTO Board (id,name,comment,create_datetime,password)VALUES('','".$_POST['name']."','".$_POST['comment']."','".$t['year']."/".$t['mon']."/".$t['mday']."/".$t['hours'].":".$t['minutes'].":".$t['seconds']."','".$_POST['pass']."')";
            $dbh->query($data);
            
            echo  ($i+1).":名前:". $_POST['name'] .":投稿日時".$t['year']."-".$t['mon']."-".$t['mday']." ".$t['hours'].":".$t['minutes'].":".$t['seconds'] ."<br>". $_POST['comment'] . "<br>";
      
        }*/
        $dbh = null;
        $res = null;
        

    } catch (PDOException $e) {
        print "エラー: " . $e->getMessage() . "<br/>";
        die();
    }


?>
</body>
</html>

