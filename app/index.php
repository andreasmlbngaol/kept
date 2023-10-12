<?php
require "../functions.php";
session_start();
if(!isset($_SESSION['loginId'])) {
    jumpTo("../");
}
session_abort();

$name = fetch('nickname');
$db = fetch('username').'_keep';
$picture = fetch('picture');
keepConn();

$totalIncome = totalIncome($db);
$routineIncome = routineIncome($db);
if($totalIncome != 0) {
    $routineIncomePercentage = number_format(($routineIncome * 100 / $totalIncome), 2, ',');
} else {
    $routineIncomePercentage = 0;
}

$additionalIncome = additionalIncome($db);
if($additionalIncome != 0) {
    $additionalIncomePercentage = number_format(($additionalIncome * 100 / $totalIncome), 2, ',');
} else {
    $additionalIncomePercentage = 0;
}
$additionalIncomeToday = additionalIncomeToday($db);

$totalSpending = totalSpending($db);
$today = dateNow();
keptConn();
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
        <a href="detail/" class="app-header-list">DETAIL</a>
        <a href="history/" class="app-header-list">HISTORY</a>
        <a href="profile/" class="app-header-list"><img src="../src/img/profilepicture/<?php echo $picture ?>" alt="Profile Picture" style="height: 50px;"></a>
        <a href="logout.php" class="app-header-list">LOGOUT</a>
    </nav>
    <br><br>
    <h3><?php showDate($today) ?></h3>
    <h1>Welcome to kept, <?php echo "$name" ?></h1>
    <br>
    <div>
        <div>
            <h2>Total Income:</h2>
            <h2>Rp. <?php echo money($totalIncome) ?></h2>
            <a href="detail/">Show Detail</a>
        </div>
        <br>
        <div>
            <h2>Total Spending:</h2>
            <h2>Rp. <?php echo money($totalSpending) ?></h2>
            <a href="detail/">Show Detail</a>
        </div>
        <br>
        <div>
            <h2>Your Wallet:</h2>
            <h2>Rp. <?php echo money($totalIncome - $totalSpending) ?></h2>
        </div>
    </div>
</body>
</html>