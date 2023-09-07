<?php
    require "functions.php";
    if(isset($_POST['submit'])) {
        if(register($_POST) > 0) {
            alert("Berhasil. Balik ke menu awal");
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
            <label for="name">Nama Lengkap</label>
            <input type="text" name="name" id="name" required>
        </div>
        <div>
            <label for="nickname">Nama Panggilan</label>
            <input type="text" name="nickname" id="nickname" required>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="text" name="email" id="email" required>
        </div>
        <div>
            <label for="birthday">Tanggal Lahir</label>
            <input type="date" name="birthday" id="birthday" required>
        </div>
        <div>
            <label for="quest">Pertanyaan Konfirmasi Lupa Password</label>
            <input type="date" name="quest" id="quest" required>
        </div>
        <div>
            <label for="ans">Jawaban</label>
            <input type="date" name="ans" id="ans" required>
        </div>
        <div>
            <label for="clue">Petunjuk</label>
            <input type="date" name="clue" id="clue" required>
        </div>
        <button type="submit" name="submit">Daftar</button>
    </form>
</body>
</html>