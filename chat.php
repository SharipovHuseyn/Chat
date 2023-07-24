<?php
session_start();

$mysql = new mysqli("localhost", "root", "", "Chat");
$mysql->query("SET NAMES 'utf8'");

$friends = $mysql->query("SELECT * FROM `users`");
$My_img = $mysql->query("SELECT * FROM `users`");
$My_name = $mysql->query("SELECT * FROM `users`");
$fr_name = $mysql->query("SELECT * FROM `users`");
$today = date_default_timezone_set('Tajikistan/Dushanbe');
$showMessages = $mysql->query("SELECT users.id_user, users.name, users.avatar,  messages.text, messages.id_user_from, messages.id_user_to, messages.created_at FROM users INNER JOIN messages ON messages.id_user_from = users.id_user");

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
print_r($id_user);
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
                echo "<div class='use'>
                        <a href='chat.php?id_user=" . $row['id_user'] . "' class='users_1'>
                            <p class='name_sty'>" . $row['name'] . "</p>
                            <img class='avatar_2' src='" . substr($row['avatar'], 23) . "' alt='" . $row['name'] . "/>
                            // <b style.color= 'red';'></b>
                        <br />
                        </a>
                        <form class='img_add' action='upload.php' method='get'>
                            <button class='ins' type='submit' name='upload' value='".$row['id_user']."'>
                                <img class='inst' src='image/img.png' alt='".$row['name'] ."/>
                            // <b style.color= 'red';'></b>
                            </button>
                        </form>
                        </div>";
            }

        }
    }
}

function showMessages($showMessages)
{
    if ($showMessages->num_rows > 0) {
        while ($row = $showMessages->fetch_assoc()) {
            if($row['id_user_to'] == $_GET["id_user"])
                if ($row['id_user_from'] == $_SESSION['id_user']) {
                    echo "<section class='soob'>
                    <div class = 'mess1'>
                    <img class='avatar' src='" . substr($row['avatar'], 23) . "' alt='" . $row['name'] . "/>
                    // <b style.color= 'red';'></b>
                    <p class='text1'>" . $row['text'] . "</p>
                    <p class='date'>" . substr($row['created_at'], 10, 6) . "</p></div>
                    </section>
                    <br /><br />";
                }
            if($row['id_user_to'] == $_SESSION['id_user'])
                if ($row['id_user_from'] == $_GET["id_user"]) {
                    echo "<div class = 'mess2'>
                    <img class='avatar' src='" . substr($row['avatar'], 23) . "' alt='" . $row['name'] . ">
                    // <b style.color= 'red';'></b>
                    <p class='f'>" . $row['name'] . "</p>
                    <p class='text1'>" . $row['text'] . "</p>
                    <p class='date1'>" . substr($row['created_at'], 10, 6) . "</p>
                    </div>
                    <br /><br />";
                }
        }

    }
}

function fr_name($fr_name){
    while ($row = $fr_name->fetch_assoc()) {
        if ($row['id_user'] == $_GET["id_user"]) {
            echo "<h1 class='text3'>".$row['name']."</h1>
            <img class='avatar_4' src='".substr($row['avatar'], 23)."' alt='".$row['name']."' />";
        }
    
    }
}

if ($message == "") {
    $error_mess = "Не возможно отправлять пустую строку!";
    $error = true;
}

if (isset($_POST['messages_send'])) {
    if (!$error)
        $mysql->query("INSERT INTO `messages` (`id_user_from`, `id_user_to`, `text`, `created_at`) VALUES('$current_user_id', '$id_user', '$message', '$today')");
}

function My_img($My_img)
{
    while ($row = $My_img->fetch_assoc()) {
        if ($row['id_user'] == $_SESSION['id_user']) {
            echo "" . substr($row['avatar'], 23) . "";
        }
    }
}
function My_name($My_name)
{
    while ($row = $My_name->fetch_assoc()) {
        if ($row['id_user'] == $_SESSION['id_user']) {
            echo $row['name'];
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
                <div class="My_name">
                    <p href="setings.php">
                        <?= My_name($My_name) ?>
                    </p>
                    <img class='avatar_3' src="<?= My_img($My_img) ?>" alt="<?= My_img($My_img) ?>" />
                </div>
            </div>
            <form action="settings.php" method="get">
                <button type='submit' name='update' class="user_id" value='<?= $current_user_id ?>'>
            </form>
            <div>
                <form class='img_add' action='upload.php?id_user="<?=$current_user_id?>"' method='get'>
                    <button class='add' type='submit' name='upload' value='<?=$current_user_id?>'>
                        <img class='add_img' src='image/img_add.png' alt='add'/>
                    </button>
                </form>
            </div>
        </div> 

    </header>
    <main>
        <section class="chat">
            <div class="block">
                <div class="mess">
                    <div class="fren">
                        <?=fr_name($fr_name)?>
                    </div>
                    <div class="block1">
                        <?= showMessages($showMessages) ?>
                    </div>
                </div>
                <form class="form_send" action="" method="post">
                    <input class="textarea" type="text" name="message" placeholder="<?= $error_mess ?>">
                    <input type="submit" class="send" name="messages_send" value="Отправить">
                </form>
                <div class="users">
                    <h1 class="frends">МОИ ДРУЗЬЯ</h1>
                    <?= printfriends($friends) ?>
                </div>
            </div>
        </section>
    </main>
    </html>
</body>