<?php
require_once('config.php');
require_once('functions.php');

$id = $_GET['id'];
$dbh = connectDb();

$sql = 'select * from posts where id = :id';

$stmt = $dbh -> prepare($sql);
$stmt -> bindParam(':id',$id);
$stmt ->execute();

$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$errors = array();

if($_SERVER['REQUEST_METHOD']==='POST')
{
    $title = $_POST['title'];
    $body = $_POST['body'];

    if($title == "")
    {
        $errors['title'] = 'タイトルを入力してください';
    }

    if($body == "")
    {
        $errors['body'] = '本文を入力してください';
    }

    // if($title ==$posts['title'] && $body == $posts['body'] )
    // {
    //     $errors[] ='タイトルか本文どちらかを編集してください';
    // }


    if(empty($errors))
    {
    $sql = 'update posts set title = :title, body = : body,';
    $sql.= 'updated_at = now() where id =:id';

    $stmt = $dbh ->prepare($sql);

    $stmt -> bindParam(':title',$title);
    $stmt -> bindParam(':body',$body);
    $stmt -> bindParam(':id',$id);

    $stmt ->execute();

    header('Location:index.php');
    exit;
    }




}

?>

<!DOCTYPE html>
<html lang ="ja">
    <head>
        <meta charset="UTF-8">
        <title>編集画面</title>
    </head>

<body>
    <h1>編集画面</h1>

    <a href ="index.php">戻る</a>

    <form action ="" method="post">

        <?php foreach ($posts as $post) :?>

            <p>タイトル<br>
            <input type ="text" name="title" size="50" value ="<?php echo $post['title']?>" >
            </p>

            <P>本文<br>
                <textarea name ="body" cols ="50" rows ="15" ><?= $post['body'] ?></textarea>
            </P>

            <input type ="submit" value="編集">
        <?php endforeach; ?>
    </form>
        <?php if(!empty($errors)): ?>
            <span style = "color:red">
                <p><?php echo $errors['title'] ?></p>
                <p><?php echo $errors['body'] ?></p>
            </span>
        <?php endif; ?>
</body>
</html>