<?php
require "../../functions.php";
if(isset($_POST['submit'])) {
    $type = $_POST['report-type'];
    $text = $_POST['report-text'];
    $username = fetch('username');
    $email = fetch('email');
    if(sendReport($type, $text)) {
        alert('Terima kasih atas Laporan anda.');
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../src/img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../src/css/style.css">
    <title>LAPOR</title>
</head>
<body class="ms-3 me-3">
    <nav class="navbar sticky-top navbar-expand-lg bg-keptblue mb-0">
        <div class="container-fluid">
            <div class="navbar-item dropdown">
                <a class="navbar-brand bg-keptskin nav-link rounded color-keptskin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../../src/img/logo.png" alt="Logo Kept" id="navbar-brand">
                </a>
                <ul class="dropdown-menu dropdown-menu-start bg-keptskin">
                    <li><a class="dropdown-item" href="../">Home</a></li>
                    <li><a class="dropdown-item" href="../keep/">Keep</a></li>
                    <li><a class="dropdown-item" href="../detail/">Detail</a></li>
                    <li><a class="dropdown-item" href="../history/">Riwayat</a></li>
                </ul>
            </div>
            <button class="navbar-toggler bg-keptskin" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="navbar-nav me-auto">
                    <a class="nav-link color-keptskin fw-bold" href="../help/">Bantuan</a>
					<a class="nav-link color-keptskin fw-bold active" href="">Lapor</a>
                    <a class="nav-link color-white fw-light"><?php echo dayName(dateNow()).', '; showDate(dateNow())?></a>
                </div>
                <div class="navbar-nav me-4">
                    <div class="navbar-item dropdown">
                        <button class="nav-link color-keptskin" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <a><?php echo greeting()?></a>
                            <img src="../../src/img/profilepicture/<?php echo fetch('picture'); ?>" alt="Profile Picture" class="border border-light rounded-circle navbar-picture">
                        </button>
						<ul class="dropdown-menu dropdown-menu-end bg-keptskin">
                            <li><a class="dropdown-item " href="../profile/">Profil</a></li>
                            <li><a class="dropdown-item" href="../plan/">Ubah Rencana</a></li>
							<!-- <li><a class="dropdown-item" href="">Another action</a></li> -->
							<li><hr class="dropdown-divider"></li>
							<li><a href="../logout.php" class="dropdown-item color-keptblue">Keluar</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
    </nav>
    <div id="keep" class="mt-4 d-flex flex-wrap justify-content-center align-items-center">
        <div class="report d-flex justify-content-center flex-wrap">
            <h1 class="mt-4 text-center text-decoration-underline w-100">Lapor</h1>
            <form action="" method="post" class="text-center report-form">
                <div>
                    <label for="report-type">Jenis Laporan</label><br>
                    <select name="report-type" id="report-type" class="text-center" required>
                        <option value="" selected>Pilih</option>
                        <option value="bug">Bug</option>
                        <option value="question">Pertanyaan</option>
                        <option value="advice">Kritik dan Saran</option>
                    </select>
                </div>
                <div>
                    <label for="report-text">Laporan</label><br>
                    <textarea class="text-start" type="text" name="report-text" id="report-text" autocomplete="off" maxlength="1000" required></textarea>
                </div>
                <button type="submit" name="submit" id="submit">Kirim</button>
            </form>
        </div>
    </div>
    <script src="../../src/script/bootstrap.bundle.min.js"></script>
</body>