<?php
require "functions.php";
$img = "src/img/profilepicture/653e68c58408d.png";
$imgPath = $directoryPath.$img;
var_dump(file_exists($imgPath));
if(file_exists("$imgPath")) {
    unlink("$imgPath");
}
echo "File telah dihapus";
var_dump(file_exists($imgPath));
?>