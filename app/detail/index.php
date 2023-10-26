<?php
require "../../functions.php";
session_start();
if(!isset($_SESSION['loginId'])) {
    jumpTo("../../");
}
session_abort();

$name = fetch('nickname');
$db = fetch('username').'_keep';
keepConn();

$totalIncome = totalIncome($db);
$routineIncome = routineIncome($db);
$additionalIncome = additionalIncome($db);
$totalSpending = totalSpending($db);
$prioritySpending = prioritySpending($db);
$needsSpending = needsSpending($db);
$wantsSpending = wantsSpending($db);
if($totalIncome != 0) {
    $routineIncomePercentage = ($routineIncome * 100 / $totalIncome);
    $additionalIncomePercentage = ($additionalIncome * 100 / $totalIncome);
} else {
    $routineIncomePercentage = 0;
    $additionalIncomePercentage = 0;
}

$incomeDataPoints = array( 
    array("label"=>"Rutin", "y"=>$routineIncomePercentage),
    array("label"=>"Tambahan", "y"=>$additionalIncomePercentage),
);

keptConn();
$realIncome = $totalIncome - $prioritySpending;

$needsPlan = (float) fetch('needs');
$wantsPlan = (float) fetch('wants');
$savingPlan = (float) fetch('saving');
$invest = ((float) fetch('saving')/100) * $realIncome;
if($realIncome != 0) {
    $needsSpendingPercentage = ($needsSpending * 100 / $realIncome);
    $wantsSpendingPercentage = ($wantsSpending * 100 / $realIncome);
    $prioritySpendingPercentage = ($prioritySpending * 100) / $totalIncome;
} else {
    $needsSpendingPercentage = 0;
    $wantsSpendingPercentage = 0;
    $prioritySpendingPercentage = 0;
}

$saving = $totalIncome - $totalSpending;
if($totalIncome != 0) {
    $spendingPercentage = ($totalSpending * 100 /$totalIncome);
    $savingPercentage = ($saving * 100/$realIncome);
    $savingPercentage2 = ($saving - $invest) * 100/$realIncome;
} else {
    $spendingPercentage = 0;
    $savingPercentage = 0;
    $savingPercentage2 = 0;
}


$today = dateNow();
$dateMonth = dateMonth($today);
$dateYear = dateYear($today);
keptConn();
$priorityName = listItem('category', 'priority', 'name');
$needsName = listItem('category', 'needs', 'name');
$wantsName = listItem('category', 'wants', 'name');
$priorityUsername = listItem('category', 'priority', 'username');
$needsUsername = listItem('category', 'needs', 'username');
$wantsUsername = listItem('category', 'wants', 'username');
keepConn();
$priorityDetail = listSpending($priorityUsername, $db);
$needsDetail = listSpending($needsUsername, $db);
$wantsDetail = listSpending($wantsUsername, $db);
$healthy = true;
keptConn();
?>

<!DOCTYPE html>
<html lang="id">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../src/img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://unpkg.com/@adminkit/core@latest/dist/css/app.css">
    <link rel="stylesheet" href="../../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../src/css/style.css">
    <title>Detail</title>
    <style>
        .container {
            display: flex;
        }
        .item {
            margin: 20px;
            border: 1pt solid #E5C3A6;
            padding: 10px;
        }
    </style>
    
