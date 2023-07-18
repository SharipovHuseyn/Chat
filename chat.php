<?php
session_start();
$current_user_id = $_SESSION['id_user'];

$mysql = new mysqli("localhost", "root", "", "Chat");
$mysql->query("SET NAMES 'utf8'");

$result = $mysql->query("SELECT * FROM `users`");
$mess = $mysql->query("SELECT * FROM `messages`");
$My_name = $mysql->query("SELECT * FROM `users`");
$f_name = $mysql->query("SELECT * FROM `users`");
$today = date_default_timezone_set('Tajikistan/Dushanbe');

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

function printResult($result)
{
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
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
// function f_name($f_name)
// {
//     while ($row = $f_name->fetch_assoc()) {
//         if ($row['id_user'] == $_GET["id_user"]) {
//             $row['name'];
//         }

//     }
// }

function mess($mess)
{
    if ($mess->num_rows > 0) {
        while ($row = $mess->fetch_assoc()) {
            $row['id_user_from'] . "<br />";
            $row['id_user_to'];
            $row['id_user'];
            
            if ($row['id_user_to'] == $_GET["id_user"]) {
                echo "<section class='soob'>
                <div class = 'mess1'><p class='text1'>" . $row['text'] . "</p></div>
                </section><p class='date'>" . $row['created_at'] . "</p>
                <br /><br />";
            }
            // elseif ($row['id_user'] == $_GET["id_user"]) {
            //     echo "<p class='your'>" . $row['f_name'] . "</p>";
            //     ;
            // }
            if ($row['id_user_from'] == $_GET["id_user"]) {
                if ($row['id_user'] == $_GET["id_user"]){
                echo "ffff";
                }
                echo "<div class = 'mess2'>
                <p class='text1'>" . $row['text'] . "</p></div>
                <p class='date1'>" . $row['created_at'] . "</p>
                <br /><br />";
            }
        }

    }
}
// function print_arr($data)
// {
//     echo '<pre>';
//     print_r($data);
//     echo '</pre>';
// }

while ($row = $f_name->fetch_assoc()) {
    if ($row['id_user'] == $_GET["id_user"]) {
        $your = $row['name'];
    }

}

if($message == ""){
    $error_mess ="Не возможно отправлять пустую строку!";
    $error = true;
}

if (isset($_POST['send'])) {
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
            <div class="My_name">
                <form action = "settings.php" method="get">
                    <input type='submit' name='update' style='border: 1px; background-color: dodgerblue; color: white; margin-left: 695px; padding: 10px 20px; font-size: 18px; border-radius: 12px; margin-top: 5px;' value='<?= My_name($My_name) ?>'>
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
                        <?= mess($mess) ?>

                    </div>
                </div>
                <div class="users">
                    <h1 class="frends">МОИ ДРУЗЬЯ</h1>
                    <?= printResult($result) ?>
                </div>
            </div>
            <div class="messages">
                <form class="form_send" action="" method="post">
                    <input class="textarea" type="text" name="message" placeholder="<?= $error_mess ?>">
                    <input type="submit" class="send" name="send" value="Отправить">
                </form>
            </div>
        </section>
    </main>

    </html>
</body>