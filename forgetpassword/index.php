<?php
require "../functions.php";
session_start();
if(isset($_POST['submit'])) {
    if(forgetPassword($_POST)) {
        alert("Dah dikirim tuh ke email {$_SESSION['privateEmail']} kodenya");
        jumpTo('codeverification/');
    }
}   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../src/img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../style.css">
    <title>FORGET PASSWORD</title>
</head>
<body>
    <nav id="home-header">
        <a href="../" class="home-header-list" id="home-header-logo-container"><img src="../src/img/logo.png" alt="logo.png"  id="home-header-logo"></a>
        <a href="" class="home-header-list">FAQ'S</a>
        <a href="" class="home-header-list">PRODUCT</a>
    </nav>
    <h1>FORGET PASSWORD</h1>
    <form action="" method="post">
        <div>
            <input type="text" name="username" id="username" autocomplete="off" placeholder="Email/Username/Phone" required>
        </div>
        <button type="submit" name="submit">NEXT</button>
    </form>
</body>
</html>