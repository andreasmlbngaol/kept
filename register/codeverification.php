<?php
require "../functions.php";
session_start();
if(isset($_POST['submit'])) {
    if(checkCode($_POST)) {
        if(register($_SESSION)) {
            alert('Oke Sip. Akun mu dah dibuat. Detailnya dikirim ke email ya. Sekarang ke home dulu');
            jumpTo('../');
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
    <title>Verifikasi Kode</title>
</head>
<body>
    <h1>Ini Halaman Daftar 4</h1>
    <form action="" method="post">
        <div>
            <label for="confirmCode">Masukin kode verifikasi yang udah dikirim ke emailmu</label>
            <input type="text" name="confirmCode" id="confirmCode" autocomplete="off" required>
        </div>
        <button type="submit" name="submit" id="submit">Lanjut</button>
    </form>
</body>
</html>