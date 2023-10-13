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
$invest = 0.1* $totalIncome;
$routineIncome = routineIncome($db);
$additionalIncome = additionalIncome($db);
if($totalIncome != 0) {
    $routineIncomePercentage = ($routineIncome * 100 / $totalIncome);
    $additionalIncomePercentage = ($additionalIncome * 100 / $totalIncome);
} else {
    $routineIncomePercentage = 0;
    $additionalIncomePercentage = 0;
}
$additionalIncomeToday = additionalIncomeToday($db);

$totalSpending = totalSpending($db);
$needsSpending = needsSpending($db);
$wantsSpending = wantsSpending($db);
if($totalSpending != 0) {
    $needsSpendingPercentage = ($needsSpending * 100 / $totalSpending);
    $wantsSpendingPercentage = ($wantsSpending * 100 / $totalSpending);
} else {
    $needsSpendingPercentage = 0;
    $wantsSpendingPercentage = 0;
}

$saving = $totalIncome - $totalSpending;
if($totalIncome != 0) {
    $spendingPercentage = ($totalSpending * 100 /$totalIncome);
    $savingPercentage = ($saving * 100/$totalIncome);
    $savingPercentage2 = ($saving - $invest) * 100/$totalIncome;
} else {
    $spendingPercentage = 0;
    $savingPercentage = 0;
    $savingPercentage2 = 0;
}


$today = dateNow();
$dateMonth = dateMonth($today);
$dateYear = dateYear($today);
keptConn();
$needsName = listItem('category', 'needs', 'name');
$wantsName = listItem('category', 'wants', 'name');
$needsUsername = listItem('category', 'needs', 'username');
$wantsUsername = listItem('category', 'wants', 'username');
keepConn();
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
                <p>Percentage</p>
                <h2><?php echo percentage($routineIncomePercentage).' % of Income'?></h2>
            </div>
            <br>
            <div>
                <h2>Additional Income:</h2>
                <h2>Rp. <?php echo money($additionalIncome)?></h2>
                <p>Percentage</p>
                <h2><?php echo percentage($additionalIncomePercentage).' % of Income'?></h2>
            </div>
        </div>
        <div class="item">
            <div>
                <h2>Total Spending:</h2>
                <h2>Rp. <?php echo money($totalSpending).' ('.percentage($spendingPercentage).' %)' ?></h2>
            </div>
            <br>
            <div>
                <h2>Spending for Needs:</h2>
                <h2>Rp. <?php echo money($needsSpending)?></h2>
                <p>Percentage</p>
                <h2><?php echo percentage($needsSpendingPercentage).' % of Spending'?> or <br> <?php echo percentage($needsSpendingPercentage * $spendingPercentage / 100).' % of Income' ?></h2>
            </div>
            <br>
            <div>
                <h2>Spending for Wants:</h2>
                <h2>Rp. <?php echo money($wantsSpending)?></h2>
                <p>Percentage</p>
                <h2><?php echo percentage($wantsSpendingPercentage).' % of Spending'?> or <br> <?php echo percentage($wantsSpendingPercentage * $spendingPercentage / 100).' % of Income' ?></h2>
            </div>
        </div>
        <br>
        <div class="item">
            <div>
                <h2>Your Wallet:</h2>
                <h2>Rp. <?php echo money($saving).' ('.percentage($savingPercentage).' %)' ?> or <br>Rp <?php echo money($saving - $invest).' ('.percentage($savingPercentage2).' %) after saving' ?></h2>
            </div>
            <br>
            <div>
                <h2>Needs List:</h2>
                <?php for($i = 0; $i < count($needsUsername); $i++) { ?>
                    <div>
                        <h3><?php echo $needsName[$i] ?>:</h3>
                        <?php if($needsSpending != 0) { ?>
                        <p>Rp. <?php echo money($needsDetail[$i]).' ('.percentage(($needsDetail[$i] * $needsSpendingPercentage / $needsSpending)).' % of Spending), ('.percentage(($needsDetail[$i] * 100 / $needsSpending)).' % of Needs)' ?></p>
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
                        <h3><?php echo $wantsName[$i] ?>:</h3>
                        <?php if($wantsSpending != 0) { ?>
                        <p>Rp. <?php echo money($wantsDetail[$i]).' ('.percentage($wantsDetail[$i] * $wantsSpendingPercentage / $wantsSpending).' % of Spending), ('.percentage($wantsDetail[$i] * 100 / $wantsSpending).' % of Wants)' ?></p>
                        <?php } else { ?>
                        <p>Rp. <?php echo money($wantsDetail[$i]).' (0 %)' ?></p>
                        <?php } ?>
                    </div>
                    <?php } ?>
            </div>
        </div>
    </div>
    <div>
        <h2>We recommend you to save at least Rp. <?php echo money($invest) ?> (10% of Income)</h2>
    </div>
    <?php if($wantsSpending > $needsSpending) { ?>
    <div>
        <h2>!!!Your wants spending is greater than your needs spending. Please reduce it :)</h2>
    </div>
    <?php ; $healthy = false;} ?>
    <?php if(($needsSpendingPercentage * $spendingPercentage / 100) > 70) { ?>
    <div>
        <h2>!!!Your Spending for Needs is greater than 70%</h2>
    </div>
    <?php ; $healthy = false; } ?>
    <?php if(($wantsSpendingPercentage * $spendingPercentage / 100) > 20) { ?>
    <div>
        <h2>!!!Your Spending for Wants is greater than 20%</h2>
    </div>
    <?php ; $healthy = false; } ?>
    <?php if($healthy) {?>
    <div>
        <h2>Your Flow is Healthy. Good Job!</h2>
    </div>
    <?php } ?>
</body>
</html>