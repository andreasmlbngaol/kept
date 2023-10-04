<?php
require "../../functions.php";
session_start();
if(isset($_POST['submit'])) {
    if(checkCode($_POST)) {
        jumpTo("../renewpassword/");
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VERIFICATION</title>
</head>
<body>
    <h1>CODE VERIFICATION</h1>
    <form action="" method="post">
        <div>
            <input type="text" name="confirmCode" id="confirmCode" autocomplete="off" placeholder="Insert Code" required>
        </div>
        <button type="submit" name="submit" id="submit">NEXT</button>
    </form>
</body>
</html>