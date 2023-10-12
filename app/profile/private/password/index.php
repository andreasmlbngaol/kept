<?php
require "../../../../functions.php";
if(isset($_POST['submit'])) {
    $truePassword = fetch('password');
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];
    if(verifyPassword($oldPassword, $truePassword)) {
        if($newPassword !== $confirmPassword){
            alert('Password is not matching');
        } else {
            if(changePassword($newPassword)) {
                alert('Password is changed');
                jumpTo('../../edit/');
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../../style.css">
    <link rel="shortcut icon" href="../../../../src/img/icon.png" type="image/x-icon">
    <title>CHANGE PASSWORD</title>
</head>
<body>
    <nav id="app-header">
        <a href="../../../" class="app-header-list" id="app-header-logo-container"><img src="../../../../src/img/logo.png" alt="logo.png"  id="app-header-logo"></a>
        <a href="../../../keep/" class="app-header-list">KEEP</a>
        <a href="../../" class="app-header-list">PROFILE</a>
        <a href="../../../logout.php" class="app-header-list">LOGOUT</a>
    </nav>
    <br><br>
    <a href="../../">BACK</a><br><br>
    <div>
        <form action="" method="post">
            <div>
                <label for="old-password">Old Password:</label><br>
                <input type="password" name="oldPassword" id="old-password" required>
            </div>
            <div>
                <label for="new-passsword">New Password:</label><br>
                <input type="password" name="newPassword" id="new-password" required>
            </div>
            <div>
                <label for="confirm-password">Confirm New Password:</label><br>
                <input type="password" name="confirmPassword" id="confirm-password" required>
            </div>
            <button type="submit" name="submit" id="submit">RENEW PASSWORD</button>
        </form>
    </div>
    <script src="script.js"></script>
</body>
</html>