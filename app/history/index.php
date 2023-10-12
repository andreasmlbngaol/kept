<?php
require "../../functions.php";
if(fetch('id') == NULL) {
    jumpTo('../../');
}
$table = fetch('username').'_keep';
$query = "SELECT * FROM $table ORDER BY date";
keepConn();
$result = query($query);
keptConn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style.css">
    <link rel="shortcut icon" href="../../src/img/icon.png" type="image/x-icon">
    <title>HISTORY</title>
    <style>
        table {
            text-align: center;
            border-color: #E5C3A6;
            background-color: black;
            color: #E5C3A6;
        }
        #value {
            text-align: right;
        }
    </style>
</head>
<body>
    <nav id="app-header">
        <a href="../" class="app-header-list" id="app-header-logo-container"><img src="../../src/img/logo.png" alt="logo.png"  id="app-header-logo"></a>
        <a href="../keep/" class="app-header-list">KEEP</a>
        <a href="" class="app-header-list">PROFILE</a>
        <a href="../logout.php" class="app-header-list">LOGOUT</a>
    </nav>
    <br><br>
    <h1>History</h1>
    <?php if($result != NULL) { ?>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Date</th>
            <th>Type</th>
            <th>Category</th>
            <th>Value (Rp)</th>
            <th>Comment</th>
        </tr>
        <?php $i = 1; foreach ($result as $transaction) {?>
        <tr>
            <td><?php echo $i ?></td>
            <td><?php showDate($transaction['date']) ?></td>
            <td><?php echo ucfirst($transaction['class']) ?></td>
            <td><?php echo $transaction['name'] ?></td>
            <td id="value"><?php echo money($transaction['value']) ?></td>
            <td><?php echo $transaction['detail'] ?></td>
        </tr>
        <?php $i++; } ?>
    </table>
    <?php } else {?>
    <h2>No history yet. Go to KEEP Menu to insert your flow!</h2>
    <?php } ?>
</body>