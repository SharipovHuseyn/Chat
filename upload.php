<?php
session_start();

$mysql = new mysqli("localhost", "root", "", "Chat");
$mysql->query("SET NAMES 'utf8'");
$gallery = $mysql->query("SELECT * FROM `gallery`");
$my_data = $mysql->query("SELECT * FROM `users`");
$current_user_id = $_SESSION['id_user'];
$_SESSION['img'] = $_GET["upload"];


if (isset($_GET["upload"])) {
	$user_id = $_GET["upload"];
}

if (isset($_POST["fileToUpload"])) {
	$image_name = $_POST["fileToUpload"];
}

if ($my_data->num_rows > 0) {
	while ($row = $my_data->fetch_assoc()) {
		if ($_GET["upload"] == $row['id_user']) {
			$my_name = $row['name'];
			$avatar = substr($row['avatar'], 23);
		}
	}
}

if (isset($_POST["submit"])) {
	$name = "/opt/lampp/htdocs/chat/form-data/data" . $_FILES["fileToUpload"]["name"];
	move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $name);

	$mysql->query("INSERT INTO `gallery` (`name`, `path`, `id_user`) VALUES('$image_name', '$name', '$user_id')");
}

if ($_GET["upload"] == $_SESSION['id_user']) {
	$add_image = '<form action="" method="post" enctype="multipart/form-data">
	Выберите изоброжения:<br />
	<br /><input type="file" name="fileToUpload" id="fileToUpload">
	<br /><br />Имя изоброжения:
	<br /><br /><input type="text" name="fileToUpload">
	<br /><br /><input type="submit" value="Upload Image" name="submit"><br /><br />
</form>
<hr/>';
}

if($user_id == false){
	echo '<h1 class="text3">Chat.ru</h1>';
	return;
}

function friend($gallery)
{
	if ($gallery->num_rows > 0) {
		while ($row = $gallery->fetch_assoc()) {
			if ($_GET["upload"] == $row['id_user']) {
				$_SESSION['PATH'] = substr($row['path'], 23);
				echo "<form action='comment.php' method='get'><div class='img_a'>";
				$path = "<a href='comment.php?id=".$_SESSION['PATH']."'name='img'>";
				echo "<img class='img_form' src='" . substr($row['path'], 23) . "' alt='" . $row['name'] . "'>
				</a>
				</div></form>";
			}
		}
	}
}

$mysql->close();
?>
<!DOCTYPE html>
<html lang="en">

<body style="background-color: #fbfbfb">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Chat</title>
		<link rel="stylesheet" href="./test4.css" />
		<link rel="stylesheet" type="text/css" href="./font-awesome/css/font-awesome.css">
	</head>
	</head>
	<div class="container1">

		<div class="container">

			<div class="display flex">

				<div class="png">
					<img src="./img/logo.png" />
				</div>
				<div class="svg">
					<img src="./img/icons/compass.svg">
					<img src="./img/icons/direct.svg">
					<img src="./img/icons/heart.svg">
					<img src="./img/icons/home.svg">
					<div class="jpg">
						<img src="./img/avatar.jpg">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="png12">
		<div class="container">
			<div class="block1">
				<img class="supercar" src="<?= $avatar ?>">

				<div class="container2">
					<div class="block">
						<h2><span><strong>
									<?= $my_name ?>
								</strong></span></h2><button class="button">подписаться</button>
					</div>
				</div>
			</div>
		</div>
		<br />
		<br />
		<hr />
		<?= $add_image ?>
		<div class="img">
			<div class='position_img'>
				<?= friend($gallery) ?>
			</div>
		</div>
		<hr />
		<div class="display01">
			<span class="text0"><i class="fa fa-th" aria-hidden="true"></i><strong>публикатции</strong></span>
			<span class="text0"><i class="fa fa-caret-square-o-left" aria-hidden="true"></i>REEL</span>
			<span class="text0"><i class="fa fa-television" aria-hidden="true"></i>IGTV</span>
			<span class="text0"><i class="fa fa-user-o" aria-hidden="true"></i>отметки</span>

		</div>
		<div class="display0">

		</div>
		<p class="border">

		</p>

		<div class="display02">
			<span class="text01"> Информация</span><span class="text01">Блог</span><span
				class="text01">Вакансии</span><span class="text01"></span> <span class="text01"> Помощь</span> <span
				class="text01">API</span><span class="text01">Конфиденциальность </span><span
				class="text01">Условия</span> <span class="text01">Популярние аккаунты</span><span class="text01">
				Хештеги </span><span class="text01">Места</span>
			</span>
		</div>

	</div>
</body>