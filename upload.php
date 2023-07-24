<?php
session_start();

$mysql = new mysqli("localhost", "root", "", "Chat");
$mysql->query("SET NAMES 'utf8'");
$gallery = $mysql->query("SELECT * FROM `gallery`");
$friend = $mysql->query("SELECT * FROM `gallery`");
$current_user_id = $_SESSION['id_user'];

if (isset($_GET["upload"])) {
    $user_id = $_GET["upload"];
}

if (isset($_POST["fileToUpload"])) {
    $image_name = $_POST["fileToUpload"];
}

if (isset($_POST["submit"])) {
    $name = "/opt/lampp/htdocs/chat/form-data/data".$_FILES["fileToUpload"]["name"];
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $name);

    $mysql->query("INSERT INTO `gallery` (`name`, `path`, `id_user`) VALUES('$image_name', '$name', '$user_id')");
}

function friend($friend){
	if ($friend->num_rows > 0) {
        while ($row = $friend->fetch_assoc()) {
			if($_GET["upload"] == $_SESSION['id_user']){
				echo '<form action="upload.php?id_user="'.$_SESSION['id_user'].'"" method="post" enctype="multipart/form-data">
				Выберите изоброжения:<br />
				<br /><input type="file" name="fileToUpload" id="fileToUpload">
				<br /><br />Имя изоброжения:
				<br /><br /><input type="text" name="fileToUpload">
				<br /><br /><input type="submit" value="Upload Image" name="submit"><br /><br />
			</form>';
			}
			if($_GET["upload"] == $row['id_user']){
				echo "<img class='img_form' src='".substr($row['path'], 23)."' alt='".$row['name']."'>";
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
		<link rel="stylesheet" href="./test4.css"/>
		 <link rel="stylesheet" type="text/css" href="./font-awesome/css/font-awesome.css">
</head>
	</head>
	<div class="container1">

		<div class="container">

			<div class="display flex">

				<div class="png">
					<img src="./img/logo.png"/>
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
			<img class="supercar" src="./img/supercarcomp.jpg">
			
			<div class="container2">
				<div class="block">
					<h2><span><strong>supercarcompany</strong></span></h2><button class="button">подписаться</button>
				</div>
				<h3>
				<span class="text">
					<b>545</b>публикаций  <b>51,7 тыс.</b> подписчиков <b>175</b> подпичиков
				</span>
				<span class="text1"><strong>supercar company</strong></span>
				<span class="text2"><img class="svg"src="./img/icons/petrol_station.svg"> THE HOME OF SUPERCARS</span>
				<span class="text3"><img src="./img/icons/порщень.svg">Fouwer/Ower:@misterkyc</span>
				<span class="text4"><img src="./img/icons/рука.svg">Use #SupercarCompany to get featured!</span>
				<span class="text5"><img src="./img/icons/канверт.svg">DM for Inquiries/Partnerships!</span>
				</h3>
			</div>
		</div>
	</div>
	<br />
	<br />
	<hr />
	<!-- <div class="container3">
		<div class="center">
			<img class="bmw"src="./img/votes/vote.jpg">
			<span class="text6"><strong>BATLLES</strong></span>
		</div>
		<div class="center">
			<img class="bmw"src="./img/votes/vote2.jpg">
			<span class="text6"><strong>YOUR OPINION V</strong></span>
		</div>
		<div class="center">
			<img class="bmw"src="./img/votes/vote3.jpg">
			<span class="text6"><strong>PHOTOS/INOS||</strong></span>
		</div class="center">
		<div>	<img class="bmw"src="./img/votes/vote4.jpg">
			<span class="text6"><strong>BATLLES V</strong></span></div class="center">

			<div class="center"><img class="bmw"src="./img/votes/vote5.jpg">
				<span class="text6"><strong>YOUR OPINION |V</strong></span></div>	
				<div class="center">	<img class="bmw"src="./img/votes/vote6.jpg">
					<span class="text6"><strong>PHOTOS/INOS</strong></span></div>
					<div class="center">	<img class="bmw"src="./img/votes/vote7.jpg">
						<span class="text6"><strong>BATLLES|V</strong></div>
						</span>
	       </div> -->
    <!-- <form class="form_scratch" action="" method="post">
        <br /><br /><input class="imput_text" type="text" name="name_img" placeholder="Имя изоброжения:">
        <input class="imput_submit" type="submit" value="поиск" name="send">
    </form>
	<br/>
	<br/>
	<br/>
	<br/>
		   <hr />
		   <br />
		   <form style="margin-left: 853px" action="upload.php" method="post" enctype="multipart/form-data">
        Выберите изоброжения:<br />
        <br /><input type="file" name="fileToUpload" id="fileToUpload">
        <br /><br />Имя изоброжения:
        <br /><br /><input type="text" name="fileToUpload">
        <br /><br /><input type="submit" value="Upload Image" name="submit"><br /><br />
    </form>
	<hr/> -->
    <div class="img">
        <?=friend($friend)?>
    </div>
			   <hr/>
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
    	<span class="text01"> Информация</span><span class="text01">Блог</span><span class="text01">Вакансии</span><span class="text01"></span> <span class="text01"> Помощь</span> <span class="text01">API</span><span class="text01">Конфиденциальность </span><span class="text01">Условия</span> <span class="text01">Популярние аккаунты</span><span class="text01"> Хештеги </span><span class="text01">Места</span>
    	</span>                                   
    </div>	

    </div>
</body>
