<?php
require "../functions.php";
session_start();
if(!isset($_SESSION['usernamelogin'])) {
    jumpTo("../");
}
session_abort();
$name = fetch('nickname');
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
    <h1>Welcome tu kept, <?php echo "$name" ?></h1>
</body>
</html>