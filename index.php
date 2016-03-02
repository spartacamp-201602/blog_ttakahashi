<?php

require_once('config.php');
require_once('functions.php');

$dbh = connectDb();


// $sql = 'select * from posts where id = :id';

// $stmt = $dbh ->prepare($sql);
// $stmt -> bindParam(':id',$id);
// $stmt ->execute();



$sql = 'select * from posts order by created_at desc';
$stmt = $dbh -> prepare($sql);
$stmt -> execute();

$posts = $stmt -> fetchAll(PDO::FETCH_ASSOC);


?>


<!DOCTYPE html>
<html lang = "ja">

    <head>
        <meta charset = "UTF-8">
        <title>Blog</title>

    </head>

    <body>


        <h1>Blog</h1>


        <a href = "add.php">
        新規記事投稿</a>

        <h1>記事一覧</h1>
        <p>
        <?php foreach($posts as $post): ?>
            <a href = 'show.php?id=<?=h($post["id"]) ?>'>
            <?php echo h($post['title']) ;?></a><br>

            <?php echo h($post['body']) ;?><br>
            投稿日時：<?php echo h($post['created_at']) ;?><br>
            <hr>
        <?php endforeach ?>
        </p>

    </body>






</html>