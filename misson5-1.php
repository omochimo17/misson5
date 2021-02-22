<!DOCTYPE html> 
<html lang="ja"> 
<head> 
    <meta charset="UTF-8"> 
    <title>mission5-1</title> 
</head> 
<body> 
    <h1>あなたの好きなアーティストは？ </h1>
    <form action=""method="post"> 
     
        <input type="text"name="name"placeholder="名前"><br/> 
     
        <input type="text"name="comment"placeholder="コメント" ><br/> 
         
        <input type="password" name="pass" placeholder="パスワード"  value="">
        <input type="text" name="edit" placeholder="編集対象番号">
        <input type="submit" name="submit" ><br> 
            
        <input type="text" name="delete" placeholder="削除対象番号">
            <br>
            <input type="password" name="delpass" placeholder="パスワード" >
            <input type="submit" value="削除"><br>
            <br>
        
            
    </form> 
</body>
</html>
<?php 
    echo "__________________掲示板欄______________________<br>" 
?> 
     <?php 
             // DB接続設定 
        $dsn = 'データベース名';
        $user = 'ユーザー名';
        $password = 'ʼパスワード';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
        
         
        if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["edit"])){
        $edit=$_POST["edit"]; //編集対象番号の受け取り
        $name=$_POST["name"];
        $comment=$_POST["comment"];
        $date=date("Y/m/d H:i:s");
        $pass=$_POST["pass"];
        $sql = 'UPDATE m7 SET name=:name,comment=:comment,dt=:dt 
                WHERE id=:id AND pass=:pass';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':dt', $date, PDO::PARAM_STR);
        $stmt->bindParam(':id', $edit, PDO::PARAM_STR);
        $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
        $stmt->execute();
      }else{
        //テキスト入力(新規投稿) 
        if(!empty($_POST["name"]) && !empty($_POST["comment"]) &&!empty($_POST["pass"])){ 
          $name=$_POST["name"]; 
          $comment=$_POST["comment"]; 
          $date=date("Y/m/d  H:i:s");
          $pass=$_POST["pass"];
        $sql = $pdo -> prepare("INSERT INTO m7 (name, comment,dt,pass) VALUES (:name, :comment,:dt,:pass)"); 
        $sql -> bindParam(':name', $name, PDO::PARAM_STR); 
        $sql -> bindParam(':comment', $comment,  PDO::PARAM_STR); 
        $sql->bindParam(':dt', $date, PDO::PARAM_STR);
        $sql->bindParam(':pass', $pass, PDO::PARAM_STR);
           //好きな名前、好きな言葉は自分で決めること 
        $sql -> execute(); 
         } 
         
      }
         
        //  削除機能
          if(!empty($_POST["delete"]) && !empty($_POST["delpass"])){
              $delete=$_POST["delete"];
              $delpass=$_POST["delpass"];
              $sql = 'delete from m7 where id=:id AND pass=:pass';
              $stmt = $pdo->prepare($sql);
              $stmt->bindParam(':id', $delete, PDO::PARAM_INT);
              $stmt->bindParam(':pass', $delpass, PDO::PARAM_INT);
              $stmt->execute();
          }
          
         
         
                //データ抽出・出力 
         $sql = 'SELECT * FROM m7'; 
         $stmt = $pdo->query($sql); 
         $results = $stmt->fetchAll(); 
         foreach ($results as $row){ 
          //$rowの中にはテーブルのカラム名が入る 
          echo $row['id'].','; 
          echo $row['name'].','; 
          echo $row['comment'].','; 
          echo $row['dt'].'<br>';
          echo "<hr>"; 
         } 
    ?>