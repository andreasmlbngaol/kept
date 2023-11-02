<?php
require "../../../../../functions.php";
session_start();
if(isset($_POST['submit'])) {
    if(checkCode($_POST)) {
        session_start();
        $confirmPassword = $_POST['password'];
        $truePassword = fetch('password');
        $email = $_SESSION['email'];
        if(verifyPassword($confirmPassword, $truePassword)) {
            if(changeEmail($email)) {
                alert('Email berhasil diubah');
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
    <link rel="stylesheet" href="../../../../../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../../../src/css/style.css">
    <link rel="shortcut icon" href="../../../../../src/img/icon.png" type="image/x-icon">
    <title>Verifikasi</title>
</head>
<body class="ms-3">
    <nav class="navbar sticky-top navbar-expand-lg bg-keptblue mb-0">
        <div class="container-fluid">
            <div class="navbar-item dropdown">
                <a class="navbar-brand bg-keptskin nav-link rounded color-keptskin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../../../../../src/img/logo.png" alt="Logo Kept" id="navbar-brand">
                </a>
                <ul class="dropdown-menu dropdown-menu-start bg-keptskin">
                    <li><a class="dropdown-item" href="../../../../">Home</a></li>
                    <li><a class="dropdown-item" href="../../../../keep/">Keep</a></li>
                    <li><a class="dropdown-item" href="../../../../detail/">Detail</a></li>
                    <li><a class="dropdown-item" href="../../../../history/">Riwayat</a></li>
                    <!-- <li><a class="dropdown-item" href="">Another action</a></li> -->
                </ul>
            </div>
            <button class="navbar-toggler bg-keptskin" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="navbar-nav me-auto">
                    <a class="nav-link color-keptskin fw-bold" href="../../../../help/">Bantuan</a>
					<a class="nav-link color-keptskin fw-bold" href="../../../../report/">Lapor</a>
					<!-- <a class="nav-link color-keptskin" href="history/">Riwayat</a> -->
                    <a class="nav-link color-white fw-light"><?php echo dayName(dateNow()).', '; showDate(dateNow())?></a>
                </div>
                <div class="navbar-nav me-4">
                    <div class="navbar-item dropdown">
                        <button class="nav-link color-keptskin" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <a><?php echo greeting()?></a>
                            <img src="../../../../../src/img/profilepicture/<?php echo fetch('picture'); ?>" alt="Profile Picture" class="border border-light rounded-circle navbar-picture">
                        </button>
						<ul class="dropdown-menu dropdown-menu-end bg-keptskin">
                            <li><a class="dropdown-item " href="../../../../profile/">Profil</a></li>
                            <li><a class="dropdown-item" href="../../../../plan/">Ubah Rencana</a></li>
							<!-- <li><a class="dropdown-item" href="">Another action</a></li> -->
							<li><hr class="dropdown-divider"></li>
							<li><a href="../../../../logout.php" class="dropdown-item color-keptblue">Keluar</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
    </nav>
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
    <script src="../../../../../src/script/bootstrap.bundle.min.js"></script>
</body>
</html>