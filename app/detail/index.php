<?php
require "../../functions.php";
session_start();
if(!isset($_SESSION['usernamelogin'])) {
    jumpTo("../../");
}
session_abort();

$name = fetch('nickname');
$db = fetch('username').'_keep';
keepConn();

$totalIncome = totalIncome($db);
$routineIncome = routineIncome($db);
$additionalIncome = additionalIncome($db);
if($totalIncome != 0) {
    $routineIncomePercentage = percentage($routineIncome * 100 / $totalIncome);
    $additionalIncomePercentage = percentage($additionalIncome * 100 / $totalIncome);
} else {
    $routineIncomePercentage = 0;
    $additionalIncomePercentage = 0;
}
$additionalIncomeToday = additionalIncomeToday($db);

$totalSpending = totalSpending($db);
$needsSpending = needsSpending($db);
$wantsSpending = wantsSpending($db);
if($totalSpending != 0) {
    $needsSpendingPercentage = percentage($needsSpending * 100 / $totalSpending);
    $wantsSpendingPercentage = percentage($wantsSpending * 100 / $totalSpending);
} else {
    $needsSpendingPercentage = 0;
    $wantsSpendingPercentage = 0;
}

if($totalIncome != 0) {
    $spendingPercentage = percentage($totalSpending * 100 /$totalIncome);
    $savingPercentage = percentage(($totalIncome - $totalSpending) * 100/$totalIncome);
} else {
    $spendingPercentage = 0;
    $savingPercentage = 0;
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
                <h2><?php echo $routineIncomePercentage.' % of Income'?></h2>
            </div>
            <br>
            <div>
                <h2>Additional Income:</h2>
                <h2>Rp. <?php echo money($additionalIncome)?></h2>
                <p>Percentage</p>
                <h2><?php echo $additionalIncomePercentage.' % of Income'?></h2>
            </div>
        </div>
        <div class="item">
            <div>
                <h2>Total Spending:</h2>
                <h2>Rp. <?php echo money($totalSpending).' ('.$spendingPercentage.' %)' ?></h2>
            </div>
            <br>
            <div>
                <h2>Needs Spending:</h2>
                <h2>Rp. <?php echo money($needsSpending)?></h2>
                <p>Percentage</p>
                <h2><?php echo $needsSpendingPercentage.' % of Spending'?></h2>
            </div>
            <br>
            <div>
                <h2>Wants Spending:</h2>
                <h2>Rp. <?php echo money($wantsSpending)?></h2>
                <p>Percentage</p>
                <h2><?php echo $wantsSpendingPercentage.' % of Spending'?></h2>
            </div>
        </div>
        <br>
        <div class="item">
            <div>
                <h2>Your Wallet:</h2>
                <h2>Rp. <?php echo money($totalIncome - $totalSpending).' ('.$savingPercentage.' %)' ?></h2>
            </div>
            <br>
            <div>
                <h2>Needs List:</h2>
                <?php for($i = 0; $i < count($needsUsername); $i++) { ?>
                    <div>
                        <h3><?php echo $needsName[$i] ?>:</h3>
                        <p>Rp. <?php echo money($needsDetail[$i]).' ('.percentage($needsDetail[$i] * 100 / $needsSpending).' %)' ?></p>
                    </div>
                    <?php } ?>
            </div>
            <br>
            <div>
                <h2>Wants List:</h2>
                <?php for($i = 0; $i < count($wantsUsername); $i++) { ?>
                    <div>
                        <h3><?php echo $wantsName[$i] ?>:</h3>
                        <p>Rp. <?php echo money($wantsDetail[$i]).' ('.percentage($wantsDetail[$i] * 100 / $wantsSpending).' %)' ?></p>
                    </div>
                    <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>