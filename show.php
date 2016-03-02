<?php
require_once('config.php');
require_once('functions.php');

$id=$_GET['id'];

$dbh = connectDb();

$sql = 'select * from posts where id = :id';

$stmt = $dbh -> prepare($sql);
$stmt ->bindParam(':id',$id);
$stmt ->execute();

//１行だけレコードを取得する
$post = $stmt-> fetch(PDO::FETCH_ASSOC);

// var_dump($post);で中身を見てみる


// コメント欄の操作

$errors =array();

$sql = 'select * from comments';

$stmt = $dbh->prepare($sql);
$stmt->execute();

$comments = $stmt-> fetchAll(PDO::FETCH_ASSOC);



if($_SERVER['REQUEST_METHOD'] === 'POST')
{

//     $id = $_GET['id'];
//     $dbh = connectDb();
//     $sql = 'select * from posts where id = :id';

//     $stmt = $dbh->prepare($sql);
//     $stmt->bindParam(':id',$id);
//     $stmt->execute();

// //１行だけレコードを取得する
//     $post = $stmt-> fetch(PDO::FETCH_ASSOC);

    $name = $_POST['name'];
    $comment = $_POST['comment'];

    if($name =="")
    {
        $errors['name'] = '名前が未入力です';
    }
    if($comment =="")
    {
        $errors['comment'] = 'コメントが未入力です';
    }

if(empty($errors))
    {

    $sql_insert = 'insert into comments (name,comment,created_at,updated_at) values (:name,:comment, now(),now())';

    $stmt = $dbh->prepare($sql_insert);
    $stmt->bindParam(':name',$name);
    $stmt->bindParam(':comment',$comment);
    $stmt->execute();

    header("Location:show.php?id=$id");
    exit;
    }

}
// コメントここまで


?>

<!DOCTYPE html>
<html lang="ja">


<head>
    <meta charset="UTF-8">
        <title>
        <?php echo h($post['title']) ?>
        </title>
</head>
<body>
        <h1><?php echo $post['title']?></h1>
        <p>
        <a href = "index.php">戻る</a><br>

        [#<?php echo $id ?>]@<?php echo $post['title']?><br>
        <?php echo $post['body']?><br>

        <a href = 'edit.php?id=<?php echo $id ?>'>[編集]</a>
        <a href = 'delete.php?id=<?php echo $id ?>'>[削除]</a>

        投稿日時：<?php echo $post['created_at'] ?>
        <hr>

        </p>



<!-- コメント欄 -->

    <h3>コメント一覧</h3>
    <?php foreach ($comments as $comment): ?>
        <p>
        名前：<?php echo $comment['name']  ?><br>
        コメント：<?php echo $comment['comment'] ?><br>
        投稿日時：<?= $comment['created_at'] ?>
        </p>
        <hr>
    <?php endforeach; ?>


    <?php if(!empty($errors)): ?>
        <?= $errors['name'] ?><br>
        <?= $errors['comment'] ?>
    <?php endif ;?>


    <form action ="" method="POST">
        <p>名前<br>
        <input type="text" name ="name"></p>

        <p>コメント<br>
        <textarea cols="50"  rows="15" name ="comment"></textarea></p>

        <p><input type="submit" value="コメント送信">


    </form>
</body>




</html>

