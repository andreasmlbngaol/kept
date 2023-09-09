<?php
require "../functions.php";
session_start();
if(isset($_POST['submit'])) {
    if(checkEmail($_POST)) {
        $email = strtolower($_SESSION['email']);
        $code = strval(rand(100000, 999999));
        $_SESSION['code'] = $code;
        if(sendEmail($email, "Kode Verifikasi", codeTextHTML($code), codeTextNotHTML($code))) {
            jumpTo("codeverification.php");
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
    <title>Email dan Buat Password</title>
</head>
<body>
    <h1>Ini Halaman Daftar 3</h1>
    <form action="" method="post">
        <div>
            <label for="email">Masukin email</label>
            <input type="text" name="email" id="email" autocomplete="off" required>
        </div>
        <button type="submit" name="submit" id="submit">Lanjut</button>
    </form>
</body>
</html>