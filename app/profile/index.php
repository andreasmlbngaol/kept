<?php
require "../../functions.php";
$id = fetch('id');
$email = fetch('email');
$username = fetch('username');
$hpnum = fetch('hpnum');
// $password = fetch('password');
if(isset($_POST['submit'])) {
    $value = $_SESSION['value'];
    $column = $value;
    $data = $_POST["$value"];
    
    if($column != 'email' && $column != 'hpnum' && $column != 'username') {
        $query = "UPDATE account SET $column = '$data' WHERE id = $id";
        mysqli_query($conn, $query);
    } else {
        if($column == 'email') {
            $_SESSION['email'] = $data;
            if(($data != $email) && checkEmail($_SESSION)) {
                $query = "UPDATE account SET $column = '$data' WHERE id = $id";
                mysqli_query($conn, $query);
            }
        } else if($column == 'hpnum') {
            $_SESSION['hpnum'] = $data;
            if(($data != $hpnum) && checkHpNum($_SESSION)) {
                $query = "UPDATE account SET $column = '$data' WHERE id = $id";
                mysqli_query($conn, $query);
            }
        } else {
            $_SESSION['username'] = $data;
            if(($data != $username) && checkUsername($_SESSION)) {
                $query = "UPDATE account SET $column = '$data' WHERE id = $id";
                mysqli_query($conn, $query);
                $_SESSION['usernamelogin'] = $data;
            }
        }
    session_abort();
    }
}

$username = fetch('username');
$email = fetch('email');
$hpnum = fetch('hpnum');
$name = fetch('name');
$nickname = fetch('nickname');
$birthday = fetch('birthday');

if($birthday[8] == '0') {
    $birthdayDate = $birthday[9];
} else {
    $birthdayDate = $birthday[8].$birthday[9];
}

$birthdayMonth = dateMonth($birthday);
$birthdayYear = $birthday[0].$birthday[1].$birthday[2].$birthday[3];
$birthday = $birthdayDate.' '.$birthdayMonth.' '.$birthdayYear;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style.css">
    <link rel="shortcut icon" href="../../src/img/icon.png" type="image/x-icon">
    <title>PROFILE</title>
</head>
<body>
    <nav id="app-header">
        <a href="../" class="app-header-list" id="app-header-logo-container"><img src="../../src/img/logo.png" alt="logo.png"  id="app-header-logo"></a>
        <a href="../keep/" class="app-header-list">KEEP</a>
        <a href="" class="app-header-list">PROFILE</a>
        <a href="../logout.php" class="app-header-list">LOGOUT</a>
    </nav>
    <h2>Profile Picture</h2>
    <img src="https://drive.google.com/uc?id=14qoFeqx54p3mdI-nkMTpMqh_-JIpVIjJ" alt="Profile Picture">
    <div>
        <ul>
            <li id="profile-name">Full Name: <?php echo $name ?> <button value="name" id="button-name">Change</button></li>
            <li id="profile-nickname">Nickname: <?php echo $nickname ?> <button value="nickname" id="button-nickname">Change</button></li>
            <li id="profile-email">Email: <?php echo $email ?> <button value="email" id="button-email">Change</button></li>
            <li id="profile-hpnum">Phone Number: <?php echo $hpnum ?> <button value="hpnum" id="button-hpnum">Change</button></li>
            <li id="profile-username">Username: <?php echo $username ?> <button value="username" id="button-username">Change</button></li>
            <li id="profile-birthday">Birthday: <?php echo $birthday ?> <button value="birthday" id="button-birthday">Change</button></li>
        </ul>
    </div>
    <script src="script.js"></script>
</body>
</html>