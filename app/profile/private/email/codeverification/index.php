<?php
require "../../../../../functions.php";
if(isset($_POST['submit'])) {
    if(checkCode($_POST)) {
        $confirmPassword = $_POST['password'];
        $truePassword = fetch('password');
        session_start();
        $email = $_SESSION['email'];
        session_abort();
        if(verifyPassword($confirmPassword, $truePassword)) {
            if(changeEmail($email)) {
                alert('Email is changed');
                jumpTo('../../../edit/');
            }
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
    <link rel="shortcut icon" href="../../../../../src/img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../../../../style.css">
    <title>VERIFICATION</title>
</head>
<body>
    <nav id="app-header">
        <a href="../../../../" class="app-header-list" id="app-header-logo-container"><img src="../../../../../src/img/logo.png" alt="logo.png"  id="app-header-logo"></a>
        <a href="../../../../keep/" class="app-header-list notranslate">KEEP</a>
        <a href="../../../../detail/" class="app-header-list">DETAIL</a>
        <a href="../../../../history/" class="app-header-list">RIWAYAT</a>
        <a href="../../../../profile/" class="app-header-list"><img src="../../../../../src/img/profilepicture/<?php echo fetch('picture') ?>" alt="Profile Picture" style="height: 50px;"></a>
        <a href="../../../../logout.php" class="app-header-list">KELUAR</a>
    </nav>
    <br><br>
    <h1>Verifikasi Email</h1>
    <br>
    <form action="" method="post">
        <div>
            <label for="confirmCode">Kode verifikasi:</label><br>
            <input type="text" name="confirmCode" id="confirmCode" autocomplete="off" required>
        </div>
        <br>
        <div>
            <label for="password">Password:</label><br>
            <input type="password" name="password" id="password" required>
        </div>
        <br>
        <button type="submit" name="submit" id="submit">UBAH EMAIL</button>
    </form>
</body>
</html>