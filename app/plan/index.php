<?php
require "../../functions.php";
$changed = fetch('changed');

if($changed != 0) {
    alert('Rencanamu gak bisa diubah sekarang. Ubah bulan depan ya :P');
    jumpTo('../');
}

if(isset($_POST['submit'])) {
    if($_POST['newPlan'] == "70") {
        $needs = 70;
        $wants = 20;
        $saving = 10;
    } else if($_POST['newPlan'] == "50") {
        $needs = 50;
        $wants = 30;
        $saving = 20;
    } else {
        $needs = $_POST['needs'];
        $wants = $_POST['wants'];
        $saving = $_POST['saving'];
    }
    if(($needs + $wants + $saving) !== 100){
        alert('Jumlahnya harus 100%. Jangan sampai ada dana ghoib');
    } else if($needs < 45) {
        alert('Batas minimum untuk kebutuhan adalah 45%');
    } else if($needs > 85) {
        alert('Batas maksimum untuk kebutuhan adalah 85%');
    } else if($wants < 10) {
        alert('Batas minimum untuk keinginan adalah 10%. Jangan lupa healing');
    } else if($wants > 45) {
        alert('Batas maksimum untuk keinginan adalah 45%. Kurangi healingnya');
    } else if($saving < 5) {
        alert('Batas minimum untuk tabungan adalah 5%');
    } else {
        if(updatePlan($needs, $wants, $saving)){
            if(changedPlan()) {
                alert('Rencanamu sudah dibuat. Kamu bisa mengubah rencanamu lagi bulan depan!');
                jumpTo('../');
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
    <link rel="shortcut icon" href="../../src/img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../src/css/style.css">
    <title>RENCANA</title>
</head>
<body class="ms-3 me-3 text-center">
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
                    <a class="nav-link color-keptskin fw-bold" href="">Bantuan</a>
					<a class="nav-link color-keptskin fw-bold" href="../report/">Lapor</a>
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
    <h1 class="text-center text-decoration-underline">Ubah Rencana</h1>
    <form action="" method="post">
        <div class="new">
            <label for="new-plan">Rencanamu</label><br>
            <select name="newPlan" id="new-plan" required>
                <option value="70" selected>70 : 20 : 10</option>
                <option value="50">50 : 30 : 20</option>
                <option value="custom">Custom</option>
            </select>
        </div><br>
        <div id="new-plan-custom">
            
        </div>
        <button type="submit" name="submit" id="submit">ENTER</button>
    </form>
    <script src="script.js"></script>
    <script src="../../src/script/bootstrap.bundle.min.js"></script>
</body>