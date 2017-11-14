<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset = "utf-8">
<title>掲示板</title>
</head>
<body>
<h1>掲示板</h1>
<form type = "kadai_2-4.php" method = "post">
名前:<input type = "text" name = "name"><br>
投稿コメント:<!--<input type = "text" name = "comment">--><br>
<textarea cols = "60" rows="6" name = "comment"></textarea><br>
<input type = "submit" value = "投稿"><br><br>
</form>
<form type = "kadai_2-4.php" method = "post">
投稿削除依頼:<input type ="text" name = "delete">
<input type ="submit" value = "送信"><br><br>
</form>
<?php
header('Content-Type: text/html; charset=utf-8');
if(isset($_POST['delete']) != "" && file_exists('kadai_2-2.txt')){
  $fp = fopen("kadai_2-2.txt",'r');
  $array_file = file('kadai_2-2.txt');
  fclose($fp);
  $fp = fopen("kadai_2-2.txt",'w');
  $j = 0;
  while(count($array_file) > $j){
    $array_file[$j] = mb_convert_encoding($array_file[$j],"utf-8","euc-jp");
    $cell = explode("<>",$array_file[$j]);
    if($cell[0] != $_POST['delete']){
      $array_file[$j] = mb_convert_encoding($array_file[$j],"euc-jp","utf-8");
      fwrite($fp,$array_file[$j]);
      echo $cell[0].":"."名前:".$cell[1]."<br>".$cell[2]."<br>";
    }else{
      $str = mb_convert_encoding($cell[0]."".":この投稿は削除されました。\n","euc-jp","utf-8");
      fwrite($fp,$str);
      echo $cell[0].":この投稿は削除されました。<br>";
    }
    $j++;
  }
  fclose($fp);
}else if(file_exists('kadai_2-2.txt')||isset($_POST['name'])){

  $fp = fopen("kadai_2-2.txt",'a+');
  $array_file = file('kadai_2-2.txt');
  $i=0;
  while($array_file[$i] != null){
    $array_file[$i] = mb_convert_encoding($array_file[$i],"utf-8","euc-jp");
    $cell = explode("<>",$array_file[$i]);
    echo $cell[0].":"."名前:".$cell[1]."<br>".$cell[2]."<br>";
    $i++;
  }
  if(isset($_POST['name'])&&isset($_POST['comment'])){
    $i = count($array_file)+1;
    $str = "$i"."<>".$_POST['name']."<>".$_POST['comment'];
    $str = str_replace(array("\r", "\n"), '', $str);
    $str = $str."\n";
    $cell = explode("<>",$str);
    echo $cell[0].":"."名前:".$cell[1]."<br>".$cell[2]."<br>";
    $str = mb_convert_encoding($str,"euc-jp","utf-8");
    fwrite($fp,$str);
  }
  fclose($fp);
}

?>
</form>
</body>
</html>