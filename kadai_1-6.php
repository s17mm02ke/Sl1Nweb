<?php
 if(isset($_GET['comment'])){
   $comment = $_GET['comment'];
   echo $comment;
   $fp = fopen("kadai_1-6.txt",'a');
   fwrite($fp,$comment);
   fclose($fp);
}
 ?>

 <!DOCTYPE html>
 <head>
 <title>�t�H�[������f�[�^���󂯎��</title>
 </head>
 <body>
 <h1>�t�H�[���f�[�^�̑��M</h1>
 <form action = "kadai_1-5.php" method = "get">
 <input type = "text" name ="comment" /><br/>
 <input type = "submit" value ="���M" />
 </form>
 </body>
 </html>