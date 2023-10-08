<?php
require "../functions.php";
session_start();
if(!isset($_SESSION['usernamelogin'])) {
    jumpTo("../");
}
session_abort();
$name = fetch('nickname');
$db = fetch('username').'_keep';
keepConn();
$totalIncome = totalIncome($db);
$totalSpending = totalSpending($db);
$additionalIncome = additionalIncome($db);
$additionalIncomeToday = additionalIncomeToday($db);
$routineIncome = routineIncome($db);
$today = dateNow();
$dateMonth = dateMonth($today);
$dateYear = dateYear($today);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../src/img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../style.css">
    <title>Home</title>
</head>
<body>
    <nav id="app-header">
        <a href="../" class="app-header-list" id="app-header-logo-container"><img src="../src/img/logo.png" alt="logo.png"  id="app-header-logo"></a>
        <a href="keep/" class="app-header-list">KEEP</a>
        <a href="profile/" class="app-header-list">PROFILE</a>
        <a href="logout.php" class="app-header-list">LOGOUT</a>
    </nav>
    <br><br>
    <h1>Welcome tu kept, <?php echo "$name" ?></h1>
    <br>
    <div>
        <div>
            <h2>Total Income:</h2>
            <p><?php echo $dateMonth.', '.$dateYear ?></p>
            <h2>Rp. <?php echo money($totalIncome) ?></h2>
            <a href="">Show Detail</a>
        </div>
        <br>
        <div>
            <h2>Additional Income:</h2>
            <p>This Month</p>
            <h2>Rp. <?php echo money($additionalIncome) ?></h2>
            <p>Today</p>
            <h2>Rp. <?php echo money($additionalIncomeToday) ?></h2>
        </div>
        <br>
        <div>
            <h2>Monthly Income:</h2>
            <p><?php echo $dateMonth.', '.$dateYear ?></p>
            <h2>Rp. <?php echo money($routineIncome) ?></h2>
        </div>
        <br>
        <div>
            <h2>Total Spending:</h2>
            <p><?php echo $dateMonth.', '.$dateYear ?></p>
            <h2>Rp. <?php echo money($totalSpending) ?></h2>
            <a href="">Show Detail</a>
        </div>
        <br>
        <div>
            <h2>Your Wallet:</h2>
            <h2><?php echo money($totalIncome - $totalSpending) ?></h2>
        </div>
    </div>
</body>
</html>