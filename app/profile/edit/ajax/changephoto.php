<?php
require "../../../../functions.php";
$folderPath = '../../../../src/img/profilepicture/';
$image_parts = explode(";base64,", $_POST['image']);
$image_type_aux = explode("image/", $image_parts[0]);
$image_type = $image_type_aux[1];
$image_base64 = base64_decode($image_parts[1]);
$image_name = fetch('username') . '.png';
$file = $folderPath . $image_name;
file_put_contents($file, $image_base64);
$id = fetch('id');
$query = "UPDATE account SET picture = '$image_name' WHERE id = $id";
if(!mysqli_query($conn, $query)) {
    alert('Maaf ada kesalahan, kami sangat mengapresiasi jika kamu mau melaporkan ini. Terima kasih.');
}
echo json_encode(["image uploaded successfully."]);
?>