<?php
require "../functions.php";
session_start();
if(isset($_POST['submit'])) {
    if(forgetPassword($_POST)) {
        alert("Dah dikirim tuh ke email. Jangan terlalu banyak pikiran ya. wkwk");
        jumpTo('../login/');
    }
}   
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ini Menu Lupa Password</title>
</head>
<body>
    <h1>Ini Halaman Lupa Password</h1>
    <form action="" method="post">
        <div>
            <label for="username">Username/Email/No.HP</label><br>
            <input type="text" name="username" id="username" autocomplete="off" required>
        </div>
        <button type="submit" name="submit">Masuk</button>
    </form>
</body>
</html>