</head>
<body class="ms-3">
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
                    <a class="nav-link color-keptskin fw-bold" href="../">FAQ</a>
					<a class="nav-link color-keptskin fw-bold" href="../">Lapor</a>
					<!-- <a class="nav-link color-keptskin" href="history/">Riwayat</a> -->
                    <a class="nav-link color-white fw-light"><?php echo dayName(dateNow()).', '; showDate(dateNow())?></a>
                </div>
                <div class="navbar-nav me-4">
                    <div class="navbar-item dropdown">
                        <button class="nav-link color-keptskin" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <a><?php echo greeting()?></a>
                            <img src="../../src/img/profilepicture/<?php echo fetch('picture'); ?>" alt="Profile Picture" class="border border-light rounded-circle" style="height: 50px;">
                        </button>
						<ul class="dropdown-menu dropdown-menu-end bg-keptskin">
                            <li><a class="dropdown-item " href="../profile/">Profil</a></li>
                            <li><a class="dropdown-item" href="../profile/private/">Pengaturan Privasi</a></li>
							<!-- <li><a class="dropdown-item" href="">Another action</a></li> -->
							<li><hr class="dropdown-divider"></li>
							<li><a href="../logout.php" class="dropdown-item color-keptblue">Keluar</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
    </nav>
    <?php if($totalIncome != 0) {?>
    <div class="d-flex ms-auto me-auto">
        <?php if($needsSpending != 0) {?>
            <div class="ms-auto me-auto bg-keptblue" id="needsChart" style="height: 370px; width: <?php echo 100/3 ?>%;"></div>
        <?php } ?>
        <div class="ms-auto me-auto bg-keptblue" id="incomeChart" style="height: 370px; width: <?php echo 100/3 ?>%;"></div>
        <?php if($wantsSpending != 0) {?>
        <div class="ms-auto me-auto bg-keptblue" id="wantsChart" style="height: 370px; width: <?php echo 100/3 ?>%;"></div>
        <?php } ?>
    </div>
    <?php } ?>
    <h1>Detail</h1>
    <br>
    <div class="container">
        <div class="item">
            <h1>Pendapatan</h1>
            <div>
                <h2>Total Pendapatan:</h2>
                <h2 class="value">Rp. <?php echo money($totalIncome) ?></h2>
            </div>
            <br>
            <div>
                <h2>Pendapatan Rutin:</h2>
                <h2 class="value">Rp. <?php echo money($routineIncome) ?></h2>
                <p><?php echo '('.percentage($routineIncomePercentage).' % dari Total Pendapatan)'?></p>
            </div>
            <br>
            <div>
                <h2>Pendapatan Tambahan:</h2>
                <h2 class="value">Rp. <?php echo money($additionalIncome)?></h2>
                <p><?php echo '('.percentage($additionalIncomePercentage).' % dari Total Pendapatan)'?></p>
            </div>
            <br>
            <div>
                <h2>Pendapatan Nyata:</h2>
                <h2 class="value">Rp. <?php echo money($realIncome)?></h2>
                <p>Pendapatan Rutin - Pengeluaran Prioritas</p>
                <p>(Rp. <?php echo money($totalIncome) ?> - Rp. <?php echo money($prioritySpending) ?>)</p>
            </div>
        </div>
        <div class="item">
            <h1>Pengeluaran</h1>
            <div>
                <h2>Total Pengeluaran:</h2>
                <h2 class="value">Rp. <?php echo money($totalSpending) ?></h2>
                <p><?php echo '('.percentage($spendingPercentage).' % of Total Pendapatan)'?></p>
            </div>
            <br>
            <div>
                <h2>Pengeluaran Prioritas:</h2>
                <h2 class="value">Rp. <?php echo money($prioritySpending)?></h2>
                <!-- <p><?php //echo '('.percentage($prioritySpendingPercentage).' % of Spending)'?> or <?php //echo '('.percentage($prioritySpendingPercentage * $spendingPercentage / 100).' % of Income)' ?></p> -->
                <p><?php echo '('.percentage($prioritySpendingPercentage).' % of Total Pendapatan)' ?></p>
            </div>
            <br>
            <div>
                <h2>Pengeluaran Kebutuhan:</h2>
                <h2 class="value">Rp. <?php echo money($needsSpending)?></h2>
                <p><?php echo '('.percentage($needsSpendingPercentage).' % dari Pendapatan Nyata)'?></p>
                <!-- <p><?php //echo '('.percentage($needsSpendingPercentage).' % of Spending)'?> or <?php //echo '('.percentage($needsSpendingPercentage * $spendingPercentage / 100).' % of Income)' ?></p> -->
            </div>
            <br>
            <div>
                <h2>Pengeluaran Keinginan:</h2>
                <h2 class="value">Rp. <?php echo money($wantsSpending)?></h2>
                <p><?php echo '('.percentage($wantsSpendingPercentage).' % dari Pendapatan Nyata)'?></p>
                <!-- <p><?php //echo '('.percentage($wantsSpendingPercentage).' % of Spending'?> or <?php //echo percentage($wantsSpendingPercentage * $spendingPercentage / 100).' % of Income' ?></p> -->
            </div>
        </div>
        <br>
        <div class="item">
            <div>
                <h2>Dompetmu:</h2>
                <h2 class="value">Rp. <?php echo money($saving)?></h2>
                <p><?php echo '('.percentage($savingPercentage).' % dari Pendapatan Nyata)' ?></p>
            </div>
            <br>
            <div>
                <h2 class="value">Rp. <?php echo money($saving - $invest)?> setelah menabung</h2>
                <p><?php echo '('.percentage($savingPercentage2).' % dari Pendapatan Nyata)' ?></p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="item">
            <div>
                <h1>Daftar Prioritas:</h1>
                <?php for($i = 0; $i < count($priorityUsername); $i++) { ?>
                    <div>
                        <h2><?php echo $priorityName[$i] ?>:</h2>
                        <?php if($prioritySpending != 0) { ?>
                        <h2 class="value">Rp. <?php echo money($priorityDetail[$i]) ?></h2>
                        <p><?php echo'('.percentage((($priorityDetail[$i]/$prioritySpending) * $prioritySpendingPercentage)).' % dari Total Pendapatan)' ?></p>
                        <?php } else {?>
                        <p class="value">Rp. <?php echo money($priorityDetail[$i]).' (0 % dari Total Pendapatan)' ?></p>
                        <?php } ?>
                    </div>
                    <br>
                    <?php } ?>
            </div>
        </div>
        <div class="item">
            <div>
                <h1>Daftar Kebutuhan:</h1>
                <?php for($i = 0; $i < count($needsUsername); $i++) { ?>
                    <div>
                        <h2><?php echo $needsName[$i] ?>:</h2>
                        <h2 class="value">Rp. <?php echo money($needsDetail[$i])?></h2>
                        <?php if($needsSpending != 0) { ?>
                        <p><?php echo '('.percentage((($needsDetail[$i]/$needsSpending) * $needsSpendingPercentage)).' % dari Pendapatan Nyata)'?></p>
                        <?php } else {?>
                        <p><?php echo '(0 % dari Pendapatan Nyata)' ?></p>
                        <?php } ?>
                    </div>
                    <br>
                    <?php } ?>
            </div>
        </div>
        <div class="item">
            <div>
                <h1>Daftar Keinginan:</h1>
                <?php for($i = 0; $i < count($wantsUsername); $i++) { ?>
                    <div>
                        <h2><?php echo $wantsName[$i] ?>:</h2>
                        <h2 class="value">Rp. <?php echo money($wantsDetail[$i]) ?></h2>
                        <?php if($wantsSpending != 0) { ?>
                        <p><?php echo '('.percentage(($wantsDetail[$i]/$wantsSpending) * $wantsSpendingPercentage).' % dari Pendapatan Nyata)' ?></p>
                        <?php } else { ?>
                        <p><?php echo '(0 % dari Pendapatan Nyata)' ?></p>
                        <?php } ?>
                    </div>
                    <br>
                    <?php } ?>
            </div>
        </div>
    </div>
    <div id="score" style="height: 100vh;">
        <h1>Kept Score</h1>
    <?php 
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
    } ?>
        <h1 class="value"><?php echo $keptScore ?></h1>
    <?php if($keptScore === 100) { ?>
        <h2>Keuanganmu sesuai perencanaan</h2>
    <?php } ?>
    <?php if($needsSpendingPercentage > $needsPlan) {?>
        <h2>Kebutuhan lebih besar dari <?php echo $needsPlan ?> % (-10 poin)</h2>
    <?php } ?>
    <?php if($wantsSpendingPercentage > (($wantsPlan + $needsPlan)/2)){ ?>
        <h2>Keinginan lebih besar dari <?php echo (($wantsPlan + $needsPlan)/2) ?> % (-20 poin) </h2>
    <?php } else if($wantsSpendingPercentage > $wantsPlan) { ?>
        <h2>Keinginan lebih besar dari <?php echo $wantsPlan ?> % (-10 poin) </h2>
    <?php } ?>
    <?php if($wantsSpending > $needsSpending) { ?>
        <h2>Keinginan lebih besar dari kebutuhan (-10 poin) </h2>
    <?php }
    if($totalIncome != 0) {
        if($savingPercentage < -$needsPlan) { ?>
            <h2>Pengeluaran <?php echo (100 + $needsPlan) ?> % dari pemasukan (-70 poin)</h2>
        <?php } else if($savingPercentage < -$wantsPlan) { ?>
            <h2>Pengeluaran <?php echo (100 + $wantsPlan) ?> % dari pemasukan (-60 poin)</h2>
        <?php } else if($savingPercentage < -($savingPlan + $wantsPlan)) { ?>
            <h2>Pengeluaran <?php echo (100 + ($savingPlan + $wantsPlan)) ?> % dari pemasukan (-50 poin)</h2>
        <?php } else if($savingPercentage < -$savingPlan) { ?>
            <h2>Pengeluaran <?php echo (100 + $savingPlan) ?> % dari pemasukan (-40 poin)</h2>
        <?php } else if($savingPercentage < 0) { ?>
            <h2>Pengeluaran lebih besar dari pemasukan (-30 poin)</h2>
        <?php } else if($savingPercentage < ($savingPlan / 2)) { ?>
            <h2>Tabungan lebih kecil dari <?php echo ($savingPlan / 2) ?> % dari pemasukan (-20 poin)</h2>
        <?php } else if($savingPercentage < $savingPlan) { ?>
            <h2>Tabungan lebih kecil dari <?php echo ($savingPlan) ?> % dari pemasukan (-10 poin)</h2>
        <?php }
    } 
    ?>
    <script>
        window.onload = function() {
            CanvasJS.addColorSet("palette1",
                [//colorSet Array
                "#2d728f",
                "#3b8ea5",
                "#f5ee9e",
                "#f49e4c",
                "#ab3428",
                ]);
            CanvasJS.addColorSet("palette2",
                [//colorSet Array
                "#447604",
                "#6cc551",
                "#9ffcdf",
                "#52ad9c",
                "#47624f",
                ]);
            var incomeChart = new CanvasJS.Chart("incomeChart", {
                animationEnabled: true,
                animationDuration: 500,
                colorSet: "palette2",
                // zoomEnabled: true,
                // zoomType: "x",
                theme: "dark2",
                backgroundColor: "#15253f",
                title: {
                    text: "Total Pendapatan"
                },
                subtitles: [{
                    text: "<?php echo dateNow() ?>"
                }],
                data: [{
                    type: "pie",
                    yValueFormatString: "#,##0.0\"%\"",
                    indexLabel: "{label} ({y})",
                    dataPoints: [
                        <?php if($routineIncome != 0) {?>
                        {label: "Rutin", y: <?php echo $routineIncomePercentage ?>},
                        <?php } ?>
                        <?php if($additionalIncome != 0) {?>
                        {label: "Tambah", y: <?php echo $additionalIncomePercentage ?>},
                        <?php } ?>
                    ]
                }]
            });
            var needsChart = new CanvasJS.Chart("needsChart", {
                animationEnabled: true,
                animationDuration: 500,
                colorSet: "palette2",
                theme: "dark2",
                backgroundColor: "#15253f",
                title: {
                    text: "Kebutuhan"
                },
                subtitles: [{
                    text: "<?php echo dateNow() ?>"
                }],
                data: [{
                    type: "doughnut",
                    yValueFormatString: "#,##0.00\"%\"",
                    indexLabel: "{label} ({y})",
                    dataPoints: [
                        <?php for($i = 0; $i < count($needsUsername); $i++) { 
                            if($needsDetail[$i] == 0) {
                                continue;
                            }?>
                            {label: "<?php echo $needsName[$i] ?>", y: <?php echo ($needsDetail[$i]/$needsSpending) * 100 ?>},
                        <?php } ?>
                    ]
                }]
            });
            var wantsChart = new CanvasJS.Chart("wantsChart", {
                animationEnabled: true,
                animationDuration: 500,
                colorSet: "palette1",
                theme: "dark2",
                backgroundColor: "#15253f",
                title: {
                    text: "Keinginan"
                },
                subtitles: [{
                    text: "<?php echo dateNow() ?>"
                }],
                data: [{
                    type: "doughnut",
                    yValueFormatString: "#,##0.00\"%\"",
                    indexLabel: "{label} ({y})",
                    dataPoints: [
                        <?php for($i = 0; $i < count($wantsUsername); $i++) { 
                            if($wantsDetail[$i] == 0) {
                                continue;
                            }?>
                            {label: "<?php echo $wantsName[$i] ?>", y: <?php echo ($wantsDetail[$i]/$wantsSpending) * 100?>},
                        <?php } ?>
                    ]
                }]
            });
            <?php if($totalIncome != 0) {?>
                incomeChart.render();
            <?php } ?>
            <?php if($needsSpending != 0) {?>
                needsChart.render();
            <?php } ?>
            <?php if($wantsSpending != 0) {?>
                wantsChart.render();
            <?php } ?>
        }
    </script>
    <script src="../../src/script/canvasjs.min.js"></script>
    <script src="../../src/script/bootstrap.bundle.min.js"></script>
</body>
</html>