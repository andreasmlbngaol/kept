<?php
require "../functions.php";
if(isset($_POST['submit'])) {
    if(checkUsername($_POST)) {
        jumpTo("insertemail.php");
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat username</title>
</head>
<body>
    <h1>Ini Halaman Daftar 2</h1>
    <form action="" method="post">
        <div>
            <label for="username">Buat username</label>
            <input type="text" name="username" id="username" autocomplete="off" required>
        </div>
        <button type="submit" name="submit" id="submit">Lanjut</button>
    </form>
</body>
</html>