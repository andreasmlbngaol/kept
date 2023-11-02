<?php
require "../../../../functions.php";
if(isset($_POST['submit'])) {
    $truePassword = fetch('password');
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];
    if(verifyPassword($oldPassword, $truePassword)) {
        if($newPassword !== $confirmPassword){
            alert('Password nggak sama');
        } else {
            if(changePassword($newPassword)) {
                alert('Password berhasil diubah');
                jumpTo('../../edit/');
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../../src/css/style.css">
    <link rel="shortcut icon" href="../../../../src/img/icon.png" type="image/x-icon">
    <title>UBAH PASSWORD</title>
</head>
<body class="ms-3">
    <nav class="navbar sticky-top navbar-expand-lg bg-keptblue mb-0">
        <div class="container-fluid">
            <div class="navbar-item dropdown">
                <a class="navbar-brand bg-keptskin nav-link rounded color-keptskin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../../../../src/img/logo.png" alt="Logo Kept" id="navbar-brand">
                </a>
                <ul class="dropdown-menu dropdown-menu-start bg-keptskin">
                    <li><a class="dropdown-item" href="../../../">Home</a></li>
                    <li><a class="dropdown-item" href="../../../keep/">Keep</a></li>
                    <li><a class="dropdown-item" href="../../../detail/">Detail</a></li>
                    <li><a class="dropdown-item" href="../../../history/">Riwayat</a></li>
                    <!-- <li><a class="dropdown-item" href="">Another action</a></li> -->
                </ul>
            </div>
            <button class="navbar-toggler bg-keptskin" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="navbar-nav me-auto">
                    <a class="nav-link color-keptskin fw-bold" href="../../../help/">Bantuan</a>
					<a class="nav-link color-keptskin fw-bold" href="../../../report/">Lapor</a>
					<!-- <a class="nav-link color-keptskin" href="history/">Riwayat</a> -->
                    <a class="nav-link color-white fw-light"><?php echo dayName(dateNow()).', '; showDate(dateNow())?></a>
                </div>
                <div class="navbar-nav me-4">
                    <div class="navbar-item dropdown">
                        <button class="nav-link color-keptskin" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <a><?php echo greeting()?></a>
                            <img src="../../../../src/img/profilepicture/<?php echo fetch('picture'); ?>" alt="Profile Picture" class="border border-light rounded-circle navbar-picture">
                        </button>
						<ul class="dropdown-menu dropdown-menu-end bg-keptskin">
                            <li><a class="dropdown-item " href="../../../profile/">Profil</a></li>
                            <li><a class="dropdown-item" href="../../../plan/">Ubah Rencana</a></li>
							<!-- <li><a class="dropdown-item" href="">Another action</a></li> -->
							<li><hr class="dropdown-divider"></li>
							<li><a href="../../../logout.php" class="dropdown-item color-keptblue">Keluar</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
    </nav>
    <a href="../../">KEMBALI</a><br><br>
    <h1>Edit Password</h1>
    <br>
    <div>
        <form action="" method="post">
            <div>
                <label for="old-password">Password Lama:</label><br>
                <input type="password" name="oldPassword" id="old-password" required>
            </div>
            <div>
                <label for="new-passsword">Password Baru:</label><br>
                <input type="password" name="newPassword" id="new-password" required>
            </div>
            <div>
                <label for="confirm-password">Konfirmasi Password Baru:</label><br>
                <input type="password" name="confirmPassword" id="confirm-password" required>
            </div>
            <button type="submit" name="submit" id="submit">UBAH PASSWORD</button>
        </form>
    </div>
    <script src="../../../../src/script/bootstrap.bundle.min.js"></script>
</body>
</html>