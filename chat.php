<?php
session_start();

$mysql = new mysqli("localhost", "root", "", "Chat");
$mysql->query("SET NAMES 'utf8'");

$friends = $mysql->query("SELECT * FROM `users`");
$My_name = $mysql->query("SELECT * FROM `users`");
$fr_name = $mysql->query("SELECT * FROM `users`");
$today = date_default_timezone_set('Tajikistan/Dushanbe');
$showMessages = $mysql->query("SELECT users.id_user, users.name, messages.text, messages.created_at FROM users INNER JOIN messages ON messages.id_user_from WHERE users.id_user = messages.id_user_from");

$current_user_id = $_SESSION['id_user'];
$error_mess = "";
$error = false;
date_default_timezone_set('Asia/Dushanbe');
$today = date("Y-m-d H:i:s", time());

if (!isset($current_user_id)) {
    header('Location: choice.php');
}

if (isset($_GET["id_user"])) {
    $id_user = $_GET["id_user"];
}

if (isset($_POST["message"])) {

    $message = $_POST["message"];
}

function printfriends($friends)
{
    if ($friends->num_rows > 0) {
        while ($row = $friends->fetch_assoc()) {
            if ($row['id_user'] == $_SESSION['id_user']) {
                $row['name'];
            } else {
                echo "<a href='chat.php?id_user=" . $row['id_user'] . "' class='users_1'>
                <b style='margin-left:80px;'>NAME :<br></b>
                <p class='name_sty'>" . $row['name'] . "</p>
                        <div class='sircle'>
                            <p class='id'>" . $row['id_user'] . "</p>
                        </div>
                    </a>";
            }

        }
    }
}

function showMessages($showMessages)
{
    if ($showMessages->num_rows > 0) {
        while ($row = $showMessages->fetch_assoc()) {
            print_r($row['user_id']);
            if ($row['id_user'] == $_SESSION['id_user']) {
                echo "<section class='soob'>
                <div class = 'mess1'><p class='text1'>" . $row['text'] . "</p>
                <p class='date'>" . substr($row['created_at'], 10, 6) . "</p></div>
                </section>
                <br /><br />";
            }
            if ($row['id_user'] == $_GET["id_user"]){
                echo "<div class = 'mess2'>
                <p class='f'>".$row['name']."</p>
                <p class='text1'>" . $row['text'] . "</p>
                <p class='date1'>" . substr($row['created_at'], 10, 6) . "</p>
                </div>
                <br /><br />";  
            }
          
        }

    }
}

while ($row = $fr_name->fetch_assoc()) {
    if ($row['id_user'] == $_GET["id_user"]) {
        $your = $row['name'];
    }

}

if($message == ""){
    $error_mess ="Не возможно отправлять пустую строку!";
    $error = true;
}

if (isset($_POST['messages_send'])) {
    if(!$error)
    $mysql->query("INSERT INTO `messages` (`id_user_from`, `id_user_to`, `text`, `created_at`) VALUES('$current_user_id', '$id_user', '$message', '$today')");
}

function My_name($My_name)
{
    while ($row = $My_name->fetch_assoc()) {
        if ($row['id_user'] == $_SESSION['id_user']) {
            echo $row['name'];
        }
        if ($_GET["id_user"] == $row['id_user']) {

        }
    }
}

$mysql->close();
?>
<!DOCTYPE html>

<head>
    <title>Chat</title>
    <link href="style.css" rel="stylesheet">
</head>

<body style='background-color: #002d54;'>
    <html>
    <header class="header">
        <div class="flex">
            <h1 class="d">CHAT.RU</h1>
            <div class="general">
            <p class="My_name"><?= My_name($My_name) ?></p>
                <form action = "settings.php" method="get">
                    <button type='submit' name='update' class="user_id" value='<?= $current_user_id ?>'>
                </form>
            </div>
        </div>
    </header>
    <main>
        <section class="chat">
            <div class="block">
                <div class="mess">
                    <div class="fren">
                        <h1 class="text3">
                            <?= $your ?>
                        </h1>
                    </div>
                    <div class="block1">
                        <?= showMessages($showMessages) ?>
                    </div>
                </div>
                <div class="users">
                    <h1 class="frends">МОИ ДРУЗЬЯ</h1>
                    <?= printfriends($friends) ?>
                </div>
            </div>
            <div class="messages">
                <form class="form_send" action="" method="post">
                    <input class="textarea" type="text" name="message" placeholder="<?= $error_mess ?>">
                    <input type="submit" class="send" name="messages_send" value="Отправить">
                </form>
            </div>
        </section>
    </main>

    </html>
</body>