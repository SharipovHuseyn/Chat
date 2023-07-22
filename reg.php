<?php 
$mysql = new mysqli("localhost", "root", "", "Chat");
$mysql->query("SET NAMES 'utf8'");

if(isset($_POST["send"])){
    if(isset($_POST["name"])){
        $name = $_POST["name"];
    }
    if(isset($_POST["login"])){
      
        $login = $_POST["login"];
    }
    if(isset($_POST["password"])){
      
        $password = $_POST["password"];
    }

    $_SESSION["name"] = $name;
    $_SESSION["login"] = $login;
    $_SESSION["password"] = $password;
    
    $error_name ="";
    $error_login ="";
    $error_password ="";
    $error =false;

    if($name == ""){
        $error_name ="Введите своё имя";
        $error =true;
    }

    if($login == "" || !preg_match("/@/", $login)){
        $error_login ="Введите корректный email";
        $error =true;
    }

    if(strlen($password) == 0){
        $error_password ="Введите свой пороль";
        $error =true;
    }

    if(!$error){
        $mysql->query("INSERT INTO `users` (`name`, `login`, `password`) VALUES('$name', '$login', '$password')");
        header ("Location: chat.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<head>
<title>Регестрация</title>  
<link href="style.css" rel="stylesheet">
</head>
<body style='background-color: #002d54;'>
<html>
<header>
</header>
<main style='display: flex; justify-content: center; align-items: center; margin-top: 190px;'>
    <section class="reg">
    <br /><br /><h1 class="b"><b>Регестрация</b></h1>

<form action="" method="POST">
    <br /><br /><label class="text_form" placeholder="<?=$error_name?>">Имя:</label><br />
    <span style="color:red"><?=$error_name?></span><br />
    <input class="form_reg" type="text" name="name" value="<?=$_SESSION["name"]?>"/><br /><br />
    <label class="text_form">Email:</label><br />
    <span style="color:red"><?=$error_login?></span><br />
    <input class="form_reg" type="text" name="login" value="<?=$_SESSION["login"]?>"/><br /><br />
    <label class="text_form">Пароль:</label><br />
    <span style="color:red"><?=$error_password?></span><br />
    <input class="form_reg" type="text" name="password" value="<?=$_SESSION["password"]?>"/><br /><br /><br /><br />
    <input class="form_button" type="submit" name="send" value="Регестрация">
</form>
    </section>
</main>
</html>
</body>