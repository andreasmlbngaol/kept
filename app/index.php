<?php
require "../functions.php";
session_start();
if(!isset($_SESSION['usernamelogin'])) {
    jumpTo("../");
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
    <h1>Welcome tu kept, <?php echo "$name" ?></h1>
    <a href="logout.php">Keluar</a>
    <a href="keep/">Masukin Pengeluaran/Pemasukan</a>
</body>
</html>