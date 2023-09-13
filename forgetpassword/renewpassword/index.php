<?php 
require "../../functions.php";
session_start();
if(!isset($_SESSION['emailrenew'])){
    jumpTo('../');
}
if(isset($_POST['submit'])) {
    if(checkPassword($_POST)) {
        if(renewPassword($_POST)) {
            alert('Dah berhasil. Ingat ya. Jangan banyak kali pikiran itu wkwkw');
            jumpTo('../../login/');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Password</title>
</head>
<body>
    <h1>Ini Halaman Memperbarui Password</h1>
    <form action="" method="post">
        <div>
            <label for="password">Buat Password</label>
            <input type="password" name="password" id="password" autocomplete="off" required>
        </div>
        <div>
            <label for="confirmPassword">Ulangin Password</label>
            <input type="password" name="confirmPassword" id="confirmPassword" autocomplete="off" required>
        </div>
        <button type="submit" name="submit" id="submit">Lanjut</button>
    </form>
</body>
</html>