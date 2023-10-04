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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORGET PASSWORD</title>
</head>
<body>
    <h1>FORGET PASSWORD</h1>
    <form action="" method="post">
        <div>
            <input type="text" name="username" id="username" autocomplete="off" placeholder="Email/Username/Phone" required>
        </div>
        <button type="submit" name="submit">NEXT</button>
    </form>
</body>
</html>