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
    <link rel="shortcut icon" href="../../src/img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../style.css">
    <title>RENEW PASSWORD</title>
</head>
<body>
    <nav id="home-header">
        <a href="../../" class="home-header-list" id="home-header-logo-container"><img src="../../src/img/logo.png" alt="logo.png"  id="home-header-logo"></a>
        <a href="" class="home-header-list">FAQ'S</a>
        <a href="" class="home-header-list">PRODUCT</a>
    </nav>
    <h1>Perbarui Password</h1>
    <form action="" method="post">
        <div>
            <input type="password" name="password" id="password" autocomplete="off" placeholder="Buat Password Baru" required>
        </div>
        <div>
            <input type="password" name="confirmPassword" id="confirmPassword" autocomplete="off" placeholder="Konfirmasi Password" required>
        </div>
        <button type="submit" name="submit" id="submit">UBAH</button>
    </form>
</body>
</html>