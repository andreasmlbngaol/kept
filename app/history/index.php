<?php
require "../../functions.php";
if(fetch('id') == NULL) {
    jumpTo('../../');
}
$table = fetch('username').'_keep';
keepConn();
if(isset($_POST['delete'])) {
    $transactionId = $_POST['delete'];
    $query = "DELETE FROM $table WHERE id = $transactionId";
    mysqli_query($conn, $query);
    if(mysqli_affected_rows($conn) <= 0) {
        alert('We\'re sorry, we have some error. We really appreciate it if you are willing to report this bug');
        die;
    }
}
$query1 = "SELECT * FROM $table WHERE class='income' ORDER BY date";
$query2 = "SELECT * FROM $table WHERE class='spending' ORDER BY date";
$income = query($query1);
$spending = query($query2);
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
    <h2>Income</h2>
    <?php if($income != NULL) { ?>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Date</th>
            <th>Type</th>
            <th>Category</th>
            <th>Value (Rp)</th>
            <th>Comment</th>
        </tr>
        <?php $i = 1; foreach ($income as $transaction) {?>
        <tr>
            <td><?php echo $i ?></td>
            <td><?php showDate($transaction['date']) ?></td>
            <td><?php echo ucfirst($transaction['class']) ?></td>
            <td><?php echo $transaction['name'] ?></td>
            <td id="value"><?php echo money($transaction['value']) ?></td>
            <td><?php echo $transaction['detail'] ?></td>
            <td>
                <form action="" method="post">
                    <button type="submit" name="delete" id="delete" value="<?php echo $transaction['id'] ?>">Hapus</button>
                </form>
            </td>
        </tr>
        <?php $i++; } ?>
    </table>
    <?php } else {?>
    <h2>No history yet. Go to KEEP Menu to insert your flow!</h2>
    <?php } ?>
    <br>
    <h2>Spending</h2>
    <?php if($spending != NULL) { ?>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Date</th>
            <th>Type</th>
            <th>Category</th>
            <th>Value (Rp)</th>
            <th>Comment</th>
        </tr>
        <?php $i = 1; foreach ($spending as $transaction) {?>
        <tr>
            <td><?php echo $i ?></td>
            <td><?php showDate($transaction['date']) ?></td>
            <td><?php echo ucfirst($transaction['class']) ?></td>
            <td><?php echo $transaction['name'] ?></td>
            <td id="value"><?php echo money($transaction['value']) ?></td>
            <td><?php echo $transaction['detail'] ?></td>
            <td>
                <form action="" method="post">
                    <button type="submit" name="delete" id="delete" value="<?php echo $transaction['id'] ?>">Hapus</button>
                </form>
            </td>
        </tr>
        <?php $i++; } ?>
    </table>
    <?php } else {?>
    <h2>No history yet. Go to KEEP Menu to insert your flow!</h2>
    <?php } ?>
</body>