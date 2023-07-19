<!DOCTYPE html>
<html>
<head>
<title>METANIT.COM</title>
<meta charset="utf-8" />
</head>
<body>
<?php
if($_FILES)
{
    foreach ($_FILES["uploads"]["error"] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES["uploads"]["tmp_name"][$key];
            $name = $_FILES["uploads"]["name"][$key];
            move_uploaded_file($tmp_name, "$name");
        }
    }
    echo "Файлы загружены";
}
?>
<h2>Загрузка файла</h2>
<form method="post" enctype="form-data/data">
    <input type="file" name="uploads[]" /><br />
    <input type="file" name="uploads[]" /><br />
    <input type="file" name="uploads[]" /><br />
    <input type="submit" value="Загрузить" />
</form>
</body>
</html>