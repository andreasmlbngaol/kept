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
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../src/img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../style.css">
    <title>Home</title>
    <style>
        #container {
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
        <a href="../../" class="app-header-list" id="app-header-logo-container"><img src="../../src/img/logo.png" alt="logo.png"  id="app-header-logo"></a>
        <a href="../keep/" class="app-header-list">KEEP</a>
        <a href="../history/" class="app-header-list">HISTORY</a>
        <a href="../profile/" class="app-header-list">PROFILE</a>
        <a href="../logout.php" class="app-header-list">LOGOUT</a>
    </nav>
    <br><br>
    <h1>DETAIL</h1>
    <br>
    <div id="container">
        <div class="item">
            <div>
                <h2>Total Income:</h2>
                <h2>Rp. <?php echo money($totalIncome) ?></h2>
            </div>
            <br>
            <div>
                <h2>Routine Income:</h2>
                <h2>Rp. <?php echo money($routineIncome) ?></h2>
                <p><?php echo '('.percentage($routineIncomePercentage).' % of Income)'?></p>
            </div>
            <br>
            <div>
                <h2>Additional Income:</h2>
                <h2>Rp. <?php echo money($additionalIncome)?></h2>
                <p><?php echo '('.percentage($additionalIncomePercentage).' % of Income)'?></p>
            </div>
            <br>
            <div>
                <h2>Real Income:</h2>
                <h2>Rp. <?php echo money($realIncome)?></h2>
                <p>Total Income - Priority Spending</p>
                <p>(Rp. <?php echo money($totalIncome) ?> - Rp. <?php echo money($prioritySpending) ?>)</p>
            </div>
        </div>
        <div class="item">
            <div>
                <h2>Total Spending:</h2>
                <h2>Rp. <?php echo money($totalSpending) ?></h2>
                <p><?php echo '('.percentage($spendingPercentage).' % of Total Income)'?></p>
            </div>
            <br>
            <div>
                <h2>Spending for Priority:</h2>
                <h2>Rp. <?php echo money($prioritySpending)?></h2>
                <!-- <p><?php //echo '('.percentage($prioritySpendingPercentage).' % of Spending)'?> or <?php //echo '('.percentage($prioritySpendingPercentage * $spendingPercentage / 100).' % of Income)' ?></p> -->
                <p><?php echo '('.percentage($prioritySpendingPercentage).' % of Total Income)' ?></p>
            </div>
            <br>
            <div>
                <h2>Spending for Needs:</h2>
                <h2>Rp. <?php echo money($needsSpending)?></h2>
                <p><?php echo '('.percentage($needsSpendingPercentage).' % of Real Income)'?></p>
                <!-- <p><?php //echo '('.percentage($needsSpendingPercentage).' % of Spending)'?> or <?php //echo '('.percentage($needsSpendingPercentage * $spendingPercentage / 100).' % of Income)' ?></p> -->
            </div>
            <br>
            <div>
                <h2>Spending for Wants:</h2>
                <h2>Rp. <?php echo money($wantsSpending)?></h2>
                <p><?php echo '('.percentage($wantsSpendingPercentage).' % of Real Income)'?></p>
                <!-- <p><?php //echo '('.percentage($wantsSpendingPercentage).' % of Spending'?> or <?php //echo percentage($wantsSpendingPercentage * $spendingPercentage / 100).' % of Income' ?></p> -->
            </div>
        </div>
        <br>
        <div class="item">
            <div>
                <h2>Your Wallet:</h2>
                <h2>Rp. <?php echo money($saving)?></h2>
                <p><?php echo '('.percentage($savingPercentage).' % of Real Income)' ?></p>
                <h2>Rp. <?php echo money($saving - $invest)?> after saving</h2>
                <p><?php echo '('.percentage($savingPercentage2).' % of Real Income)' ?></p>
            </div>
        </div>
        <div class="item">
            <div>
                <h1>Priority List:</h1>
                <?php for($i = 0; $i < count($priorityUsername); $i++) { ?>
                    <div>
                        <h2><?php echo $priorityName[$i] ?>:</h2>
                        <?php if($prioritySpending != 0) { ?>
                        <h2>Rp. <?php echo money($priorityDetail[$i]) ?></h2>
                        <p><?php echo'('.percentage((($priorityDetail[$i]/$prioritySpending) * $prioritySpendingPercentage)).' % of Total Income)' ?></p>
                        <?php } else {?>
                        <p>Rp. <?php echo money($priorityDetail[$i]).' (0 %)' ?></p>
                        <?php } ?>
                    </div>
                    <?php } ?>
            </div>
            <br>
            <div>
                <h2>Needs List:</h2>
                <?php for($i = 0; $i < count($needsUsername); $i++) { ?>
                    <div>
                        <h2><?php echo $needsName[$i] ?>:</h2>
                        <?php if($needsSpending != 0) { ?>
                        <h2>Rp. <?php echo money($needsDetail[$i])?></h2>
                        <p><?php echo '('.percentage((($needsDetail[$i]/$needsSpending) * $needsSpendingPercentage)).' % of Real Income)'?></p>
                        <?php } else {?>
                        <p>Rp. <?php echo money($needsDetail[$i]).' (0 %)' ?></p>
                        <?php } ?>
                    </div>
                    <?php } ?>
            </div>
            <br>
            <div>
                <h2>Wants List:</h2>
                <?php for($i = 0; $i < count($wantsUsername); $i++) { ?>
                    <div>
                        <h2><?php echo $wantsName[$i] ?>:</h2>
                        <?php if($wantsSpending != 0) { ?>
                        <h2>Rp. <?php echo money($wantsDetail[$i]) ?></h2>
                        <p><?php echo '('.percentage(($wantsDetail[$i]/$needsSpending) * $needsSpendingPercentage).' % of Real Income)' ?></p>
                        <?php } else { ?>
                        <p>Rp. <?php echo money($wantsDetail[$i]).' (0 %)' ?></p>
                        <?php } ?>
                    </div>
                    <?php } ?>
            </div>
        </div>
    </div>
    <div id="score">
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

    if($needsSpendingPercentage > $needsPlan) {?>
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