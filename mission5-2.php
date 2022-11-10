<?php
//データベースに接続
 $dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    $sql = "CREATE TABLE IF NOT EXISTS mission5"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    . "date TEXT,"
    . "password char(32)"
    .");";
    $stmt = $pdo->query($sql);

//新規フォーム受信(4-5)
if(!empty($_POST["name"]) &&!empty($_POST["str"]) && empty($_POST["hidden_num"]) && !empty($_POST["pass"])){
    $sql = $pdo -> prepare("INSERT INTO mission5 (name, comment, date, password) VALUES (:name, :comment, :date, :password)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql -> bindParam(':date', $date, PDO::PARAM_STR);
    $sql -> bindParam(':password', $password, PDO::PARAM_STR);
    $name = $_POST["name"];
    $comment = $_POST["str"]; 
    $date =  date("Y年m月d日H時i分s秒") ;
    $password = $_POST["pass"];
    $sql -> execute();

    //データベースを表示
    $sql = 'SELECT * FROM mission5';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['date'].'<br>';
    echo "<hr>";
    }}
    
//削除フォーム受信(4-8)
elseif(!empty($_POST["delete_num"] ) && $_POST["delete_num"] && $_POST["delete_pass"]){
        $id = $_POST["delete_num"] ; 
        $sql = 'SELECT * FROM mission5 WHERE id=:id ';
        $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
        $stmt->execute();
       
        $results = $stmt->fetchAll(); 
        foreach ($results as $row){
        $delete_password=$row["password"];
        if($_POST["delete_pass"]==$delete_password){
        $stmt = $pdo->prepare("DELETE FROM mission5 WHERE id = :id");
        $stmt->bindParam( ':id', $id, PDO::PARAM_INT);
        $res = $stmt->execute();
        $sql = 'SELECT * FROM mission5';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['date'].'<br>';
    echo "<hr>";
    }}}}

//編集ボタン押されたとき
elseif(!empty($_POST["editor_num"] ) && $_POST["editor_num"] && $_POST["editor_pass"]){
     $id = $_POST["editor_num"] ; 
     $sql = 'SELECT * FROM mission5 WHERE id=:id';
     $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
     $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
     $stmt->execute();                             
     $results = $stmt->fetchAll(); 
    foreach ($results as $row){
    if($_POST["editor_pass"]==$row["password"]){
    $edit_name=$row["name"];
    $edit_str=$row["comment"];
    $edit_num=$id;
        }
    else{
    $edit_name="";
    $edit_str="";
    $edit_num="";
    }
    //入手して、元のフォームに挿入することができた。
    $sql = 'SELECT * FROM mission5';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['date'].'<br>';
    echo "<hr>";
    }}}
    
//編集フォーム受信(4-7)
elseif(!empty($_POST["hidden_num"]) && !empty($_POST["name"]) && !empty($_POST["str"]) && !empty($_POST["password"])){
    $id = $_POST["hidden_num"]; 
    $name = $_POST["name"];
    $comment = $_POST["str"];
    $date = date("Y年m月d日H時i分s秒");
    $password = $_POST["password"];
    $sql = 'UPDATE mission5 SET name=:name,comment=:comment,date=:date,password=:password WHERE id=:id ';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();    
    $sql = 'SELECT * FROM mission5';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
     
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['date'].'<br>';
    echo "<hr>";}
    }
   
   
   //何も送信されていないとき
    elseif(empty($_POST["name"]) && empty($_POST["str"])){
    $sql = 'SELECT * FROM mission5';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['date'].'<br>';
    echo "<hr>";}
    }
?>

  <!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-1</title>
</head>
<body>
    <form action="" method="post">
         <input type="text" name="name" placeholder="名前" value=<?php 
          if(!empty($_POST["editor_num"])){
            echo $row['name'];
            }?>>
            <br>
        <input type="text" name="str" placeholder="コメント"  value=<?php 
         if(!empty($_POST["editor_num"])){
            echo $row['comment'];
            }?>>
             <br>
        <input type="text" name="pass" placeholder="パスワード※必須" value=<?php 
         if(!empty($_POST["editor_num"])){
            echo $row['password'];
         }
            ?>>
         <input type="hidden" name="hidden_num" placeholder="編集番号" value=<?php
         if(!empty($_POST["editor_num"])){
         echo $_POST["editor_num"];}
         ?>>
         <br>
        <input type="submit" name="submit">
        <br>
        <input type="text" name="editor_num" placeholder="編集対象番号入力欄">
         <br>
        <input type="text" name="editor_pass" placeholder="パスワード※必須">
        　 <br>
        <button>編集</button>    
        <br>
        <input type="text" name="delete_num" placeholder="削除対象番号">
          <br>
        <input type="text" name="delete_pass" placeholder="パスワード※必須">
         　 <br>
       <button>削除</button>
    </form>
  </body>
  </html>
