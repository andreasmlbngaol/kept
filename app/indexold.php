<?php
require "../functions.php";
$today = dateNow();
session_start();
if(!isset($_SESSION['loginId'])) {
    jumpTo("../");
}
session_abort();
if(fetch('new') == 1) {
    jumpTo("new/");
}
$name = fetch('nickname');
$db = fetch('username').'_keep';
keepConn();

$totalIncome = totalIncome($db);
$totalSpending = totalSpending($db);
$prioritySpending = prioritySpending($db);
$needsSpending = needsSpending($db);
$wantsSpending = wantsSpending($db);
$dailySpending = dailySpending($db);
keptConn();
$needsPlan = (float) fetch('needs');
$wantsPlan = (float) fetch('wants');
$savingPlan = (float) fetch('saving');
$realIncome = $totalIncome - $prioritySpending;
$needsWallet = ($needsPlan/100) * $realIncome- $needsSpending;
$wantsWallet = ($wantsPlan/100) * $realIncome - $wantsSpending;
$savingWallet = ($savingPlan/100) * $realIncome;
$saving = $needsWallet + $wantsWallet + $savingWallet;
if($needsWallet < 0) {
    $wantsWallet += $needsWallet;
    $needsWallet = 0;
}
if($wantsWallet < 0) {
    $savingWallet += $wantsWallet;
    $wantsWallet = 0;
}
if($savingWallet < 0) {
    $needsWallet += $savingWallet;
    $savingWallet = 0;
}
if($totalIncome > 0) {
    $needsSpendingPercentage = $needsSpending * 100 / $realIncome;
    $wantsSpendingPercentage = $wantsSpending * 100 / $realIncome;
    $savingPercentage = $saving * 100 / $realIncome;
} else {
    $needsSpendingPercentage = 0;
    $wantsSpendingPercentage = 0;
    $savingPercentage = 0;
}
$keptScore = 100;
if($needsSpendingPercentage > $needsPlan) $keptScore -= 10;
if($wantsSpendingPercentage > (($wantsPlan + $needsPlan)/2)) $keptScore -= 20;
else if($wantsSpendingPercentage > $wantsPlan) $keptScore -= 10;
if($wantsSpending > $needsSpending) $keptScore -= 10;
if($totalIncome != 0) {
    if($savingPercentage < -$needsPlan) {
        $keptScore -= 70;
    } else if($savingPercentage < -$wantsPlan) {
        $keptScore -= 60;
    } else if($savingPercentage < -($savingPlan + $wantsPlan)) {
        $keptScore -= 50;
    } else if($savingPercentage < -$savingPlan) {
        $keptScore -= 40;
    } else if($savingPercentage < 0) {
        $keptScore -= 30;
    } else if($savingPercentage < ($savingPlan / 2)) {
        $keptScore -= 20;
    } else if($savingPercentage < $savingPlan) {
        $keptScore -= 10;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../src/img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/style.css">
    <title>KEPT</title>
</head>
<body class="ms-3 me-3">
    <nav class="navbar sticky-top navbar-expand-lg bg-keptblue mb-0">
        <div class="container-fluid">
            <div class="navbar-item dropdown">
                <a class="navbar-brand bg-keptskin nav-link rounded color-keptskin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../src/img/logo.png" alt="Logo Kept" id="navbar-brand">
                </a>
                <ul class="dropdown-menu dropdown-menu-start bg-keptskin">
                    <li><a class="dropdown-item" href="">Home</a></li>
                    <li><a class="dropdown-item" href="keep/">Keep</a></li>
                    <li><a class="dropdown-item" href="detail/">Detail</a></li>
                    <li><a class="dropdown-item" href="history/">Riwayat</a></li>
                    <!-- <li><a class="dropdown-item" href="">Another action</a></li> -->
                </ul>
            </div>
            <button class="navbar-toggler bg-keptskin" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="navbar-nav me-auto">
                    <a class="nav-link color-keptskin fw-bold" href="help/">Bantuan</a>
					<a class="nav-link color-keptskin fw-bold" href="report/">Lapor</a>
					<!-- <a class="nav-link color-keptskin" href="history/">Riwayat</a> -->
                    <a class="nav-link color-white fw-light"><?php echo dayName(dateNow()).', '; showDate(dateNow())?></a>
                </div>
                <div class="navbar-nav me-4">
                    <div class="navbar-item dropdown">
                        <button class="nav-link color-keptskin" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <a><?php echo greeting()?></a>
                            <img src="../src/img/profilepicture/<?php echo fetch('picture'); ?>" alt="Profile Picture" class="border border-light rounded-circle navbar-picture">
                        </button>
						<ul class="dropdown-menu dropdown-menu-end bg-keptskin">
                            <li><a class="dropdown-item " href="profile/">Profil</a></li>
                            <li><a class="dropdown-item" href="plan/">Ubah Rencana</a></li>
							<!-- <li><a class="dropdown-item" href="">Another action</a></li> -->
							<li><hr class="dropdown-divider"></li>
							<li><a href="logout.php" class="dropdown-item color-keptblue">Keluar</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
    </nav>
    <?php if ($totalIncome != 0) { ?>
    <div class="page mb-0">
        <div class="container app-container p-0">
            <div class="app-item border rounded text-center">
                <h2 class="color-keptskin app-h2">Kept Score</h2>
                <hr>
                <div class="app-centered">
                    <p class="app-value"><?= $keptScore ?><a class="app-a" href="detail/#kept-score">?</a></p>
                </div>
            </div>
            <div class="app-item border rounded text-center">
                <h2 class="color-keptskin app-h2">Pendapatan</h2>
                <hr>
                <div class="app-centered">
                    <p class="app-value">Rp. <?php echo money($totalIncome) ?> <a href="detail/" class="app-detail">Detail</a></p>
                    
                </div>
            </div>
            <div class="app-item border rounded text-center">
                <h2 class="color-keptskin app-h2">Pengeluaran</h2>
                <hr>
                <div class="app-centered">
                    <p class="app-value">Rp. <?php echo money($totalSpending) ?> <a href="detail/" class="app-detail">Detail</a></p>
                    
                </div>
            </div>
        </div>
        <div class="container app-container p-0">
            <div class="app-item border rounded text-center">
                <h2 class="color-keptskin app-h2">Keep</h2>
                <hr>
                <div class="app-centered">
                    <p class="app-value"><a href="keep/" class="app-a">Masukkan Transaksi</a></p>
                </div>
            </div>
            <div class="app-item border rounded text-center">
                <h2 class="color-keptskin app-h2">Dompetmu</h2>
                <hr>
                <div class="app-centered">
                <p class="app-wallet">Kebutuhan:</p>
                <p class="app-wallet">Rp. <?php echo money($needsWallet) ?></p>
                <p class="app-wallet">Keinginan:</p>
                <p class="app-wallet">Rp. <?php echo money($wantsWallet) ?></p>
                <p class="app-wallet">Tabungan:</p>
                <p class="app-wallet">Rp. <?php echo money($savingWallet) ?></p>
                <!-- <p class="app-value">Rp.100.000 <a href="detail/" class="app-detail">Detail</a></p> -->
            </div>
            </div>
            <div class="app-item border rounded text-center">
                <h2 class="color-keptskin app-h2">Riwayat</h2>
                <hr>
                <div class="app-centered">
                    <p class="app-value"><a href="history/" class="app-a">Lihat Transaksi</a></p>
                    
                </div>
            </div>
        </div>
    </div>
<?php }  else {?>
    <div class="d-flex justify-content-center align-items-center" style="height: 80vh; font-size: 5em; flex-direction: column;">
        <h1>Selamat Datang di Kept!</h1>
        <a href="keep/" class="app-new">Masukkan Transaksi Pertamamu</a>
    </div>
<?php } ?>
    <script src="../src/script/bootstrap.bundle.min.js"></script> 
</body>
</html>   