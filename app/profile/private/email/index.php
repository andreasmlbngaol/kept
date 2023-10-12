<?php
require "../../../../functions.php";
$oldEmail = fetch('email');
if(isset($_POST['submit'])) {
    if(checkEmail($_POST)) {
        session_start();
        $email = strtolower($_POST['email']);
        $_SESSION['email'] = $email;
        $code = strval(rand(10000, 99999));
        $_SESSION['code'] = $code;
        if(sendEmail($email, "Verification Code", codeTextHTML($code), codeTextNotHTML($code))) {
            jumpTo("codeverification/");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../../style.css">
    <link rel="shortcut icon" href="../../../../src/img/icon.png" type="image/x-icon">
    <title>CHANGE EMAIL</title>
</head>
<body>
    <nav id="app-header">
        <a href="../../../" class="app-header-list" id="app-header-logo-container"><img src="../../../../src/img/logo.png" alt="logo.png"  id="app-header-logo"></a>
        <a href="../../../keep/" class="app-header-list">KEEP</a>
        <a href="../../" class="app-header-list">PROFILE</a>
        <a href="../../../logout.php" class="app-header-list">LOGOUT</a>
    </nav>
    <br><br>
    <a href="../../">BACK</a><br><br>
    <div>
        <h3>Old Email:</h3>
        <p><?php echo $oldEmail ?></p>
        <form action="" method="post">
            <div>
                <label for="new-email">New Email:</label><br>
                <input type="text" name="email" id="new-email" autocomplete="off" required>
            </div>
            <button type="submit" name="submit" id="submit">NEXT</button>
        </form>
    </div>
    <script src="script.js"></script>
</body>
</html>