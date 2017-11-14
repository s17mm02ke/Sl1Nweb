<!DOCTYPE html>
<head>
<title>簡易掲示板</title>
</head>
<body>
<h1>簡易掲示板</h1>
<form type = "kadai_2-3.php" method = "post">
名前:<input type = "text" name = "name"><br>
コメント:<!--<input type = "text" name = "comment">--><br>
<textarea cols = "70" rows="7" name = "comment"></textarea><br>
<input type = "submit" value = "送信">
</form>
</body>
</html>

<?php
if(file_exists('kadai_2-2.txt') || isset($_POST['name']))
  {
   $fp = fopen("kadai_2-2.txt",'a');
   $array_file = file('kadai_2-2.txt');
   $i = count($array_file)+1;
   $str = "$i"."<>".$_POST['name']."<>".$_POST['comment']."<>".date("Y/m/d/H:i");
   $str = str_replace(array("\r","\n"),'',$str);
   $str = $str."\n";
   fwrite($fp,$str);
   fclose($fp);
   $i = 0;
   while($array_file[$i] != null)
     {
      $cell = explode("<>",$array_file[$i]);
      echo $cell[0].":"."名前:".$cell[1]."<br>".$cell[2]."<br>".$cell[3]."<br>";
      $i++;
     }
   $cell = explode("<>",$str);
   echo $cell[0].":"."名前:".$cell[1]."<br>".$cell[2]."<br>".$cell[3]."<br>";
   }
?>
