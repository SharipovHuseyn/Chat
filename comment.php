<?php
session_start();

$mysql = new mysqli("localhost", "root", "", "Chat");
$mysql->query("SET NAMES 'utf8'");
$comment = $mysql->query("SELECT users.id_user, users.avatar, comment.id_attchament, comment.id_user_from, comment.created_at, comment.text, gallery.id_user, gallery.id FROM comment INNER JOIN gallery ON comment.id_attchament = gallery.id INNER JOIN users ON users.id_user = comment.id_user_from");
$gallery = $mysql->query("SELECT * FROM `gallery`");
$current_user_id = $_SESSION['id_user'];
$id_f = $_SESSION['id'];

date_default_timezone_set('Asia/Dushanbe');
$today = date("Y-m-d H:i:s", time());

if (isset($_GET["img"])) {
    $img_path = $_GET["img"];
}

$id_attchment = substr($img_path, -2);

if(isset($_POST['comment_text'])){
    $comment_text = $_POST['comment_text'];
}

if(isset($_POST['send_comment'])){
    $mysql->query("INSERT INTO `comment` (`text`, `id_attchament`, `id_user_from`, `created_at`) VALUES('$comment_text', '$id_attchment', '$current_user_id', '$today')");
}

function friend($comment)
{
	if ($comment->num_rows > 0) {
		while ($row = $comment->fetch_assoc()) {
			if ($row['id_attchament'] == substr($_GET["img"], -2)) {
				echo "<div class='comment_text_block'>";
                    echo "<img class='avatar' src='".substr($row['avatar'], 23)."' alt='".substr($row['avatar'],30)."'>";
                echo "<p class='comm'>".$row['text']."</p>
                <p class='date'>".substr($row['created_at'], 10, 6)."</p></div>";
			}
            
		}
	}
}

$mysql->close();
?>
<!DOCTYPE html>

<head>
    <title>Chat</title>
    <link href="test4.css" rel="stylesheet">
</head>

<body style="background-color: #cdcdcd">
    <html>
    <div class="img">
        <div class='img_a'>
            <img class='img_comment' src='<?=$img_path?>' alt='<?=$img_path?>'>
        </div>
        <div class="comment">
            <div>
            <?=friend($comment)?>
            </div>
        </div>
    </div>

<form class='form_comment' method='post' action=''>
<input type="text" class="comment_text" name ='comment_text'>
<button type='submit' class="send_comment" name='send_comment'>Отправить</button>
</form>
    </html>
</body>