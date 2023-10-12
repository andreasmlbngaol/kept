<?php
require "../../../../../functions.php";
if(isset($_POST['submit'])) {
    if(checkCode($_POST)) {
        $confirmPassword = $_POST['password'];
        $truePassword = fetch('password');
        session_start();
        $email = $_SESSION['email'];
        session_abort();
        if(verifyPassword($confirmPassword, $truePassword)) {
            if(changeEmail($email)) {
                alert('Email is changed');
                jumpTo('../../../edit/');
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../../../src/img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../../../../style.css">
    <title>VERIFICATION</title>
</head>
<body>
    <nav id="home-header">
        <a href="../../" class="home-header-list" id="home-header-logo-container"><img src="../../../../../src/img/logo.png" alt="logo.png"  id="home-header-logo"></a>
        <a href="" class="home-header-list">FAQ'S</a>
        <a href="" class="home-header-list">PRODUCT</a>
    </nav>
    <h1>CODE VERIFICATION</h1>
    <form action="" method="post">
        <div>
            <label for="confirmCode">Verification Code:</label><br>
            <input type="text" name="confirmCode" id="confirmCode" autocomplete="off" required>
        </div>
        <div>
            <label for="password">Password:</label><br>
            <input type="password" name="password" id="password" required>
        </div>
        <button type="submit" name="submit" id="submit">NEXT</button>
    </form>
</body>
</html>