<?php
// require "functions.php";
// if(isset($_POST['register'])) {
//     if(checkUsernameAndPassword($_POST) > 0) {
//         jumpTo("register2.php");
//     }
// }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h1>Ini Halaman Daftar</h1>
    <form action="" method="post">
        <div>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="text" name="password" id="password" required>
        </div>
        <div>
            <label for="confirmPassword">Konfirmasi Password</label>
            <input type="text" name="confirmPassword" id="confirmPassword" required>
        </div>
        <button type="submit" name="submit">Selanjutnya</button>
    </form>
</body>
</html>