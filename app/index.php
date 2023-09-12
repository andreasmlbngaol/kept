<?php
require "../functions.php";
session_start();
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    jumpTo("../index.php");
}
$name = fetch('nickname');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h1>Welkam tu kept, <?php echo "$name" ?></h1>

</body>
</html>