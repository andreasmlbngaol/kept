<?php
require "../functions.php";
if(isset($_POST['submit'])) {
    if(login($_POST) > 0) {
        jumpTo("../app/index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ini Menu Login</title>
</head>
<body>
    <h1>Ini Halaman Login</h1>
    <form action="" method="post">
        <div>
            <label for="username">Username</label><br>
            <input type="text" name="username" id="username" autocomplete="off" required>
        </div>
        <div>
            <label for="password">Password</label><br>
            <input type="password" name="password" id="password" autocomplete="off" required>
        </div>
        <button type="submit" name="submit">Masuk</button>
    </form>
</body>
</html>