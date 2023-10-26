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

$dayName = dayName($today);
$time = date('H');
if((int) $time >= 6 AND (int) $time < 12) {
    $greeting = 'Selamat Pagi';
} else if((int) $time >= 12 AND (int) $time < 15) {
    $greeting = 'Selamat Siang';
} else if((int) $time >= 15 AND (int) $time < 18) {
    $greeting = 'Selamat Sore';
} else {
    $greeting = 'Selamat Malam';
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
    <title>Home</title>
</head>
<body class="ms-3">
    <nav class="navbar sticky-top navbar-expand-lg bg-keptblue">
		<div class="container-fluid">
			<a class="navbar-brand bg-keptskin" href="">
                <img src="../src/img/logo.png" alt="Logo Kept" id="navbar-brand">
			</a>
			<button class="navbar-toggler bg-keptskin" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<div class="navbar-nav me-auto">
                    <a class="nav-link color-keptskin" href="keep/">Keep</a>
					<a class="nav-link color-keptskin" href="detail/">Detail</a>
					<a class="nav-link color-keptskin" href="history/">Riwayat</a>
                </div>
                <div class="navbar-nav d-flex me-4">
                    <a class="nav-link" href="profile/">
                        <img src="../src/img/profilepicture/<?php echo fetch('picture'); ?>" alt="Profile Picture" style="height: 50px;">
                    </a>
                    <div class="navbar-item dropdown">
                        <a class="nav-link dropdown-toggle color-keptskin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="sr-only"></span>
                        </a>
						<ul class="dropdown-menu dropdown-menu-end bg-keptskin">
							<li><a class="dropdown-item" href="profile/private/">Pengaturan Privasi</a></li>
							<!-- <li><a class="dropdown-item" href="">Another action</a></li> -->
							<li><hr class="dropdown-divider"></li>
							<li><a href="logout.php" class="dropdown-item color-keptblue">Keluar</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</nav>
    <h3><?php echo $dayName.', '; showDate($today) ?></h3>
    <h1><?php echo $greeting ?>, <span class="notranslate"><?php echo "$name" ?></span></h1>
    <br>
    <div>
        <div>
            <h2>Kept Score mu:</h2>
            <h2><a href="detail/#score" style="text-decoration: none"><?php echo $keptScore ?></a></h2>
        </div>
        <br>
        <div>
            <h2>Total Pendapatan:</h2>
            <h2>Rp. <?php echo money($totalIncome) ?></h2>
            <a href="detail/">Lihat Detail</a>
        </div>
        <br>
        <div>
            <h2>Total Pengeluaran:</h2>
            <h2>Rp. <?php echo money($totalSpending) ?></h2>
            <a href="detail/">Lihat Detail</a>
        </div>
        <br>
        <div>
            <h2>Rata-rata Pengeluaran Harian:</h2>
            <h2>Rp. <?php echo money($dailySpending) ?></h2>
            <a href="detail/">Lihat Detail</a>
        </div>
        <br>
        <div>
            <h2>Dompetmu:</h2>
            <h2>Rp. <?php echo money($saving) ?></h2>
            <a href="detail/">Lihat Detail</a><br>
            <br>
            <h3>Sisa Uang untuk Kebutuhan:</h3>
            <h3>Rp <?php echo money($needsWallet) ?></h3>
            <br>
            <h3>Sisa Uang untuk Keinginan:</h3>
            <h3>Rp <?php echo money($wantsWallet) ?></h3>
            <br>
            <h3>Sisa Uang untuk Tabungan:</h3>
            <h3>Rp <?php echo money($savingWallet) ?></h3>
        </div>
    </div>
    <div style="height: 25vh">
    </div>
    <script src="../src/script/bootstrap.bundle.min.js"></script>
</body>
</html>