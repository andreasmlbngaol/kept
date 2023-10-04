<?php
require "functions.php";
session_start();
if(isset($_SESSION['usernamelogin'])) {
    jumpTo("app/");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="src/img/logo kept 7.png" type="image/x-icon">
    <title>kept</title>
</head>
<body id="home">
    <nav id="home-header">
        <a href="" class="home-header-list" id="home-header-logo-container"><img src="src/img/logo.png" alt=""  id="home-header-logo"></a>
        <a href="login/" class="home-header-list">SIGN IN</a>
        <a href="" class="home-header-list">FAQ'S</a>
        <a href="" class="home-header-list">PRODUCT</a>
    </nav>

    <div id="home-menu-container">
        <div id="home-menu-text">
            <h2 class="home-menu-item"><span id="home-menu-text-motto">Smartly Kept, Wisely Flowed</span></h2>
            <h1 class="home-menu-item">LET'S TAKE YOUR <br>FLOW TO THE<br> NEXT LEVEL</h1>
            <p class="home-menu-item">You will have the best experience with thousands of smart individuals worldwide in managing their finances</p>
        </div>
        <div id="home-menu-img">
            <img src="src/img/logo.png" alt="Ini Gambar" id="home-img" class="home-menu-item">
        </div>
    </div>
    <a href="register/" id="home-register"><span id="home-register-text">GET STARTED</span></a>
</body>
</html>