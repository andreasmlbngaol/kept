<?php
require "../functions.php";
session_start();
if(!isset($_SESSION['username'])){
    jumpTo('register.php');
}
if(isset($_POST['submit'])) {
    $code = strval(100000,999999);
    if(sendEmail("$code", "andreaspremium006@gmail.com") == true) {
        alert('Sukses');
        jumpTo('../index.php');
    }
    if(register($_POST) > 0) {
        alert("Berhasil. Balik ke menu awal");
        session_destroy();
        jumpTo("../index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register 2</title>
</head>
<body>
    <h1>Ini halaman register 2</h1>
    <form action="" method="post">
        <div>
            <label for="name">Nama Lengkap</label><br>
            <input type="text" name="name" id="name" autocomplete="off" required>
        </div>
        <div>
            <label for="nickname">Nama Panggilan</label><br>
            <input type="text" name="nickname" id="nickname" autocomplete="off" required>
        </div>
        <div>
            <label for="email">Email</label><br>
            <input type="text" name="email" id="email" autocomplete="off" required>
        </div>
        <div>
            <label for="birthday">Tanggal Lahir</label><br>
            <input type="date" name="birthday" id="birthday" autocomplete="off" required>
        </div>
        <div>
            <label for="quest">Pertanyaan Konfirmasi Lupa Password</label><br>
            <input type="text" name="quest" id="quest" autocomplete="off" required>
        </div>
        <div>
            <label for="ans">Jawaban</label><br>
            <input type="text" name="ans" id="ans" autocomplete="off" required>
        </div>
        <div>
            <label for="clue">Petunjuk</label><br>
            <input type="text" name="clue" id="clue" autocomplete="off" required>
        </div>
        <button type="submit" name="submit">Daftar</button>
    </form>
</body>
</html>