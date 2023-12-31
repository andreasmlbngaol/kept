<?php
require "../../functions.php";
$today = dateNow();
if(fetch('id') == NULL) {
    jumpTo('../../');
}
if(isset($_POST['submit'])) {
    if(insertKeep($_POST)) {
        alert('Berhasil');
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
    <title>keep</title>
    <style>
        .input {
            width: 200px;
        }
    </style>
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
                    <!-- <li><a class="dropdown-item" href="">Another action</a></li> -->
                </ul>
            </div>
            <button class="navbar-toggler bg-keptskin" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="navbar-nav me-auto">
                    <a class="nav-link color-keptskin fw-bold" href="../help/">Bantuan</a>
					<a class="nav-link color-keptskin fw-bold" href="../report/">Lapor</a>
					<!-- <a class="nav-link color-keptskin" href="history/">Riwayat</a> -->
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
        <div class="d-flex justify-content-center flex-wrap">
            <h1 class="text-decoration-underline w-100">Keep</h1>
            <div>
                <form action="" method="post">
                    <div class="input" id="input-date">
                        <label for="date">Tanggal:</label><br>
                        <input type="date" name="date" id="date" class="text-center keep-input" value="<?php echo $today?>" required>
                    </div>

                    <div class="input">
                        <label for="input-isincome">Tipe:</label><br>
                        <select name="input-isincome" id="input-isincome" class="text-center keep-input" required>
                            <option value="" selected>Pilih</option>
                            <option value="true">Pendapatan</option>
                            <option value="false">Pengeluaran</option>
                        </select>
                    </div>

                    <div class="input">
                        <label for="input-class">Kategori:</label><br>
                        <select name="input-class" id="input-class" class="text-center keep-input" required>
                            <option value="" selected>Pilih</option>
                        </select>
                    </div>

                    <div class="input" id="input-type">
                        <label for="nominal">Jumlah (Rp.):</label><br>
                        <input type="number" name="nominal" id="nominal" class="text-center keep-input" required>
                    </div>
                    
                    <div class="input mb-3" id="input-desc">
                        <label for="desc">Komentar:</label><br>
                        <input type="text" name="desc" id="desc" autocomplete="off" class="text-center keep-input" required>
                    </div>
                    <button class="keep-submit rounded-pill p-2" type="submit" id="submit" name="submit">KEEP</button>
                </form>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
    <script src="../../src/script/bootstrap.bundle.min.js"></script>
</body>
</html>