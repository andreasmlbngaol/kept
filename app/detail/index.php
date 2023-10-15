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

keptConn();
$realIncome = $totalIncome - $prioritySpending;
$needsPlan = (float) fetch('needs');
$wantsPlan = (float) fetch('wants');
$savingPlan = (float) fetch('saving');
$invest = ((float) fetch('saving')/100) * $realIncome;
if($totalSpending != 0) {
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
    <link rel="stylesheet" href="../../style.css">
    <title>Home</title>
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
<body>
    <nav id="app-header">
        <a href="../" class="app-header-list" id="app-header-logo-container"><img src="../../src/img/logo.png" alt="logo.png"  id="app-header-logo"></a>
        <a href="../keep/" class="app-header-list notranslate">KEEP</a>
        <a href="../detail/" class="app-header-list active">DETAIL</a>
        <a href="../history/" class="app-header-list">RIWAYAT</a>
        <a href="../profile/" class="app-header-list"><img src="../../src/img/profilepicture/<?php echo fetch('picture') ?>" alt="Profile Picture" style="height: 50px;"></a>
        <a href="../logout.php" class="app-header-list">KELUAR</a>
    </nav>
    <br><br>
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
                        <p><?php echo '('.percentage(($wantsDetail[$i]/$needsSpending) * $needsSpendingPercentage).' % dari Pendapatan Nyata)' ?></p>
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
        $savingPercentage = abs($saving) * 100 / $realIncome;
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
    <br>
</body>
</html>