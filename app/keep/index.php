<?php
require "../../functions.php";
if(fetch('id') == NULL) {
    jumpTo('../../');
}
if(isset($_POST['submit'])) {
    if(insertKeep($_POST)) {
        alert('Success');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../src/img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../style.css">
    <title>keep</title>
    <style>
        .input {
            width: 200px;
        }
    </style>
</head>
<body>
    <nav id="app-header">
        <a href="../" class="app-header-list" id="app-header-logo-container"><img src="../../src/img/logo.png" alt="logo.png"  id="app-header-logo"></a>
        <a href="" class="app-header-list">KEEP</a>
        <a href="../profile/" class="app-header-list">PROFILE</a>
        <a href="../logout.php" class="app-header-list">LOGOUT</a>
    </nav>

    <form action="" method="post">
        <div class="input" id="input-date">
            <label for="date">Date:</label><br>
            <input type="date" name="date" id="date" value="<?php echo dateNow()?>" required>
        </div>

        <div class="input">
            <label for="input-isincome">Type:</label><br>
            <select name="input-isincome" id="input-isincome" required>
                <option value="" selected>Choose</option>
                <option value="true">Income</option>
                <option value="false">Spending</option>
            </select>
        </div>

        <div class="input">
            <label for="input-class">Category:</label><br>
            <select name="input-class" id="input-class" required>
                <option value="" selected>Choose</option>
            </select>
        </div>

        <div class="input" id="input-type">
            <label for="nominal">Nominal:</label><br>
            <input type="number" name="nominal" id="nominal" required>
        </div>
        
        <div class="input" id="input-desc">
            <label for="desc">Description:</label><br>
            <input type="text" name="desc" id="desc" autocomplete="off" required>
        </div>
        <button type="submit" id="submit" name="submit">INSERT</button>
    </form>
    <script src="script.js"></script>
</body>
</html>