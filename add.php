<?php


require_once('config.php');
require_once('functions.php');

$dbh = connectDb();

// $sql = 'select * from posts ';
// $stmt = $dbh ->prepare($sql);
// $stmt -> execute();

// $posts = $stmt-> fetchAll(PDO::FETCH_ASSOC);

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $title = $_POST['title'];
    $body = $_POST['body'];

// バリデーション
    $errors = array();

    if($title == "") //emptyも可
    {
        $errors['title'] = 'タイトルを入力してください';
    }

    if($body =="")
    {
        $errors['body'] = '本文を入力してください';
    }

// エラーがなければpostsテーブルにデータを格納

    if(empty($errors))
    {
    $sql = 'insert into posts (title,body,created_at,updated_at)';
    $sql.= 'values (:title,:body, now(),now())';

    $stmt= $dbh->prepare($sql);
    $stmt ->bindParam(':title',$title);
    $stmt ->bindParam(':body',$body);
    $stmt ->execute();

    header('Location:index.php');
    exit;
    }

}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規記事投稿</title>
</head>

<body>
    <h1>新規記事投稿</h1>

    <a href ="index.php">
    戻る</a>

    <form action ="" method="post">

        <ul style ='list-style-type: none'>
        <span style = "color:red;">

        <?php if(!empty($errors)) :?>
                <li><?php echo h($errors['title']); ?></li>
                <li><?php echo h($errors['body']); ?></li>
        <?php endif ?>

        </span>

        </ul>
        <p>タイトル<br>
            <input type="text" name="title" size ="50">

        </p>

        <p>本文<br>
            <textarea name= "body" cols="80" rows="15"></textarea>
            <br>
            <input type="submit" value="投稿する">


        </p>
    </form>


</body>





</html>
