<?php
 $comment = $_GET['comment'];
echo $comment;
 ?>

 <!DOCTYPE html>
 <head>
 <title>フォームからデータを受け取る</title>
 </head>
 <body>
 <h1>フォームデータの送信</h1>
 <form action = "kadai_1-4.php" method = "get">
 <input type = "text" name ="comment" /><br/>
 <input type = "submit" value ="送信" />
 </form>
 </body>
 </html>