<?php
$mysql = new mysqli("localhost", "root", "", "Chat");
$mysql->query("SET NAMES 'utf8'");

$error = false;
$error_name = '';
$error_password = '';
$error_email = '';

if (isset($_POST["name"])) {
    $name = $_POST["name"];
}

if (isset($_POST["password"])) {
    $password = $_POST["password"];
}

if (isset($_POST["email"])) {
    $email = $_POST["email"];
}

if (isset($_GET["update"])) {
    $user_id = $_GET["update"];
}



if (isset($_POST["send"])) {

    if ($name == '') {
        $error_name = 'Введите своё имя';
        $error = true;
    }

    if ($password == '') {
        $error_password = 'Введите свой пороль';
        $error = true;
    }

    if($email == "" || !preg_match("/@/", $email)){
        $error_email ="Введите корректный email";
        $error =true;
    }

        if (!$error) { 
            $mysql->query("UPDATE `users` SET name = '$name', password = '$password', login = '$email' WHERE id_user = '$user_id'");
            header("Location: chat.php");
            exit;
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
    <main style='display: flex; justify-content: center; align-items: center; margin-top: 190px;'>
        <section class="reg">
            <br /><br />
            <h1 style="color:white;">Ввиводите изменения</h1><br />
            <form action="" method="POST">
                <label class="text_form">Имя:</label><br /><br />
                <input class="form_reg" type="text" name="name" /><br />
                <span style="color:red">
                    <?= $error_name ?>
                </span><br /><br />
                <label class="text_form">Пароль:</label><br /><br />
                <input class="form_reg" type="text" name="password"><br />
                <span style="color:red">
                    <?= $error_password ?>
                </span><br /><br />
                <label class="text_form">email:</label><br /><br />
                <input class="form_reg" type="text" name="email"><br /><br />
                <span style="color:red">
                    <?= $error_email ?>
                </span><br /><br />
                <input type="hidden" name="id" value="" />
                <input class="form_button" type="submit" name="send" value="Добавить">
            </form>
        </section>
    </main>

    </html>
</body>