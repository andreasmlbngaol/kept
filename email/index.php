<?php
require "../functions.php";
if(isset($_POST['email'])) {
    $to = $_POST['email'];
    $code = strval(rand(100000,999999));
    session_start();
    $_SESSION['code'] = $code;
    if(sendEmail($code, $to) == true) {
        alert("Sukses");
        jumpTo('../index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi</title>
</head>
<body>
    <form action="" method="post">
        <label for="email">Email Tujuan</label><br>
        <input type="text" name="email" id="email">
        <button type="submit">Kirim</button>
    </form>
</body>
</html>