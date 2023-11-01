<?php 
require "../../functions.php";
session_start();
if(!isset($_SESSION['emailrenew'])){
    jumpTo('../');
}
if(isset($_POST['submit'])) {
    if(checkPassword($_POST)) {
        if(renewPassword($_POST)) {
            alert('Dah berhasil. Ingat ya. Jangan banyak kali pikiran itu wkwkw');
            jumpTo('../../login/');
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
    <link rel="shortcut icon" href="../../src/img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../src/css/style.css">
    <title>PERBARUI PASSWORD</title>
</head>
<body class="ms-3 me-3 text-center">
    <nav class="navbar sticky-top navbar-expand-lg bg-keptblue mb-0">
        <div class="container-fluid">
            <a class="navbar-brand bg-keptskin nav-link rounded color-keptskin" href="../../">
                <img src="../../src/img/logo.png" alt="Logo Kept" id="navbar-brand">
            </a>
            <button class="navbar-toggler bg-keptskin" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="navbar-nav me-auto">
					<a class="nav-link color-keptskin fw-bold active" href="../../login/">Masuk</a>
					<a class="nav-link color-keptskin fw-bold" href="../../register/">Daftar</a>
					<a class="nav-link color-keptskin fw-bold" href="../../about/">Tentang</a>
                </div>
			</div>
		</div>
    </nav>
    <div class="d-flex justify-content-center align-items-center login-container">
        <div class="login-form-container">
            <h1 class="login-header text-decoration-underline mb-3">Perbarui Password</h1>
            <form action="" method="post">
                <div>
                    <input class="login-input text-center" type="password" name="password" id="password" autocomplete="off" placeholder="Buat Password Baru" required>
                </div>
                <div>
                    <input class="login-input text-center mb-3" type="password" name="confirmPassword" id="confirmPassword" autocomplete="off" placeholder="Konfirmasi Password" required>
                </div>
                <button class="login-submit rounded-pill p-2" type="submit" name="submit" id="submit">UBAH</button>
            </form>
    <script src="../../src/script/bootstrap.bundle.min.js"></script>
</body>
</html>