<?php
$mysql = new mysqli("localhost", "root", "", "Chat");
$mysql->query("SET NAMES 'utf8'");
$gallery = $mysql->query("SELECT * FROM `gallery`");

if (isset($_POST["fileToUpload"])) {
    $image_name = $_POST["fileToUpload"];
}

if (isset($_POST["submit"])) {
    $name = "/opt/lampp/htdocs/chat/form-data/data" . $_FILES["fileToUpload"]["name"];
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $name);

    $mysql->query("INSERT INTO `gallery` (`name`, `path`) VALUES('$image_name', '$name')");
}

if(isset($_POST["send"])){
    function gallery($gallery){
        while ($row = $gallery->fetch_assoc()) {
            if ($row['name'] == $_POST["name_img"]) {
                echo "<img src='".substr($row['path'], 23)."' alt='".$row['name']."'>";
            } 
    
        }
    }
}

$mysql->close();
?>
<!DOCTYPE html>
<html>
<body>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        Выберите изоброжения:<br />
        <br /><input type="file" name="fileToUpload" id="fileToUpload">
        <br /><br />Имя изоброжения:
        <br /><br /><input type="text" name="fileToUpload">
        <br /><br /><input type="submit" value="Upload Image" name="submit"><br /><br /><br />
    </form>
    <hr/>
    <form action="" method="post">
        <br /><br />Имя изоброжения:
        <br /><br /><input type="text" name="name_img">
        <input type="submit" value="поиск" name="send">
    </form>
    <div class="img">
        <?=gallery($gallery)?>
    </div>
</body>
</html>