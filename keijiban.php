<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
 </head>
  <body>
    <?php 
    //DB接続設定
    $dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE => PDO::
    ERRMODE_WARNING));
    $sql = "CREATE TABLE IF NOT EXISTS keijiban"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    . "date TIMESTAMP"
    .");";
    $stmt = $pdo->query($sql);
    if($pdo !== false){
      if(!empty($_POST["name"]) && !empty($_POST["text"])
      && !empty($_POST["pass"])){
       $pass=$_POST["pass"];
       if('pass'==$pass){
       if(empty($_POST["editNo"])){
           //新規投稿
           $sql = $pdo -> prepare("INSERT INTO keijiban (name, comment, date) VALUES (:name, :comment, :date)");
           $sql -> bindParam(':name', $name, PDO::PARAM_STR);
           $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
           $sql -> bindParam(':date', $date, PDO::PARAM_STR);
           $name = $_POST["name"];
           $comment = $_POST["text"];
           $date = date("Y/m/d H:i:s");
           $sql -> execute();
       }else{
        //編集
        $id = $_POST["editNo"];
        $name = $_POST["name"];
        $comment = $_POST["text"];
        $date = date("Y/m/d H:i:s");
        $sql = 'UPDATE keijiban SET name=:name,comment=:comment,date=:date WHERE id=:id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
       }
      }
    }
  }      
  if(isset($_POST["del"]) && !empty($_POST["delpass"])){//削除機能
    $delpass=$_POST["delpass"];
    if('pass'==$delpass){
              $id = $_POST["del"];
              $sql = 'delete from keijiban where id=:id';
              $stmt = $pdo->prepare($sql);
              $stmt->bindParam(':id', $id, PDO::PARAM_INT);
              $stmt->execute();
            }
          }
          //編集する番号の指定
       if(!empty($_POST["edit"]) && !empty($_POST["editpass"])){
        $editpass=$_POST["editpass"];
        $edit=$_POST["edit"];
            if('pass'==$editpass){
               $id = $_POST["edit"];
               $sql = 'SELECT * FROM keijiban WHERE id=:id';
               $stmt = $pdo->prepare($sql);
               $stmt->bindParam(':id', $id, PDO::PARAM_INT);
               $stmt->execute();
      $results = $stmt->fetchALL();
      foreach ($results as $row){
        $i = $row['id'];
        $n = $row['name'];
        $c = $row['comment'];
            }
           }
          }
          ?>
          【投稿フォーム】<br>
          <form action="" method="post">
          名前：<span style="margin-right:48px;"></span>
          <input type="text" name="name" placeholder="名前" value="<?php if(isset
          ($n)) echo $n; ?>"><br>
          コメント：<span style="margin-right:16px;"></span>
          <input type="text" name="text" placeholder="コメント" value="<?php if
          (isset($c)) echo $c; ?>"><br>
          <input type="hidden" name="editNo" value="<?php if(isset($i))
           echo $i; ?>">
           パスワード：
           <input type="password" name="pass"><br>
          <input type="submit" name="submit">
          </form>
          <br>
          【削除フォーム】
          <form action="" method="post">
          投稿番号：<span style="margin-right:16px;"></span>
          <input type="number" name="del"><br>
          パスワード：
          <input type="password" name="delpass"><br>
          <input type="submit" name="delete" value="削除">
          </form>
          <br>
          【編集フォーム】
          <form action="" method="post">
          投稿番号：<span style="margin-right:16px;"></span>
          <input type="number" name="edit"><br>
          パスワード：
          <input type="password" name="editpass"><br>
          <input type="submit" name="editbutton" value="編集">
          </form>
          <br>
          <hr>
          【投稿一覧】
           <br>
          <?php
          $sql = 'SELECT * FROM keijiban';
      $stmt = $pdo->query($sql);
      $results = $stmt->fetchALL();
      foreach ($results as $row){
        echo $row['id'].'.';
        echo $row['name'].' ';
        echo $row['comment'].' ';
        echo $row['date'].'<br>';
      　echo "<hr>";
      }
      ?>
    </body>
    </html>
