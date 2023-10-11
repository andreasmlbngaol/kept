<?php
session_start();
require "../../functions.php";
$_SESSION['name'] = NULL;
$_SESSION['nickname'] = NULL;
$_SESSION['birthday'] = NULL;
if(isset($_POST['submit'])) {
    session_start();
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['nickname'] = $_POST['nickname'];
    $_SESSION['birthday'] = $_POST['birthday'];
    if(register($_SESSION)) {
        alert('Done. Your account has been made. The detail is sent to your email. Back to Home.');
        jumpTo('../../');
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
    <title>PERSONAL DATA</title>
</head>
<body>
    <nav id="home-header">
        <a href="../../" class="home-header-list" id="home-header-logo-container"><img src="../../src/img/logo.png" alt="logo.png"  id="home-header-logo"></a>
        <a href="" class="home-header-list">FAQ'S</a>
        <a href="" class="home-header-list">PRODUCT</a>
    </nav>
    <h1>PERSONAL DATA</h1>
    <form action="" method="post">
        <div>
            <input type="text" id="name" name="name" autocomplete="off" value="<?php echo $_SESSION['name'] ?>" placeholder="Full Name" required>
        </div>
        <div>
            <input type="text" id="nickname" name="nickname" autocomplete="off" value="<?php echo $_SESSION['nickname'] ?>" placeholder="Nickname" required>
        </div>
        <div>
            <input type="date" id="birthday" name="birthday" autocomplete="off" value="<?php echo $_SESSION['birthday'] ?>" placeholder="Birthday" required>
        </div>
        <button type="submit" name="submit" id="submit">NEXT</button>
    </form>
</body>
</html>