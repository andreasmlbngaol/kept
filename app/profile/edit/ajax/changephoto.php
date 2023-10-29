<?php 
require "../../../functions.php";
$data = $_POST['image'];
list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);
$data = base64_decode($data);
$imageName = fetch('username').'.png';
file_put_contents('upload/'.$imageName, $data);
?>