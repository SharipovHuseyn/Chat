<?php
session_start();

$mysql = new mysqli("localhost", "root", "", "Chat");
$mysql->query("SET NAMES 'utf8'");

$gallery = $mysql->query("SELECT * FROM `gallery`");
$img_id = $_SESSION["img"];

print_r($img_id);

// function friend($gallery){
// 	if ($gallery->num_rows > 0) {
//         while ($row = $gallery->fetch_assoc()) {
// 			if($_SESSION["img"] == $row['id_user']){
// 				echo "<div class='img_a'>
// 				<a href='comment.php'><img class='img_form' src='".$_SESSION['PATH']."' alt='".$row['name']."'></a>
// 				</div>";
// 			}
// 		}
// 	}
// }

if (isset($_GET["img"])) {
    $img_path = $_GET["img"];
}

print_r($img_path);

$mysql->close();
?>
<!DOCTYPE html>

<head>
    <title>Chat</title>
    <link href="test4.css" rel="stylesheet">
</head>

<body>
    <html>
    <div class="img">
        <div class='img_a'>
            <img class='img_form' src='".$path."' alt=''>
        </div>
    </div>

    </html>
</body>