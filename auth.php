<?php
session_start();

if(isset($_POST["send"])){
    $mysql = new mysqli("localhost", "root", "", "Chat");
    $mysql->query("SET NAMES 'utf8'");

    $_SESSION["login"] = $login;
    $_SESSION["password"] = $password;

    $error_login ="";
    $error_password ="";
    $error =false;

    if($login == "" || !preg_match("/@/", $login)){
        $error_login ="Введите корректный email";
        $error =true;
    }

    if(strlen($password) == 0){
        $error_password ="Введите свой пароль";
        $error =true;
    }

    $login = $_POST["login"];   
    $password = $_POST["password"];

    $query="SELECT * FROM users WHERE `login`='$login' AND BINARY `password`='$password'";
    $result=mysqli_query($mysql, $query);
    $user_data=mysqli_fetch_assoc($result);

    if ($user_data){
        $_SESSION['id_user'] = $user_data['id_user'];
        $_SESSION['login'] = $login;
        $_SESSION['password'] = $password;
        header ("Location: chat.php");
        exit;
    }
    else{
        echo'НЕ ПРАВИЛЬНО';
    }
    
    $mysql->close();
}
?>
<!DOCTYPE html>
<head>
<title>LOGIN</title>  
<link href="style.css" rel="stylesheet">
</head>
<body style='background-color: #002d54;'>
<html>
<main style='display: flex; justify-content: center; align-items: center; margin-top: 190px;'>
    <section class="reg">
    <br /><br /><h1 class="b"><b>LOGIN</b></h1>

<form action="" method="POST">
    <br /><br /><br /><br /><label class="text_form">Email:</label><br /><br />
    <span style="color:red"><?=$error_login?></span><br />
    <input class="form_reg" type="text" name="login" value="<?=$_SESSION["login"]?>"/><br /><br />
    <label class="text_form">Пароль:</label><br /><br />
    <span style="color:red"><?=$error_password?></span><br />
    <input class="form_reg" type="text" name="password" value="<?=$_SESSION["password"]?>"/><br /><br /><br /><br />
    <input class="form_button" type="submit" name="send" value="LOGIN">
</form>
    </section>
</main>
</html>
</body>